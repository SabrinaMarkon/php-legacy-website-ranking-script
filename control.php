<?php 
if(!isset($_SESSION))
{
session_start();
}
include "db.php";
if ($_REQUEST["loginusername"])
{
$_SESSION["loginusername"] = $_REQUEST["loginusername"];
$_SESSION["loginpassword"] = $_REQUEST["loginpassword"];
}
$loginq = "select * from members where userid=\"".$_SESSION["loginusername"]."\" and password=\"".$_SESSION["loginpassword"]."\"";
$loginr = mysql_query($loginq);
$loginrows = mysql_num_rows($loginr);
	if ($loginrows < 1)
	{
	unset($_SESSION["loginusername"]);
	unset($_SESSION["loginpassword"]);
	$memberloggedin = "no";
	$show = "<div class=\"message\">Incorrect Login</div>";
	@header("Location: " . $domain . "/login.php?show=" . $show);
	exit;
	}
	if ($loginrows > 0)
	{
	$memberloggedin = "yes";
	$userid = mysql_result($loginr,0,"userid");
	$password = mysql_result($loginr,0,"password");
	$referid = mysql_result($loginr,0,"referid");
	$firstname = mysql_result($loginr,0,"firstname");
	$lastname = mysql_result($loginr,0,"lastname");
	$fullname = $firstname . " " . $lastname;
	$email = mysql_result($loginr,0,"email");
	$country = mysql_result($loginr,0,"country");
	$signupdate = mysql_result($loginr,0,"signupdate");
	$signupip = mysql_result($loginr,0,"signupip");
	$verified = mysql_result($loginr,0,"verified");
	$verifieddate = mysql_result($loginr,0,"verifieddate");
	$lastlogin = mysql_result($loginr,0,"lastlogin");
	}

	if ($verified == "no")
	{
	unset($_SESSION["loginusername"]);
	unset($_SESSION["loginpassword"]);
	#session_destroy();
	$show = "<div class=\"message\">Email Address Not Verified!<br><br><a href=resendverify.php?userid=$userid>Click Here to Resend your Verification Email</a></div>";
	@header("Location: " . $domain . "/login.php?show=" . $show);
	exit;
	}

extract($_REQUEST);
?>