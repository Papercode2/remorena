<!DOCTYPE html>
<html>
<head>
    <title> REMORENA CYBER</title>
</head>
</style>
<center>
<body style="background-color:powderblue;">
    <h2>Signup Form</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <label>Username:</label>
        <input type="text" name="username" required><br>

        <label>Email:</label>
        <input type="email" name="email" required><br>

        <label>Phone:</label>
        <input type="tel" name="phone" required><br>

        <label>Password:</label>
        <input type="password" name="password" required><br>

        <input type="submit" value="Signup">
    </form>
    <button><a href="logout.php" class="dashboard-button">logout</a></button>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Replace with your actual database credentials
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "remorena";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepare and bind the SQL statement
        $stmt = $conn->prepare("INSERT INTO users (username, email, phone, password) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $phone, $hashed_password);

        // Retrieve form data
        $username = $_POST['username'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];

        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Execute the prepared statement
        if ($stmt->execute()) {
            echo "Signup successful!";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement and connection
        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>
