<?php
    // Include your database connection file if not already included
    // require_once("db_connection.php");

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['candidate_id'])) {
        $candidate_id = mysqli_real_escape_string($db, $_POST['candidate_id']);

        // Delete candidate from the database
        $deleteQuery = mysqli_query($db, "DELETE FROM candidate_details WHERE candidate_id = '$candidate_id'");

        if ($deleteQuery) {
            // Redirect back to the main page with a success message
            header("Location: index.php?addCandidatePage=1&deleted=1");
            exit();
        } else {
            // Redirect back to the main page with an error message
            header("Location: index.php?addCandidatePage=1&deleteFailed=1");
            exit();
        }
    } else {
        // Handle the case where no candidate ID is provided
        header("Location: index.php?addCandidatePage=1&deleteFailed=1");
        exit();
    }
?>
