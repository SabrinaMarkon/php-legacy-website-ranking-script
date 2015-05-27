<?php
include "control.php";
include "header.php";
$action = $_POST["action"];
$show = "";
if ($action == "update")
{
$password = $_POST["password"];
$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$email = $_POST["email"];
$country = $_POST["country"];
	if (!$password)
	{
	$error .= "<div>Please return and enter a valid password.</div>";
	}
	if(!$firstname)
	{
	$error .= "<div>Please return and enter your first name.</div>";
	}
	if(!$lastname)
	{
	$error .= "<div>Please return and type in your last name.</div>";
	}
	if(!$email)
	{
	$error .= "<div>Please return and enter your email address.</div>";
	}
	
	if(!$error == "")
	{
	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="600">
	<tr><td align="center" colspan="2"><div class="heading">Update Error</div></td></tr>
	<tr><td colspan="2" align="center"><br><?php echo $error ?></td></tr>
	<tr><td colspan="2" align="center"><br><a href="profile.php">RETURN</a></td></tr>
	</table>
	<br><br>
	<?php
	include "footer.php";
	exit;
	}

$q = "update members set password=\"$password\",firstname=\"$firstname\",lastname=\"$lastname\",email=\"$email\",country=\"$country\" where userid=\"$userid\"";
$r = mysql_query($q);

$show = "Your profile was updated!";

} # if ($action == "update")
?>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="800">
<tr><td align="center" colspan="2"><div class="heading">Your Account Profile</div></td></tr>
<?php
if ($show != "")
{
?>
<tr><td align="center" colspan="2"><br><?php echo $show ?></td></tr>
<?php
}
?>
<tr><td align="center" colspan="2">
<table cellpadding="2" cellspacing="2" border="0" align="center" width="100%">
<tr><td>
<div style="text-align: center;">
<?php
$q = "select * from pages where name='Members Area Profile Page'";
$r = mysql_query($q);
$rowz = mysql_fetch_array($r);
$htmlcode = $rowz["htmlcode"];
echo $htmlcode;
?>
</div>
</td></tr>
</table>
</td></tr>

<tr><td align="center" colspan="2">
<table cellpadding="2" cellspacing="2" border="0" align="center" width="100%" class="sabrinatable">
<tr class="sabrinatrlight"><td align="right">UserID:</td><td><?php echo $userid ?></td></tr>
<form action="profile.php" method="post" target="_top">
<tr class="sabrinatrlight"><td align="right">Password:</td><td><input type="text" name="password" class="typein" maxlength="255" size="55" value="<?php echo $password ?>"></td></tr>
<tr class="sabrinatrlight"><td align="right">First Name:</td><td><input type="text" name="firstname" class="typein" maxlength="255" size="55" value="<?php echo $firstname ?>"></td></tr>
<tr class="sabrinatrlight"><td align="right">Last Name:</td><td><input type="text" name="lastname" class="typein" maxlength="255" size="55" value="<?php echo $lastname ?>"></td></tr>
<tr class="sabrinatrlight"><td align="right">Email:</td><td><input type="text" name="email" class="typein" maxlength="255" size="55" value="<?php echo $email ?>"></td></tr>
<?php
$cq = "select * from countries order by country_id";
$cr = mysql_query($cq);
$crows = mysql_num_rows($cr);
if ($crows > 0)
{
?>
<tr class="sabrinatrlight"><td align="right">Country:</td><td><select name="country" style="width: 140px;" class="pickone">
<?php
	while ($crowz = mysql_fetch_array($cr))
	{
	$country_name = $crowz["country_name"];
?>
<option value="<?php echo $country_name ?>" <?php if ($country == $country_name) { echo "selected"; } ?>><?php echo $country_name ?></option>
<?php
	}
?>
</select>
<?php
}
?>
</td></tr>
<tr class="sabrinatrdark"><td colspan="2" align="center">
<input type="hidden" name="action" value="update">
<input type="submit" value="SAVE" class="sendit">
</td></tr></form>

</table>
</td></tr>

</table>
<br><br>
<?php
include "footer.php";
exit;
?>