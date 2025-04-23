<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng nhập hệ thống quản lý</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: linear-gradient(to bottom right, #e8f1f8, #f7fafd);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .login-wrapper {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.08);
            width: 400px;
            overflow: hidden;
        }

        .login-header {
            background-color: #0a5a97;
            padding: 20px;
            text-align: center;
        }

        .login-header img {
            max-height: 60px;
            object-fit: contain;
            margin-bottom: 5px;
        }

        .login-header .logo-text {
            color: #fff;
            font-weight: 600;
            font-size: 15px;
            letter-spacing: 1px;
        }

        .login-body {
            padding: 30px;
        }

        h3 {
            text-align: center;
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 25px;
            color: #0a5a97;
        }

        label {
            font-weight: 500;
            color: #333;
            margin-bottom: 6px;
            display: block;
            font-size: 14px;
        }

        input {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        input:focus {
            outline: none;
            border-color: #0a5a97;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #0a5a97;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #08487b;
        }
    </style>
</head>
<body>

<div class="login-wrapper">
    <div class="login-header">
        <img src="/assets/img/LOGO.png" alt="Corp Logo">
    </div>

    <div class="login-body">
        <h3>Đăng nhập hệ thống quản lý</h3>
        <form action="{{ route('auth.postLogin') }}" method="post">
            @csrf
            <label for="email">Email</label>
            <input type="email" id="email" placeholder="Nhập email của bạn" name="email" required>

            <label for="password">Mật khẩu</label>
            <input type="password" id="password" placeholder="Nhập mật khẩu" name="password" required>

            <button type="submit">Tiếp tục</button>
        </form>
    </div>
</div>
</body>
</html>
