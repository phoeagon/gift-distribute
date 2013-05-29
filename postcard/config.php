<?php
/*
Postcard Distribution System
by phoeagon
this software is distributed under the GNU General Public License (GPL). 
It comes with ABSOLUTELY NO WARRANTY.
This is free software, and you are welcome to redistribute it
under certain conditions. Check "gpl.txt" for details.
*/
	$sql_host='localhost';
	$sql_user='root';
	$sql_pass='vertrigo';
	$sql_database='postcard';
	
	$message_pre="<html><head><title>System Message</title><body>";
	$message_post="</body></html>";
	
	$message_close=urlencode("<big><big>System Closed</big></big></br></br>System Closed by Admin. <br/>How about coming here later?");
	$message_banned=urlencode("<big><big>Operation Disabled</big></big></br>");
	
	$copr = "<hr/><center><small>Copyright 2011 by phoeagon</small><br/></center>";
	
	function str_crypt($line){
		$salt = substr($line,0,CRYPT_SALT_LENGTH);
		return $result = md5(crypt($line,$salt));
	}
	
	function print_footer($copr){
		echo $copr;
		echo "</body></html>\n";
	}
	function print_header($title){
		echo "<html><head><title>".$title."</title>";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />";
		echo "</head>\n";
		echo "<body>\n";
	}
	
	//(rcv,pcode,stt,address,note,nick,email,passw)
	function get_set_val($opt){
		$result = mysql_query("SELECT * FROM general WHERE opt='".$opt."'");
		if (!$result){
			die(mysql_error());
			return "ERROR";
		}
		$a = mysql_fetch_array($result);
		return $a['val'];
	}
	function get_cont_val($opt){
		$result = mysql_query("SELECT * FROM cont WHERE opt='".$opt."'");
		if (!$result){
			die(mysql_error());
			return "ERROR";
		}
		$a = mysql_fetch_array($result);
		return $a['val'];
	}
	function print_title_in_page($system_title){
		echo "<p><b><big><big><center>";
		echo "<a href=index.php>".$system_title."</a>";
		echo "</center></big></big></b></p>";
	}
	function write_auto_reload($time,$url){
		echo "<html><head>";
		echo "<meta http-equiv='refresh' content='".$time.";url=".$url."'>\n</head>\n ";
		echo "<body>Now redirecting to <a href=".$url.">here</a>.</body></html>";
	}
	function print_header_reload($title,$time,$url){
		echo "<html><head><title>".$title."</title>";
		echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\" />";
		echo "<meta http-equiv='refresh' content='".$time.";url=".$url."'>\n</head>\n ";
		echo "</head>\n";
		echo "<body>\n";
	}
	function write_script_reload($time,$url){
		//echo "lala";
		echo "<a href=javascript:setTimeout('window.location=".$url."',".$time.")>";
		echo "here</a>\n";
	}
	function user_ip(){
		$user_IP = ($_SERVER["HTTP_VIA"]) ? $_SERVER["HTTP_X_FORWARDED_FOR"] : $_SERVER["REMOTE_ADDR"];
		$user_IP = ($user_IP) ? $user_IP : $_SERVER["REMOTE_ADDR"]; 
		return $user_IP;
	}
	function print_quota($quota){
		echo $quota." postcard(s) planned";
	}
	function print_current($all,$ac){
		if (strlen($all)) echo "".$all." submission(s) in total";
		if (strlen($ac)) echo " | ".$ac." accepted or sent.";
	}
	function show_admin_quota($quota,$allcnt,$accnt){
		echo "<br/><div style='text-align:right'>";
		print_quota($quota);
		echo " | ";
		print_current($allcnt,$accnt);
		
		echo "</div>\n";
	}
?>
