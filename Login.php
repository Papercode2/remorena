<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    
    // Validate input (e.g., check for empty fields)
    if (empty($username) || empty($password)) {
        echo "Please fill in both fields.";
    } else {
        // Establish database connection
        $servername = "localhost"; // Replace with your database server name
        $username_db = "root"; // Replace with your database username
        $password_db = ""; // Replace with your database password
        $dbname = "remorena"; // Replace with your database name

        $conn = new mysqli($servername, $username_db, $password_db, $dbname);
        
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        // Prepare and execute query to retrieve user by username
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $storedPassword = $row["password"]; // Assuming the hashed password is stored in the "password" column
            
            // Verify the password
            if (password_verify($password, $storedPassword)) {
                echo "Login successful!";
                // Redirect to the user's dashboard or other authorized page
                header("location:dashboard.html");
                exit();
            } else {
                echo "Invalid username or password.";
            }
        } else {
            echo "Invalid username or password.";
        }
        
        $stmt->close();
        $conn->close();
    }
}
?>