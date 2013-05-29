<?php
/*
Postcard Distribution System
by phoeagon
this software is distributed under the GNU General Public License (GPL). 
It comes with ABSOLUTELY NO WARRANTY.
This is free software, and you are welcome to redistribute it
under certain conditions. Check "gpl.txt" for details.
*/
	if ($_GET["op"] == "install"){
		
		if ($_POST["pass"]==NULL){
			header("Location: setup_wizard.htm");
			exit;
		}
			else $pass = $_POST["pass"];
		
		
		
		if (!mysql_query("CREATE DATABASE ".$sql_database))
			die("Error creating database named ".$sql_database);

		if (!mysql_select_db($sql_database,$con))
			die("Connection Error!");
		mysql_query("ALTER DATABASE `".$sql_database."` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");
		
		mysql_query("DROP TABLE general");
		if (!mysql_query("CREATE TABLE general (opt varchar(50),val varchar(50),descr varchar(50))",$con))
			die("Error Creating table 'general'!");
		
		if (
			mysql_query("INSERT INTO general (opt,val,descr) VALUES ('sys_run','1','System On (0/1):')") &&
			mysql_query("INSERT INTO general (opt,val,descr) VALUES ('pass','".str_crypt($pass)."','Password():')") &&
			mysql_query("INSERT INTO general (opt,val,descr) VALUES ('can_submit','1','Allow Submission(0/1):')") &&
			mysql_query("INSERT INTO general (opt,val,descr) VALUES ('can_viewrec','1','Allow Record Viewing for visitors(0/1):')")&&
			mysql_query("INSERT INTO general (opt,val,descr) VALUES ('invi','','Invitation Code. (NULL/Code)')") &&
			mysql_query("INSERT INTO general (opt,val,descr) VALUES ('quota','50','Postcard Quota:')") &&
			mysql_query("INSERT INTO general (opt,val,descr) VALUES ('viewquota','1','Quota_is_public:')") &&
			mysql_query("INSERT INTO general (opt,val,descr) VALUES ('viewcnt','1','Count_is_public:')")
		)
			echo "General Setup Okay!<br/><b>Password:</b>".$pass."<br/>";
		else echo "Setup Error!<br/>";
		
		mysql_query("DROP TABLE lists");
		if (!mysql_query("CREATE TABLE lists ( rcv varchar(50)NOT NULL,pcode varchar(50)NOT NULL,stt varchar(50),address varchar(255)NOT NULL,note varchar(255), nick varchar(50),email varchar(100) UNIQUE NOT NULL,passw varchar(100) NOT NULL,invi varchar(50),subtime int, ip varchar(50))",$con))
			die("Error Creating table 'lists'!");
		//(rcv,pcode,stt,address,note,nick,email(unique),passw,invi,subtime,ip)
		
		if (mysql_query("INSERT INTO lists (rcv,pcode,stt,address,note,nick,email,passw,invi,subtime,ip) VALUES ('system','555555','sent','somewhere on Mars','Hello world','sys','sys%40sys.edu','".md5("123")."','self-invited',-1,'localhost')"))
			echo "Postcard record Test Passed! <br/>";
		else echo "Test Error!<br/>";
		
		mysql_query("DROP TABLE cont");
		if (!mysql_query("CREATE TABLE cont ( opt varchar(50) , val text )",$con))
			die("Error Creating table 'cont'!");
		if (
			mysql_query("INSERT INTO cont (opt,val) VALUES ('title','PostCard Distribution System') ")&&
			mysql_query("INSERT INTO cont (opt,val) VALUES ('desc','This is a test example')")
		)echo "Content table test okay.";
		else echo "Content Table Test Fault!";
		
		
		echo "<p><a href=index.php>Homepage</a></p>";
		print_footer($copr);
		exit;
	}
?>