<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>

body{
    margin:0;
    padding:0;
    font-family:Segoe UI,sans-serif;
}

.sidebar{

    position:fixed;
    left:0;
    top:0;

    width:260px;
    height:100vh;

    background:linear-gradient(180deg,#0f172a,#1e3a8a);

    padding-top:25px;

    box-shadow:5px 0 20px rgba(0,0,0,.3);

    z-index:999;

}

.logo{

    text-align:center;

    color:white;

    font-size:24px;

    font-weight:bold;

    margin-bottom:35px;

}

.sidebar a{

    display:block;

    color:white;

    text-decoration:none;

    padding:15px 25px;

    margin:8px 15px;

    border-radius:12px;

    transition:.3s;

    font-size:16px;

}

.sidebar a i{

    width:25px;

}

.sidebar a:hover{

    background:#2563eb;

    transform:translateX(8px);

}

.main-content{

    margin-left:280px;
    padding:30px;

}

</style>


<div class="sidebar">

<div class="logo">
🎓 Smart Quiz
</div>

<a href="dashboard.php">
<i class="fas fa-home"></i>
Dashboard
</a>

<a href="quizzes.php">
<i class="fas fa-pencil-alt"></i>
Take Quiz
</a>

<a href="result.php">
<i class="fas fa-poll"></i>
My Results
</a>

<a href="performance.php">
<i class="fas fa-chart-line"></i>
Performance
</a>

<a href="study_planner.php">
<i class="fas fa-calendar-check"></i>
Study Planner
</a>

<a href="focus_timer.php">
<i class="fas fa-stopwatch"></i>
Focus Timer
</a>

<a href="performance.php">
<i class="fas fa-trophy"></i>
My performance
</a>

<a href="../logout.php">
<i class="fas fa-sign-out-alt"></i>
Logout
</a>

</div>

<div class="main-content">