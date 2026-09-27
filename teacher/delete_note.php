<?php
include '../config/db.php';

if(isset($_GET['id'])){

    $id = $_GET['id'];

    $result = mysqli_query($conn, "SELECT file FROM notes WHERE id='$id'");
    $note = mysqli_fetch_assoc($result);

    if($note){

        $file = "../uploads/notes/" . $note['file'];

        if(file_exists($file)){
            unlink($file);
        }
    }

    mysqli_query($conn, "DELETE FROM notes WHERE id='$id'");
}

header("Location: upload_notes.php");
exit;