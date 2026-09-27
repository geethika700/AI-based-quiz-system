<?php
include '../includes/auth_check.php';
include '../config/db.php';

$teacher_id = $_SESSION['user_id'];

/* TOTAL QUIZZES */
$quiz_sql = "SELECT COUNT(*) as total FROM quizzes WHERE teacher_id='$teacher_id'";
$quiz_result = mysqli_query($conn, $quiz_sql);
$total_quizzes = mysqli_fetch_assoc($quiz_result)['total'];

/* TOTAL RESULTS */
$result_sql = "SELECT COUNT(*) as total FROM results";
$result_result = mysqli_query($conn, $result_sql);
$total_results = mysqli_fetch_assoc($result_result)['total'];

/* TOTAL STUDENTS */
$student_sql = "SELECT COUNT(*) as total FROM users WHERE role='student'";
$student_result = mysqli_query($conn, $student_sql);
$total_students = mysqli_fetch_assoc($student_result)['total'];

/* CLASS AVERAGE */
$avg_sql = "SELECT AVG((score/total_questions)*100) as avg_score FROM results";
$avg_result = mysqli_query($conn, $avg_sql);
$avg_score = mysqli_fetch_assoc($avg_result)['avg_score'];
$avg_score = round($avg_score);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Teacher Analytics</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">
   <?php include '../includes/teacher_sidebar.php'; ?> 

<div class="container mt-5">

    <h2 class="mb-4">
        Teacher Analytics Dashboard
    </h2>

    <!-- STATS CARDS -->
    <div class="row">

        <div class="col-md-3 mb-3">
            <div class="card shadow p-4 text-center">
                <h5>Total Quizzes</h5>
                <h2><?php echo $total_quizzes; ?></h2>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow p-4 text-center">
                <h5>Total Students</h5>
                <h2><?php echo $total_students; ?></h2>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow p-4 text-center">
                <h5>Total Attempts</h5>
                <h2><?php echo $total_results; ?></h2>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow p-4 text-center">
                <h5>Class Average</h5>
                <h2><?php echo $avg_score; ?>%</h2>
            </div>
        </div>

    </div>

    <!-- INSIGHT -->
    <div class="card shadow p-4 mt-4">

        <h4>System Insight</h4>

        <?php if ($avg_score >= 75) { ?>

            <div class="alert alert-success">
                Class performance is excellent 🔥
            </div>

        <?php } elseif ($avg_score >= 50) { ?>

            <div class="alert alert-warning">
                Class performance is average 📈
            </div>

        <?php } else { ?>

            <div class="alert alert-danger">
                Class performance is weak 📚
            </div>

        <?php } ?>

    </div>

    <!-- QUICK ACTION -->
    <div class="card shadow p-4 mt-4">

        <h4>Quick Actions</h4>

        <a href="generate_quiz.php" class="btn btn-success me-2">
            Create Quiz
        </a>

        <a href="upload_notes.php" class="btn btn-primary me-2">
            Upload Notes
        </a>

        <a href="leaderboard.php" class="btn btn-warning">
            View Leaderboard
        </a>

    </div>

</div>
</div>

</body>
</html>