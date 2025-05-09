<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use App\Models\Attendance;
use App\Models\AttendanceDetail;
use App\Models\Bonus;
use App\Models\Deduction;
use App\Models\Employee;
use App\Models\EmployeeBonus;
use App\Models\Journal;
use App\Models\Payroll;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Carbon\CarbonPeriod;
use Carbon\Month;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class AccountingController extends Controller
{
    public function showIndex(Request $request): View|Factory|Application
    {
        $month = $request->input('month', now()->format('Y-m'));
        $data = $this->getDataAccountingTable($month);
        return view('page.accounting.index', $data);
    }

    public function loadIndex(Request $request): Response
    {
        $month = $request->input('month', now()->format('Y-m'));
        $data = $this->getDataAccountingTable($month);

        $html = view('page.accounting.index-table', $data)->render();
        return response($html);
    }

    public function showPayment(Request $request): View|Factory|Application
    {
        $month = $request->input('month', now()->format('Y-m'));
        $data = $this->getDataAccountingTable($month);
        return view('page.accounting.payment', $data);
    }

    public function loadPayment(Request $request): Response
    {
        $month = $request->input('month', now()->format('Y-m'));
        $data = $this->getDataAccountingTable($month);

        $html = view('page.accounting.payment-table', $data)->render();
        return response($html);
    }

    public function showEmployeeBonus(Request $request): View|Factory|Application
    {
        $month = $request->input('month', now()->format('Y-m'));
        $data = $this->getEmployeeBonusData($month);

        return view('page.accounting.employee_bonus', $data);
    }

    public function loadEmployeeBonusTable(Request $request): Response
    {
        $month = $request->input('month', now()->format('Y-m'));
        $data = $this->getEmployeeBonusData($month);

        $html = view('page.accounting.employee_bonus_table', $data)->render();
        return response($html);
    }

    public function updateEmployeeBonus(Request $request): JsonResponse
    {
        $month = Carbon::createFromFormat('Y-m', $request->input('month'));
        $checked = $request->input('checked', []);
        $unchecked = $request->input('unchecked', []);
        $monthDate = $month->day(15)->format('Y-m-d');
        foreach ($checked as $item) {
            EmployeeBonus::updateOrInsert([
                'employee_id' => $item['employee_id'],
                'bonus_id' => $item['bonus_id'],
                'month' => $monthDate,
            ]);
        }

        foreach ($unchecked as $item) {
            EmployeeBonus::where('employee_id', $item['employee_id'])
                ->where('bonus_id', $item['bonus_id'])
                ->whereDate('month', $monthDate)
                ->delete();
        }

        return response()->json(['status' => 'ok']);
    }

    public function postPayrollTable(Request $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $monthDate = Carbon::createFromFormat('Y-m', $request->input('month'));
            $month = $monthDate->month;
            $year = $monthDate->year;
            $employees = Employee::with(['allowances', 'deductions'])->get();
            foreach ($employees as $employee) {
                $salaryBasic = $employee->salary_basic;
                $period = CarbonPeriod::create("{$year}-{$month}-01", "{$year}-{$month}-" . $monthDate->daysInMonth);
                $workingDaysRequired = collect($period)->filter(function ($item) {
                   return !in_array($item->dayOfWeek, [CarbonInterface::SATURDAY, CarbonInterface::SUNDAY], true);
                })->count();

                $attendance = Attendance::where('employee_id', $employee->id)
                    ->where('month', $month)
                    ->where('year', $year)
                    ->first();

                $actualWorkingDays = $attendance ? $attendance->working_days : 0;

                $salaryV1 = (int)($salaryBasic / $workingDaysRequired * $actualWorkingDays);

                $totalAllowance = $employee->allowances->sum(function ($allowance) use ($salaryBasic) {
                    return $allowance->rate * $salaryBasic;
                });

                $totalDeduction = $employee->deductions->sum(function ($deduction) use ($salaryV1) {
                    return $deduction->rate * $salaryV1;
                });

                $overtimeDetails = AttendanceDetail::where('employee_id', $employee->id)
                    ->whereYear('work_date', $year)
                    ->whereMonth('work_date', $month)
                    ->where('is_overtime', true)
                    ->with('workingShift')
                    ->get();
                $workingShiftAmount = $overtimeDetails->sum(fn($detail) => $detail->workingShift?->hourly_rate ?? 0);

                $bonusIds = EmployeeBonus::where('employee_id', $employee->id)
                    ->whereMonth('month', $month)
                    ->whereYear('month', $year)
                    ->pluck('bonus_id');
                $totalBonus = Bonus::whereIn('id', $bonusIds)->sum('amount');

                $netBeforeTax = $salaryV1 + (int)$totalAllowance + (int)$workingShiftAmount + (int)$totalBonus - (int)$totalDeduction;

                $arrayTax = $this->calculateTax($netBeforeTax);

                Payroll::updateOrCreate(
                    [
                        'employee_id' => $employee->id,
                        'month' => $month,
                        'year' => $year,
                    ],
                    [
                        'salary_v1' => $salaryV1,
                        'total_allowance' => (int)$totalAllowance,
                        'total_deduction' => (int)$totalDeduction,
                        'working_shift_amount' => (int)$workingShiftAmount,
                        'total_bonus' => (int)$totalBonus,
                        'net_salary_before_tax' => $netBeforeTax,
                        'net_salary_after_tax' => (int)$arrayTax['netAfterTax'],
                        'tax_amount' => (int)$arrayTax['taxCalculation'],
                    ]
                );
            }
            DB::commit();
            return redirect()->route('accounting.showIndex')->with('success', 'Tạo bảng lương thành công');
        }catch (Exception $exception){
            DB::rollBack();
            return redirect()->route('accounting.showIndex')->with('error', 'Tạo bảng lương thất bại');
        }
    }

    public function previewPaymentPdf($month): Response
    {
        $data = $this->getDataAccountingTable($month);
        return PDF::loadView('page.template-download-file.payment', [
            'data' => $data,
        ])->setPaper('A4', 'landscape')->stream("BANG_THANH_TOAN_LUONG_" . $month . ".pdf");
    }

    private function getDataAccountingTable(string $month): array
    {
        $date = Carbon::createFromFormat('Y-m', $month);
        $monthInt = $date->month;
        $year = $date->year;

        $allowanceTypes = ['position', 'hazard', 'responsibility'];
        $allowances = Allowance::whereIn('type', $allowanceTypes)->get();
        $deductions = Deduction::all();
        $daysInMonth = $date->daysInMonth;
        $workingDaysRequired = collect(range(1, $daysInMonth))->filter(function ($day) use ($date) {
            $d = $date->copy()->day($day);
            return !in_array($d->dayOfWeek, [CarbonInterface::SATURDAY, CarbonInterface::SUNDAY], true);
        })->count();
        $employees = Employee::with([
            'position',
            'allowances',
            'deductions',
            'payrolls' => function ($q) use ($monthInt, $year) {
                $q->where('month', $monthInt)->where('year', $year);
            },
            'attendance' => function ($q) use ($monthInt, $year) {
                $q->where('month', $monthInt)->where('year', $year);
            },
        ])->get();

        return [
            'employees' => $employees,
            'allowances' => $allowances,
            'deductions' => $deductions,
            'workingDaysRequired' => $workingDaysRequired,
            'month' => $month,
        ];
    }

    private function getEmployeeBonusData(string $month): array
    {
        $date = Carbon::createFromFormat('Y-m', $month);
        $employees = Employee::with('position')->get();
        $bonuses = Bonus::all()->keyBy('id');
        $employeeBonuses = EmployeeBonus::whereYear('month', $date->year)
            ->whereMonth('month', $date->month)
            ->get()
            ->groupBy('employee_id');
        return compact('employees', 'bonuses', 'employeeBonuses', 'month');
    }

    private function calculateTax($netBeforeTax): array
    {
        $taxCalculation = $netBeforeTax / 100 * 10;
        $netAfterTax = $netBeforeTax - $taxCalculation;
        return [
            'taxCalculation' => $taxCalculation,
            'netAfterTax' => $netAfterTax,
        ];
    }
}
