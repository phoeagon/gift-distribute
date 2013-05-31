<?php
/*
Postcard Distribution System
by phoeagon
this software is distributed under the GNU General Public License (GPL). 
It comes with ABSOLUTELY NO WARRANTY.
This is free software, and you are welcome to redistribute it
under certain conditions. Check "gpl.txt" for details.
*/
	if ($system_run=='0'){
		header("Location: index.php?op=message&content=".$message_close);
		exit;
	}
	
	print_header($system_title);
	print_title_in_page($system_title);
	
	if (get_set_val("can_viewrec")=='0'){
			header("Location: index.php?op=message&content=".$message_banned);
			exit;
		}
		
		$sql = "SELECT * FROM lists WHERE "; 
		if ($_GET['status']=='0' || $_GET['status']==NULL)
			$result = mysql_query($sql."stt='accepted' or stt='sent' or stt='pending' ORDER BY subtime");
		else if ($_GET['status']=='1')
			$result = mysql_query($sql."stt='accepted' or stt='sent' ORDER BY subtime");
		else if ($_GET['status']=='2')
			$result = mysql_query($sql."stt='rejected' or stt='revoked' ORDER BY subtime");
		else if ($_GET['status']=='3')
			$result = mysql_query($sql."stt='pending' ORDER BY subtime");
		
		
		echo "<a href='index.php?op=showrecord&status=0'>Default List</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "<a href='index.php?op=showrecord&status=1'>Accepted/Sent Queries Only</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "<a href='index.php?op=showrecord&status=3'>Pending Queries Only</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "<a href='index.php?op=showrecord&status=2'>Rejected/Revoked Queries Only</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		echo "<br/><br/>\n";
		
		echo "--------Records:-------<br/>";
		echo "<table border='1'>
		<tr>
		<th>Nickname</th>
		<th>Status</th>
		</tr>";

		while($row = mysql_fetch_array($result)){
			echo "<tr>";
			echo "<td>" . urldecode($row['nick']) . "</td>";
			echo "<td>" . urldecode($row['stt']) . "</td>";
			echo "</tr>";
		}
			echo "</table>";

		echo "<br/>-----------------------<br/>All records in accordance to the filter are listed above.<br/><br/>";
		
		print_footer($copr);
?>