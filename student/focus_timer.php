<?php

include '../includes/auth_check.php';
include '../config/db.php';


$student_id = $_SESSION['user_id'];


// SAVE SESSION

if(isset($_POST['save_session'])){


    $minutes = $_POST['minutes'];


    mysqli_query($conn,

    "INSERT INTO focus_sessions

    (student_id,minutes)

    VALUES

    ('$student_id','$minutes')

    ");


    header("Location: focus_timer.php");

}



// TOTAL FOCUS TIME


$total = mysqli_fetch_assoc(mysqli_query($conn,

"

SELECT SUM(minutes) total

FROM focus_sessions

WHERE student_id='$student_id'

"

));


$total_minutes = $total['total'] ?? 0;



// TREE LEVEL


if($total_minutes >= 600){

    $tree="🌲";
    $tree_name="Big Forest Tree";

}

elseif($total_minutes >=300){

    $tree="🌳";
    $tree_name="Growing Tree";

}

elseif($total_minutes >=100){

    $tree="🌴";
    $tree_name="Young Tree";

}

else{

    $tree="🌱";
    $tree_name="Small Plant";

}



?>



<!DOCTYPE html>

<html>


<head>

<title>Focus Timer</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"

rel="stylesheet">



<style>


body{

background:

linear-gradient(
rgba(2,6,23,0.65),
rgba(15,46,35,0.75)
),

url('../assets/images/forest.jpg');


background-size:cover;

background-position:center;

background-attachment:fixed;

min-height:100vh;

color:white;

}



.container{

padding-top:40px;

}



.glass{

background:rgba(255,255,255,.15);

backdrop-filter:blur(15px);

border-radius:25px;

padding:30px;

}



.tree{

font-size:100px;

text-align:center;

}



.timer{

font-size:70px;

font-weight:bold;

text-align:center;

}



button{

border-radius:20px!important;

}



</style>


</head>



<body>
    <?php include '../includes/student_sidebar.php'; ?>


<div class="container">


<h2 class="text-center mb-5">

🌳 Focus Forest

</h2>



<div class="glass text-center mb-4">


<div class="tree">

<?= $tree ?>

</div>


<h3>

<?= $tree_name ?>

</h3>


<p>

Total Focus:

<b>

<?= $total_minutes ?>

Minutes

</b>

</p>


</div>





<div class="glass">


<h3 class="text-center">

⏳ Focus Session

</h3>



<div class="timer"

id="timer">

25:00

</div>



<div class="text-center mt-4">


<button onclick="startTimer()"

class="btn btn-success">

▶ Start

</button>



<button onclick="resetTimer()"

class="btn btn-danger">

Reset

</button>

<div class="card p-4 mt-4 text-center">

<h3>
🌿 Focus Mindset
</h3>

<p class="fs-5">

"Small focused steps every day create big achievements."

</p>

</div>



</div>


</div>




<form method="POST"

id="saveForm"

class="mt-4 text-center">


<input type="hidden"

name="minutes"

id="minutes"

value="25">


<button name="save_session"

class="btn btn-warning btn-lg">

🌱 Grow My Tree

</button>


</form>



</div>






<script>


let time=1500;

let interval;



function startTimer(){


interval=setInterval(()=>{


let min=Math.floor(time/60);

let sec=time%60;



document.getElementById("timer").innerHTML=

min+":"+(sec<10?"0":"")+sec;



time--;



if(time<0){

clearInterval(interval);

alert("Focus Session Completed 🌱");


}



},1000);



}





function resetTimer(){


clearInterval(interval);


time=1500;


document.getElementById("timer").innerHTML="25:00";


}


</script>
</div>



</body>

</html>