<?php
include '../includes/auth_check.php';
include '../config/db.php';

/* LEADERBOARD */
$sql = "SELECT
users.full_name,
AVG((results.score/results.total_questions)*100) AS avg_score,
COUNT(results.id) AS attempts

FROM results

JOIN users
ON results.student_id = users.id

WHERE users.role='student'

GROUP BY results.student_id

ORDER BY avg_score DESC

LIMIT 10";

$result = mysqli_query($conn,$sql);


/* TOTAL STUDENTS */

$total_students = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM users
WHERE role='student'
"))['total'];


/* TOTAL ATTEMPTS */

$total_attempts = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT COUNT(*) total
FROM results
"))['total'];


/* HIGHEST AVERAGE */

$highest = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT MAX(avg_score) highest
FROM
(
SELECT AVG((score/total_questions)*100) avg_score
FROM results
GROUP BY student_id
)t
"));

$highest_score = round($highest['highest'] ?? 0);


/* STORE RESULT */

$leaderboard = [];

while($row=mysqli_fetch_assoc($result)){
    $leaderboard[]=$row;
}


/* CHART DATA */

$names=[];
$scores=[];

foreach($leaderboard as $row){

    $names[]=$row['full_name'];

   $scores[]=round($row['avg_score'] ?? 0);

}

?>

<!DOCTYPE html>

<html>

<head>

<meta charset="UTF-8">

<title>Leaderboard</title>

<link
href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>

body{

background:

linear-gradient(
rgba(15,23,42,0.75),
rgba(30,64,175,0.75)
),

url('../assets/images/leaderboard.jpg');


background-size:cover;

background-position:center;

background-attachment:fixed;

min-height:100vh;

color:white;

}

.container{

max-width:1300px;

padding-top:40px;

padding-bottom:50px;

}

.glass-card{

background:rgba(255,255,255,.10);

backdrop-filter:blur(15px);

border:none;

border-radius:20px;

box-shadow:0 10px 30px rgba(0,0,0,.3);

color:white;

}

.summary-card{

padding:30px;

text-align:center;

}

.summary-card h2{

font-size:42px;

font-weight:bold;

}

.summary-card h5{

opacity:.9;

}

.rank-card{

padding:25px;

text-align:center;

}

.rank-card h1{

font-size:55px;

}

.rank-card h4{

margin-top:15px;

font-weight:bold;

}

.table{

color:white;

}

.table td,
.table th{

vertical-align:middle;

color:white;

}

.table-dark{

--bs-table-bg:transparent;

}

canvas{

background:rgba(255,255,255,.05);

border-radius:15px;

padding:20px;

}

.rank-badge{

padding:6px 14px;

border-radius:50px;

font-weight:bold;

}

.rank1{

background:gold;

color:black;

}

.rank2{

background:silver;

color:black;

}

.rank3{

background:#cd7f32;

}

</style>

</head>

<body>
    <?php include '../includes/teacher_sidebar.php'; ?>

<div class="container">

<h2 class="text-center fw-bold mb-5">

🏆 Student Leaderboard Dashboard

</h2>

<!-- SUMMARY -->

<div class="row mb-4">

<div class="col-md-4">

<div class="glass-card summary-card">

<h5>Total Students</h5>

<h2><?= $total_students ?></h2>

</div>

</div>

<div class="col-md-4">

<div class="glass-card summary-card">

<h5>Total Attempts</h5>

<h2><?= $total_attempts ?></h2>

</div>

</div>

<div class="col-md-4">

<div class="glass-card summary-card">

<h5>Highest Average</h5>

<h2><?= $highest_score ?>%</h2>

</div>

</div>

</div>

<!-- TOP 3 -->

<div class="row mb-4">

<?php

$medals=["🥇","🥈","🥉"];

for($i=0;$i<3;$i++){

if(isset($leaderboard[$i])){

?>

<div class="col-md-4">

<div class="glass-card rank-card">

<h1><?= $medals[$i] ?></h1>

<h4><?= $leaderboard[$i]['full_name'] ?></h4>

<h3 class="text-warning">

<?= round($leaderboard[$i]['avg_score']) ?>%

</h3>

<p>

Attempts :
<?= $leaderboard[$i]['attempts'] ?>

</p>

</div>

</div>

<?php } } ?>

</div>

<!-- TABLE -->

<div class="glass-card p-4">

<h4 class="mb-4">

📋 Leaderboard Ranking

</h4>

<table class="table table-hover table-dark">

<thead>

<tr>

<th>Rank</th>

<th>Student</th>

<th>Average</th>

<th>Attempts</th>

</tr>

</thead>

<tbody>

<?php

$rank=1;

foreach($leaderboard as $row){
    ?>
      <tr>

    <td>

        <?php if($rank==1){ ?>

            <span class="rank-badge rank1">
                🥇 1
            </span>

        <?php } elseif($rank==2){ ?>

            <span class="rank-badge rank2">
                🥈 2
            </span>

        <?php } elseif($rank==3){ ?>

            <span class="rank-badge rank3">
                🥉 3
            </span>

        <?php } else { ?>

            <span class="badge bg-secondary">
                <?= $rank ?>
            </span>

        <?php } ?>

    </td>

    <td>

        <?= htmlspecialchars($row['full_name']) ?>

    </td>

    <td>

        <strong>

            <?= round($row['avg_score'] ?? 0) ?>%

        </strong>

    </td>

    <td>

        <?= $row['attempts'] ?>

    </td>

</tr>

<?php

$rank++;

}

?>

</tbody>

</table>

</div>

<!-- BAR CHART -->

<div class="glass-card p-4 mt-4">

    <h4 class="mb-4">
        📊 Top Student Performance
    </h4>

    <div style="height:350px;">
        <canvas id="leaderChart"></canvas>
    </div>
</div>



<!-- PIE CHART -->

<div class="glass-card p-4 mt-4">

    <h4 class="mb-4">
        🥇 Top 5 Average Score Distribution
    </h4>

    <div style="height:320px;">
        <canvas id="pieChart"></canvas>
    </div>

</div>

<script>

const names = <?= json_encode($names); ?>;

const scores = <?= json_encode($scores); ?>;
console.log(names);
console.log(scores);

/* BAR CHART */

new Chart(document.getElementById("leaderChart"),{

type:"bar",

data:{

labels:names,

datasets:[{

label:"Average Score %",

data:scores,

backgroundColor:[
"#3b82f6",
"#2563eb",
"#60a5fa",
"#1d4ed8",
"#38bdf8",
"#2563eb",
"#60a5fa",
"#3b82f6",
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
            display:false
        }
    },

    scales:{

        x:{
            ticks:{
                autoSkip:false,
                maxRotation:45,
                minRotation:45,
                color:"white"
            }
        },

        y:{
            beginAtZero:true,
            max:100,
            ticks:{
                color:"white"
            }
        }

    }

}

});


/* PIE CHART */

new Chart(document.getElementById("pieChart"),{

    type:"pie",

    data:{

        labels:names.slice(0,5),

        datasets:[{

            label:"Average Score",

            data:scores.slice(0,5),

            backgroundColor:[

                "#FFD700",
                "#C0C0C0",
                "#CD7F32",
                "#3b82f6",
                "#38bdf8"

            ]

        }]

    },

    options:{

    responsive:true,

    maintainAspectRatio:false,

    plugins:{

        legend:{
            position:'right',
            labels:{
                color:"white"
            }
        }

    }

}

});

</script>
</div>

</body>

</html>

