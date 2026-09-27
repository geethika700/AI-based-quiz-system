<?php
include '../includes/auth_check.php';
include '../config/db.php';

$teacher_id = $_SESSION['user_id'];


/* TOTAL QUIZZES */
$totalQuiz = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM quizzes
WHERE teacher_id='$teacher_id'
"))['total'];


/* TOTAL ATTEMPTS */
$totalAttempts = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(results.id) total
FROM results
JOIN quizzes 
ON results.quiz_id = quizzes.id
WHERE quizzes.teacher_id='$teacher_id'
"))['total'];


/* OVERALL SCORE */
$avg = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT AVG((results.score/results.total_questions)*100) avg_score
FROM results
JOIN quizzes 
ON results.quiz_id = quizzes.id
WHERE quizzes.teacher_id='$teacher_id'
"));

$overallScore = round($avg['avg_score'] ?? 0);



/* QUIZ PERFORMANCE */

$sql="
SELECT 
quizzes.title,
AVG((results.score/results.total_questions)*100) avg_score,
COUNT(results.id) attempts

FROM quizzes

LEFT JOIN results
ON quizzes.id = results.quiz_id

WHERE quizzes.teacher_id='$teacher_id'

GROUP BY quizzes.id
";

$result=mysqli_query($conn,$sql);



/* BEST QUIZ */

$best=mysqli_fetch_assoc(mysqli_query($conn,"
SELECT quizzes.title,
AVG((results.score/results.total_questions)*100) avg_score

FROM quizzes

JOIN results
ON quizzes.id=results.quiz_id

WHERE quizzes.teacher_id='$teacher_id'

GROUP BY quizzes.id

ORDER BY avg_score DESC

LIMIT 1
"));



/* CHART DATA */

$names=[];
$scores=[];
$attemptData=[];


$chart=mysqli_query($conn,$sql);


while($row=mysqli_fetch_assoc($chart)){

    $names[]=$row['title'];

    $scores[]=round($row['avg_score'] ?? 0);

    $attemptData[]=$row['attempts'];

}

?>


<!DOCTYPE html>
<html>

<head>

<title>Quiz Analytics Dashboard</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



<style>


body{

background:

linear-gradient(
rgba(15,23,42,0.75),
rgba(30,64,175,0.75)
),

url('../assets/images/analytics.jpg');


background-size:cover;

background-position:center;

background-attachment:fixed;

min-height:100vh;

color:white;

}


.card-box{

background:
rgba(255,255,255,0.12);

backdrop-filter:blur(15px);

border-radius:20px;

padding:25px;

box-shadow:0 10px 30px rgba(0,0,0,.3);

}



.stat-card h1{

font-size:40px;

font-weight:bold;

}



.table td,
.table th{

color:white;

}



.chart-box{

background:
rgba(255,255,255,.1);

padding:25px;

border-radius:20px;

}



</style>


</head>


<body>
   <?php include '../includes/teacher_sidebar.php'; ?> 


<div class="container py-5">


<h2 class="text-center mb-5">

📊 Quiz Analytics Dashboard

</h2>



<!-- SUMMARY -->


<div class="row">


<div class="col-md-4 mb-3">

<div class="card-box stat-card text-center">

<h5>
📚 Total Quizzes
</h5>

<h1>
<?= $totalQuiz ?>
</h1>

</div>

</div>



<div class="col-md-4 mb-3">

<div class="card-box stat-card text-center">

<h5>
👨‍🎓 Total Attempts
</h5>

<h1>
<?= $totalAttempts ?>
</h1>

</div>

</div>



<div class="col-md-4 mb-3">

<div class="card-box stat-card text-center">

<h5>
⭐ Average Score
</h5>

<h1>
<?= $overallScore ?>%
</h1>

</div>

</div>


</div>





<!-- BEST QUIZ -->


<div class="card-box text-center mt-4">


<h4>
🔥 Best Performing Quiz
</h4>


<h2>
<?= $best['title'] ?? "No Data"; ?>
</h2>


<h3 class="text-warning">

<?= round($best['avg_score'] ?? 0); ?>%

</h3>


</div>





<!-- TABLE -->


<div class="card-box mt-4">


<h4>
📄 Quiz Performance Details
</h4>


<table class="table table-dark table-hover mt-3">


<tr>

<th>
Quiz
</th>

<th>
Average Score
</th>

<th>
Attempts
</th>

</tr>


<?php while($row=mysqli_fetch_assoc($result)){ ?>


<tr>

<td>
<?= $row['title']; ?>
</td>


<td>
<?= round($row['avg_score'] ?? 0); ?>%
</td>


<td>
<?= $row['attempts']; ?>
</td>


</tr>


<?php } ?>


</table>


</div>






<!-- CHARTS -->


<div class="row mt-4">


<div class="col-md-7">


<div class="chart-box">


<h4>
📊 Score Comparison
</h4>


<canvas id="barChart"></canvas>


</div>


</div>




<div class="col-md-5">


<div class="chart-box">


<h4>
🥧 Attempt Distribution
</h4>


<canvas id="pieChart"></canvas>


</div>


</div>


</div>



</div>





<script>


new Chart(
document.getElementById('barChart'),

{

type:'bar',

data:{


labels:
<?= json_encode($names); ?>,


datasets:[{


label:'Average Score %',


data:
<?= json_encode($scores); ?>


}]


},


options:{


scales:{


y:{


beginAtZero:true,

max:100


}


}


}


}

);





new Chart(

document.getElementById('pieChart'),

{


type:'pie',


data:{


labels:
<?= json_encode($names); ?>,


datasets:[{


data:
<?= json_encode($attemptData); ?>


}]


}


}


);



</script>

</div>
</body>

</html>