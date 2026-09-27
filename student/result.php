<?php
include '../includes/auth_check.php';
include '../config/db.php';

$student_id = $_SESSION['user_id'];

/* GET STUDENT RESULTS */

$sql = "
SELECT
    results.*,
    quizzes.title
FROM results
JOIN quizzes
ON results.quiz_id = quizzes.id
WHERE results.student_id='$student_id'
ORDER BY results.submitted_at ASC
";

$result = mysqli_query($conn, $sql);

/* STORE RESULTS */

$results = [];

$total_attempts = 0;
$total_percentage = 0;
$best_score = 0;

$excellent = 0;
$average = 0;
$improve = 0;

$quiz_names = [];
$quiz_scores = [];

while($row = mysqli_fetch_assoc($result)){

    $percent = 0;

    if($row['total_questions'] > 0){
        $percent = ($row['score'] / $row['total_questions']) * 100;
    }

    $row['percent'] = round($percent);

    $results[] = $row;

    $total_attempts++;

    $total_percentage += $percent;

    if($percent > $best_score){
        $best_score = $percent;
    }

    if($percent >= 75){

        $excellent++;

    }elseif($percent >= 50){

        $average++;

    }else{

        $improve++;

    }

    /* CHART DATA */

    $quiz_names[] = $row['title'];
    $quiz_scores[] = round($percent);

}

/* SUMMARY */

$average_score = 0;

if($total_attempts > 0){

    $average_score = round($total_percentage / $total_attempts);

}

/* PERFORMANCE LABEL */

if($average_score >= 75){

    $overall_status = "Excellent";
    $status_color = "success";

}elseif($average_score >= 50){

    $overall_status = "Average";
    $status_color = "warning";

}else{

    $overall_status = "Needs Improvement";
    $status_color = "danger";

}
?>

<!DOCTYPE html>
<html>

<head>

<meta charset="UTF-8">

<title>Student Performance Dashboard</title>

<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

body{

background:

linear-gradient(
rgba(2,6,23,0.70),
rgba(30,58,138,0.75)
),

url('../assets/images/leaderboard.jpg');


background-size:cover;

background-position:center;

background-attachment:fixed;

min-height:100vh;

color:white;

}

.container{

max-width:1400px;

padding-top:40px;

padding-bottom:50px;

}

.glass{

background:rgba(255,255,255,.10);

backdrop-filter:blur(15px);

border-radius:20px;

padding:25px;

box-shadow:0 10px 30px rgba(0,0,0,.30);

border:none;

}

.summary{

text-align:center;

}

.summary h2{

font-size:42px;

font-weight:bold;

}

.summary h5{

opacity:.9;

}

.table-dark{

--bs-table-bg:transparent;

}

.table td,
.table th{

color:white;

vertical-align:middle;

}

canvas{

background:rgba(255,255,255,.05);

border-radius:15px;

padding:15px;

}

.progress{

height:28px;

border-radius:30px;

}

.badge{

font-size:14px;

padding:8px 14px;

}

</style>

</head>

<body>
    <?php include '../includes/student_sidebar.php'; ?>

<div class="container">

<h2 class="text-center fw-bold mb-5">

📊 Student Performance Dashboard

</h2>


<!-- SUMMARY -->

<div class="row g-4 mb-4">

<div class="col-md-3">

<div class="glass summary">

<h5>Total Quizzes</h5>

<h2><?= $total_attempts ?></h2>

</div>

</div>


<div class="col-md-3">

<div class="glass summary">

<h5>Average Score</h5>

<h2><?= $average_score ?>%</h2>

</div>

</div>


<div class="col-md-3">

<div class="glass summary">

<h5>Best Score</h5>

<h2><?= round($best_score) ?>%</h2>

</div>

</div>


<div class="col-md-3">

<div class="glass summary">

<h5>Performance</h5>

<h2 class="text-<?= $status_color ?>">

<?= $overall_status ?>

</h2>

</div>

</div>

</div>


<!-- PROGRESS BAR -->

<div class="glass mb-4">

<h4 class="mb-3">

🎯 Overall Progress

</h4>

<div class="progress">

<div

class="progress-bar bg-success"

style="width:<?= $average_score ?>%">

<?= $average_score ?>%

</div>

</div>

