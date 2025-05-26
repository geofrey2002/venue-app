<?php
// get_complaints.php
header('Content-Type: application/json');
$file = 'complaints.json';
if (file_exists($file)) {
    echo file_get_contents($file);
} else {
    echo json_encode([]);
}
