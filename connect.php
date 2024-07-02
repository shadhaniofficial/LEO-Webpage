<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gmail = $_POST['gmail'];
    $password = $_POST['password'];
    
    // Db Connection
    $conn = new mysqli('localhost', 'root', '', 'leo');
    
    if ($conn->connect_error) {
        die('Connection Failed: ' . $conn->connect_error);
    } else {
        $stmt = $conn->prepare("INSERT INTO signin (gmail, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $gmail, $password);
        $stmt->execute();
        echo "Registration Successful!";
        $stmt->close();
        $conn->close();
    }
}
?>

