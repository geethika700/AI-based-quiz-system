<?php
include '../includes/auth_check.php';
include '../config/db.php';

$teacher_id = $_SESSION['user_id'];

// CREATE QUIZ
if (isset($_POST['create_quiz'])) {

    $title = mysqli_real_escape_string($conn, $_POST['title']);

    $sql = "INSERT INTO quizzes (teacher_id, title)
            VALUES ('$teacher_id', '$title')";

    mysqli_query($conn, $sql);

    $quiz_id = mysqli_insert_id($conn);

    header("Location: generate_quiz.php?quiz_id=$quiz_id");
    exit;
}

// ADD QUESTION
if (isset($_POST['add_question'])) {

    $quiz_id = $_POST['quiz_id'];
    $question = mysqli_real_escape_string($conn, $_POST['question']);
    $o1 = $_POST['option1'];
    $o2 = $_POST['option2'];
    $o3 = $_POST['option3'];
    $o4 = $_POST['option4'];
    $correct = $_POST['correct_answer'];

    $sql = "INSERT INTO questions
    (quiz_id, question, option1, option2, option3, option4, correct_answer)
    VALUES
    ('$quiz_id', '$question', '$o1', '$o2', '$o3', '$o4', '$correct')";

    mysqli_query($conn, $sql);

    header("Location: generate_quiz.php?quiz_id=$quiz_id");
    exit;
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Generate Quiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

<div class="container mt-5">

    <h2>Create Quiz</h2>

    <!-- CREATE QUIZ -->
    <?php if (!isset($_GET['quiz_id'])) { ?>

        <form method="POST" class="card p-4 shadow">

            <input type="text" name="title" class="form-control mb-3" placeholder="Quiz Title" required>

            <button name="create_quiz" class="btn btn-primary">
                Create Quiz
            </button>

        </form>

    <?php } else { ?>

        <?php $quiz_id = $_GET['quiz_id']; ?>

        <div class="alert alert-success">
            Quiz Created! ID: <?php echo $quiz_id; ?>
        </div>

        <!-- ADD QUESTION -->
        <form method="POST" class="card p-4 shadow">

            <input type="hidden" name="quiz_id" value="<?php echo $quiz_id; ?>">

            <input type="text" name="question" class="form-control mb-2" placeholder="Question" required>

            <input type="text" name="option1" class="form-control mb-2" placeholder="Option 1" required>
            <input type="text" name="option2" class="form-control mb-2" placeholder="Option 2" required>
            <input type="text" name="option3" class="form-control mb-2" placeholder="Option 3" required>
            <input type="text" name="option4" class="form-control mb-2" placeholder="Option 4" required>

            <input type="text" name="correct_answer" class="form-control mb-3" placeholder="Correct Answer" required>

            <button name="add_question" class="btn btn-success">
                Add Question
            </button>

        </form>

    <?php } ?>

</div>

</body>
</html>