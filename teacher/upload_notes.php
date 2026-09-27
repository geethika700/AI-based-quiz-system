<?php
include("../config/db.php");

$result = mysqli_query($conn, "SELECT * FROM notes ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Upload Notes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet">

<link rel="stylesheet" href="../assets/css/style.css">

    <style>

        body{

background:

linear-gradient(
rgba(15,23,42,0.75),
rgba(30,64,175,0.75)
),

url('../assets/images/teacher.jpg');


background-size:cover;

background-position:center;

background-attachment:fixed;

min-height:100vh;

color:white;

}

.container{
    max-width:1200px;
}

.page-box{
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(10px);
    border-radius:25px;
    padding:40px;
    margin-top:40px;
    color:white;
    box-shadow:0 10px 30px rgba(0,0,0,0.3);
}

.card{
    background: rgba(255,255,255,0.10);
    border:none;
    border-radius:18px;
    color:white;
}

input[type=text],
input[type=file]{
    width:100%;
    padding:12px;
    border-radius:10px;
    border:none;
    margin-bottom:15px;
}

table{
    width:100%;
}

table th{
    background:#2563eb;
    color:white;
}

table td{
    background:rgba(255,255,255,0.05);
    color:white;
}

a{
    text-decoration:none;
}

</style>

</head>

<body>
    <?php include '../includes/teacher_sidebar.php'; ?>

<div class="container">

    <div class="page-box">

        <h2>Upload Notes</h2>

        <?php

        if(isset($_POST['upload_note'])){

            $title = $_POST['title'];

            $file = $_FILES['file']['name'];
            $tmp = $_FILES['file']['tmp_name'];

            $new_name = time() . "_" . $file;

            move_uploaded_file(
                $tmp,
                "../uploads/notes/" . $new_name
            );

            mysqli_query($conn, "
                INSERT INTO notes
                (title, file)
                VALUES
                ('$title', '$new_name')
            ");

            echo "<p style='color:green;'>
                    Note uploaded successfully!
                  </p>";

            header("Refresh:1");
        }

        ?>

        <form method="POST"
              enctype="multipart/form-data">

            <label>Note Title</label>

            <input type="text"
                   name="title"
                   required>

            <label>Upload PDF</label>

            <input type="file"
                   name="file"
                   accept=".pdf"
                   required>

            <button type="submit"
        name="upload_note"
        class="btn btn-primary">

    📚 Upload Note

</button>

        </form>

        <h2>Uploaded Notes</h2>

       <table class="table table-dark table-hover mt-4">

            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>File</th>
                <th>Actions</th>
            </tr>

            <?php while($row = mysqli_fetch_assoc($result)) { ?>

            <tr>

                <td><?= $row['id'] ?></td>

                <td><?= $row['title'] ?></td>

                <td>

                    <td>

    <a href="../uploads/notes/<?= $row['file'] ?>"
       target="_blank"
       class="btn btn-sm btn-outline-light">

        📄 View PDF

    </a>

</td>

                </td>

                <td>

                    



<a href="delete_note.php?id=<?= $row['id'] ?>"
   class="btn btn-sm btn-danger"
   onclick="return confirm('Delete this note?')">
    Delete
</a>

<a href="generate_quiz_form.php?note_id=<?= $row['id'] ?>"
   class="btn btn-sm btn-success">
    Auto Quiz
</a>

                </td>

            </tr>

            <?php } ?>

        </table>

    </div>

</div>
</div>

</body>
</html>