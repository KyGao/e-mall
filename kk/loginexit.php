<?php	
	//初始化到登录界面
	session_start();
	unset($_SESSION['userid']);
	unset($_SESSION['usertype']);
	session_destroy();
	header("location: start.html");
?>