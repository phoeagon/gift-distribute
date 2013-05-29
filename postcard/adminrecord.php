<?php
/*
Postcard Distribution System
by phoeagon
this software is distributed under the GNU General Public License (GPL). 
It comes with ABSOLUTELY NO WARRANTY.
This is free software, and you are welcome to redistribute it
under certain conditions. Check "gpl.txt" for details.
*/
	//admin page,
	//runs even if system not on

	print_header($system_title);
	print_title_in_page($system_title);
	
	$sql = "SELECT * FROM lists WHERE "; 
		if ($_POST['condition']!=NULL){
			$cond = stripslashes(urldecode($_POST['condition']));
			//this is not SQL safe but it's in a admin page.
			echo "<p>Customized Filter: &nbsp ".$sql.$cond."</p>";
			$result = mysql_query($sql.$cond);
		}
		else if ($_GET['status']=='0')
			$result = mysql_query($sql."stt!='hidden' ORDER BY subtime");
		else if ($_GET['status']=='1')
			$result = mysql_query($sql."stt='accepted' or stt='sent' ORDER BY subtime");
		else if ($_GET['status']=='2')
			$result = mysql_query($sql."stt='rejected' or stt='revoked' ORDER BY subtime");
		else if ($_GET['status']=='3')
			$result = mysql_query($sql."stt='pending' ORDER BY subtime");
		else if ($_GET['status']=='4' || $_GET['status']==NULL)
			$result = mysql_query($sql."stt='pending' or stt='accepted' or stt='sent' ORDER BY subtime");
		
		
		echo "<a href='admin.php?op=viewrecord&status=0'>All Queries</a>&nbsp&nbsp&nbsp&nbsp&nbsp";
		echo "<a href='admin.php?op=viewrecord&status=4'>Default List</a>&nbsp&nbsp&nbsp&nbsp&nbsp";
		echo "<a href='admin.php?op=viewrecord&status=1'>Accepted/Sent Queries Only</a>&nbsp&nbsp&nbsp&nbsp&nbsp";
		echo "<a href='admin.php?op=viewrecord&status=3'>Pending Queries Only</a>&nbsp&nbsp&nbsp&nbsp&nbsp";
		echo "<a href='admin.php?op=viewrecord&status=2'>Rejected/Revoked Queries Only</a>&nbsp&nbsp&nbsp&nbsp&nbsp";
		echo "<br/><br/>\n";
		
		echo "<form action=admin.php?op=viewrecord method=POST>\n" ;
		echo "Advanced Filter:\n";
		echo "<input type=text size=50 name=condition />&nbsp&nbsp&nbsp";
		echo "<input type=submit value=Filter>&nbsp";
		echo "<input type=reset value=reset></form>";
		
		echo "<small><small>(rcv,pcode,stt,address,note,nick,email,passw,subtime)</small></small>";
		//(rcv,pcode,stt,address,note,nick,email,passw)
		echo "<center>";
		
		echo "<small>Filtered by: status='".$_GET['status']."' </small><br/>\n";
		echo "--------Records:-------<br/>";
		
		echo "<table border='1'>
					<tr>
					<th>Email</th>
					<th>Receiver</th>
					<th>Address</th>
					<th>Postcode</th>
					<th>Note</th>
					<th>IP</th>
					<th>Time</th>
					<th>Status</th>
					<th>Admin</th>
					</tr><tr>";
		if ($result)
			while ($row = mysql_fetch_array($result)){
					echo "<th>".urldecode($row['email'])."</th>
					<th>".urldecode($row['rcv'])."</th>
					<th>".urldecode($row['address'])."</th>
					<th>".urldecode($row['pcode'])."</th>
					<th>".urldecode($row['note'])."</th>
					<th><small>".urldecode($row['ip'])."</small></th>
					<th><small>".date("M d (H:i)",$row['subtime'])."</small></th>
					<th>".urldecode($row['stt'])."</th>".
					"<th><a href=admin.php?op=editrecord&email=".$row['email'].">Edit</a>".
					"&nbsp&nbsp<a href=admin.php?op=quickstt&stt=accepted&email=".$row['email'].">a</a>".
					"&nbsp<a href=admin.php?op=quickstt&stt=sent&email=".$row['email'].">s</a>".
					"&nbsp<a href=admin.php?op=quickstt&stt=rejected&email=".$row['email'].">r</a>".
					"&nbsp<a href=admin.php?op=quickstt&stt=pending&email=".$row['email'].">p</a>"
					."</th>".
					"</tr><tr>";
				}
				
		echo "</tr></table><br/><br/></p>";
		echo "<br/>-----------------------<br/>All records in accordance to the filter are listed above.<br/><br/>";
		
		show_admin_quota($quota,$allcnt,$accnt);
	
		echo "<hr/>";
		echo "<p>Commands here are executed for all records, not just those above.</p>";
		echo "<a href=admin.php?op=cleantrash>!~!Delete Trash Records!~!</a>";
		echo "&nbsp&nbsp&nbsp&nbsp&nbsp";
		echo "<a href=admin.php?op=acceptall>Accept all Pending</a>";
		echo "&nbsp&nbsp&nbsp&nbsp&nbsp";
		echo "<a href=admin.php?op=rejectall>Reject all Pending</a>";
		echo "&nbsp&nbsp&nbsp&nbsp&nbsp";
		echo "<a href=admin.php?op=sendall>Send all Accepted</a>";
		echo "&nbsp&nbsp&nbsp&nbsp&nbsp";
		echo "<a href=admin.php?op=markreject>Mark all as Rejected</a>";
		echo "&nbsp&nbsp&nbsp&nbsp&nbsp";
		
		
		echo "\n<br/><br/><a href=admin.php>Control Pannel</a> &nbsp&nbsp"
			."<a href=admin.php?op=phpinfo>PHP info</a>";
		echo "</center>";
		echo "<br/><br/>";
		
		print_footer($copr);
		
?>