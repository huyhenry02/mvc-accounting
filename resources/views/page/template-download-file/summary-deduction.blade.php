@php use Carbon\Carbon; @endphp
    <!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Báo cáo trích nộp</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 20px;
        }

        h2, h3 {
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
            font-size: 13px;
        }

        .header-table td {
            border: none;
            text-align: center;
            vertical-align: middle;
            font-size: 12px;
            line-height: 1.6;
            height: 60px;
        }
        .header-table .center {
            text-align: center;
            vertical-align: middle;
        }

        .header-table .left {
            text-align: left;
        }

        .header-table .right {
            text-align: right;
        }

        .bold {
            font-weight: bold;
        }

        .header .date {
            margin-top: 10px;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: auto;
        }

        th, td {
            border: 0.5px solid #000;
            padding: 5px 6px;
            text-align: center;
            vertical-align: middle;
        }

        .text-left {
            text-align: left;
        }

        .signature {
            margin-top: 20px;
            width: 100%;
        }

        .signature td {
            border: none;
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>
<body>
<table class="header-table">
    <tr>
        <td class="center">
            <div class="bold">Công ty TNHH Công nghệ Hoa Sơn</div>
            <div class="bold"> Chi nhánh: Hà nội</div>
        </td>
        <td>
            <div class="bold">CỘNG HÒA XÃ HỘI CHỦ NGHĨA VIỆT NAM</div>
            <div class="bold" style="margin-right: 30px" >Độc lập - Tự do - Hạnh phúc</div>
        </td>
    </tr>
</table>
<h2>TỔNG HỢP CÁC KHOẢN TRÍCH NỘP THEO NHÂN VIÊN</h2>
<table>
    <thead>
    <tr>
        <th rowspan="2">STT</th>
        <th rowspan="2">Mã NV</th>
        <th rowspan="2">Họ tên</th>
        <th rowspan="2">Chức vụ</th>
        <th colspan="{{ $deductions->count() }}">Các khoản trích nộp</th>
    </tr>
    <tr>
        @foreach ($deductions as $deduction)
            <th>{{ $deduction->name }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
    @foreach ( $data as $index => $employee)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td width="10%">{{ $employee['employee_code'] }}</td>
            <td class="text-left" width="15%">{{ $employee['full_name'] }}</td>
            <td width="15%">{{ $employee['position'] }}</td>
            @foreach ($deductions as $deduction)
                <td>
                    {{ $employee['deductions'][$deduction->name] ? '✓' : '' }}
                </td>
            @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
<table class="signature">
    <tr>
        <td></td>
        <td></td>
        <td style="text-align: center;">
            Hà nội, ngày {{ Carbon::now()->format('d') }} tháng {{ Carbon::now()->format('m') }} năm {{ Carbon::now()->format('Y') }}<br>
        </td>
    </tr>
    <tr>
        <td style="text-align: center;">
            <strong>Người lập bảng</strong> <br>
            ( Ký, ghi rõ họ tên )
        </td>
        <td style="text-align: center;">
        </td>
        <td style="text-align: center;">
            <strong>Giám đốc</strong> <br>
            ( Ký, ghi rõ họ tên )
        </td>
    </tr>
</table>
</body>
</html>
