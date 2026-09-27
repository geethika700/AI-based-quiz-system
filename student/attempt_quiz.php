<?php
include '../includes/auth_check.php';
include '../config/db.php';

$quiz_id = $_GET['quiz_id'];

$sql = "SELECT * FROM questions WHERE quiz_id='$quiz_id'";
$result = mysqli_query($conn, $sql);

$total_questions = mysqli_num_rows($result);
$score = 0;
$submitted = false;

if(isset($_POST['submit_quiz'])) {

    $submitted = true;

    $result = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_assoc($result)) {

        $qid = $row['id'];

        if(isset($_POST['answer'][$qid])) {

            $answer = $_POST['answer'][$qid];

            if($answer == $row['correct_answer']) {
                $score++;
            }
        }
    }

   $student_id = $_SESSION['user_id'];

/* CHECK IF RESULT ALREADY EXISTS */
$check = mysqli_query(
    $conn,
    "SELECT * FROM results
     WHERE student_id='$student_id'
     AND quiz_id='$quiz_id'"
);

if(mysqli_num_rows($check) > 0){

    /* UPDATE EXISTING RESULT */

    mysqli_query(
        $conn,
        "UPDATE results
         SET score='$score',
             total_questions='$total_questions',
             submitted_at=NOW()
         WHERE student_id='$student_id'
         AND quiz_id='$quiz_id'"
    );

}else{

    /* INSERT NEW RESULT */

    mysqli_query(
        $conn,
        "INSERT INTO results
        (student_id, quiz_id, score, total_questions)
        VALUES
        ('$student_id','$quiz_id','$score','$total_questions')"
    );
} 
}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Attempt Quiz</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>

        body{
            background:#f1f5f9;
        }

        .navbar{
            background: linear-gradient(135deg,#1e293b,#0f172a);
        }

        .quiz-card{
            border:none;
            border-radius:16px;
            margin-bottom:20px;
            transition:0.3s;
        }

        .quiz-card:hover{
            transform:translateY(-3px);
        }

        .question-title{
            font-weight:700;
            color:#0f172a;
        }

        .option-box{
            display:block;
            border:1px solid #e5e7eb;
            padding:12px;
            border-radius:10px;
            margin-bottom:10px;
            cursor:pointer;
            background:#fff;
        }

        .option-box:hover{
            background:#f8fafc;
        }

        .submit-btn{
            padding:12px 35px;
            border-radius:12px;
            font-weight:bold;
        }

    </style>

</head>

<body>

<nav class="navbar navbar-dark">

    <div class="container-fluid">

        <span class="navbar-brand">
            🎓 Smart Quiz System
        </span>

        <a href="quizzes.php"
           class="btn btn-light btn-sm">

            ← Back

        </a>

    </div>

</nav>

<div class="container mt-5">

    <h2 class="fw-bold">
        📝 Quiz Attempt
    </h2>

    <p class="text-muted">
        Answer all questions carefully and submit your quiz
    </p>

    <?php if($submitted){ ?>

        <div class="alert alert-success text-center shadow">

            🎉 Your Score:
            <strong>
                <?php echo $score; ?> / <?php echo $total_questions; ?>
            </strong>

        </div>

    <?php } ?>

    <form method="POST">

        <?php

        $result = mysqli_query($conn, $sql);

        $number = 1;

        while($row = mysqli_fetch_assoc($result)) {

        ?>

        <div class="card quiz-card shadow p-4">

            <h5 class="question-title mb-3">

                <?php echo $number++; ?>.
                <?php echo $row['question']; ?>

            </h5>

            <label class="option-box">

                <input type="radio"
                       name="answer[<?php echo $row['id']; ?>]"
                       value="A"
                       required>

                A) <?php echo $row['option1']; ?>

            </label>

            <label class="option-box">

                <input type="radio"
                       name="answer[<?php echo $row['id']; ?>]"
                       value="B">

                B) <?php echo $row['option2']; ?>

            </label>

            <label class="option-box">

                <input type="radio"
                       name="answer[<?php echo $row['id']; ?>]"
                       value="C">

                C) <?php echo $row['option3']; ?>

            </label>

            <label class="option-box">

                <input type="radio"
                       name="answer[<?php echo $row['id']; ?>]"
                       value="D">

                D) <?php echo $row['option4']; ?>

            </label>

        </div>

        <?php } ?>

        <div class="text-center mt-4 mb-5">

            <button name="submit_quiz"
                    class="btn btn-success submit-btn">

                🚀 Submit Quiz

            </button>

        </div>

    </form>

</div>

</body>
</html>