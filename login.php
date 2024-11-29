


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">

    <title>Login</title>
</head>
<header>
    <h1>Library Service</h1>
</header>
<body>
<nav class="navbar">
        <div>
            <a href="homepage.php">Home</a>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
            
            <?php if (isset($_SESSION['Username'])): ?>
                <a href="logout.php" >Logout</a>
            <?php endif; ?>
        </div>
    </nav>

<form class="form1" action="login.php" method="POST">
    <label for="Username">Username:</label>
    <input type="text" name="Username"  required><br><br>
    <label for="Password">Password:</label>
    <input type="password" name="Password" required><br><br>
    <input type="submit" value="Login" id="button">
</form>

</body>
<footer class="footer">
<a>©2024 Created by Oskar Sadowski</a>

</footer>
</html>

<?php 
session_start();
include "database.php";
// stores username and password in a variable to be compared with user in database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputtedUsername = $_POST['Username'];
    $inputtedPassword = $_POST['Password'];
//searches database for username and password that are correct
    $logincheck = "SELECT * FROM users WHERE username = '$inputtedUsername' AND password = '$inputtedPassword'";
    $result = $conn->query($logincheck);

    if ($result->num_rows > 0) {
       
        // compare password
            $_SESSION['Username'] = $inputtedUsername;
            echo "Login successful! Welcome, " . $_SESSION['Username'];
            header("Location: homepage.php");
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "No user found with that username.";
    }


    


$conn->close();

?>