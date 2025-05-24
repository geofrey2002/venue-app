<?php
// set_key_given.php
// Updates key_given.json for key collection status
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idx = $_POST['idx'] ?? '';
    $type = $_POST['type'] ?? 'given';
    $checked = $_POST['checked'] ?? '0';
    $file = 'key_given.json';
    $keys = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    if (!isset($keys[$idx]))
        $keys[$idx] = ["given" => false, "returned" => false];
    $keys[$idx][$type] = $checked ? true : false;
    file_put_contents($file, json_encode($keys, JSON_PRETTY_PRINT));
    // Notification logic: create notification for the user if key is given or returned
    if ($type === 'given' && $checked) {
        $notifFile = 'notifications.json';
        $notifs = file_exists($notifFile) ? json_decode(file_get_contents($notifFile), true) : [];
        $notifs[] = ["idx" => $idx, "type" => "given", "time" => date('Y-m-d H:i:s')];
        file_put_contents($notifFile, json_encode($notifs, JSON_PRETTY_PRINT));
    }
    if ($type === 'returned' && $checked) {
        $notifFile = 'notifications.json';
        $notifs = file_exists($notifFile) ? json_decode(file_get_contents($notifFile), true) : [];
        $notifs[] = ["idx" => $idx, "type" => "returned", "time" => date('Y-m-d H:i:s')];
        file_put_contents($notifFile, json_encode($notifs, JSON_PRETTY_PRINT));
    }
    echo 'OK';
    exit;
}
echo 'Invalid request';
