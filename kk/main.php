<?php
header("Cache-Control: no-cache, post-check=0, pre-check=0");
header("Content-type:text/html;charset=gb2312");
error_reporting(E_ALL);

session_start();

//主页导向
//-----------------------------
//top.php   指向三分区的上部
//lefttree.php    指向三分区的左部（目录栏）
//selectproduct0.php    指向三分区的右部（买家主界面）
//manageproduct0.php    指向三分区的右部（卖家主界面）
//-----------------------------
?>

<html xmlns="http://www.w3.org/1999/xhtml" >
  <head>
    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=gb2312">
    <meta name="GENERATOR" content="Microsoft FrontPage 4.0">
    <meta name="ProgId" content="FrontPage.Editor.Document">
    <title>信息系统</title>
  </head>

  <frameset rows="13%,*">
    <frame name="banner" scrolling="no" noresize target="contents" src="top.php">

  <frameset cols="22%,*" frameborder="NO" border="1" framespacing="1" name="main" scrolling="yes">
    <frame name="left" frameborder="yes" border="1" scrolling="auto"  src="lefttree.php">
    <frame name="right" noresize  
		  src=" <?php if($_SESSION['usertype']==1) echo "selectproduct0.php"; else if($_SESSION['usertype']==0) echo "manageproduct0.php";?>">
  </frameset>
  
  <noframes>
  <body>
    <p>此网页使用了框架，但您的浏览器不支持框架。</p>

  </body>
  </noframes>
  </frameset>
  </html>
</html>
