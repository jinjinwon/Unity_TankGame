<?php
	$u_id = $_POST["Input_ID"];
	$u_itemType = $_POST["Input_ItemType"];

	$con = mysqli_connect("localhost", "pmaker", "unity11!", "pmaker");
	
	if(!$con)
		die("Could not Connect".mysqli_connect_error());
	
	$JSONBUFF = array();
	$sqlList = mysqli_query($con, "SELECT u.ItemNo, u.ItemName, u.Level, u.isBuy, u.KindOfItem, u.ItemUsable, i.UnitAttack, i.UnitDefence, i.UnitHP, i.UnitAttSpeed,  i.UnitPrice,i.UnitUpPrice FROM UserItem AS u JOIN DefItem AS i ON u.KindOfItem = i.No AND u.UserId = '".$u_id."' AND u.isAttack = '".$u_itemType."'");
	
	$rowsCount = mysqli_num_rows($sqlList);
	if($rowsCount == 0|| !$sqlList)
	{
		die("List does not exist1.\n");
	}
	
	$RowDatas = array();
	$Return = array();
	
	// 1차적으로 Select 하는 부분
	for($aa = 0; $aa < $rowsCount; $aa++)
	{
		$a_row = mysqli_fetch_array($sqlList);
		if($a_row != false)
		{
			//JSON 생성을 위한 변수
			$RowDatas["ItemNo"] = $a_row["ItemNo"];
			$RowDatas["ItemName"] = $a_row["ItemName"];
			$RowDatas["Level"] = $a_row["Level"];
			$RowDatas["isBuy"] = $a_row["isBuy"];
			$RowDatas["KindOfItem"] = $a_row["KindOfItem"];
			$RowDatas["ItemUsable"] = $a_row["ItemUsable"];		
			$RowDatas["UnitAttack"] = $a_row["UnitAttack"];
			$RowDatas["UnitDefence"] = $a_row["UnitDefence"];
			$RowDatas["UnitHP"] = $a_row["UnitHP"];
			$RowDatas["UnitAttSpeed"] = $a_row["UnitAttSpeed"];
			$RowDatas["UnitMoveSpeed"] = $a_row["UnitMoveSpeed"];
			$RowDatas["UnitPrice"] = $a_row["UnitPrice"];
			$RowDatas["UnitUpPrice"] = $a_row["UnitUpPrice"];					
			array_push($Return, $RowDatas);
		}//if($a_row != false)
	}//for($aa = 0; $aa < $rowsCount; $aa++)
	
	$JSONBUFF["UnitList"] = $Return;
	

	$output = json_encode($JSONBUFF,JSON_UNESCAPED_UNICODE);
	echo $output;
	echo "\n";
	echo "Get_Item_Success~";
	
	mysqli_close($con);
?>