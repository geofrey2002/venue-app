<?php
// book_venue.php

$bookingsFile = 'bookings.json';

// Create file if it doesn't exist
if (!file_exists($bookingsFile)) {
    file_put_contents($bookingsFile, json_encode([]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Simulate user role from session or request (replace with real authentication in production)
    session_start();
    $userRole = $_SESSION['userRole'] ?? ($_POST['userRole'] ?? 'guest');
    if ($userRole !== 'crs' && $userRole !== 'teacher') {
        echo "❌ Only authorized CRS or Teacher can book venues.";
        exit;
    }

    $venueId = $_POST['venue_id'] ?? '';
    $date = $_POST['date'] ?? '';
    $from = $_POST['from'] ?? '';
    $to = $_POST['to'] ?? '';

    if ($venueId && $date && $from && $to) {
        // Prevent booking for past dates (robust check)
        $today = strtotime(date('Y-m-d'));
        $bookingDate = strtotime($date);
        if ($bookingDate < $today) {
            echo "❌ You cannot book a venue for a past date.";
            exit;
        }
        // Load existing bookings
        $bookings = json_decode(file_get_contents($bookingsFile), true);

        // Check for a conflict
        foreach ($bookings as $booking) {
            if (
                $booking['venue_id'] == $venueId &&
                $booking['date'] == $date &&
                !($to <= $booking['from'] || $from >= $booking['to'])
            ) {
                echo "❌ This venue is already booked on $date from {$booking['from']} to {$booking['to']}.";
                exit;
            }
        }

        // No conflict – add the booking
        $bookings[] = [
            'venue_id' => $venueId,
            'date' => $date,
            'from' => $from,
            'to' => $to,
            'booked_by' => $_SESSION['fullname'] ?? 'Unknown'
        ];
        file_put_contents($bookingsFile, json_encode($bookings, JSON_PRETTY_PRINT));
        echo "✅ Booking confirmed for venue ID $venueId on $date from $from to $to.";
    } else {
        echo "❌ Missing data.";
    }
} else {
    echo "❌ Invalid request method.";
}
