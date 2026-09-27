<?php
include '../includes/auth_check.php';
include '../config/db.php';

// get teacher id
$teacher_id = $_SESSION['user_id'];

// fetch notes
$sql = "SELECT * FROM notes WHERE teacher_id = '$teacher_id' ORDER BY uploaded_at DESC";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>My Notes</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">
</head>

<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-dark">

    <div class="container-fluid">

        <span class="navbar-brand">My Notes</span>

        <a href="../teacher/dashboard.php" class="btn btn-light btn-sm">
            Back
        </a>

    </div>

</nav>

<div class="container mt-5">

    <h3 class="mb-4">
        Uploaded Notes
    </h3>

    <div class="card shadow p-3">

        <table class="table table-bordered table-striped">

            <thead class="table-dark">

                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>File</th>
                    <th>Type</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>

            </thead>

            <tbody>

            <?php while($row = mysqli_fetch_assoc($result)) { ?>

                <tr>

                    <td><?php echo $row['id']; ?></td>

                    <td><?php echo $row['title']; ?></td>

                    <td><?php echo $row['file_name']; ?></td>

                    <td><?php echo $row['file_type']; ?></td>

                    <td><?php echo $row['uploaded_at']; ?></td>

                    <td>

                        <a href="../uploads/notes/<?php echo $row['file_name']; ?>"
                           class="btn btn-success btn-sm"
                           target="_blank">

                            View

                        </a>

                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>