<?php
	//unity import
	$u_id  = $_POST[ "Input_user" ]; 
	$u_pw = $_POST[ "Input_pass" ];
	$nick   = $_POST[ "Input_nick" ];

	$con = mysqli_connect("localhost", "pmaker", "unity11!", "pmaker");
	// "localhost" <-- 같은 서버 내

	if(!$con)
		die( "Could not Connect" . mysqli_connect_error() ); 
	//연결 실패했을 경우 이 스크립트를 닫아주겠다는 뜻
	
	// echo $u_id."<br>";
	// echo $u_pw."<br>";
	// echo $nick."<br>";
	// echo "DB까지 접속 성공";

	$check = mysqli_query($con, "SELECT UserId FROM UserInfo WHERE UserId = '".$u_id."'" );
	$numrows = mysqli_num_rows($check);
	if($numrows != 0) //즉 0이 아니라는 뜻은 내가 찾는 ID값이 존재한 다는 뜻이다.
	{
		die("ID does exist. \n");
	}

	$check = mysqli_query($con, "SELECT UserNick FROM UserInfo WHERE UserNick = '".$nick."'" );
	$numrows = mysqli_num_rows($check);
	if($numrows != 0)  //즉 0이 아니라는 뜻은 내가 찾는 Nickname값이 존재한 다는 뜻이다.
	{
		die("Nickname does exist. \n");
	}

	$Result = mysqli_query($con, 
	"INSERT INTO UserInfo (UserId, UserPw, UserNick) VALUES ('".$u_id."', '".$u_pw."', '".$nick."');" );
	
	$RowDatas = array();
	$RowDatas["UserId"] = $u_id; //한글 포함된 경우	
	$CreateInfo = json_encode($RowDatas, JSON_UNESCAPED_UNICODE);
	
	if($Result)
	{
		echo $CreateInfo;
		echo ("\n");
		echo("Create Success. \n");
	}		
	else
		die("Create error. \n");		

	mysqli_close($con);

?>