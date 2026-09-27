<?php
include '../includes/auth_check.php';
include '../config/db.php';

$teacher_id = $_SESSION['user_id'];

$message = "";

/* ADD QUIZ */
if(isset($_POST['add_quiz'])) {

    $title = $_POST['title'];
$type  = $_POST['type'];

mysqli_query($conn,
"INSERT INTO quizzes (teacher_id, title, type)
 VALUES ('$teacher_id', '$title', '$type')");

    $message = "Quiz Added Successfully!";
}

/* DELETE QUIZ */
if(isset($_GET['delete'])) {

    $quiz_id = $_GET['delete'];

    mysqli_query($conn,
    "DELETE FROM questions WHERE quiz_id='$quiz_id'");

    mysqli_query($conn,
    "DELETE FROM results WHERE quiz_id='$quiz_id'");

    mysqli_query($conn,
    "DELETE FROM quizzes WHERE id='$quiz_id'");

    header("Location: manage_quizzes.php");
    exit;
}

/* GET QUIZZES */
$quizzes = mysqli_query($conn,
"SELECT * FROM quizzes
 WHERE teacher_id='$teacher_id'
 ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>

<head>

    <title>Manage Quizzes</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

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

        .glass-card{
            background: rgba(255,255,255,0.10);
            border: none;
            border-radius: 18px;
            backdrop-filter: blur(12px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            padding: 25px;
        }

        h2, h4{
            font-weight: bold;
        }

        input, .form-control{
            background: rgba(255,255,255,0.15) !important;
            border: none !important;
            color: white !important;
            padding: 12px !important;
            border-radius: 10px !important;
        }

        input::placeholder{
            color: #ddd;
        }

        table{
            border-radius: 12px;
            overflow: hidden;
        }

        table td, table th{
            color: white !important;
            vertical-align: middle;
        }

        .btn-custom{
            border-radius: 10px;
            font-weight: bold;
        }

        .badge{
            padding: 6px 10px;
        }

    </style>

</head>

<body>
    <?php include '../includes/teacher_sidebar.php'; ?>

<div class="container py-5">

    <!-- TITLE -->
    <h2 class="text-center mb-4">
        🛠 Manage Quizzes
    </h2>

    <!-- MESSAGE -->
    <?php if($message != "") { ?>

        <div class="alert alert-success text-center">
            <?php echo $message; ?>
        </div>

    <?php } ?>

    <!-- ADD QUIZ -->
    <div class="glass-card mb-4">

        <h4 class="mb-3">➕ Add New Quiz</h4>

        <a href="create_quiz.php" class="btn btn-warning">
    ➕ Add Quiz
</a>

    </div>

    <!-- QUIZ LIST -->
    <div class="glass-card">

        <h4 class="mb-3">📄 All Quizzes</h4>

        <table class="table table-dark table-hover">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

            <?php while($quiz = mysqli_fetch_assoc($quizzes)) { ?>

                <tr>

                    <td><?php echo $quiz['id']; ?></td>

                    <td><?php echo $quiz['title']; ?></td>

                    <td>
                        <?php
                        if(strpos($quiz['title'], 'Auto') !== false) {
                            echo "<span class='badge bg-warning text-dark'>Auto</span>";
                        } else {
                            echo "<span class='badge bg-primary'>Manual</span>";
                        }
                        ?>
                    </td>

                    <td>

                        <a href="view_questions.php?quiz_id=<?php echo $quiz['id']; ?>"
                           class="btn btn-success btn-sm btn-custom">

                            View
                        </a>

                        <a href="manage_questions.php?quiz_id=<?php echo $quiz['id']; ?>"
                           class="btn btn-info btn-sm btn-custom">

                            Questions
                        </a>

                        <a href="?delete=<?php echo $quiz['id']; ?>"
                           class="btn btn-danger btn-sm btn-custom"
                           onclick="return confirm('Delete this quiz?')">

                            Delete
                        </a>

                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

    <!-- EDIT QUIZ -->
    <?php if(isset($_GET['edit'])) {

        $edit_id = $_GET['edit'];

        $edit_quiz = mysqli_fetch_assoc(mysqli_query($conn,
        "SELECT * FROM quizzes WHERE id='$edit_id'"));
    ?>

    <div class="glass-card mt-4">

        <h4 class="mb-3">✏ Edit Quiz</h4>

        <form method="POST">

            <input type="hidden" name="quiz_id" value="<?php echo $edit_quiz['id']; ?>">

            <input type="text"
                   name="new_title"
                   class="form-control mb-3"
                   value="<?php echo $edit_quiz['title']; ?>"
                   required>

            <button name="update_quiz"
                    class="btn btn-success w-100 btn-custom">

                Update Quiz
            </button>

        </form>

    </div>

    <?php } ?>

</div>
</div>

</body>
</html>

<?php

/* UPDATE QUIZ */
if(isset($_POST['update_quiz'])) {

    $id = $_POST['quiz_id'];
    $new_title = $_POST['new_title'];

    mysqli_query($conn,
    "UPDATE quizzes SET title='$new_title' WHERE id='$id'");

    header("Location: manage_quizzes.php");
    exit;
}
?>