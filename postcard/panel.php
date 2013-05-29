<?php
/*
Postcard Distribution System
by phoeagon
this software is distributed under the GNU General Public License (GPL). 
It comes with ABSOLUTELY NO WARRANTY.
This is free software, and you are welcome to redistribute it
under certain conditions. Check "gpl.txt" for details.
*/
	//called from admin.php as main panel
	
	//echo "logged in";
	print_header($system_title);
	print_title_in_page($system_title);
	
	echo "<hr/>";
	echo "<center><a href=admin.php?op=viewrecord>View Records</a>&nbsp&nbsp&nbsp&nbsp&nbsp\n";
	echo "<a href=admin.php?op=logout>Logout</a></center>\n";
	show_admin_quota($quota,$allcnt,$accnt);
	//echo "";
	
	//the first form
		echo "<p><b>Overview Setting</b></p>\n";
		$result = mysql_query("SELECT * FROM general");
		echo "<form action=admin.php?op=paneledit method=POST />\n";
		while ($row = mysql_fetch_array($result)){
			if ($row['opt']=='pass')
				$row['val']='';
			echo $row['descr']."<input type=text name=".$row['opt']." value='".$row['val']."' />"."<br/>\n";
		}
		echo "<input type=submit value='Configure!' />&nbsp&nbsp\n";
		echo "<input type='reset' value='Reset' />\n";
		echo "</form>\n";
	
	//now the second form
		echo "<br/>";
		echo "<p><b>TEXT settings</b></p>\n";
		echo "<form action=admin.php?op=textedit method=POST />\n";
		$result = mysql_query("SELECT * FROM cont");
		
		//now the title
		$row = mysql_fetch_array($result);
		echo $row['opt']."<br/><input type=text name=".$row['opt']." value='".$row['val']."' size=50 /><br/>\n";
		
		while ($row = mysql_fetch_array($result)){
			echo $row['opt']."<br/><textarea name=".$row['opt']." cols=40 rows=10>".$row['val']."</textarea><br/>\n";
		}
		echo "<input type=submit value='Configure!' />&nbsp&nbsp\n";
		echo "<input type='reset' value='Reset' />\n";
		echo "</form>\n";
		echo "<br/><br/><br/>";
	
	//echo "<center><a href=admin.php?op=logout>Logout</a></center>\n";
	//echo "<hr/>\n";
	
	print_footer($copr);
?>