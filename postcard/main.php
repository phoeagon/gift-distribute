<?php
/*
Postcard Distribution System
by phoeagon
this software is distributed under the GNU General Public License (GPL). 
It comes with ABSOLUTELY NO WARRANTY.
This is free software, and you are welcome to redistribute it
under certain conditions. Check "gpl.txt" for details.
*/
	print_header($system_title);
	
	print_title_in_page($system_title);
	
	echo get_cont_val('desc');
	echo "<hr/>";
	
	if (get_set_val("can_viewrec")=="1")
		echo "<a href=index.php?op=showrecord>View records</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	else echo "[<s>Record View</s>]&nbsp;&nbsp;&nbsp;&nbsp;";
	
	//echo "<hr/>";
	//(rcv,pcode,stt,address,note,nick,email,passw)
	//require_once "login.php";
	//if ($_COOKIE['user']==NULL)
		echo "<a href=index.php?op=login>My Status</a>";
	//else echo "<a href=index.php?op=login>My Status</a>";
	
	echo "<br/><div style='text-align:right'>";
	if ($viewquota=='1')
		print_quota($quota);
	echo " ";
	if ($viewcnt=='1')
		print_current($allcnt,'');
	
	echo "</div><hr/>\n";
	//(rcv,pcode,stt,address,note,nick,email(unique),passw,invi)

	
	if (get_set_val("can_submit")=='1'){
		echo "<form action=index.php?op=submit method=POST>\n";
		echo "<b>Apply for a postcard:</b>\n<br/>";
		echo "<p>Email:&nbsp;&nbsp;&nbsp;&nbsp;<input type=text name=email /><br/><small>(won't be published, must be unique)</small></p>";
		echo "<p>Password:&nbsp;<input type=password name=passw /></p>";
		echo "<p>Nickname:&nbsp;<input type=text name=nick />[public]</p>";
		
		if ($invite_code!='')echo "<p>Invitation:<input type=text name=invi ".$_GET['invicode']."/></p>";
		
		echo "<p>Receiver:&nbsp;<input type=text name=rcv />";
		echo "     Postcode:<input type=text name=pcode /></p>";
		echo "<p>Address:&nbsp;<input type=text name=address size=50 /></p>";
		echo "<p>Note:&nbsp;&nbsp;&nbsp;&nbsp;<textarea name=note cols=60 rows=5></textarea></p>\n";
		
		echo "<p><input type=submit value='Submit!' /></p>";
		echo "</form>\n";
	}
	else echo "Submission Disabled.";
	print_footer($copr);
	echo "<center><small><a href=admin.php>Control Pannel</a>&nbsp;&nbsp;</small></center>";
?>