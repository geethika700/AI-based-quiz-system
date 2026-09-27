<?php

include '../includes/auth_check.php';

include '../config/db.php';

$teacher_id = $_SESSION['user_id'];

/*
|--------------------------------------------------------------------------
| DELETE QUIZ
|--------------------------------------------------------------------------
*/

if(isset($_GET['delete'])){

    $quiz_id = $_GET['delete'];

    mysqli_query(
        $conn,
        "DELETE FROM questions WHERE quiz_id='$quiz_id'"
    );

    mysqli_query(
        $conn,
        "DELETE FROM results WHERE quiz_id='$quiz_id'"
    );

    mysqli_query(
        $conn,
        "DELETE FROM quizzes WHERE id='$quiz_id'"
    );

    header("Location: view_quizzes.php");

    exit;
}

/*
|--------------------------------------------------------------------------
| GET QUIZZES
|--------------------------------------------------------------------------
*/

$sql = "
SELECT *
FROM quizzes
WHERE teacher_id='$teacher_id'
ORDER BY id DESC
";

$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html>

<head>

    <title>View Quizzes</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>
            📄 My Quizzes
        </h2>

        <a href="dashboard.php"
           class="btn btn-secondary">

            Back
        </a>

    </div>

    <div class="card shadow p-4">

        <?php
        if(mysqli_num_rows($result) > 0){
        ?>

        <table class="table table-bordered table-hover">

            <thead class="table-dark">

                <tr>

                    <th>ID</th>

                    <th>Quiz Title</th>

                    <th>Created Date</th>

                    <th>Type</th>

                    <th width="250">
                        Actions
                    </th>

                </tr>

            </thead>

            <tbody>

            <?php
            while($row = mysqli_fetch_assoc($result)){

                $quiz_id = $row['id'];

                $question_count_query = mysqli_query(
                    $conn,
                    "SELECT COUNT(*) as total
                     FROM questions
                     WHERE quiz_id='$quiz_id'"
                );

                $question_count =
                mysqli_fetch_assoc(
                    $question_count_query
                )['total'];
            ?>

                <tr>

                    <td>
                        <?php echo $row['id']; ?>
                    </td>

                    <td>

                        <strong>
                            <?php echo $row['title']; ?>
                        </strong>

                        <br>

                        <small class="text-muted">

                            Questions:
                            <?php echo $question_count; ?>

                        </small>

                    </td>

                    <td>

                        <?php
                        echo $row['created_at'];
                        ?>

                    </td>

                    <td>

                        <?php

                        if(
                            strpos(
                                strtolower($row['title']),
                                'auto'
                            ) !== false
                        ){

                            echo "
                            <span class='badge bg-warning text-dark'>
                                Auto Generated
                            </span>
                            ";

                        }else{

                            echo "
                            <span class='badge bg-primary'>
                                Manual
                            </span>
                            ";
                        }

                        ?>

                    </td>

                    <td>

                        <a
                            href="view_questions.php?quiz_id=<?php echo $row['id']; ?>"
                            class="btn btn-sm btn-info"
                        >

                            View Questions

                        </a>

                        <a
                            href="?delete=<?php echo $row['id']; ?>"
                            class="btn btn-sm btn-danger"
                            onclick="return confirm('Delete this quiz?')"
                        >

                            Delete

                        </a>

                    </td>

                </tr>

            <?php
            }
            ?>

            </tbody>

        </table>

        <?php
        }else{
        ?>

            <div class="alert alert-warning">

                No quizzes found.

            </div>

        <?php
        }
        ?>

    </div>

</div>

</body>
</html>