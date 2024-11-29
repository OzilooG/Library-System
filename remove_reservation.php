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

    
    try {
        // delete the reservation record
        $query = "DELETE FROM Reservations WHERE ISBN = '$isbn' AND Username = '$username'";
        $result = $conn->query($query);

        // update the books reservation status
        $query = "UPDATE Books SET Reserve = 'N' WHERE ISBN = '$isbn'";
        $result = $conn->query($query);

        $conn->commit();
        echo "Reservation removed successfully! <a href='yourbooks.php'>Back to Your Reserved Books</a>";
    } catch (Exception $e) {
        $conn->rollback();
        echo "Error removing reservation: " . $e->getMessage();
    }
}

$conn->close();
?>
