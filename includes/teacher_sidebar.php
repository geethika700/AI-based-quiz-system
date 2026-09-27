<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

<style>

body{
    margin:0;
    padding:0;
    font-family:Segoe UI, sans-serif;
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

    margin-bottom:40px;

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

.active{

    background:#2563eb;

}

.main-content{

    margin-left:280px;
    padding:30px;

}

</style>

<div class="sidebar">

<div class="logo">
📚 Smart Quiz
</div>

<a href="dashboard.php">
<i class="fas fa-home"></i>
Dashboard
</a>

<a href="manage_quizzes.php">
<i class="fas fa-book"></i>
Manage Quizzes
</a>

<a href="upload_notes.php">
<i class="fas fa-file-upload"></i>
Upload Notes
</a>

<a href="quiz_analytics.php">
<i class="fas fa-chart-line"></i>
Quiz Analytics
</a>

<a href="leaderboard.php">
<i class="fas fa-trophy"></i>
Leaderboard
</a>

<a href="user_management.php">
<i class="fas fa-users"></i>
User Management
</a>

<a href="../logout.php">
<i class="fas fa-sign-out-alt"></i>
Logout
</a>

</div>

<div class="main-content">