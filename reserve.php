<?php
session_start();
include "database.php";

if (!isset($_SESSION['Username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $isbn = $_POST['isbn'];
    $username = $_SESSION['Username'];
    $reservedDate = date('Y-m-d');

    // check if the book is already reserved
    $resget = "SELECT Reserve FROM Books WHERE ISBN = '$isbn'";
    $result = $conn->query($resget);
    $book = $result->fetch_assoc();

    if ($book && $book['Reserve'] === 'N') {
        //reserve the book
        $conn->begin_transaction();
        try {
            // insert reservation  record
            $query = "INSERT INTO Reservations (ISBN, Username, ReservedDate) VALUES ('$isbn', '$username', '$reservedDate')";
            $stmt = $conn->query($query);
            

            // update the book as reserved
            $query = "UPDATE Books SET Reserve = 'Y' WHERE ISBN = '$isbn'";
            $stmt = $conn->query($query);
            

            $conn->commit();
            echo "Book reserved successfully! <a href='search.php'>Back to Search</a>";
        } catch (Exception $e) {
            $conn->rollback();
            echo "Error reserving the book: " . $e->getMessage();
        }
    } else {
        echo "This book is already reserved. <a href='search.php'>Back to Search</a>";
    }
}

$conn->close();
?>
