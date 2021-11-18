<?php
	$u_ItemName = $_POST["Input_ItemName"];
	$u_Level = $_POST["Input_Level"];
	$u_isBuy = $_POST["Input_isBuy"];
	$u_KindOfItem = $_POST["Input_KindOfItem"];
	$u_ItemUsable = $_POST["Input_ItemUsable"];
	$u_isAttack = $_POST["Input_isAttack"];	
	$u_ID = $_POST["Input_ID"];

	$con = mysqli_connect("localhost", "pmaker", "unity11!", "pmaker");
	
	if(!$con)
		die("Could not Connect" . mysqli_connect_error()); 
		
	$check = mysqli_query($con, "INSERT INTO UserItem(ItemName, Level, isBuy, KindOfItem, ItemUsable, isAttack, UserId) VALUES('".$u_ItemName."','".$u_Level."','".$u_isBuy."','".$u_KindOfItem."','".$u_ItemUsable."','".$u_isAttack."','".$u_ID."')");	
	if($check)
	{
		echo("Success");
	}
	else
	{
		echo("Fail");
	}
	
	mysqli_close($con);
?>