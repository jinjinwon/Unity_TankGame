<?php	
	$con = mysqli_connect("localhost", "pmaker", "unity11!", "pmaker");
	
	if(!$con)
		die("Could not Connect".mysqli_connect_error()); 
	
	$JSONBUFF = array();
	$sqlList = mysqli_query($con, "SELECT * FROM DefItem");
	
	$rowsCount = mysqli_num_rows($sqlList);
	if($rowsCount == 0|| !$sqlList)	//������� ���ų� ������ ������ ���
	{
		die("List does not exist2.\n");
	}
	
	$RowDatas = array();	//������ ���ڵ带 ������ �迭
	$Return = array();		//�迭�� ������ �迭
	
	for($aa = 0; $aa < $rowsCount; $aa++)
	{
		$a_row = mysqli_fetch_array($sqlList);
		if($a_row != false)
		{
			//JSON ������ ���� ����
			$RowDatas["UnitName"] = $a_row["UnitName"];
			$RowDatas["UnitAttack"] = $a_row["UnitAttack"];
			$RowDatas["UnitDefence"] = $a_row["UnitDefence"];
			$RowDatas["UnitHP"] = $a_row["UnitHP"];
			$RowDatas["UnitAttSpeed"] = $a_row["UnitAttSpeed"];
			$RowDatas["UnitPrice"] = $a_row["UnitPrice"];
			$RowDatas["UnitUpPrice"] = $a_row["UnitUpPrice"];			
			$RowDatas["UnitRange"] = $a_row["UnitRange"];				
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