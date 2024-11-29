<?php

session_start();
if (!isset($_SESSION['Username'])) {
    // redirect to login page if not logged in
    header("Location: login.php");
    exit();
}



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">
    

    <title>Library System</title>
</head>
<header>
    <h1>Library Service</h1>
 <!-- prints the users name beside welcome  -->
    <h2>Welcome, <?php echo $_SESSION['Username']; ?>!</h2>
    
</header>
<body>
    <nav class="navbar">
        <div>
            <a href="homepage.php">Home</a>
            <a href="search.php">Search</a>
            <a href="yourbooks.php">View Reserved</a>
<!-- logout button only appears when user is logged in -->
            <?php if (isset($_SESSION['Username'])): ?>
                <a href="logout.php">Logout</a>
                <!-- when logged in the login and register button dissapear -->
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            <?php endif; ?>
        </div>
    </nav>

    <p id="hpara">Welcome to your personal library account where you can <br>
       manage all your books, search for books in our domain,
       view books that maybe reserved and reserve books <br>
       for your own personal use.
    </p>
    

    
</body>
<footer class="footer">
<a>©2024 Created by Oskar Sadowski</a>

</footer>
</html>