<?php

include("../config/db.php");

if(!isset($_GET['note_id'])){
    die("Note ID missing");
}

$note_id = $_GET['note_id'];

$result = mysqli_query(
    $conn,
    "SELECT * FROM notes WHERE id='$note_id'"
);

if(mysqli_num_rows($result) == 0){
    die("Note not found");
}

$note = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Generate AI Quiz</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>

        body{
            background: linear-gradient(135deg,#0f172a,#1e293b,#2563eb);
            min-height:100vh;
            font-family: Arial;
            color:white;
        }

        .box{
            max-width:600px;
            margin:auto;
            margin-top:60px;
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(12px);
            border-radius:20px;
            padding:30px;
            box-shadow:0 10px 30px rgba(0,0,0,0.3);
        }

        .title{
            text-align:center;
            font-size:28px;
            font-weight:bold;
            margin-bottom:25px;
        }

        .note-box{
            background: rgba(255,255,255,0.10);
            padding:15px;
            border-radius:12px;
            margin-bottom:20px;
        }

        label{
            font-weight:bold;
            margin-top:10px;
        }

        input,
        select{
            width:100%;
            padding:12px;
            margin-top:8px;
            margin-bottom:18px;
            border-radius:10px;
            border:none;
            outline:none;
        }

        input, select{
            background: rgba(255,255,255,0.15);
            color:white;
        }

        input::placeholder{
            color:#ddd;
        }

        option{
            color:black;
        }

        .btn-custom{
            width:100%;
            padding:14px;
            font-size:18px;
            font-weight:bold;
            border-radius:12px;
            background:#facc15;
            border:none;
            color:black;
            transition:0.3s;
        }

        .btn-custom:hover{
            background:#eab308;
            transform:scale(1.02);
        }

    </style>

</head>

<body>

<div class="box">

    <div class="title">
        🤖 Auto Generate Quiz
    </div>

    <div class="note-box">

        <strong>Selected Note:</strong>
        <br><br>

        <?php echo $note['title']; ?>

    </div>

    <form method="GET" action="preview_quiz.php">

        <input type="hidden" name="note_id" value="<?= $note_id ?>">

        <label>Number of Questions</label>
        <input type="number" name="count" min="1" max="50" value="5" required>

        <label>Difficulty Level</label>
        <select name="difficulty">
            <option>Easy</option>
            <option>Medium</option>
            <option>Hard</option>
        </select>

        <button type="submit" class="btn-custom">
            🚀 Preview Quiz
        </button>

    </form>

</div>

</body>
</html>