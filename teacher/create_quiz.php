<?php
include '../includes/auth_check.php';
include '../config/db.php';

$teacher_id = $_SESSION['user_id'];

if(isset($_POST['create_quiz'])){

    $title = mysqli_real_escape_string($conn,$_POST['title']);
    $description = mysqli_real_escape_string($conn,$_POST['description']);

    mysqli_query($conn,"
        INSERT INTO quizzes
        (teacher_id,title,type,created_at)
        VALUES
        ('$teacher_id','$title','Manual',NOW())
    ");

    $quiz_id = mysqli_insert_id($conn);

    header("Location: manage_questions.php?quiz_id=".$quiz_id);
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>

<title>Create Manual Quiz</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>

body{
background:linear-gradient(135deg,#0f172a,#1e293b,#2563eb);
min-height:100vh;
}

.card-box{
max-width:700px;
margin:auto;
margin-top:60px;
background:rgba(255,255,255,.1);
backdrop-filter:blur(12px);
padding:35px;
border-radius:20px;
color:white;
}

.form-control{
background:rgba(255,255,255,.15)!important;
border:none!important;
color:white!important;
}

textarea{
background:rgba(255,255,255,.15)!important;
border:none!important;
color:white!important;
}

</style>

</head>

<body>

<div class="card-box">

<h2 class="mb-4 text-center">
📝 Create Manual Quiz
</h2>

<form method="POST">

<label class="mb-2">
Quiz Title
</label>

<input
type="text"
name="title"
class="form-control mb-3"
required>

<label class="mb-2">
Description
</label>



<button
class="btn btn-warning w-100"
name="create_quiz">

Continue →
</button>

</form>

</div>

</body>

</html>