</div>


<!-- BAR CHART -->

<div class="glass mb-4">

<h4>

📈 Quiz Performance

</h4>

<div style="height:330px;">

<canvas id="barChart"></canvas>

</div>

</div>


<!-- PIE CHART -->

<div class="glass mb-4">

<h4>

🥧 Performance Distribution

</h4>

<div style="height:330px;">

<canvas id="pieChart"></canvas>

</div>

</div>


<!-- LINE CHART -->

<div class="glass mb-4">

<h4>

📉 Progress Trend

</h4>

<div style="height:330px;">

<canvas id="lineChart"></canvas>

</div>

</div>


<!-- RESULT TABLE -->

<div class="glass">

<h4 class="mb-4">

📋 Quiz Results

</h4>

<table class="table table-hover table-dark">

<thead>

<tr>

<th>Quiz</th>

<th>Score</th>

<th>Percentage</th>

<th>Status</th>

<th>Date</th>

</tr>

</thead>

<tbody>

<?php foreach($results as $row){

$percent=$row['percent'];

if($percent>=75){

$badge="success";

$text="Excellent";

}
elseif($percent>=50){

$badge="warning";

$text="Average";

}
else{

$badge="danger";

$text="Needs Improvement";

}

?>

<tr>

<td>

<?= htmlspecialchars($row['title']) ?>

</td>

<td>

<?= $row['score'] ?>/<?= $row['total_questions'] ?>

</td>

<td>

<strong><?= $percent ?>%</strong>

</td>

<td>

<span class="badge bg-<?= $badge ?>">

<?= $text ?>

</span>

</td>

<td>

<?= $row['submitted_at'] ?>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</div>
<script>

const quizNames = <?= json_encode($quiz_names); ?>;
const quizScores = <?= json_encode($quiz_scores); ?>;

/* ===========================
   BAR CHART
=========================== */

new Chart(document.getElementById("barChart"),{

type:"bar",

data:{

labels:quizNames,

datasets:[{

label:"Score %",

data:quizScores,

backgroundColor:[
"#2563eb",
"#3b82f6",
"#60a5fa",
"#38bdf8",
"#1d4ed8",
"#2563eb",
"#3b82f6",
"#60a5fa",
"#38bdf8",
"#1d4ed8"
],

borderRadius:8

}]

},

options:{

responsive:true,

maintainAspectRatio:false,

plugins:{

legend:{
labels:{
color:"white"
}
}

},

scales:{

x:{
ticks:{
color:"white"
},
grid:{
color:"rgba(255,255,255,.15)"
}
},

y:{

beginAtZero:true,

max:100,

ticks:{
color:"white"
},

grid:{
color:"rgba(255,255,255,.15)"
}

}

}

}

});


/* ===========================
   PIE CHART
=========================== */

new Chart(document.getElementById("pieChart"),{

type:"pie",

data:{

labels:[
"Excellent",
"Average",
"Needs Improvement"
],

datasets:[{

data:[
<?= $excellent ?>,
<?= $average ?>,
<?= $improve ?>
],

backgroundColor:[

"#22c55e",
"#facc15",
"#ef4444"

],

borderColor:"#ffffff",

borderWidth:2

}]

},

options:{

responsive:true,

maintainAspectRatio:false,

plugins:{

legend:{

position:"bottom",

labels:{

color:"white",

padding:20

}

}

}

}

});


/* ===========================
   LINE CHART
=========================== */

new Chart(document.getElementById("lineChart"),{

type:"line",

data:{

labels:quizNames,

datasets:[{

label:"Progress",

data:quizScores,

borderColor:"#38bdf8",

backgroundColor:"rgba(56,189,248,.2)",

fill:true,

tension:.4,

pointRadius:5,

pointBackgroundColor:"#ffffff"

}]

},

options:{

responsive:true,

maintainAspectRatio:false,

plugins:{

legend:{

labels:{

color:"white"

}

}

},

scales:{

x:{

ticks:{
color:"white"
},

grid:{
color:"rgba(255,255,255,.15)"
}

},

y:{

beginAtZero:true,

max:100,

ticks:{
color:"white"
},

grid:{
color:"rgba(255,255,255,.15)"
}

}

}

}

});

</script>
</div>

</body>
</html>
