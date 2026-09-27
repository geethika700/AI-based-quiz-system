<?php
include '../includes/auth_check.php';
include '../config/db.php';

if (!isset($_GET['quiz_id'])) {

    die("Quiz ID Missing");
}

$quiz_id = $_GET['quiz_id'];

/* GET QUIZ */
$quiz = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM quizzes WHERE id='$quiz_id'"));

/* GET QUESTIONS */
$questions = mysqli_query($conn,
"SELECT * FROM questions WHERE quiz_id='$quiz_id'");
?>

<!DOCTYPE html>
<html>

<head>

    <title>View Questions</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

    <h2 class="mb-4">
        📘 <?php echo $quiz['title']; ?>
    </h2>

    <div class="card shadow p-4">

        <?php
        $count = 1;

        while($q = mysqli_fetch_assoc($questions)) {
        ?>

            <div class="mb-4">

                <h5>
                    Question <?php echo $count++; ?>
                </h5>

                <p>
                    <?php echo $q['question']; ?>
                </p>

                <ul class="list-group">

                    <li class="list-group-item">
                        A. <?php echo $q['option1']; ?>
                    </li>

                    <li class="list-group-item">
                        B. <?php echo $q['option2']; ?>
                    </li>

                    <li class="list-group-item">
                        C. <?php echo $q['option3']; ?>
                    </li>

                    <li class="list-group-item">
                        D. <?php echo $q['option4']; ?>
                    </li>

                </ul>

                <div class="alert alert-success mt-2">

                    Correct Answer:
                    <?php echo $q['correct_answer']; ?>

                </div>

            </div>

            <hr>

        <?php } ?>

    </div>

</div>

</body>
</html>