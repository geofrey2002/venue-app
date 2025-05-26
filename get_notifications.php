<?php
// get_notifications.php
header('Content-Type: application/json');
$file = 'notifications.json';
if (file_exists($file)) {
    echo file_get_contents($file);
} else {
    echo json_encode([]);
}
