<?php
/*
Postcard Distribution System
by phoeagon
this software is distributed under the GNU General Public License (GPL). 
It comes with ABSOLUTELY NO WARRANTY.
This is free software, and you are welcome to redistribute it
under certain conditions. Check "gpl.txt" for details.
*/
	if ($_GET['action']=='exec'){
		echo "EXEC<br/>";
		$result = mysql_query("SELECT * FROM lists WHERE email='".urlencode($_POST['email'])."'");
		if ($result){
			mysql_query("UPDATE lists SET email='".urlencode($_POST['email']).
				"',rcv='".urlencode($_POST['rcv']).
				"',address='".urlencode($_POST['address']).
				"',pcode='".urlencode($_POST['pcode']).
				"',note='".urlencode($_POST['note']).
				"',stt='".urlencode($_POST['stt']).
				"' WHERE email='".urlencode($_POST['email'])."'");
			
				write_auto_reload("0","admin.php?op=viewrecord");
		}
	}
	else{
		//admin page,
		//runs even if system not on

		print_header($system_title);
		print_title_in_page($system_title);
		echo "<p><a href=admin.php?op=viewrecord>Back</a></p>";
	
		echo "<p><b>Editing Record:</b></p>";
		echo "<form action=admin.php?op=editrecord&action=exec method=POST name=info >\n";
		echo "<table border=1>";
		
		//echo "SELECT * FROM lists WHERE email='".urlencode($_GET['email'])."'";
		$result = mysql_query("SELECT * FROM lists WHERE email='".urlencode($_GET['email'])."'");
		if ($result){
			$row = mysql_fetch_array($result);
			
			echo "<tr><th>Email:</th><th><input type=text name=email value='".urldecode($row['email'])."'></th></tr><tr>
			<th>Receiver:</th><th><input type=text name=rcv value='".urldecode($row['rcv'])."'></th></tr><tr>
			<th>Address:</th><th><input type=text name=address value='".urldecode($row['address'])."'></th></tr><tr>
			<th>Postal Code:</th><th><input type=text name=pcode value='".urldecode($row['pcode'])."'></th></tr><tr>
			<th>Notes:</th><th><input type=text name=note value='".urldecode($row['note'])."'></th></tr><tr>
			<th>Status:</th><th><input type=text name=stt value='".urldecode($row['stt'])."'></th></tr>".
			"<th>MD5:</th><th><input type=text size=20 name=rcv value='".urldecode($row['passw'])."'></th>"
			."</tr>";
			
			echo "<tr><th><input type=submit value=submit></th>";
			echo "<th><input type=reset value=reset></th></tr>";
		}
		echo "</table>";
		echo "Status options:<br/>";
		
		echo "<input type=button value=Pend onclick='javascript:document.info.stt.value=\"pending\"'>";
		echo "<input type=button value=Reject onclick='javascript:document.info.stt.value=\"rejected\"'>";
		echo "<input type=button value=Accept onclick='javascript:document.info.stt.value=\"accepted\"'>";
		echo "<input type=button value=Send onclick='javascript:document.info.stt.value=\"sent\"'>";
		echo "<br/><br/>";
		print_footer($copr);
	}
?>