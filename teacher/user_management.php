<?php

include '../includes/auth_check.php';
include '../config/db.php';



/* DELETE USER */

if(isset($_GET['delete'])){

    $id=$_GET['delete'];


    mysqli_query($conn,

    "DELETE FROM users WHERE id='$id'");


    header("Location:user_management.php");

    exit;

}



/* GET USERS */

$students=mysqli_query($conn,

"SELECT * FROM users

WHERE role='student'

ORDER BY id DESC");



$teachers=mysqli_query($conn,

"SELECT * FROM users

WHERE role='teacher'

ORDER BY id DESC");

?>


<!DOCTYPE html>

<html>

<head>

<title>User Management</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"

rel="stylesheet">


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

padding-top:40px;

}


.card{

background:rgba(255,255,255,.12);

backdrop-filter:blur(15px);

border:none;

border-radius:20px;

color:white;

}











.title{

font-weight:800;

}
/* ===== USER MANAGEMENT IMPROVEMENTS ===== */

.table{
    background: rgba(255,255,255,0.15);
    border-radius: 15px;
    overflow: hidden;
}

.table thead th{
    background:#1d4ed8 !important;
    color:white !important;
    padding:15px;
    font-size:16px;
}


.table tbody tr{

    background:rgba(255,255,255,0.25) !important;
    transition:0.3s;
}


.table tbody tr:hover{

    background:rgba(255,255,255,0.40) !important;
    transform:scale(1.01);
}


.table td{
    color:white !important;
    font-weight:500;
    padding:15px;
}


/* DELETE BUTTON */

.btn-danger{

    background:#dc2626 !important;
    color:white !important;
    border:none !important;
    padding:8px 18px;
    border-radius:10px;
    font-weight:bold;

}


.btn-danger:hover{

    background:#991b1b !important;

}


/* CARD HEADINGS */

.card h3{

    font-weight:800;

}


.card h3:first-letter{

    font-size:35px;

}
/* CUSTOM USER TABLE */

.user-table{
    width:100%;
    border-collapse:separate;
    border-spacing:0 10px;
}


.user-table thead th{

    background:#2563eb !important;
    color:white !important;
    padding:15px;
    border:none;

}


.user-table tbody tr{

    background:rgba(255,255,255,0.18) !important;
    border-radius:15px;

}


.user-table tbody td{

    background:rgba(255,255,255,0.18) !important;
    color:white !important;
    padding:18px;
    font-size:16px;
    font-weight:600;
    border:none !important;

}


/* first and last cell round */

.user-table tbody td:first-child{

    border-radius:15px 0 0 15px;

}


.user-table tbody td:last-child{

    border-radius:0 15px 15px 0;

}



.user-table tbody tr:hover td{

    background:rgba(255,255,255,0.35) !important;

}


</style>


</head>


<body>
    <?php include '../includes/teacher_sidebar.php'; ?>



<div class="container">



<h2 class="text-center mb-5 title">

👥 User Management

</h2>




<!-- STUDENTS -->


<div class="card p-4 mb-5">


<h3>

🎓 Students

</h3>



<table class="user-table">


<thead>

<tr>

<th>ID</th>

<th>Name</th>

<th>Email</th>

<th>Action</th>

</tr>


</thead>



<tbody>



<?php while($row=mysqli_fetch_assoc($students)){ ?>


<tr>


<td>

<?= $row['id']; ?>

</td>


<td>

<?= $row['full_name']; ?>

</td>



<td>

<?= $row['email']; ?>

</td>



<td>


<a href="?delete=<?= $row['id']; ?>"

onclick="return confirm('Delete student?')"

class="btn btn-danger btn-sm">

Delete

</a>


</td>


</tr>



<?php } ?>



</tbody>



</table>



</div>







<!-- TEACHERS -->


<div class="card p-4">


<h3>

👨‍🏫 Teachers

</h3>




<table class="user-table">


<thead>


<tr>

<th>ID</th>

<th>Name</th>

<th>Email</th>

<th>Action</th>


</tr>


</thead>




<tbody>



<?php while($row=mysqli_fetch_assoc($teachers)){ ?>



<tr>


<td>

<?= $row['id']; ?>

</td>


<td>

<?= $row['full_name']; ?>

</td>



<td>

<?= $row['email']; ?>

</td>



<td>



<a href="?delete=<?= $row['id']; ?>"

onclick="return confirm('Delete teacher?')"

class="btn btn-danger btn-sm">

Delete

</a>



</td>


</tr>



<?php } ?>



</tbody>


</table>


</div>



</div>
</div>


</body>

</html>