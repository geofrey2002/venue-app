<?php
// lock_venue.php
// Stores locked venues and reasons in locked_venues.json
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $venueId = $_POST['venue_id'] ?? '';
    $reason = $_POST['reason'] ?? '';
    if (!$venueId || !$reason) {
        echo '<span style="color:red;">Venue and reason required.</span>';
        exit;
    }
    $file = 'locked_venues.json';
    $locked = file_exists($file) ? json_decode(file_get_contents($file), true) : [];
    $locked[$venueId] = $reason;
    file_put_contents($file, json_encode($locked, JSON_PRETTY_PRINT));
    echo '<span style="color:green;">Venue locked successfully.</span>';
    exit;
}
echo '<span style="color:red;">Invalid request.</span>';
