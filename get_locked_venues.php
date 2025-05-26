<?php
// get_locked_venues.php
header('Content-Type: application/json');
$file = 'locked_venues.json';
if (file_exists($file)) {
    echo file_get_contents($file);
} else {
    echo json_encode([]);
}
