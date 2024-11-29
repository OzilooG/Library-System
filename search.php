<?php
session_start();
include "database.php"; 

if (!isset($_SESSION['Username'])) {
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
<body>
<header>
    <h1>Library Service</h1>
</header>
<nav class="navbar">
    <div>
        <a href="homepage.php">Home</a>
        <a href="search.php">Search</a>
        <a href="yourbooks.php">View Reserve</a>
        <?php if (isset($_SESSION['Username'])): ?>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </div>
</nav>

<h2>Search for Books</h2>
<form class="svform" action="search.php" method="GET">
    <p>
        Enter book title: <input type="text" name="title" placeholder="Enter name of book">
    </p>
    <p>
        Enter book author: <input type="text" name="author" placeholder="Enter name of author">
    </p>
    <p>
        Category:
        <select name="category">
            <option value="">-- Please Select --</option>
            <option value="1">Health</option>
            <option value="2">Business</option>
            <option value="3">Biography</option>
            <option value="4">Technology</option>
            <option value="5">Travel</option>
            <option value="6">Self-Help</option>
            <option value="7">Cookery</option>
            <option value="8">Fiction</option>
        </select>
    </p>
    <p>
        <input type="submit" value="Search">
    </p>
</form>

<?php

// one line if statement checks if the title is there or emtpty
$title = isset($_GET['title']) && $_GET['title'] !== '' ? "%{$_GET['title']}%" : null;
$author = isset($_GET['author']) && $_GET['author'] !== '' ? "%{$_GET['author']}%" : null;
$category = isset($_GET['category']) && $_GET['category'] !== '' ? $_GET['category'] : null;


// page number logic
$results_per_page = 5;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;
$offset = ($page - 1) * $results_per_page;

// build the main query
$query = "SELECT ISBN, BookTitle, Author, Edition, Year, Category, Reserve FROM Books WHERE 1=1";

if ($title) {
    $query .= " AND `BookTitle` LIKE '%$title%'";
}
if ($author) {
    $query .= " AND `Author` LIKE '%$author%'";
}
if ($category) {
    $query .= " AND `Category` = '$category'";
}

// add pages limits
$query .= " LIMIT $results_per_page OFFSET $offset";

$result = $conn->query($query);

if ($result && $result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>ISBN</th>
                <th>Title</th>
                <th>Author</th>
                <th>Edition</th>
                <th>Year</th>
                <th>Category</th>
                <th>Reserved</th>
            </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['ISBN']}</td>
                <td>{$row['BookTitle']}</td>
                <td>{$row['Author']}</td>
                <td>{$row['Edition']}</td>
                <td>{$row['Year']}</td>
                <td>{$row['Category']}</td>
                <td>" . ($row['Reserve'] === 'Y' ? "Yes" : "No") . "</td>
                <td>";

        if ($row['Reserve'] === 'N') {
            echo "<form class='svform' action='reserve.php' method='POST'>
                    <input type='hidden' name='isbn' value='{$row['ISBN']}'>
                    <input type='submit' value='Reserve'>
                  </form>";
        } else {
            echo "Unavailable";
        }

        echo "</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "<p>No results found.</p>";
}

// pages query to count total results
$count_query = "SELECT COUNT(*) as total FROM Books WHERE 1=1";

if ($title) {
    $count_query .= " AND `BookTitle` LIKE '%$title%'";
}
if ($author) {
    $count_query .= " AND `Author` LIKE '%$author%'";
}
if ($category) {
    $count_query .= " AND `Category` = '$category'";
}

$count_result = $conn->query($count_query);
if ($count_result) {
    $row = $count_result->fetch_assoc();
    $total_results = $row['total'];
    $total_pages = ceil($total_results / $results_per_page);

    // prepare pages links with search parameters
    $title_param = $title ? $_GET['title'] : '';
    $author_param = $author ? $_GET['author'] : '';
    $category_param = $category ? $_GET['category'] : '';

    echo "<div>";
    if ($page > 1) {
        echo "<a class='pages' href='?page=" . ($page - 1) . "&title=$title_param&author=$author_param&category=$category_param'>Previous</a> ";
    }
    if ($page < $total_pages) {
        echo "<a class='pages' href='?page=" . ($page + 1) . "&title=$title_param&author=$author_param&category=$category_param'>Next</a>";
    }
    echo "</div>";
}

$conn->close();

?>
</body>
<footer class="footer">
    <a>©2024 Created by Oskar Sadowski</a>
</footer>
</html>
