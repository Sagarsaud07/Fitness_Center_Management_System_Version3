<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "fitness_center_management_system";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update membership duration for active members in the evening_shift table
$updateQuery = "UPDATE evening_shift SET MembershipDurationDays = GREATEST(MembershipDurationDays - 1, 0) WHERE MembershipStatus = 'Active'";
$conn->query($updateQuery);

$conn->close();
?>
