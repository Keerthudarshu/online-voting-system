<?php

require_once("inc/header.php");
require_once("inc/navigation.php");
// Include your database connection

if(isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];

    // Fetch candidate details for editing
    $fetchCandidateData = mysqli_query($db, "SELECT * FROM candidate_details WHERE id = '". $edit_id ."'") or die(mysqli_error($db));
    $candidateData = mysqli_fetch_assoc($fetchCandidateData);
?>

    <h3>Edit Candidate Details</h3>
    <form method="POST">
        <input type="hidden" name="candidate_id" value="<?php echo $candidateData['id']; ?>" />
        <div class="form-group">
            <label for="candidate_name">Candidate Name:</label>
            <input type="text" name="candidate_name" value="<?php echo $candidateData['candidate_name']; ?>" class="form-control" required />
        </div>
        <div class="form-group">
            <label for="candidate_details">Candidate Details:</label>
            <textarea name="candidate_details" class="form-control" required><?php echo $candidateData['candidate_details']; ?></textarea>
        </div>
        <!-- Add other input fields for candidate details -->
        <input type="submit" value="Update Candidate" name="updateCandidateBtn" class="btn btn-primary" />
    </form>

<?php
}

// Handle form submission for updating candidate details
if(isset($_POST['updateCandidateBtn'])) {
    $candidate_id = mysqli_real_escape_string($db, $_POST['candidate_id']);
    $new_candidate_name = mysqli_real_escape_string($db, $_POST['candidate_name']);
    $new_candidate_details = mysqli_real_escape_string($db, $_POST['candidate_details']);
    // Add other input fields for candidate details

    // Update candidate details in the database
    mysqli_query($db, "UPDATE candidate_details SET candidate_name = '$new_candidate_name', candidate_details = '$new_candidate_details' WHERE id = '$candidate_id'") or die(mysqli_error($db));

    echo "<script> alert('Candidate details updated successfully.'); </script>";
    echo "<script> location.assign('index.php?canddetailsPage=1'); </script>";
}
?>
