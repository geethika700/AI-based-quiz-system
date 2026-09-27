<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

include '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $teacher_id = $_SESSION['user_id'];
    $title = mysqli_real_escape_string($conn, $_POST['title']);

    $file_name = $_FILES['note_file']['name'];
    $tmp_name = $_FILES['note_file']['tmp_name'];

    $file_type = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    $allowed = ['pdf', 'jpg', 'jpeg', 'png', 'txt'];

    if (in_array($file_type, $allowed)) {

        $new_file_name = time() . "_" . $file_name;

        $upload_path = "../../uploads/notes/" . $new_file_name;

        if (move_uploaded_file($tmp_name, $upload_path)) {

            $sql = "INSERT INTO notes (teacher_id, title, file_name, file_type)
                    VALUES ('$teacher_id', '$title', '$new_file_name', '$file_type')";

            if (mysqli_query($conn, $sql)) {

                echo "Note Uploaded Successfully!";

            } else {

                echo "Database Error: " . mysqli_error($conn);
            }

        } else {

            echo "File Upload Failed";
        }

    } else {

        echo "Invalid File Type";
    }

} else {
    echo "Invalid Request";
}
?>