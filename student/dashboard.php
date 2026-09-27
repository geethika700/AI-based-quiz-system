<?php
include '../includes/auth_check.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        body{

    background:
    linear-gradient(
        rgba(15,23,42,0.75),
        rgba(30,64,175,0.75)
    ),
    url('../assets/images/dashboard.jpg');

    background-size:cover;

    background-position:center;

    background-attachment:fixed;

    min-height:100vh;

    color:white;

}

        /* NAVBAR */
        .navbar{
            background: rgba(0,0,0,0.6) !important;
            backdrop-filter: blur(10px);
        }

        /* CARDS */
        .card{
            border: none;
            border-radius: 18px;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            color: white;
            transition: 0.3s;
        }

        .card:hover{
            transform: translateY(-5px);
            background: rgba(255,255,255,0.15);
        }

        h2, h4, h5{
            font-weight: bold;
        }

        .btn{
            border-radius: 10px;
            font-weight: bold;
        }

        .btn-primary{
            background:#2563eb;
            border:none;
        }

        .btn-success{
            background:#16a34a;
            border:none;
        }

        .btn-warning{
            background:#facc15;
            border:none;
            color:black;
        }

        .text-muted{
            color:#cbd5e1 !important;
        }

        .stats-number{
            font-size: 28px;
            font-weight: bold;
        }

    </style>
</head>

<body>
    <?php include '../includes/student_sidebar.php'; ?>

<!-- NAVBAR -->
<nav class="navbar navbar-dark px-3 py-2">

    <span class="navbar-brand fw-bold">
        Smart Quiz System
    </span>

    <div>
        <span class="me-3">
            <?php echo $_SESSION['full_name']; ?>
        </span>

        <a href="../logout.php" class="btn btn-danger btn-sm">
            Logout
        </a>
    </div>

</nav>

<!-- CONTENT -->
<div class="container mt-5">

    <h2>Welcome, <?php echo $_SESSION['full_name']; ?> 👋</h2>
    <p class="text-muted">Student Dashboard</p>

    <!-- STATS -->
    <div class="row mt-4">

        <div class="col-md-4 mb-3">
            <div class="card p-4 text-center">
                <h5>Available Quizzes</h5>
                <div class="stats-number">0</div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card p-4 text-center">
                <h5>Completed Quizzes</h5>
                <div class="stats-number">0</div>
            </div>
        </div>

        <div class="col-md-4 mb-3">
            <div class="card p-4 text-center">
                <h5>Average Score</h5>
                <div class="stats-number">0%</div>
            </div>
        </div>

    </div>

    <!-- QUICK ACTIONS -->
    <div class="card p-4 mt-4">

        <h4 class="mb-3">⚡ Quick Actions</h4>

        <a href="quizzes.php" class="btn btn-primary me-2 mb-2">
            View Quizzes
        </a>

        <a href="result.php" class="btn btn-success me-2 mb-2">
            My Results
        </a>

        <a href="performance.php" class="btn btn-warning mb-2">
            Performance Analysis
        </a>

        

    </div>

    <!-- STUDY PLANNER -->

<div class="col-md-4 mb-4">

<div class="card shadow p-4 text-center">

<h2>
🌱
</h2>

<h4>
Study Planner
</h4>

<p>
Plan your daily learning tasks
</p>


<a href="study_planner.php"

class="btn btn-success">

Open Planner

</a>


</div>

</div>



<!-- FOCUS TIMER -->

<div class="col-md-4 mb-4">

<div class="card shadow p-4 text-center">


<h2>
🌳
</h2>


<h4>
Focus Forest
</h4>


<p>
Improve concentration with focus sessions
</p>


<a href="focus_timer.php"

class="btn btn-warning">

Start Focus

</a>


</div>

</div>

    <!-- INFO -->
    <div class="row mt-4">

        <div class="col-md-6 mb-3">

            <div class="card p-4">

                <h5>Student Information</h5>

                <p><strong>Name:</strong> <?php echo $_SESSION['full_name']; ?></p>
                <p><strong>Role:</strong> Student</p>
                <p><strong>Status:</strong> Active</p>

            </div>

        </div>

        <div class="col-md-6 mb-3">

            <div class="card p-4">

                <h5>System Status</h5>

                <p>Quiz Module: Active</p>
                <p>Results System: Ready</p>
                <p>AI Analytics: Coming Soon</p>

            </div>

        </div>

    </div>

</div>
</div>

</body>
</html>