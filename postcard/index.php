<?php
/*
Postcard Distribution System
by phoeagon
this software is distributed under the GNU General Public License (GPL). 
It comes with ABSOLUTELY NO WARRANTY.
This is free software, and you are welcome to redistribute it
under certain conditions. Check "gpl.txt" for details.
*/
	if (file_exists("config.php"))
		require_once "config.php";
	else die("Configuration missing!");
?>
<?php
	$con = mysql_connect($sql_host,$sql_user,$sql_pass);
	if (!$con)
		die("Database Configuration Error!");
?>
<?php
	require_once "install.php";
?>
<?php
	if ($_GET['op']=='message'){
		echo $message_pre.$_GET['content'].$message_post;
		return 0;
	}
/*
	op values:
	message - content
	admin
	showrecord
*/
?>
<?php
	if (!mysql_select_db($sql_database,$con))
		die("Connection Error!<br/>Check if you've installed it.");
	
	$system_title = get_cont_val('title');
	$invite_code = get_set_val('invi');
	$system_run = get_set_val("sys_run");
	
	$viewquota = get_set_val("viewquota");
	$viewcnt = get_set_val("viewcnt");
	$quota = get_set_val("quota");
	
	if ($result = mysql_query("SELECT COUNT(email) AS count FROM lists")){
		$row = mysql_fetch_array($result);
		$allcnt = $row['count'];
	}
	
	if ($system_run == '0'){
		header("Location: index.php?op=message&content=".$message_close);
		exit;
	}
?>
<?php

	if ($_GET["op"]=="showrecord"){
		require_once "showrecord.php";
	}
	else if ($_GET["op"]=="login"){
		require_once "login.php";
	}
	else if ($_GET["op"]=="submit"){
		require_once "submit.php";
	}
	else{
		require_once "main.php";
	}
	
?>
<?php
	mysql_close($con);
?>
