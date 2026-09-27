<?php

session_start();

include("../config/db.php");

require '../vendor/autoload.php';

use Smalot\PdfParser\Parser;

/*
|--------------------------------------------------------------------------
| SAVE QUIZ
|--------------------------------------------------------------------------
*/

if(isset($_POST['save_quiz'])){

    $note_id = $_POST['note_id'];

    $quiz_data = json_decode($_POST['quiz_data'], true);

    if($quiz_data){

        $quiz_title = "Auto Quiz - " . date("Y-m-d H:i:s");

        mysqli_query($conn,"
            INSERT INTO quizzes
            (
                teacher_id,
                title,
                note_id,
                created_at
            )
            VALUES
            (
                '".$_SESSION['user_id']."',
                '$quiz_title',
                '$note_id',
                NOW()
            )
        ");

        $quiz_id = mysqli_insert_id($conn);

        foreach($quiz_data as $q){

            $question = mysqli_real_escape_string(
                $conn,
                $q['question']
            );

            $option1 = mysqli_real_escape_string(
                $conn,
                $q['option1']
            );

            $option2 = mysqli_real_escape_string(
                $conn,
                $q['option2']
            );

            $option3 = mysqli_real_escape_string(
                $conn,
                $q['option3']
            );

            $option4 = mysqli_real_escape_string(
                $conn,
                $q['option4']
            );

            $answer = mysqli_real_escape_string(
                $conn,
                $q['answer']
            );

            mysqli_query($conn,"
                INSERT INTO questions
                (
                    quiz_id,
                    question,
                    option1,
                    option2,
                    option3,
                    option4,
                    correct_answer
                )
                VALUES
                (
                    '$quiz_id',
                    '$question',
                    '$option1',
                    '$option2',
                    '$option3',
                    '$option4',
                    '$answer'
                )
            ");
        }

        echo "
        <script>
            alert('Quiz Saved Successfully!');
            window.location.href='view_quizzes.php';
        </script>
        ";

        exit;
    }
}

/*
|--------------------------------------------------------------------------
| CHECK NOTE ID
|--------------------------------------------------------------------------
*/

if(!isset($_GET['note_id'])){
    die("Note ID missing");
}

$note_id = $_GET['note_id'];

$count = $_GET['count'] ?? 5;

$difficulty = $_GET['difficulty'] ?? 'Easy';

/*
|--------------------------------------------------------------------------
| GET NOTE
|--------------------------------------------------------------------------
*/

$result = mysqli_query(
    $conn,
    "SELECT * FROM notes WHERE id='$note_id'"
);

if(mysqli_num_rows($result) == 0){
    die("Note not found");
}

$note = mysqli_fetch_assoc($result);

/*
|--------------------------------------------------------------------------
| PDF PATH
|--------------------------------------------------------------------------
*/

$pdf_file = "../uploads/notes/" . $note['file'];

if(!file_exists($pdf_file)){
    die("PDF file not found");
}

/*
|--------------------------------------------------------------------------
| READ PDF
|--------------------------------------------------------------------------
*/

$parser = new Parser();

$pdf = $parser->parseFile($pdf_file);

$text = $pdf->getText();

if(empty(trim($text))){
    die("PDF text empty");
}

/* SMALLER TEXT = MORE STABLE */

$text = substr($text, 0, 1000);

/*
|--------------------------------------------------------------------------
| AI PROMPT
|--------------------------------------------------------------------------
*/

$prompt = "
Generate $count multiple choice questions from the following study material.

IMPORTANT RULES:

1. Return ONLY valid JSON
2. No explanations
3. No markdown
4. No extra text
5. Start with [
6. End with ]

FORMAT:

[
  {
    \"question\":\"Question here\",
    \"option1\":\"Option A\",
    \"option2\":\"Option B\",
    \"option3\":\"Option C\",
    \"option4\":\"Option D\",
    \"answer\":\"A\"
  }
]

Difficulty Level: $difficulty

Study Material:
$text
";

/*
|--------------------------------------------------------------------------
| GEMINI API
|--------------------------------------------------------------------------
*/

$apiKey = "API KEY";

$url =
"https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=".$apiKey;

$data = [
    "contents" => [
        [
            "parts" => [
                [
                    "text" => $prompt
                ]
            ]
        ]
    ]
];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

curl_setopt($ch, CURLOPT_POST, true);

curl_setopt(
    $ch,
    CURLOPT_HTTPHEADER,
    [
        "Content-Type: application/json"
    ]
);

curl_setopt(
    $ch,
    CURLOPT_POSTFIELDS,
    json_encode($data)
);

$response = curl_exec($ch);

if(curl_errno($ch)){

    die(
        "Curl Error: " .
        curl_error($ch)
    );
}

$http_code = curl_getinfo(
    $ch,
    CURLINFO_HTTP_CODE
);

curl_close($ch);

if($http_code != 200){

    echo "<pre>";

    echo htmlspecialchars($response);

    echo "</pre>";

    die("HTTP Code: ".$http_code);
}




/*
|--------------------------------------------------------------------------
| API ERROR
|--------------------------------------------------------------------------
*/

if($http_code != 200){

    die("
        <div style='
            padding:20px;
            background:#ffebee;
            color:#c62828;
            font-family:Arial;
            border-radius:10px;
            margin:30px;
        '>

        <h2>⚠ Gemini API Busy</h2>

        <p>
        Please try again after few seconds.
        </p>

        <p>
        HTTP Code: $http_code
        </p>

        </div>
    ");
}

/*
|--------------------------------------------------------------------------
| DECODE RESPONSE
|--------------------------------------------------------------------------
*/

$result = json_decode($response, true);

$quizText =
$result['candidates'][0]['content']['parts'][0]['text']
?? '';
$quizText = trim($quizText);

$quizText = str_replace("```json", "", $quizText);
$quizText = str_replace("```", "", $quizText);

$quizText = trim($quizText);

$questions = json_decode($quizText, true);

if (!$questions) {

    echo "<h3>JSON Decode Failed</h3>";

    echo "<pre>";
    echo htmlspecialchars($quizText);
    echo "</pre>";

    exit;
}

if(empty($quizText)){

    echo "<pre>";
    print_r($result);
    echo "</pre>";

    die("AI generation failed");
}

/*
|--------------------------------------------------------------------------
| CLEAN JSON
|--------------------------------------------------------------------------
*/

$quizText = trim($quizText);

$quizText = str_replace(
    "```json",
    "",
    $quizText
);

$quizText = str_replace(
    "```",
    "",
    $quizText
);

/*
|--------------------------------------------------------------------------
| CONVERT JSON
|--------------------------------------------------------------------------
*/



if(json_last_error() !== JSON_ERROR_NONE){

    echo "<h3>AI FORMAT ERROR</h3>";

    echo "<pre>";
    echo htmlspecialchars($quizText);
    echo "</pre>";

    exit;
}

?>



<!DOCTYPE html>
<html>

<head>

    <title>Preview Quiz</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <style>

        body{
            background: linear-gradient(135deg,#0f172a,#1e293b,#2563eb);
            min-height:100vh;
            color:white;
        }

        .quiz-box{
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .question-card{
            background: rgba(255,255,255,0.10);
            border: none;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .question-title{
            font-weight: bold;
            color: #38bdf8;
        }

        .option{
            padding: 8px;
            margin: 5px 0;
            background: rgba(255,255,255,0.05);
            border-radius: 10px;
        }

        .save-btn{
            padding: 14px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 12px;
        }

    </style>

</head>

<body>

<div class="container py-5">

    <div class="quiz-box">

        <h2 class="text-center mb-3">
            🤖 AI Generated Quiz Preview
        </h2>

        <h5 class="text-center text-light mb-4">
            <?php echo $note['title']; ?>
        </h5>

        <?php
        $number = 1;
        foreach($questions as $q){
        ?>

        <div class="question-card">

            <h5 class="question-title">
                <?php echo $number . ". " . $q['question']; ?>
            </h5>

            <div class="mt-3">

                <div class="option">A) <?php echo $q['option1']; ?></div>
                <div class="option">B) <?php echo $q['option2']; ?></div>
                <div class="option">C) <?php echo $q['option3']; ?></div>
                <div class="option">D) <?php echo $q['option4']; ?></div>

                <div class="alert alert-success mt-3">
                    Correct Answer:
                    <strong><?php echo $q['answer']; ?></strong>
                </div>

            </div>

        </div>

        <?php
        $number++;
        }
        ?>

        <form method="POST">

            <input type="hidden" name="note_id" value="<?php echo $note_id; ?>">

            <input type="hidden"
                   name="quiz_data"
                   value='<?php echo htmlspecialchars(json_encode($questions)); ?>'>

            <button type="submit"
                    name="save_quiz"
                    class="btn btn-warning w-100 save-btn shadow">

                💾 Save Quiz

            </button>

        </form>

    </div>

</div>

</body>
</html>