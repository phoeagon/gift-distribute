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
	if ($_POST['user']==NULL && $_COOKIE['user']==NULL){
		print_header($system_title);
		print_title_in_page($system_title);
		
		echo "<p><b>Login here:</b></p>\n";	
		echo "<form action='index.php?op=login' method=POST>\n";
		echo "Email: <input type=text name=user /><br/>\n";
		echo "Password: <input type=password name=pass /><br/>\n";
		echo "<input type=submit value='Login!' />\n";
		echo "</form>";
		print_footer($copr);
	}
	else{
		if ($_COOKIE['user']==NULL){
			$user = urlencode($_POST['user']);
			$pass = urlencode($_POST['pass']);
		}
		else{
			$user = urlencode($_COOKIE['user']);
			$pass = urlencode($_COOKIE['pass']);
		}
		
		//(rcv,pcode,stt,address,note,nick,email,passw)
		$result = mysql_query("SELECT * from lists where email='".$user."' and passw='".md5($pass)."'");
		//echo "SELECT (email,passw) from lists where email='".$user."' and passw='".$pass."'";
		
		if ($row = mysql_fetch_array($result)){
			if ($_COOKIE['user']==NULL){
				setcookie('user',$_POST['user']);
				setcookie('pass',$_POST['pass']);
			}
			
			if ($_GET['action']=='revoke'){
				setcookie('user','');
				setcookie('pass','');
				
				$result = mysql_query("UPDATE lists SET stt='revoked', email='".str_replace("%40","%23",$user).
					strval(time()).
					"' WHERE email='".$user."' and passw='".$pass."' and (stt='accpeted' or stt='pending')");
					//echo mysql_error();
				if (!is_null($result)){
					print_header($system_title);
					print_title_in_page($system_title);
					echo "<p>Your Ticket Revoked!<br/>";
					echo "You can now apply again with this email.<br/></p>";
					echo "<p><b><a href=index.php>Homepage</a></b></p>";
					print_footer($copr);
				}
				else{
					//echo "<b>Error occur!</b><br/>";
					write_auto_reload("0","index.php");
				}
			}
			else if ($_GET['action']=='logout'){
				setcookie('user','');
				setcookie('pass','');
				
				print_header($system_title);
				print_title_in_page($system_title);
				echo "<p><b>Logged out.</b></br>";
				echo "<a href=index.php>Homepage</a></p>";
				print_footer($copr);
			}
			else{
				print_header($system_title);
				print_title_in_page($system_title);
				
				echo "Login Successful!<br/><br/>";
				
				echo "Your Submission:<br/>";
				//$row = mysql_fetch_array($result);
				echo "<p style='font-style:normal'>";
				echo "<table border='1'>
					<tr>
					<th>Email</th>
					<th>Receiver</th>
					<th>Address</th>
					<th>Postcode</th>
					<th>Note</th>
					<th>Status</th>
					</tr><tr>";
				echo "<th>".urldecode($row['email'])."</th>
				<th>".urldecode($row['rcv'])."</th>
				<th>".urldecode($row['address'])."</th>
				<th>".urldecode($row['pcode'])."</th>
				<th>".urldecode($row['note'])."</th>
				<th>".urldecode($row['stt'])."</th>";
				echo "</tr></table><br/><br/></p>";
				if ($row['stt']=='accepted'||$row['stt']=='pending')
					echo "-- <a href='index.php?op=login&action=revoke'>Revoke</a> -- ";
				else echo "-- <s>Revoke</s> -- ";
				
				echo "<a href='index.php?op=login&action=logout'>Logout</a>";
				echo " --";
				print_footer($copr);
			}
		}
		else{
			setcookie("user","");
			setcookie("pass","");
			
			print_header_reload($system_title,'5','index.php');
			print_title_in_page($system_title);
			
			echo "<p><b>Login Failed</b><br/>this may be due to a revoked request or malformed cookie.".
			"<br/><a href=index.php>Homepage</a></p><br>";
			print_footer($copr);
		}
	}
	
	
?>
