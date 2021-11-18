<?php
	$u_ID = $_POST["Input_ID"]; 
	
	$con =  mysqli_connect("localhost", "pmaker", "unity11!", "pmaker");
	if(!$con)
		die( "Could not Connect" . mysqli_connect_error() ); 
	
	// 트랜잭션 시작
	mysqli_autocommit($con, FALSE);
	
	// 아이디 넘버 가져오기
	$check = mysqli_query($con, "SELECT * FROM UserInfo WHERE UserId = '".$u_ID."'" );	
	$numrows = mysqli_num_rows($check);
	if($numrows == 0)
	{  //mysqli_num_rows() 함수는 데이터베이스에서 쿼리를 보내서 나온 레코드의 개수를 알아낼 때 쓰임
	   //즉 0이라는 뜻은 해당 조건을 못 찾았다는 뜻
		mysqli_close($con);
		die("ID does not exist\n");
	}
	
	$row = mysqli_fetch_assoc($check); //user_id 이름에 해당하는 행의 내용을 가져온다.
	$userNo = 0;
	if($row)
	{
		$userNo = $row["UserNo"];
	}
	else
	{
		mysqli_close($con);
		die("row not exist\n");
	}
	
	// 가져온 유저 넘버를 통해 아이템 넣어주기	
	// 공격용 아이템 넣기
	$check = mysqli_query($con, "INSERT INTO UserItem(ItemName, Level, isBuy, KindOfItem, ItemUsable, isAttack, UserId) VALUES('NormalTank','1','1','1','10','1','".$userNo."')");	
	if(!$check)
	{
		mysqli_rollback($con);
		mysqli_close($con);
		die("AttItem insert Fail\n");
	}	
	
	// 방어용 아이템 넣기
	$check = mysqli_query($con, "INSERT INTO UserItem(ItemName, Level, isBuy, KindOfItem, ItemUsable, isAttack, UserId) VALUES('MachineGunTower','1','1','1','0','0','".$userNo."')");	
	if(!$check)
	{
		mysqli_rollback($con);
		mysqli_close($con);
		die("DefItem insert Fail\n");
	}	
	
	mysqli_commit($con);
	echo "Insert_Success~";	
	mysqli_close($con);
?>