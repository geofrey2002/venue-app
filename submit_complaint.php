<?php
// submit_complaint.php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['user'] ?? 'Anonymous';
    $text = $_POST['text'] ?? '';
    if (!$text) {
        echo '<span style="color:red;">Complaint cannot be empty.</span>';
        exit;
    }
    $file = 'complaints.json';
    $complaints = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    $complaints[] = [
        'user' => $user,
        'text' => $text,
        'date' => date('Y-m-d H:i:s')
    ];
    file_put_contents($file, json_encode($complaints, JSON_PRETTY_PRINT));
    echo '<span style="color:green;">Complaint submitted successfully.</span>';
    exit;
}
echo '<span style="color:red;">Invalid request.</span>';
