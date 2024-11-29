
<?php

include "database.php";

// checks if variables are set
if ( isset($_POST['Username']) && isset($_POST['Password']) && isset($_POST['FirstName']) && isset($_POST['Surname'])&& 
    isset($_POST['AddressLine1'])&& isset($_POST['AddressLine2'])&& isset($_POST['City'])&& isset($_POST['Telephone'])&& isset($_POST['Mobile'])) {
$u = $_POST['Username'];
$p = $_POST['Password'];
$f = $_POST['FirstName'];
$s = $_POST['Surname'];
$a1 = $_POST['AddressLine1'];
$a2 = $_POST['AddressLine2'];
$c = $_POST['City'];
$t = $_POST['Telephone'];
$m = $_POST['Mobile']; 

// chekcs if data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $inputtedUsername = $_POST['Username'];
    $inputtedMobile = $_POST['Mobile'];
    $inputtedPassword = $_POST['Password'];
    $confirmPassword = $_POST['confPass'];

    // checks all fields are entered
    if (empty($inputtedUsername) || empty($inputtedMobile) || empty($inputtedPassword) || empty($confirmPassword)) {
        die("All fields are required.");
    }

    // checks mobile number: numeric and exactly 10 digits
    if (!is_numeric($inputtedMobile) || strlen($inputtedMobile) != 10) {
        die("Mobile number must be numeric and 10 digits long.");
    }

    // checks password length
    if (strlen($inputtedPassword) < 6) {
        die("Password must be at least 6 characters long.");
    }

    // password confirmation
    if ($inputtedPassword !== $confirmPassword) {
        die("Password and Confirm Password do not match.");
    }

    // check if username is unique
    $getuser = "SELECT username FROM users WHERE username = '$inputtedUsername'";
    $result = $conn->query($getuser);

    if ($result->num_rows > 0) {
        die("Username already exists. Please choose another.");
    }
    else{
        //if all is inputted correctly, register user
        $sql = "INSERT INTO users (Username, Password, FirstName, Surname, AddressLine1, AddressLine2, City, Telephone, Mobile)
        VALUES ('$u', '$p', '$f', '$s', '$a1', '$a2', '$c', '$t', '$m')";
    }
if ($conn->query($sql) === TRUE) {
echo "Registered successfully";
} else {
echo "Error: " . $sql . "<br>" . $conn->error;
}
    
}
$conn->close();
}
    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">


    <title>Register</title>
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
<form class="form1" method="post">
<p>Username:
<input type="text" name="Username" required></p>
<p>Password:
<input type="password" name="Password" minlenght='6' required></p>
<p>Confirm Password:
<input type="password" name="confPass" minlength='6' required></p>
<p>Firstname:
<input type="text" name="FirstName" required></p>
<p>Surname:
<input type="text" name="Surname" required></p>
<p>AddressLine1:
<input type="text" name="AddressLine1" required></p>
<p>Addressline2:
<input type="text" name="AddressLine2"></p>
<p>City:
<input type="text" name="City" required></p>
<p>Telephone:
<input type="text" name="Telephone"></p>
<p>Mobile:
<input type="text" name="Mobile" required></p>

<p><input type="submit" value="Register" id="button"/></p>

</form>

</body>
<footer class="footer">
<a>©2024 Created by Oskar Sadowski</a>

</footer>
</html>