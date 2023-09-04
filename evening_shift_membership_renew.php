<!DOCTYPE html>
<html>
<head>
    <title>Evening Shift Membership Renewal of Evening Shift</title>
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
    <h1>Evening Shift Membership Renewal</h1>

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

            // Update the membership duration for the selected member in the evening_shift table
            $updateQuery = "UPDATE evening_shift SET MembershipDurationDays = MembershipDurationDays + $membershipIncrement WHERE MemberID = '$memberID'";
            if ($conn->query($updateQuery) === TRUE) {
                echo "Membership duration updated successfully.";
            } else {
                echo "Error updating membership duration: " . $conn->error;
            }
        }
    }

    $eveningShiftMembersSql = "SELECT member.MemberID, member.FirstName, member.LastName FROM member INNER JOIN evening_shift ON member.MemberID = evening_shift.MemberID";
    $eveningShiftMembersResult = $conn->query($eveningShiftMembersSql);

    if ($eveningShiftMembersResult && $eveningShiftMembersResult->num_rows > 0) {
        echo '<form action="evening_shift_membership_renew.php" method="post">';
        echo '<table>
                <tr>
                    <th>Member ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Membership Increment</th>
                </tr>';

        while ($row = $eveningShiftMembersResult->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['MemberID']}</td>
                    <td>{$row['FirstName']}</td>
                    <td>{$row['LastName']}</td>
                    <td>
                        <form action='evening_shift_membership_renew.php' method='post'>
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
