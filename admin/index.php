<?php 
    require_once("inc/header.php");
    require_once("inc/navigation.php");


    if(isset($_GET['homepage']))
    {
        require_once("inc/homepage.php");
    }else if(isset($_GET['addElectionPage']))
    {
        require_once("inc/add_elections.php");
    }else if(isset($_GET['addCandidatePage']))
    {
        require_once("inc/add_candidates.php");
    }else if(isset($_GET['viewResult']))
    {
        require_once("inc/viewResults.php");
    }else if(isset($_GET['canddetailsPage']))
    {
        require_once("inc/cand_details.php");
    }else if(isset($_GET['editCandidate']))
    {
        require_once("inc/edit_candidate.php");
    }

?>


<?php 
    require_once("inc/footer.php");
?>