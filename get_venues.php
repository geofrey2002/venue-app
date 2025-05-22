<?php
// get_venues.php
header('Content-Type: application/json');

$venues = [
    ["id" => 1, "name" => "102 C", "capacity" => 100, "features" => "Projector,camera"],
    ["id" => 2, "name" => "Lab 1", "capacity" => 70, "features" => "Computers, Internet ,projector ,camera"],
    ["id" => 3, "name" => "NYERERE HAL", "capacity" => 200, "features" => "Whiteboard,Stage, Sound System, Wi-Fi, Projectors,Camera"],
    ["id" => 4, "name" => "D-005/D-006", "capacity" => 80, "features" => "Microphone, Screen,camera"],
    ["id" => 5, "name" => "LPII-GF-P2", "capacity" => 70, "features" => "Projector, Wi-Fi,camera"]
];

echo json_encode($venues);
?>