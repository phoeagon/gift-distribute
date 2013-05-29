<?php
/*
Postcard Distribution System
by phoeagon
this software is distributed under the GNU General Public License (GPL). 
It comes with ABSOLUTELY NO WARRANTY.
This is free software, and you are welcome to redistribute it
under certain conditions. Check "gpl.txt" for details.
*/
	if ($_GET['op']=='cleantrash'){
				mysql_query("DELETE FROM lists WHERE stt='rejected' or stt='revoked'");
				write_auto_reload('0','admin.php?op=viewrecord');
			}
			else if ($_GET['op']=='editrecord'){
				require_once "editrecord.php";
			}
	else if ($_GET['op']=='acceptall'){
		mysql_query("UPDATE lists SET stt='accepted' WHERE stt='pending'");
		write_auto_reload('0','admin.php?op=viewrecord');
	}
	else if ($_GET['op']=='rejectall'){
		mysql_query("UPDATE lists SET stt='rejected' WHERE stt='pending'");
		write_auto_reload('0','admin.php?op=viewrecord');
	}
	else if ($_GET['op']=='sendall'){
		mysql_query("UPDATE lists SET stt='sent' WHERE stt='accepted'");
		write_auto_reload('0','admin.php?op=viewrecord');
	}
	else if ($_GET['op']=='markreject'){
		mysql_query("UPDATE lists SET stt='rejected'");
		write_auto_reload('0','admin.php?op=viewrecord');
	}
	else if ($_GET['op']=='quickstt'){
		$sss = urlencode($_GET['stt']);
		$email = urlencode($_GET['email']);
		mysql_query("UPDATE lists SET stt='".$sss."' WHERE email='".$email."'");
		write_auto_reload('0','admin.php?op=viewrecord');
	}
	else if ($_GET['op']=='phpinfo'){
		print_header($system_title);
		echo "<br/><a href=admin.php>Panel</a>";
		echo phpinfo();
		echo "<br/><a href=admin.php>Panel</a>";
	}
?>