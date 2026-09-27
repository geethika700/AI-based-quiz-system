<?php

include '../includes/auth_check.php';
include '../config/db.php';


$student_id = $_SESSION['user_id'];


// ADD TASK

if(isset($_POST['add_task'])){


    $task = $_POST['task_name'];


    mysqli_query($conn,"
    INSERT INTO study_tasks
    (student_id,task_name)

    VALUES

    ('$student_id','$task')
    ");


    header("Location: study_planner.php");

}



// COMPLETE TASK

if(isset($_GET['complete'])){


    $id=$_GET['complete'];


    mysqli_query($conn,"
    UPDATE study_tasks

    SET status='Completed'

    WHERE id='$id'
    AND student_id='$student_id'
    ");


    header("Location: study_planner.php");

}



// GET TASKS


$tasks=mysqli_query($conn,"
SELECT *

FROM study_tasks

WHERE student_id='$student_id'

ORDER BY id DESC

");

?>


<!DOCTYPE html>

<html>

<head>

<title>Study Planner</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">


<style>




body{

background:

linear-gradient(
rgba(15,23,42,0.75),
rgba(30,64,175,0.75)
),

url('../assets/images/planner.jpg');


background-size:cover;

background-position:center;

background-attachment:fixed;

min-height:100vh;

color:white;

}


.container{

padding-top:40px;

}


.card{

background:rgba(255,255,255,0.15);

backdrop-filter:blur(15px);

border:none;

border-radius:20px;

color:white;

}


.task{

padding:15px;

border-radius:15px;

background:rgba(255,255,255,.1);

margin-bottom:15px;

}


.completed{

text-decoration:line-through;

opacity:.5;

}


</style>


</head>


<body>
    <?php include '../includes/student_sidebar.php'; ?>


<div class="container">


<h2 class="text-center mb-5">

🌱 My Study Planner

</h2>



<div class="card p-4 mb-4">


<h4>

➕ Add Study Task

</h4>


<form method="POST">


<input type="text"

name="task_name"

class="form-control mb-3"

placeholder="Example: Study Java OOP"

required>


<button name="add_task"

class="btn btn-warning">

Add Task

</button>


</form>


</div>





<div class="card p-4">


<h4>

📚 Today's Study Plan

</h4>



<?php while($row=mysqli_fetch_assoc($tasks)){ ?>


<div class="task
<?= $row['status']=="Completed"?'completed':'' ?>">



<h5>

<?= $row['task_name'] ?>

</h5>


<p>

Status:
<?= $row['status'] ?>

</p>



<?php if($row['status']=="Pending"){ ?>


<a href="?complete=<?= $row['id'] ?>"

class="btn btn-success btn-sm">

✅ Complete

</a>


<?php } ?>



</div>


<?php } ?>



</div>



</div>
</div>


</body>

</html>