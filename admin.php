<?php
// Handle file upload and store data in the database
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['name'])) {
    $name = $_POST['name'];
    $designation = $_POST['designation'];
    $image = $_FILES['image'];

    // Check if the image was uploaded
    if ($image['error'] == 0) {
        // Define the target directory
        $targetDir = "img/uploads/";
        // Define the target file path
        $targetFile = $targetDir . basename($image["name"]);
        // Move the uploaded file to the target directory
        if (move_uploaded_file($image["tmp_name"], $targetFile)) {
            // Connect to the database
            $conn = new mysqli('localhost', 'root', '', 'leo');
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Insert the data into the database
            $stmt = $conn->prepare("INSERT INTO team (name, designation, image_path) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $name, $designation, $targetFile);
            if ($stmt->execute()) {
                echo "added successfully!";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
            $conn->close();
        } else {
            echo "Error uploading the file.";
        }
    } else {
        echo "No file uploaded or upload error.";
    }
}

?>
