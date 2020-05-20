<?php
	$db = mysqli_connect("localhost", "root", "pass", "TRD");
	$sql = "INSERT INTO trades (ENTRY_DATE,TRD_ASSET,TRD_POS,TRD_QUANTITY,TRD_LEVERAGE,TRD_MARGIN,ENTRY_CAP,EXIT_CAP) VALUES ('".$_POST['ENTRY_DATE']."','".$_POST['TRD_ASSET']."','".$_POST['TRD_POS']."','".$_POST['TRD_QUANTITY']."','".$_POST['TRD_LEVERAGE']."','".$_POST['TRD_MARGIN']."','".$_POST['ENTRY_CAP']."','".$_POST['EXIT_CAP']."');";
	$query = mysqli_query($db, $sql);
?>
