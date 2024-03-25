<?php
$servername = "localhost";
$username = "root";  // Your DB username
$password = "";      // Your DB password
$dbname = "risk";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT risk_name,risk_impact AS impact, risk_likelihood AS likelihood, 
        CASE 
            WHEN risk_score >= 25 THEN 'Critical'
            WHEN risk_score >= 16 THEN 'High'
            WHEN risk_score >= 6 THEN 'Medium'
            ELSE 'Low'
        END AS category
        FROM risk_register";

$result = $conn->query($sql);

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}



$conn->close();

echo json_encode($data);
?>
