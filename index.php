<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Smart Quiz Generation System</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>

        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #0f172a, #1e293b, #2563eb);
            color: white;
        }

        .hero-section {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .hero-box {
            width: 100%;
            max-width: 1000px;
            background: rgba(255,255,255,0.08);
            border-radius: 25px;
            padding: 50px;
            backdrop-filter: blur(10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            text-align: center;
        }

        .main-icon {
            font-size: 80px;
            color: #facc15;
            margin-bottom: 20px;
        }

        .title {
            font-size: 50px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .description {
            font-size: 20px;
            color: #e2e8f0;
            line-height: 1.8;
            margin-bottom: 40px;
        }

        .btn-custom {
            padding: 14px 35px;
            font-size: 18px;
            border-radius: 12px;
            margin: 10px;
            font-weight: bold;
        }

        .feature-card {
            background: rgba(255,255,255,0.08);
            border-radius: 18px;
            padding: 25px;
            transition: 0.3s;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-6px);
            background: rgba(255,255,255,0.15);
        }

        .feature-icon {
            font-size: 40px;
            color: #38bdf8;
            margin-bottom: 15px;
        }

        .footer-text {
            margin-top: 35px;
            color: #cbd5e1;
            font-size: 15px;
        }

        @media(max-width:768px){

            .title{
                font-size: 36px;
            }

            .description{
                font-size: 17px;
            }

            .hero-box{
                padding: 30px;
            }
        }

    </style>

</head>

<body>

<div class="hero-section">

    <div class="hero-box">

        <div class="main-icon">
            <i class="fa-solid fa-graduation-cap"></i>
        </div>

        <h1 class="title">
            Smart Quiz Generation & Student Performance Analysis System
        </h1>

        <p class="description">

            An intelligent learning management system that automatically generates quizzes
            from notes, analyzes student performance, and provides advanced analytics
            dashboards for teachers and students.

        </p>

        <!-- BUTTONS -->

        <a href="login.php"
           class="btn btn-warning btn-custom">

            <i class="fa-solid fa-right-to-bracket"></i>
            Login

        </a>

        <a href="register.php"
           class="btn btn-light btn-custom">

            <i class="fa-solid fa-user-plus"></i>
            Register

        </a>

        <!-- FEATURES -->

        <div class="row mt-5 g-4">

            <div class="col-md-4">

                <div class="feature-card">

                    <div class="feature-icon">
                        <i class="fa-solid fa-robot"></i>
                    </div>

                    <h4>Auto Quiz Generation</h4>

                    <p>
                        Automatically generate quizzes from uploaded learning notes.
                    </p>

                </div>

            </div>

            <div class="col-md-4">

                <div class="feature-card">

                    <div class="feature-icon">
                        <i class="fa-solid fa-chart-column"></i>
                    </div>

                    <h4>Performance Analytics</h4>

                    <p>
                        Analyze student performance using smart charts and reports.
                    </p>

                </div>

            </div>

            <div class="col-md-4">

                <div class="feature-card">

                    <div class="feature-icon">
                        <i class="fa-solid fa-ranking-star"></i>
                    </div>

                    <h4>Leaderboard System</h4>

                    <p>
                        Rank students based on their quiz scores and achievements.
                    </p>

                </div>

            </div>

        </div>

        <p class="footer-text">
            Developed using PHP, MySQL, Bootstrap, Chart.js & Smart Analytics
        </p>

    </div>

</div>

</body>
</html>