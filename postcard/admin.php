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
	if (!mysql_select_db($sql_database,$con))
		die("Connection Error!<br/>Check if you've installed it.");
	
	$system_title = get_cont_val('title');
	$invite_code = get_set_val('invi');
	$system_run = get_set_val("sys_run");
	
	$admin_pass = get_set_val("pass");
	
	$quota = get_set_val("quota");
	if ($result = mysql_query("SELECT COUNT(email) AS count FROM lists")){
		$row = mysql_fetch_array($result);
		$allcnt = $row['count'];
	}
	if ($result = mysql_query("SELECT COUNT(email) AS count FROM lists WHERE stt='accepted' or stt='sent'")){
		$row = mysql_fetch_array($result);
		$accnt = $row['count'];
	}
?>
<?php
	session_start();
	
	if ($_GET['op']=='auth'){
			$password = urlencode($_POST['pass']);
			if ( str_crypt($password) == $admin_pass ){
				$_SESSION['isadmin']='1';
				write_auto_reload("0","admin.php");
			}
			else echo header("Location admin.php");
		}
	else if (!isset($_SESSION['isadmin'])){	
		print_header($system_title);
		print_title_in_page($system_title);
		echo "<hr/>";
		echo "<center><p><b><big>Control Pannel</big></b></p>\n";
		echo "<form action=admin.php?op=auth method=POST>\n";
		echo "Admin Password:&nbsp <input type=password name=pass /><br/>";
		echo "<input type=submit value=Log-in /><br/><br/></center>";
		echo "<p><center><a href=index.php>Homepage</a></center></p>";
		print_footer($copr);
	}
	else {
		if ($_GET['op']=='logout'){
			session_destroy();
			write_auto_reload("0","admin.php");
			/*
			print_header($system_title);
			print_title_in_page($system_title);
			echo "<p><b>Admin Logged out.</b></br>";
			echo "<a href=admin.php>Panel</a></p>";
			print_footer($copr);
			*/
		}		
		else if ($_GET['op']==NULL || $_GET['op']=='panel' ){
			require_once "panel.php";
		}
		else if ($_GET['op']=='paneledit'){
			$need_logout = 0;
			
			$result = mysql_query("SELECT opt FROM general");
			while ($row = mysql_fetch_array($result)){
				$el = $row['opt'];
				$_POST[$el] = urlencode($_POST[$el]);
				if ($el!='pass')
					mysql_query("UPDATE general SET val='".$_POST[$el]."' WHERE opt='".$el."'");
				else if (strlen($_POST[$el])){
					$need_logout = 1;
					mysql_query("UPDATE general SET val='".str_crypt($_POST[$el])."' WHERE opt='pass'");
				}
			}
			if($need_logout)
				session_destroy();
			write_auto_reload('0','admin.php?op=panel');
		}
		else if ($_GET['op']=='textedit'){
			$result = mysql_query("SELECT opt FROM cont");
			while ($row = mysql_fetch_array($result)){
				$el = $row['opt'];
				mysql_query("UPDATE cont SET val='".$_POST[$el]."' WHERE opt='".$el."'");
			}
			write_auto_reload('0','admin.php?op=panel');
		}
		else if ($_GET['op']=='viewrecord'){
			require_once "adminrecord.php";
		}
		else {
			//quick execute some command
			require_once "quickexec.php";
		}
		
	}
?>
<?php
		mysql_close($con);
?>
