<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $risk_id = $_POST['risk_id'];

    // Database connection
    $servername = "localhost";
$username = "root"; // Your DB username
$password = "";     // Your DB password
$dbname = "risk";   // Your DB name

    $conn = new mysqli($risk, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare a delete statement
    $sql = "DELETE FROM risk_register WHERE id = ?";

    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $risk_id);

        if ($stmt->execute()) {
            echo "Record deleted successfully.";
        } else {
            echo "Error deleting record: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Error preparing the statement: " . $conn->error;
    }

    $conn->close();

    // Redirect back to the page with the table, or elsewhere
    header("Location: index.php");
    exit;
}
?>
