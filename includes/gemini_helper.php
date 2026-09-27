<?php

include '../config/gemini.php';

function generateQuizFromGemini($text) {

    $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . GEMINI_API_KEY;

    $prompt = "
Create 5 multiple choice questions from the following study notes.

Rules:
- Each question must have 4 options
- Mention correct answer
- Questions should be high quality
- Output format:

Question:
A)
B)
C)
D)
Correct Answer:

Study Notes:
" . $text;

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

    $headers = [
        "Content-Type: application/json"
    ];

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);

    curl_close($ch);

    $result = json_decode($response, true);

    return $result['candidates'][0]['content']['parts'][0]['text'] ?? "";
}
?>