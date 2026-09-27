<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

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

        .register-card{
            width:100%;
            max-width:500px;
            background:rgba(255,255,255,0.08);
            backdrop-filter:blur(12px);
            border-radius:25px;
            padding:40px;
            color:white;
            box-shadow:0 10px 30px rgba(0,0,0,0.3);
        }

        .register-icon{
            font-size:65px;
            color:#facc15;
            margin-bottom:15px;
        }

        .title{
            font-size:32px;
            font-weight:bold;
        }

        .subtitle{
            color:#cbd5e1;
            margin-bottom:25px;
        }

        .form-control,
        .form-select{
            border-radius:12px;
            padding:12px;
            border:none;
        }

        .form-control:focus,
        .form-select:focus{
            box-shadow:none;
            border:2px solid #38bdf8;
        }

        .btn-register{
            background:#facc15;
            color:#000;
            font-weight:bold;
            border:none;
            border-radius:12px;
            padding:12px;
        }

        .btn-register:hover{
            background:#eab308;
        }

        .login-link{
            color:#cbd5e1;
            text-decoration:none;
        }

        .login-link:hover{
            color:white;
        }

    </style>

</head>

<body>

<div class="register-card text-center">

    <div class="register-icon">
        <i class="fa-solid fa-user-plus"></i>
    </div>

    <h2 class="title">
        Smart Quiz System
    </h2>

    <p class="subtitle">
        Create Your Account
    </p>

    <form action="modules/auth/register_process.php" method="POST">

        <div class="mb-3 text-start">

            <label class="form-label">
                Full Name
            </label>

            <input type="text"
                   name="full_name"
                   class="form-control"
                   required>

        </div>

        <div class="mb-3 text-start">

            <label class="form-label">
                Email Address
            </label>

            <input type="email"
                   name="email"
                   class="form-control"
                   required>

        </div>

        <div class="mb-3 text-start">

            <label class="form-label">
                Password
            </label>

            <input type="password"
                   name="password"
                   class="form-control"
                   required>

        </div>

        <div class="mb-4 text-start">

            <label class="form-label">
                Role
            </label>

            <select name="role"
                    class="form-select"
                    required>

                <option value="">
                    Select Role
                </option>

                <option value="teacher">
                    Teacher
                </option>

                <option value="student">
                    Student
                </option>

            </select>

        </div>

        <button type="submit"
                class="btn btn-register w-100">

            <i class="fa-solid fa-user-check"></i>
            Register

        </button>

    </form>

    <div class="mt-4">

        <a href="login.php"
           class="login-link">

            Already have an account? Login

        </a>

    </div>

</div>

</body>
</html>