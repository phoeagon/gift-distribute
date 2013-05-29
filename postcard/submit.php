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
	if ($_POST['email']==NULL){
		echo "How did you reach here?!\n";
	}
	else if (get_set_val("can_submit")=='1' ){
		//echo "e";
		//echo $system_run;
	//(rcv,pcode,stt,address,note,nick,email(unique),passw,invi,subtime,ip)
		$email = urlencode($_POST['email']);
		$passw = urlencode($_POST['passw']);
		
		$receiver = urlencode($_POST['rcv']);
		$pcode = urlencode($_POST['pcode']);
		$address = urlencode($_POST['address']);
		$note = urlencode($_POST['note']);
		$nick = urlencode($_POST['nick']);
		$invi = urlencode($_POST['invi']);
		
		if ($invi==$invite_code || strlen($invite_code)==0){
			$result = mysql_query(
			"INSERT INTO lists VALUES ('".
				$receiver.	"','".
				$pcode.		"','".
				"pending".	"','".
				$address.	"','".
				$note.		"','".
				$nick.		"','".
				$email.		"','".
				md5($passw).		"','".
				$invi.		"','".
				strval(time())."','".
				user_ip()."')" 
				 );
			if ($result){
				//print_header($system_title);
				print_header_reload($system_title,'5','index.php');
				print_title_in_page($system_title);
				
				echo "<b>Submission Successful!</b><br/>\n";
				echo "<a href=index.php>Homepage</a><br/>";
				print_footer($copr);
			}
			else {
				print_header_reload($system_title,'3','index.php');
				print_title_in_page($system_title);
				
				echo "<b>an error occur!</b><br/>Check your submission again and especially your invitation code.";
				echo "<br/><br/><a href=index.php>Homepage</a><br/>";
				//write_script_reload('3','index.php');
				print_footer($copr);
			}
		}
		else {
				print_header_reload($system_title,'3','index.php');
				print_title_in_page($system_title);
				
				echo "<b>an error occur!</b><br/>Check your submission again and especially your invitation code.";
				echo "<br/><br/><a href=index.php>Homepage</a><br/>";
				write_script_reload('3','index.php');
				print_footer($copr);
			}
	}
	else {
		header("Location: index.php?op=message&content=".urlencode("<b>Submission Closed.</b>"));
	}
?>