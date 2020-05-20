<?php
	$db = mysqli_connect("localhost", "root", "pass", "TRD");
	$sql = "UPDATE trades SET ENTRY_DATE='".$_POST['ENTRY_DATE']."',TRD_ASSET='".$_POST['TRD_ASSET']."',TRD_POS='".$_POST['TRD_POS']."',TRD_QUANTITY='".$_POST['TRD_QUANTITY']."',TRD_LEVERAGE='".$_POST['TRD_LEVERAGE']."',TRD_MARGIN='".$_POST['TRD_MARGIN']."',ENTRY_CAP='".$_POST['ENTRY_CAP']."',EXIT_CAP='".$_POST['EXIT_CAP']."' where TRD_ID=".$_POST['TRD_ID'].";";
	$query = mysqli_query($db, $sql);
?>
