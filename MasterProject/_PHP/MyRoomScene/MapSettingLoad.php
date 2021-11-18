<?php
	$u_number = $_POST["Input_usernumber"];
	
	$con = mysqli_connect("localhost", "pmaker", "unity11!", "pmaker");
	if(!$con)	//연결 실패했을 경우 이 스크립트를 닫아주겠다는 뜻
		die("Could not Connect".mysqli_connect_error());

	$sqlList = mysqli_query($con, "SELECT `mapType`, `userSetTower`, `towerType`, `mapPower` FROM MapSetting WHERE userN = '".$u_number."'");
	$rowsCount = mysqli_num_rows($sqlList);
	if(!$sqlList || $rowsCount == 0)
	{
		die("List does not exist. \n");
	}

	$RowDatas = array();
	$Return = array();

	for($i = 0; $i < $rowsCount; $i++)
	{
		$a_row = mysqli_fetch_array($sqlList);
		if($a_row != false)
		{
			$RowDatas["maptype"][$i] = $a_row["mapType"];
			$RowDatas["userselltower"][$i] = $a_row["userSetTower"];
			$RowDatas["towertype"][$i] = $a_row["towerType"];
			$RowDatas["mapPower"][$i] = $a_row["mapPower"];
		}
	}
	array_push($Return, $RowDatas);

	$JSONBUFF['MapList'] = $Return;
	$output = json_encode($JSONBUFF, JSON_UNESCAPED_UNICODE);

	echo $output;

	echo("\n");

	echo "MapLoadDone";

	mysqli_close($con);
?>