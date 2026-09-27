<?php

include '../includes/auth_check.php';
include '../config/db.php';


$student_id = $_SESSION['user_id'];


// TOTAL QUIZZES
$total_sql = mysqli_query($conn,"
SELECT COUNT(*) total
FROM results
WHERE student_id='$student_id'
");

$total_quizzes = mysqli_fetch_assoc($total_sql)['total'];



// AVERAGE SCORE

$avg_sql = mysqli_query($conn,"
SELECT AVG((score/total_questions)*100) average
FROM results
WHERE student_id='$student_id'
");


$average = mysqli_fetch_assoc($avg_sql)['average'];

$average = round($average ?? 0);

// AI COACH MESSAGE

if($average >= 90){

    $coach_message = "👑 Amazing! You are performing like a Quiz Master. Keep challenging yourself.";

}
elseif($average >= 75){

    $coach_message = "🔥 Great work! You are improving well. Try advanced quizzes next.";

}
elseif($average >= 50){

    $coach_message = "🚀 Good progress! Practice more quizzes to reach the next level.";

}
else{

    $coach_message = "🌱 Keep learning! Complete more quizzes and improve step by step.";

}



// NEXT GOAL

$goal = 75;

if($average >= 75){

    $goal = 90;

    $goal_text = "Reach 90% Average Score";

}
else{

    $goal = 75;

    $goal_text = "Reach 75% Average Score";

}


$goal_progress = ($average/ $goal) * 100;


if($goal_progress > 100){

    $goal_progress = 100;

}



// REWARDS

$rewards = [

[
"icon"=>"🥉",
"name"=>"Bronze Learner",
"unlock"=>$total_quizzes >= 3
],

[
"icon"=>"🥈",
"name"=>"Silver Learner",
"unlock"=>$total_quizzes >= 5
],

[
"icon"=>"🥇",
"name"=>"Gold Learner",
"unlock"=>$average >= 90
]

];



// QUOTES

$quotes = [

"Every quiz you complete makes you stronger 🚀",

"Small progress is still progress 🌱",

"Keep learning. Your future self will thank you 💪",

"Success comes from consistent practice ⭐"

];


$random_quote = $quotes[array_rand($quotes)];




// LEVEL SYSTEM

if($average >= 90){

    $level = "Quiz Master";
    $icon = "👑";
    $message = "Outstanding performance! You are a Quiz Master.";

}

elseif($average >= 75){

    $level = "Achiever";
    $icon = "🏅";
    $message = "Excellent work! Keep improving.";

}

elseif($average >= 50){

    $level = "Explorer";
    $icon = "🚀";
    $message = "Good progress! Continue learning.";

}

elseif($average >= 30){

    $level = "Learner";
    $icon = "📘";
    $message = "Keep practicing to improve.";

}

else{

    $level = "Beginner";
    $icon = "🌱";
    $message = "Start your learning journey.";

}



// XP SYSTEM

$xp = $average * 10;


$next_xp = 1000;


$xp_percent = ($xp/$next_xp)*100;

if($xp_percent > 100){

    $xp_percent = 100;

}
// ACHIEVEMENTS

$badges = [];


// First Quiz Badge

if($total_quizzes >= 1){

    $badges[] = [
        "icon"=>"🥇",
        "name"=>"First Quiz",
        "status"=>"Unlocked"
    ];

}


// Active Learner

if($total_quizzes >= 5){

    $badges[] = [
        "icon"=>"📚",
        "name"=>"Active Learner",
        "status"=>"Unlocked"
    ];

}


// High Scorer

if($average >= 80){

    $badges[] = [
        "icon"=>"🏆",
        "name"=>"High Scorer",
        "status"=>"Unlocked"
    ];

}


// Quiz Master

if($average >= 90){

    $badges[] = [
        "icon"=>"👑",
        "name"=>"Quiz Master",
        "status"=>"Unlocked"
    ];

}


// Locked Badges

$all_badges = [

[
"icon"=>"🥇",
"name"=>"First Quiz"
],

[
"icon"=>"📚",
"name"=>"Active Learner"
],

[
"icon"=>"🏆",
"name"=>"High Scorer"
],

[
"icon"=>"👑",
"name"=>"Quiz Master"
]

];



?>


<!DOCTYPE html>

<html>

<head>

<title>My Performance</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
rel="stylesheet">


<style>


body{

background:

linear-gradient(
rgba(2,6,23,0.75),
rgba(30,58,138,0.75)
),

url('../assets/images/performance.jpg');


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

background:rgba(255,255,255,0.12);

backdrop-filter:blur(15px);

border-radius:25px;

padding:30px;

box-shadow:0 10px 30px rgba(0,0,0,.3);

}


.level-icon{

font-size:80px;

}


.title{

font-weight:800;

}


.progress{

height:25px;

border-radius:20px;

}

.badge-card{

text-align:center;

transition:.3s;

}


.badge-card:hover{

transform:translateY(-8px);

}


.badge-icon{

font-size:45px;

}


.locked{

opacity:.35;

filter:grayscale(1);

}


.journey{

display:flex;

justify-content:center;

align-items:center;

gap:25px;

flex-wrap:wrap;

}


.step{

text-align:center;

}


.step-icon{

font-size:45px;

}


.active-step{

transform:scale(1.2);

}


.line{

font-size:30px;

color:#facc15;

}

.coach-card{

background:linear-gradient(135deg,#2563eb,#7c3aed);

color:white;

}


.progress{

height:18px;

border-radius:20px;

}


.reward-card{

text-align:center;

padding:25px;

transition:.3s;

}


.reward-card:hover{

transform:translateY(-8px);

}


.reward-icon{

font-size:45px;

}


.lock{

opacity:.35;

filter:grayscale(1);

}


.quote-card{

font-size:20px;

font-style:italic;

text-align:center;

padding:30px;

}



</style>


</head>


<body>
    <?php include '../includes/student_sidebar.php'; ?>


<div class="container">


<h2 class="text-center mb-5 title">

🚀 My Performance Dashboard

</h2>



<!-- LEVEL CARD -->


<div class="glass text-center mb-4">


<div class="level-icon">

<?= $icon ?>

</div>


<h2>

<?= $level ?>

</h2>


<h4>

Average Score

</h4>


<h1 class="text-warning">

<?= $average ?>%

</h1>


<p>

<?= $message ?>

</p>


</div>





<!-- XP CARD -->


<div class="glass mb-4">


<h4>

🔥 Experience Points

</h4>


<h5>

<?= $xp ?> / <?= $next_xp ?> XP

</h5>



<div class="progress">

<div class="progress-bar bg-warning"
style="width:<?= $xp_percent ?>%">


<?= round($xp_percent) ?>%




</div>


</div>


</div>





<!-- QUIZ COUNT -->


<div class="glass text-center">


<h4>

📚 Completed Quizzes

</h4>


<h1>

<?= $total_quizzes ?>

</h1>


</div>

<!-- ACHIEVEMENTS -->

<div class="glass mt-4">


<h3 class="mb-4">

🏅 My Achievements

</h3>



<div class="row">


<?php foreach($all_badges as $badge){


$unlocked=false;


foreach($badges as $mybadge){

if($mybadge['name']==$badge['name']){

$unlocked=true;

}

}


?>


<div class="col-md-3 mb-3">


<div class="glass badge-card 
<?php echo !$unlocked ? 'locked':''; ?>">


<div class="badge-icon">

<?= $badge['icon'] ?>

</div>


<h5>

<?= $badge['name'] ?>

</h5>


<?php if($unlocked){ ?>

<span class="badge bg-success">
Unlocked
</span>


<?php }else{ ?>


<span class="badge bg-secondary">
Locked
</span>


<?php } ?>


</div>


</div>


<?php } ?>


</div>


</div>






<!-- LEARNING JOURNEY -->


<div class="glass mt-4">


<h3 class="mb-5">

🗺 Learning Journey

</h3>



<div class="journey">



<div class="step 
<?= $level=="Beginner"?'active-step':'' ?>">

<div class="step-icon">
🌱
</div>

Beginner

</div>



<div class="line">
➡
</div>




<div class="step 
<?= $level=="Learner"?'active-step':'' ?>">

<div class="step-icon">
📘
</div>

Learner

</div>



<div class="line">
➡
</div>



<div class="step 
<?= $level=="Explorer"?'active-step':'' ?>">

<div class="step-icon">
🚀
</div>

Explorer

</div>



<div class="line">
➡
</div>




<div class="step 
<?= $level=="Achiever"?'active-step':'' ?>">

<div class="step-icon">
🏅
</div>

Achiever

</div>



<div class="line">
➡
</div>



<div class="step 
<?= $level=="Quiz Master"?'active-step':'' ?>">

<div class="step-icon">
👑
</div>

Quiz Master

</div>

</div>

<!-- AI COACH -->

<div class="glass coach-card mt-4 p-4">

<h3>
🤖 AI Learning Coach
</h3>

<p class="fs-5">

<?= $coach_message ?>

</p>

</div>




<!-- NEXT GOAL -->

<div class="glass mt-4 p-4">

<h3>
🎯 Next Goal
</h3>


<h5>

<?= $goal_text ?>

</h5>


<div class="progress mt-3">

<div class="progress-bar bg-success"
style="width:<?= $goal_progress ?>%">

<?= round($goal_progress) ?>%

</div>

</div>


</div>





<!-- REWARDS -->

<div class="glass mt-4 p-4">

<h3>
🎁 My Rewards
</h3>


<div class="row">


<?php foreach($rewards as $reward){ ?>


<div class="col-md-4 mb-3">


<div class="glass reward-card 
<?= !$reward['unlock']?'lock':'' ?>">


<div class="reward-icon">

<?= $reward['icon'] ?>

</div>


<h5>

<?= $reward['name'] ?>

</h5>



<?php if($reward['unlock']){ ?>

<span class="badge bg-success">

Unlocked

</span>


<?php }else{ ?>


<span class="badge bg-secondary">

Locked

</span>


<?php } ?>


</div>


</div>


<?php } ?>


</div>

</div>





<!-- MOTIVATION -->

<div class="glass quote-card mt-4">


🌟
<?= $random_quote ?>


</div>



</div>


</div>



</div>
</div>


</body>

</html>