<?php 
    if(isset($_GET['added']))
    {
?>
        <div class="alert alert-success my-3" role="alert">
            Candidate has been added successfully.
        </div>
<?php 
    }else if(isset($_GET['largeFile'])) {
?>
        <div class="alert alert-danger my-3" role="alert">
            Candidate image is too large, please upload small file (you can upload any image upto 2mbs.).
        </div>
<?php
    }else if(isset($_GET['invalidFile']))
    {
?>
        <div class="alert alert-danger my-3" role="alert">
            Invalid image type (Only .jpg, .png files are allowed) .
        </div>
<?php
    }else if(isset($_GET['failed']))
    {
?>
        <div class="alert alert-danger my-3" role="alert">
            Image uploading failed, please try again.
        </div>
<?php
    }

?>

<?php 
    if(isset($_GET['delete_id']))
    {
        $d_id = $_GET['delete_id'];
        mysqli_query($db, "DELETE FROM candidate_details WHERE id = '". $d_id ."'") or die(mysqli_error($db));
?>
  <div class="alert alert-danger my-3" role="alert">
            Candidate has been deleted successfully!
        </div>
<?php
    }
    
?>


<div class="row my-3">
    <div class="col-8">
        <h3>Candidate Details</h3>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Photo</th>
                    <th scope="col">Name</th>
                    <th scope="col">Details</th>
                    <th scope="col">Election</th>
                    <th scope="col">Action </th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $fetchingData = mysqli_query($db, "SELECT * FROM candidate_details") or die(mysqli_error($db)); 
                    $isAnyCandidateAdded = mysqli_num_rows($fetchingData);

                    if($isAnyCandidateAdded > 0)
                    {
                        $sno = 1;
                        while($row = mysqli_fetch_assoc($fetchingData))
                        {
                            $election_id = $row['election_id'];
                            $fetchingElectionName = mysqli_query($db, "SELECT * FROM elections WHERE id = '". $election_id ."'") or die(mysqli_error($db));
                            $execFetchingElectionNameQuery = mysqli_fetch_assoc($fetchingElectionName);
                            $election_name = $execFetchingElectionNameQuery['election_topic'];

                            $candidate_photo = $row['candidate_photo'];

                ?>
                            <tr>
                                <td><?php echo $sno++; ?></td>
                                <td> <img src="<?php echo $candidate_photo; ?>" class="candidate_photo" /> </td>
                                <td><?php echo $row['candidate_name']; ?></td>
                                <td><?php echo $row['candidate_details']; ?></td>
                                <td><?php echo $election_name; ?></td>
                                <td> 
                                <a class="btn btn-sm btn-warning" onclick="EditData(<?php echo $row['id']; ?>)">Edit</a>

                                <script>
    function EditData(candidateId) {
        console.log('EditData called with candidateId:', candidateId);
        window.location.href = 'edit_candidate.php?editCandidate=' + candidateId;
    }
</script>
                                   <button class="btn btn-sm btn-danger" onclick="DeleteData(<?php echo $row['id']; ?>)"> Delete </button>
                                </td>
                            </tr>   
                <?php
                        }
                    } else {
                ?>
                        <tr> 
                            <td colspan="7"> No candidates have been added yet. </td>
                        </tr>
                <?php
                    }
                ?>
            </tbody>    
        </table>
    </div>
</div>
<style>
    .col-8{
        margin-left: 300px;
   
            max-height:400px; /* Set the maximum height */
            overflow-y: auto; /* Enable vertical scrolling */
        }
</style>
<script>
    const DeleteData = (e_id) => {
        let c = confirm("Are you really want to delete it?");
        if(c == true) {
            location.assign("index.php?canddetailsPage=1&delete_id=" + e_id);
        }
    }
</script>



<br>



<?php 

    if(isset($_POST['addCandidateBtn']))
    {
        $election_id = mysqli_real_escape_string($db, $_POST['election_id']);
        $candidate_name = mysqli_real_escape_string($db, $_POST['candidate_name']);
        $candidate_details = mysqli_real_escape_string($db, $_POST['candidate_details']);
        $inserted_by = $_SESSION['username'];
        $inserted_on = date("Y-m-d");

        // Photograph Logic Starts
        $targetted_folder = "../assets/images/candidate_photos/";
        $candidate_photo = $targetted_folder . rand(111111111, 99999999999) . "_" . rand(111111111, 99999999999) . $_FILES['candidate_photo']['name'];
        $candidate_photo_tmp_name = $_FILES['candidate_photo']['tmp_name'];
        $candidate_photo_type = strtolower(pathinfo($candidate_photo, PATHINFO_EXTENSION));
        $allowed_types = array("jpg", "png", "jpeg");        
        $image_size = $_FILES['candidate_photo']['size'];

        if($image_size < 2000000) // 2 MB
        {
            if(in_array($candidate_photo_type, $allowed_types))
            {
                if(move_uploaded_file($candidate_photo_tmp_name, $candidate_photo))
                {
                    // inserting into db
                    mysqli_query($db, "INSERT INTO candidate_details(election_id, candidate_name, candidate_details, candidate_photo, inserted_by, inserted_on) VALUES('". $election_id ."', '". $candidate_name ."', '". $candidate_details ."', '". $candidate_photo ."', '". $inserted_by ."', '". $inserted_on ."')") or die(mysqli_error($db));

                    echo "<script> location.assign('index.php?addCandidatePage=1&added=1'); </script>";


                }else {
                    echo "<script> location.assign('index.php?addCandidatePage=1&failed=1'); </script>";                    
                }
            }else {
                echo "<script> location.assign('index.php?addCandidatePage=1&invalidFile=1'); </script>";
            }
        }else {
            echo "<script> location.assign('index.php?addCandidatePage=1&largeFile=1'); </script>";
        }

        // Photograph Logic Ends
    
    ?>
      <?php

    }

?>