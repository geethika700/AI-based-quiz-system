<?php
require_once "../config/db.php";

$api_key = "AIzaSyDxL_uj9mmyQOShTWaGgEk8SCCK7-PcT6o"; // 

$note_id = $_GET['note_id'] ?? 0;

// Get file from DB
$result = mysqli_query($conn, "SELECT * FROM notes WHERE id='$note_id'");
$note = mysqli_fetch_assoc($result);

if (!$note) {
    die("Note not found");
}

$file_path = "../uploads/notes/" . $note['file'];

if (!file_exists($file_path)) {
    die("File not found");
}

// Read PDF text
require_once "../vendor/autoload.php";

use Smalot\PdfParser\Parser;

$parser = new Parser();
$pdf = $parser->parseFile($file_path);
$text = $pdf->getText();

if (!$text) {
    die("Empty PDF text");
}

// Gemini Prompt
$prompt = "
Create 5 multiple choice questions from this content.
Format strictly like:

Question
...
A) ...
B) ...
C) ...
D) ...
Correct Answer: A

Content:
$text
";

// API Call
$data = [
    "contents" => [
        [
            "parts" => [
                ["text" => $prompt]
            ]
        ]
    ]
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=$api_key");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

$response = curl_exec($ch);
curl_close($ch);

$result = json_decode($response, true);

$ai_text = $result['candidates'][0]['content']['parts'][0]['text'] ?? null;

if (!$ai_text) {
    die("AI generation failed");
}

// Parse Questions
$blocks = preg_split('/Question\s*\d*:?/i', $ai_text);

$inserted = 0;

foreach ($blocks as $q) {

    $q = trim($q);
    if (strlen($q) < 10) continue;

    preg_match('/^(.*?)(A\))/s', $q, $mq);
    $question = trim($mq[1] ?? '');

    preg_match('/A\)\s*(.*?)B\)/s', $q, $a);
    preg_match('/B\)\s*(.*?)C\)/s', $q, $b);
    preg_match('/C\)\s*(.*?)D\)/s', $q, $c);
    preg_match('/D\)\s*(.*?)Correct Answer:/s', $q, $d);
    preg_match('/Correct Answer:\s*([A-D])/i', $q, $ans);

    if (!$question) continue;

    mysqli_query($conn, "
        INSERT INTO questions (
            quiz_id,
            question,
            option1,
            option2,
            option3,
            option4,
            correct_answer
        ) VALUES (
            '$note_id',
            '".mysqli_real_escape_string($conn, $question)."',
            '".mysqli_real_escape_string($conn, $a[1] ?? '')."',
            '".mysqli_real_escape_string($conn, $b[1] ?? '')."',
            '".mysqli_real_escape_string($conn, $c[1] ?? '')."',
            '".mysqli_real_escape_string($conn, $d[1] ?? '')."',
            '".($ans[1] ?? '')."'
        )
    ");

    $inserted++;
}

foreach ($questions as $q) {

    $q = trim($q);
    if ($q == "") continue;

    preg_match('/^(.*?)(A\))/s', $q, $matchQ);
    $question = trim($matchQ[1] ?? '');

    preg_match('/A\)\s*(.*?)B\)/s', $q, $a);
    preg_match('/B\)\s*(.*?)C\)/s', $q, $b);
    preg_match('/C\)\s*(.*?)D\)/s', $q, $c);
    preg_match('/D\)\s*(.*?)Correct Answer:/s', $q, $d);
    preg_match('/Correct Answer:\s*([A-D])/s', $q, $ans);

    mysqli_query($conn, "
        INSERT INTO questions (
            quiz_id,
            question,
            option1,
            option2,
            option3,
            option4,
            correct_answer
        ) VALUES (
            '$note_id',
            '".mysqli_real_escape_string($conn, $question)."',
            '".mysqli_real_escape_string($conn, $a[1] ?? '')."',
            '".mysqli_real_escape_string($conn, $b[1] ?? '')."',
            '".mysqli_real_escape_string($conn, $c[1] ?? '')."',
            '".mysqli_real_escape_string($conn, $d[1] ?? '')."',
            '".($ans[1] ?? '')."'
        )
    ");
}

echo "Inserted Questions: " . $inserted;
?>