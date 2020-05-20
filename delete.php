<?php
	$db = mysqli_connect("localhost", "root", "pass", "TRD");
	$sql = "delete from trades where TRD_ID=".$_POST['TRD_ID']."";
	$query = mysqli_query($db, $sql);
?>
