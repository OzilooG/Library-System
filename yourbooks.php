<?php
session_start();
include "database.php"; 

if (!isset($_SESSION['Username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['Username'];

// query to get books reserved by the logged in user
$query = "SELECT b.ISBN, b.BookTitle, b.Author, b.Edition, b.Year, b.Category, r.ReservedDate
    FROM Reservations r
    JOIN Books b ON r.ISBN = b.ISBN
    WHERE r.Username = '$username'";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css">

    <title>Your Reserved Books</title>
</head>
<body>
<header>
    <h1>Library Service</h1>
</header>
<nav class="navbar">
    <div>
        <a href="homepage.php">Home</a>
        <a href="search.php">Search</a>
        <a href="yourbooks.php">View Reserved</a>
        <a href="logout.php">Logout</a>
    </div>
</nav>
<h2>Books You Have Reserved:</h2>
<?php
if ($result->num_rows > 0) {
    
    echo "<table border='1'>
            <tr>
                <th>ISBN</th>
                <th>Title</th>
                <th>Author</th>
                <th>Edition</th>
                <th>Year</th>
                <th>Category</th>
                <th>Reserved Date</th>
                <th>Action</th>
            </tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['ISBN']}</td>
                <td>{$row['BookTitle']}</td>
                <td>{$row['Author']}</td>
                <td>{$row['Edition']}</td>
                <td>{$row['Year']}</td>
                <td>{$row['Category']}</td>
                <td>{$row['ReservedDate']}</td>
                <td>
                    <form class='svform' action='remove_reservation.php' method='POST'>
                        <input type='hidden' name='isbn' value='{$row['ISBN']}'>
                        <input type='submit' value='Remove Reservation'>
                    </form>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>You have no reserved books at the moment.</p>";
}

$conn->close();
?>

</body>
<footer class="footer">
    <a>©2024 Created by Oskar Sadowski</a>
</footer>
</html>
