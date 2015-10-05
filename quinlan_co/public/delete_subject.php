<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_logged_in(); ?>
<?php find_selected_page();?>
<?php
	$current_subject = find_subject_by_id($_GET["subject"],false);
	if(!$current_subject){
	redirect_to("manage_content.php");
	}
	$pages_set = find_pages_for_subject($current_subject["id"]);
	if(mysqli_num_rows($pages_set)>0){
		$_SESSION["message"] = "Can't Delete a Subject with Pages.";
		redirect_to("manage_content.php?subject={$current_subject["id"]}");
	}
	$id = $current_subject["id"];
	$query = "DELETE FROM subjects WHERE id = {$id} LIMIT 1";
	$result = mysqli_query($connection,$query);
	if($result&& mysqli_affected_rows($connection)== 1){
		$_SESSION["message"] = "Subject Deleted.";
		redirect_to("manage_content.php");
	}
	else{
		$_SESSION["message"] = "Subject Deletion Failed.";
		redirect_to("manage_content.php?subject={$id}");
	}
?>