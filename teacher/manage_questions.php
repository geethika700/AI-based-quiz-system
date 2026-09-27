<?php
include '../includes/auth_check.php';
include '../config/db.php';

/* CHECK QUIZ ID */
if(!isset($_GET['quiz_id'])) {

    die("Quiz ID Missing");
}

$quiz_id = $_GET['quiz_id'];

/* DELETE QUESTION */
if(isset($_GET['delete'])) {

    $question_id = $_GET['delete'];

    mysqli_query($conn,
    "DELETE FROM questions WHERE id='$question_id'");

    header("Location: manage_questions.php?quiz_id=$quiz_id");
    exit;
}

/* GET QUIZ DETAILS */
$quiz = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM quizzes WHERE id='$quiz_id'"));
/* ADD QUESTION */
if(isset($_POST['add_question'])){

    $question = mysqli_real_escape_string($conn,$_POST['question']);
    $option1 = mysqli_real_escape_string($conn,$_POST['option1']);
    $option2 = mysqli_real_escape_string($conn,$_POST['option2']);
    $option3 = mysqli_real_escape_string($conn,$_POST['option3']);
    $option4 = mysqli_real_escape_string($conn,$_POST['option4']);
    $correct = $_POST['correct_answer'];

    mysqli_query($conn,"
    INSERT INTO questions
    (quiz_id,question,option1,option2,option3,option4,correct_answer)
    VALUES
    ('$quiz_id','$question','$option1','$option2','$option3','$option4','$correct')
    ");

    header("Location: manage_questions.php?quiz_id=".$quiz_id);
    exit;
}

/* GET QUESTIONS */
$questions = mysqli_query($conn,
"SELECT * FROM questions
 WHERE quiz_id='$quiz_id'");
?>

<!DOCTYPE html>
<html>

<head>

    <title>Manage Questions</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

    <h2 class="mb-4">
        📘 Manage Questions - <?php echo $quiz['title']; ?>
    </h2>

    <!-- BACK BUTTON -->

    <a href="manage_quizzes.php"
       class="btn btn-secondary mb-4">

       ← Back to Quizzes
    </a>
    <div class="card shadow p-4 mb-4">

    <h4 class="mb-4">
        ➕ Add New Question
    </h4>

    <form method="POST">

        <div class="mb-3">
            <label class="form-label">Question</label>

            <textarea
                name="question"
                class="form-control"
                rows="3"
                required></textarea>
        </div>

        <div class="row">

            <div class="col-md-6 mb-3">

                <label>Option A</label>

                <input
                    type="text"
                    name="option1"
                    class="form-control"
                    required>

            </div>

            <div class="col-md-6 mb-3">

                <label>Option B</label>

                <input
                    type="text"
                    name="option2"
                    class="form-control"
                    required>

            </div>

            <div class="col-md-6 mb-3">

                <label>Option C</label>

                <input
                    type="text"
                    name="option3"
                    class="form-control"
                    required>

            </div>

            <div class="col-md-6 mb-3">

                <label>Option D</label>

                <input
                    type="text"
                    name="option4"
                    class="form-control"
                    required>

            </div>

        </div>

        <div class="mb-3">

            <label>Correct Answer</label>

            <select
                name="correct_answer"
                class="form-select"
                required>

                <option value="">Select Answer</option>
                <option value="A">Option A</option>
                <option value="B">Option B</option>
                <option value="C">Option C</option>
                <option value="D">Option D</option>

            </select>

        </div>

        <button
            type="submit"
            name="add_question"
            class="btn btn-success">

            💾 Save Question

        </button>

    </form>

</div>

    <?php
    $count = 1;

    while($q = mysqli_fetch_assoc($questions)) {
    ?>

        <div class="card shadow p-4 mb-4">

            <!-- QUESTION TITLE -->

            <h5 class="mb-3">
                Question <?php echo $count++; ?>
            </h5>

            <!-- QUESTION -->

            <p class="fw-bold">
                <?php echo $q['question']; ?>
            </p>

            <!-- OPTIONS -->

            <ul class="list-group mb-3">

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

            <!-- CORRECT ANSWER -->

            <div class="alert alert-success">

                <strong>Correct Answer:</strong>
                <?php echo $q['correct_answer']; ?>

            </div>

            <!-- ACTION BUTTONS -->

            <div>

                <a href="?quiz_id=<?php echo $quiz_id; ?>&delete=<?php echo $q['id']; ?>"
                   class="btn btn-danger"
                   onclick="return confirm('Delete this question?')">

                   Delete Question
                </a>

            </div>

        </div>

    <?php } ?>

</div>

</body>
</html>