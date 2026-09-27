<?php
include '../includes/auth_check.php';
include '../config/db.php';

$teacher_id = $_SESSION['user_id'];

/* STATS */
$total_quizzes = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM quizzes WHERE teacher_id='$teacher_id'"))['total'];

$total_notes = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM notes WHERE teacher_id='$teacher_id'"))['total'];

$total_students = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM users WHERE role='student'"))['total'];

$total_attempts = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM results"))['total'];
?>

<!DOCTYPE html>
<html>

<head>

    <title>Teacher Dashboard</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

          <link rel="stylesheet" href="../assets/css/style.css">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        body{

background:

linear-gradient(
rgba(15,23,42,0.75),
rgba(30,64,175,0.75)
),

url('../assets/images/teacher.jpg');


background-size:cover;

background-position:center;

background-attachment:fixed;

min-height:100vh;

color:white;

}

.container{
    max-width:1200px;
}

.dashboard-box{
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(10px);
    border-radius:25px;
    padding:40px;
    margin-top:40px;
    color:white;
    box-shadow:0 10px 30px rgba(0,0,0,0.3);
}

.card{
    background: rgba(255,255,255,0.10);
    border:none;
    border-radius:18px;
    color:white;
}

.card h2,
.card h5,
.card h4{
    color:white;
}

.stat-card{
    transition:.3s;
}

.stat-card:hover{
    transform:translateY(-5px);
}

.btn-quick{
    padding:15px;
    border-radius:12px;
    font-weight:bold;
}

</style>

</head>

<body>

<?php include '../includes/teacher_sidebar.php'; ?>
<div class="container">
<div class="dashboard-box">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>👨‍🏫 Teacher Dashboard</h2>

        <a href="../logout.php"
           class="btn btn-danger">

           Logout
        </a>

    </div>

    <!-- STATS -->
    <div class="row">

        <div class="col-md-3 mb-3">
            <div class="card shadow p-3 text-center">
                <h5>📘 Quizzes</h5>
                <h2><?php echo $total_quizzes; ?></h2>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow p-3 text-center">
                <h5>📚 Notes</h5>
                <h2><?php echo $total_notes; ?></h2>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow p-3 text-center">
                <h5>👨‍🎓 Students</h5>
                <h2><?php echo $total_students; ?></h2>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card shadow p-3 text-center">
                <h5>📝 Attempts</h5>
                <h2><?php echo $total_attempts; ?></h2>
            </div>
        </div>

    </div>

    <!-- QUICK ACTIONS -->
    <div class="card shadow p-4 mt-4">

        <h4 class="mb-3">⚡ Quick Actions</h4>

        <div class="row">

            <div class="col-md-4 mb-3">
                <a href="upload_notes.php"
                   class="btn btn-primary btn-quick w-100">

                   📚 Upload Notes
                </a>
            </div>

            

            <!-- ONLY ONE QUIZ CONTROL -->
            <div class="col-md-4 mb-3">
                <a href="manage_quizzes.php"
                   class="btn btn-success btn-quick w-100">

                   🛠 Manage Quizzes
                </a>
            </div>

            <div class="col-md-4 mb-3">
                <a href="quiz_analytics.php"
                   class="btn btn-info btn-quick w-100">

                   📊 Analytics
                </a>
            </div>

            <div class="col-md-4 mb-3">
                <a href="leaderboard.php"
                   class="btn btn-dark btn-quick w-100">

                   🏆 Leaderboard
                </a>
            </div>

            <div class="col-md-4 mb-4">

<div class="card shadow p-4 text-center">


<h2>
👥
</h2>


<h4>
User Management
</h4>


<p>
Manage students and teachers
</p>


<a href="user_management.php"

class="btn btn-primary">

Manage Users

</a>


</div>

</div>

        </div>

    </div>
</div>
</div>
</div>

</body>
</html>