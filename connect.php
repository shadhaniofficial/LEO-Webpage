<?php
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $gmail = $_POST['gmail'];
    $password = $_POST['password'];
    
    // Db Connection
    $conn = new mysqli('localhost', 'root', '', 'leo');
    
    if ($conn->connect_error) {
        die('Connection Failed: ' . $conn->connect_error);
    } else {
        $stmt = $conn->prepare("SELECT * FROM signin WHERE gmail = ? AND password = ?");
        $stmt->bind_param("ss", $gmail, $password);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Successful login
            $_SESSION['gmail'] = $gmail; // Set session variable
            $response = array('success' => true, 'redirect' => 'admin.html');
        } else {
            // Failed login
            $response = array('success' => false, 'message' => 'Invalid email or password!');
        }
        
        echo json_encode($response); // Return response as JSON
        exit();
        
        $stmt->close();
        $conn->close();
    }
}
?>
