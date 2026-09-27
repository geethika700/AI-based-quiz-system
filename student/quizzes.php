<?php
include '../includes/auth_check.php';
include '../config/db.php';

$sql = "SELECT * FROM quizzes ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>

<head>

    <title>Available Quizzes</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>

        
        body{

background:

linear-gradient(
rgba(2,6,23,0.75),
rgba(30,64,175,0.75)
),

url('../assets/images/performance.jpg');


background-size:cover;

background-position:center;

background-attachment:fixed;

min-height:100vh;

color:white;

}

        .container{
            margin-top: 50px;
        }

        h2{
            font-weight: bold;
        }

        .card{
            border: none;
            border-radius: 18px;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            color: white;
        }

        table{
            color: white !important;
        }

        thead{
            background: #2563eb !important;
            color: white;
        }

        tbody tr{
            transition: 0.3s;
        }

        tbody tr:hover{
            background: rgba(255,255,255,0.1);
            transform: scale(1.01);
        }

        .btn-primary{
            background:#2563eb;
            border:none;
            border-radius:10px;
            font-weight:bold;
        }

        .btn-primary:hover{
            background:#1d4ed8;
        }

        .badge{
            padding:6px 10px;
            border-radius:20px;
        }

        .header-box{
            margin-bottom: 20px;
        }

    </style>

</head>

<body>
  <?php include '../includes/student_sidebar.php'; ?>  

<div class="container">

    <div class="header-box">
        <h2>📚 Available Quizzes</h2>
        <p class="text-muted" style="color:#cbd5e1;">
            Select a quiz and start your assessment
        </p>
    </div>

    <div class="card shadow p-4">

        <table class="table table-borderless align-middle">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Quiz Title</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

            <?php while($row = mysqli_fetch_assoc($result)) { ?>

                <tr>

                    <td>
                        <span class="badge bg-secondary">
                            #<?php echo $row['id']; ?>
                        </span>
                    </td>

                    <td>
                        <strong><?php echo $row['title']; ?></strong>
                    </td>

                    <td>
                        <?php echo $row['created_at']; ?>
                    </td>

                    <td>

                        <a href="attempt_quiz.php?quiz_id=<?php echo $row['id']; ?>"
                           class="btn btn-primary btn-sm">

                            ▶ Start Quiz
                        </a>

                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>
</div>

</body>
</html>