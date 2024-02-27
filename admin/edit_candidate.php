<?php
require_once("inc/header.php");
require_once("inc/navigation.php");

// Include your database connection code here if it's not already included

if (isset($_GET['editCandidate'])) {
    $candidate_id = mysqli_real_escape_string($db, $_GET['editCandidate']);
    $fetchCandidateDetails = mysqli_query($db, "SELECT * FROM candidate_details WHERE id = $candidate_id") or die(mysqli_error($db));
    $candidateData = mysqli_fetch_assoc($fetchCandidateDetails);

    if (!$candidateData) {
        // Handle candidate not found, redirect or display an error message.
        header('Location: index.php?candidatesPage=1&notFound=1');
        exit();
    }

    // If the update form is submitted
    if (isset($_POST['updateCandidateBtn'])) {
        // Retrieve and sanitize form data
        $newCandidateName = mysqli_real_escape_string($db, $_POST['candidate_name']);
        $newCandidateDetails = mysqli_real_escape_string($db, $_POST['candidate_details']);
        $newElectionId = mysqli_real_escape_string($db, $_POST['election_id']);

        // Photograph Logic - Only update if a new photo is uploaded
        if ($_FILES['candidate_photo']['size'] > 0) {
            $targetted_folder = "../assets/images/candidate_photos/";
            $newCandidatePhoto = $targetted_folder . rand(111111111, 99999999999) . "_" . rand(111111111, 99999999999) . $_FILES['candidate_photo']['name'];
            $newCandidatePhotoTmpName = $_FILES['candidate_photo']['tmp_name'];
            $newCandidatePhotoType = strtolower(pathinfo($newCandidatePhoto, PATHINFO_EXTENSION));
            $allowed_types = array("jpg", "png", "jpeg");

            if ($_FILES['candidate_photo']['size'] < 2000000 && in_array($newCandidatePhotoType, $allowed_types)) {
                if (move_uploaded_file($newCandidatePhotoTmpName, $newCandidatePhoto)) {
                    // Delete old photo from the server
                    unlink($candidateData['candidate_photo']);
                }
            }
        } else {
            // No new photo uploaded, use the existing one
            $newCandidatePhoto = $candidateData['candidate_photo'];
        }

        // Perform the update in the database
        $updateQuery = "UPDATE candidate_details SET candidate_name = '$newCandidateName', candidate_details = '$newCandidateDetails', election_id = '$newElectionId', candidate_photo = '$newCandidatePhoto' WHERE id = $candidate_id";
        $result = mysqli_query($db, $updateQuery);

        // Check if the update was successful
        if ($result) {
            header('Location: index.php?candidatesPage=1&updated=1');
            exit();
        } else {
            header('Location: index.php?candidatesPage=1&updateFailed=1');
            exit();
        }
    }
?>

<div class="row my-3">
    <div class="col-8">
        <h3>Edit Candidate Details</h3>
        <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="candidate_id" value="<?php echo $candidateData['id']; ?>">

            <div class="form-group">
                <label>Current Election: <?php echo $candidateData['election_id']; ?></label>
            </div>

            <div class="form-group">
                <select class="form-control" name="election_id" required>
                    <!-- Populate the dropdown with available elections -->
                    <?php
                    $fetchingElections = mysqli_query($db, "SELECT * FROM elections") or die(mysqli_error($db));
                    while ($row = mysqli_fetch_assoc($fetchingElections)) {
                        $election_id = $row['id'];
                        $election_name = $row['election_topic'];
                        $selected = ($election_id == $candidateData['election_id']) ? 'selected' : '';
                        echo "<option value=\"$election_id\" $selected>$election_name</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <input type="text" name="candidate_name" value="<?php echo $candidateData['candidate_name']; ?>" placeholder="Candidate Name" class="form-control" required />
            </div>

            <div class="form-group">
                <input type="text" name="candidate_details" value="<?php echo $candidateData['candidate_details']; ?>" placeholder="Candidate Details" class="form-control" required />
            </div>

            <div class="form-group">
                <label>Current Photo:</label>
                <img src="<?php echo $candidateData['candidate_photo']; ?>" class="candidate_photo" />
            </div>

            <div class="form-group">
                <label>Upload New Photo:</label>
                <input type="file" name="candidate_photo" class="form-control" />
            </div>

            <input type="submit" value="Update Candidate" name="updateCandidateBtn" class="btn btn-success" onclick="submitForm()" />
       
        </form>
    </div>
</div>



<?php
}

require_once("inc/footer.php");
?>

<script>
    function submitForm() {
        // Your existing form submission logic here...

        // After successful form submission, show an alert
        alert('Candidate details successfully updated!');

        // Redirect to the candidate details page
        window.location.href = 'index.php?canddetailsPage=1';
    }
</script>