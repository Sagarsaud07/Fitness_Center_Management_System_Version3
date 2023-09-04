<!DOCTYPE html>
<html>
<head>
    <title>Membership Renewal Of Morning Shift</title>
    <style>
        body {
            border: 1px solid #ccc;
            padding: 20px;
        }

        h1 {
            /* Your h1 styles */
        }

        table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #ccc;
        }

        th, td {
            text-align: left;
            padding: 8px;
            border: 1px solid #ccc;
        }

        /* Add your other CSS styles here */
    </style>
</head>
<body>
    <h1>Membership Renewal Of Morning Shift</h1>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "fitness_center_management_system";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['incrementMembership']) && isset($_POST['memberID']) && isset($_POST['membershipIncrement'])) {
            $memberID = $_POST['memberID'];
            $membershipIncrement = $_POST['membershipIncrement'];

            // Update the membership duration for the selected member in the morning_shift table
            $updateQuery = "UPDATE morning_shift SET MembershipDurationDays = MembershipDurationDays + $membershipIncrement WHERE MemberID = '$memberID'";
            if ($conn->query($updateQuery) === TRUE) {
                echo "Membership duration updated successfully.";
            } else {
                echo "Error updating membership duration: " . $conn->error;
            }
        }
    }

    $morningShiftMembersSql = "SELECT member.MemberID, member.FirstName, member.LastName FROM member INNER JOIN morning_shift ON member.MemberID = morning_shift.MemberID";
    $morningShiftMembersResult = $conn->query($morningShiftMembersSql);

    if ($morningShiftMembersResult && $morningShiftMembersResult->num_rows > 0) {
        echo '<form action="MembershipRenew.php" method="post">';
        echo '<table>
                <tr>
                    <th>Member ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Membership Increment</th>
                </tr>';

        while ($row = $morningShiftMembersResult->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['MemberID']}</td>
                    <td>{$row['FirstName']}</td>
                    <td>{$row['LastName']}</td>
                    <td>
                        <form action='MembershipRenew.php' method='post'>
                            <input type='hidden' name='memberID' value='" . $row['MemberID'] . "'>
                            <input type='number' name='membershipIncrement' min='1' placeholder='Enter days'>
                            <input type='submit' name='incrementMembership' value='Increment'>
                        </form>
                    </td>
                  </tr>";
        }

        echo '</table>';
        echo '</form>';
    } else {
        echo "<p>No member data found.</p>";
    }

    $conn->close();
    ?>

    <a href="dashboard.html">Go back to Dashboard</a>
</body>
</html>
