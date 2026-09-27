<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>

        body{
            margin:0;
            padding:0;
            min-height:100vh;
            background:linear-gradient(135deg,#0f172a,#1e293b,#2563eb);
            display:flex;
            justify-content:center;
            align-items:center;
            font-family:Arial,sans-serif;
        }

        .login-card{
            width:100%;
            max-width:450px;
            background:rgba(255,255,255,0.08);
            backdrop-filter:blur(12px);
            border-radius:25px;
            padding:40px;
            color:white;
            box-shadow:0 10px 30px rgba(0,0,0,0.3);
        }

        .login-icon{
            font-size:65px;
            color:#facc15;
            margin-bottom:15px;
        }

        .form-control{
            border-radius:12px;
            padding:12px;
            border:none;
        }

        .form-control:focus{
            box-shadow:none;
            border:2px solid #38bdf8;
        }

        .btn-login{
            background:#facc15;
            color:#000;
            font-weight:bold;
            border:none;
            border-radius:12px;
            padding:12px;
        }

        .btn-login:hover{
            background:#eab308;
        }

        .register-link{
            color:#cbd5e1;
            text-decoration:none;
        }

        .register-link:hover{
            color:white;
        }

        .title{
            font-size:32px;
            font-weight:bold;
        }

        .subtitle{
            color:#cbd5e1;
            margin-bottom:25px;
        }

    </style>

</head>
<body>

<div class="login-card text-center">

    <div class="login-icon">
        <i class="fa-solid fa-graduation-cap"></i>
    </div>

    <h2 class="title">
        Smart Quiz System
    </h2>

    <p class="subtitle">
        Login to continue
    </p>

    <form action="modules/auth/login_process.php" method="POST">

        <div class="mb-3 text-start">

            <label class="form-label">
                Email Address
            </label>

            <input type="email"
                   name="email"
                   class="form-control"
                   required>

        </div>

        <div class="mb-4 text-start">

            <label class="form-label">
                Password
            </label>

            <input type="password"
                   name="password"
                   class="form-control"
                   required>

        </div>

        <button type="submit"
                class="btn btn-login w-100">

            <i class="fa-solid fa-right-to-bracket"></i>
            Login

        </button>

    </form>

    <div class="mt-4">

        <a href="register.php"
           class="register-link">

            Don't have an account? Register

        </a>

    </div>

</div>

</body>
</html>