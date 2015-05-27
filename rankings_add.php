<?php
include "control.php";
include "header.php";
$action = $_POST["action"];
$show = "";
$error = "";
if ($action == "add")
{
$newtitle = $_POST["newtitle"];
$newdescription = $_POST["newdescription"];
$newbannerurl = $_POST["newbannerurl"];
$newbuttonurl = $_POST["newbuttonurl"];
$newurl = $_POST["newurl"];
	if(!$newurl)
	{
	$error .= "<div>Please return and enter the url for your Top Site.</div>";
	}
	if (!$newtitle)
	{
	$error .= "<div>Please return and enter a title for your Top Site.</div>";
	}
	if(!$newdescription)
	{
	$error .= "<div>Please return and enter a short description for your Top Site.</div>";
	}
	if(!$newbannerurl)
	{
	$error .= "<div>Please return and enter the url to your 468x60 banner's image file.</div>";
	}
	if(!$newbuttonurl)
	{
	$error .= "<div>Please return and enter the url to your 125x125 button's image file.</div>";
	}
	if(!$error == "")
	{
	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="600">
	<tr><td align="center" colspan="2"><div class="heading">Error</div></td></tr>
	<tr><td colspan="2" align="center"><br><?php echo $error ?></td></tr>
	<tr><td colspan="2" align="center"><br><a href="rankings_add.php">RETURN</a></td></tr>
	</table>
	<br><br>
	<?php
	include "footer.php";
	exit;
	}
$newtitle = mysql_real_escape_string($newtitle);
$newdescription = mysql_real_escape_string($newdescription);
$q = "insert into rankings_sites (userid,title,description,bannerurl,buttonurl,url,added,dateadded,voteforthissite) values (\"$userid\",\"$newtitle\",\"$newdescription\",\"$newbannerurl\",\"$newbuttonurl\",\"$newurl\",\"yes\",NOW(),\"yes\")";
$r = mysql_query($q);
$idq = "select * from rankings_sites where userid=\"$userid\" and url=\"$newurl\"";
$idr = mysql_query($idq);
$idrows = mysql_num_rows($idr);
if ($idrows > 0)
	{
	$newid = mysql_result($idr,0,"id");
	}
$clickurl = $domain . "/index.php?action=vote&v=" . $newid;
?>
<script language="JavaScript" type="text/javascript">
var copytoclip=1
function HighlightAll(theField) {
var tempval=eval("document."+theField)
tempval.focus()
tempval.select()
if (document.all&&copytoclip==1){
therange=tempval.createTextRange()
therange.execCommand("Copy")
window.status="Contents highlighted and copied to clipboard!"
setTimeout("window.status=''",1800)
}
}
</script>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="600">
<tr><td align="center" colspan="2"><div class="heading">Your Top Site Was Submitted for Admin Approval!</div></td></tr>
<tr><td colspan="2" align="center"><br>IMPORTANT: For your site to be approved by the admin, please make sure you have placed the following code for display on the URL: <a href="<?php echo $newurl ?>" target="_blank"><?php echo $newurl ?></a></td></tr>
<form name="rankingcodeform">
<tr><td colspan="2" align="center"><br>
<textarea rows="3" cols="60" name="rankingcode"><center><a href="<?php echo $clickurl ?>"><img src="<?php echo $domain ?>/images/voteformysite.jpg" border="0" alt="<?php echo $sitename ?>"></a></center></textarea><br><br><a href="javascript: HighlightAll('rankingcodeform.rankingcode')">select all code</a></form>
</td></tr>
<tr><td colspan="2" align="center"><br><a href="rankings_add.php">RETURN</a></td></tr>
</table>
<br><br>
<?php
include "footer.php";
exit;
} # if ($action == "add")
#######################################
if ($action == "delete")
{
$deleteid = $_POST["deleteid"];
?>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="600">
<tr><td align="center" colspan="2"><div class="heading">Are You Sure You Want to Delete Your Top Site Entry?</div></td></tr>
<form action="rankings_add.php" method="post">
<tr><td align="center" colspan="2">
<input type="hidden" name="action" value="deleteconfirm">
<input type="hidden" name="deleteid" value="<?php echo $deleteid ?>">
<input type="submit" value="YES - DELETE THIS SITE">
</form>
</td></tr>
<tr><td colspan="2" align="center"><br><a href="rankings_add.php">NO! CANCEL</a></td></tr>
</table>
<br><br>
<?php
include "footer.php";
exit;
} # if ($action == "delete")
#######################################
if ($action == "deleteconfirm")
{
$deleteid = $_POST["deleteid"];
$q = "delete from rankings_sites where id=\"$deleteid\"";
$r = mysql_query($q);
$q2 = "delete from rankings_click_ips where rankingsiteidclicked=\"$deleteid\"";
$r2 = mysql_query($q2);
?>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="600">
<tr><td align="center" colspan="2"><div class="heading">The Site Was Deleted from the Top Sites Rankings!</div></td></tr>
<tr><td colspan="2" align="center"><br><a href="rankings_add.php">RETURN</a></td></tr>
</table>
<br><br>
<?php
include "footer.php";
exit;
} # if ($action == "deleteconfirm")
#######################################
if ($action == "save")
{
$saveid = $_POST["saveid"];
$savetitle = $_POST["savetitle"];
$savedescription = $_POST["savedescription"];
$savebannerurl = $_POST["savebannerurl"];
$savebuttonurl = $_POST["savebuttonurl"];
$saveurl = $_POST["saveurl"];
$oldurl = $_POST["oldurl"];
$savevoteforthissite = $_POST["savevoteforthissite"];
	if(!$saveurl)
	{
	$error .= "<div>Please return and enter the url for your Top Site.</div>";
	}
	if (!$savetitle)
	{
	$error .= "<div>Please return and enter a title for your Top Site.</div>";
	}
	if(!$savedescription)
	{
	$error .= "<div>Please return and enter a short description for your Top Site.</div>";
	}
	if(!$savebannerurl)
	{
	$error .= "<div>Please return and enter the url to your 468x60 banner's image file.</div>";
	}
	if(!$savebuttonurl)
	{
	$error .= "<div>Please return and enter the url to your 125x125 button's image file.</div>";
	}
	if(!$error == "")
	{
	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="600">
	<tr><td align="center" colspan="2"><div class="heading">Error</div></td></tr>
	<tr><td colspan="2" align="center"><br><?php echo $error ?></td></tr>
	<tr><td colspan="2" align="center"><br><a href="rankings_add.php">RETURN</a></td></tr>
	</table>
	<br><br>
	<?php
	include "footer.php";
	exit;
	}
$savetitle = mysql_real_escape_string($savetitle);
$savedescription = mysql_real_escape_string($savedescription);
if ($oldurl != $saveurl)
	{
	$q = "update rankings_sites set title=\"$savetitle\",description=\"$savedescription\",bannerurl=\"$savebannerurl\",buttonurl=\"$savebuttonurl\",url=\"$saveurl\",voteforthissite=\"$savevoteforthissite\",added=\"yes\",dateadded=NOW(),votingcodeadded=\"no\",approved=\"no\" where id=\"$saveid\"";
	$r = mysql_query($q);
	$clickurl = $domain . "/index.php?action=vote&v=" . $saveid;
	?>
	<script language="JavaScript" type="text/javascript">
	var copytoclip=1
	function HighlightAll(theField) {
	var tempval=eval("document."+theField)
	tempval.focus()
	tempval.select()
	if (document.all&&copytoclip==1){
	therange=tempval.createTextRange()
	therange.execCommand("Copy")
	window.status="Contents highlighted and copied to clipboard!"
	setTimeout("window.status=''",1800)
	}
	}
	</script>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="600">
	<tr><td align="center" colspan="2"><div class="heading">Your Top Site Was Saved and Submitted for Admin Approval!</div></td></tr>
	<tr><td colspan="2" align="center"><br>IMPORTANT: You have changed your website's URL and it will need to be re-approved. For your site to be approved by the admin, please make sure you have placed the following code for display on the URL: <a href="<?php echo $saveurl ?>" target="_blank"><?php echo $saveurl ?></a></td></tr>
	<form name="rankingcodeform">
	<tr><td colspan="2" align="center"><br>
	<textarea rows="3" cols="60" name="rankingcode"><center><a href="<?php echo $clickurl ?>"><img src="<?php echo $domain ?>/images/voteformysite.jpg" border="0" alt="<?php echo $sitename ?>"></a></center></textarea><br><br><a href="javascript: HighlightAll('rankingcodeform.rankingcode')">select all code</a></form>
	</td></tr>
	<tr><td colspan="2" align="center"><br><a href="rankings_add.php">RETURN</a></td></tr>
	</table>
	<br><br>
	<?php
	include "footer.php";
	exit;
	}
if ($oldurl == $saveurl)
	{
	$q = "update rankings_sites set title=\"$savetitle\",description=\"$savedescription\",bannerurl=\"$savebannerurl\",buttonurl=\"$savebuttonurl\",url=\"$saveurl\",voteforthissite=\"$savevoteforthissite\" where id=\"$saveid\"";
	$r = mysql_query($q);
	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="600">
	<tr><td align="center" colspan="2"><div class="heading">Your Top Site Was Saved!</div></td></tr>
	<tr><td colspan="2" align="center"><br><a href="rankings_add.php">RETURN</a></td></tr>
	</table>
	<br><br>
	<?php
	include "footer.php";
	exit;
	}
} # if ($action == "save")
#######################################
?>
<script language="JavaScript">
function previewad(bannerurl,targeturl,type)
{
var win
	if (type == "banner")
	{
	win = window.open("", "win", "height=60,width=468,toolbar=no,directories=no,menubar=no,scrollbars=yes,resizable=yes,dependent=yes'");
	}
	if (type == "button")
	{
	win = window.open("", "win", "height=125,width=125,toolbar=no,directories=no,menubar=no,scrollbars=yes,resizable=yes,dependent=yes'");
	}
win.document.clear();
win.document.write('<center><a href="'+targeturl+'"><img src="'+bannerurl+'" border="0"></a></center>');
win.focus();
win.document.close();
}
var copytoclip=1
function HighlightAll(theField) {
var tempval=eval("document."+theField)
tempval.focus()
tempval.select()
if (document.all&&copytoclip==1){
therange=tempval.createTextRange()
therange.execCommand("Copy")
window.status="Contents highlighted and copied to clipboard!"
setTimeout("window.status=''",1800)
}
}
</script>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="800">
<tr><td align="center" colspan="2"><div class="heading">My Top Sites</div></td></tr>
<?php
if ($show != "")
{
?>
<tr><td align="center" colspan="2"><br><?php echo $show ?></td></tr>
<?php
}
?>
<tr><td align="center" colspan="2">
<table cellpadding="2" cellspacing="2" border="0" align="center" width="800">
<tr><td>
<div style="text-align: center;">
<?php
$q = "select * from pages where name='Members Area Add Sites To Top Ranked Sites Page'";
$r = mysql_query($q);
$rowz = mysql_fetch_array($r);
$htmlcode = $rowz["htmlcode"];
echo $htmlcode;
?>
</div>
</td></tr>
</table>
</td></tr>

<tr><td align="center" colspan="2"><br>
<form action="rankings_add.php" method="post">
<table width="800" border="0" cellpadding="2" cellspacing="2" class="sabrinatable" align="center">
<tr class="sabrinatrlight"><td align="center" colspan="2">ADD NEW TOP SITE!</td></tr>
<tr class="sabrinatrdark"><td colspan="2">IMPORTANT! Before your site will appear on the <a href="index.php" target="_blank">Top Site Rankings</a> page, you need to verify your website by adding the vote code to your site. After the code is added,
your site will be approved by us shortly to show in the Top Sites and start receiving votes!</td></tr>
<tr class="sabrinatrlight"><td>Website URL:</td><td><input type="text" name="newurl" size="100" maxlength="500"></td></tr>
<tr class="sabrinatrlight"><td>Website Title (max 50 characters):</td><td><input type="text" name="newtitle" size="100" maxlength="50"></td></tr>
<tr class="sabrinatrlight"><td>Website Description (max 300 characters):</td><td><input type="text" name="newdescription" size="100" maxlength="300"></td></tr>
<tr class="sabrinatrlight"><td>Your 468x60 Banner Image URL (jpg, gif, or png):</td><td><input type="text" name="newbannerurl" size="100" maxlength="500"></td></tr>
<tr class="sabrinatrlight"><td>Your 125x125 Button Image URL (jpg, gif, or png):</td><td><input type="text" name="newbuttonurl" size="100" maxlength="500"></td></tr>
<tr class="sabrinatrdark"><td colspan="2" align="center">
<input type="hidden" name="action" value="add">
<input type="button" name="preview" value="PREVIEW BANNER" style="width:150px;" onclick="previewad(newbannerurl.value, newurl.value, 'banner')">&nbsp;&nbsp;<input type="button" name="preview" value="PREVIEW BUTTON" style="width:150px;" onclick="previewad(newbuttonurl.value, newurl.value, 'button')">&nbsp;&nbsp;<input type="submit" value="ADD" style="width:150px;"></form>
</td></tr>
</table>
</td></tr>

<tr><td align="center" colspan="2"></td></tr>

<?php
$sitesq = "select * from rankings_sites where userid=\"$userid\" order by id";
$sitesr = mysql_query($sitesq);
$sitesrows = mysql_num_rows($sitesr);
if ($sitesrows > 0)
{
?>
<tr><td align="center" colspan="2"><br>
<table width="800" border="0" cellpadding="2" cellspacing="2" class="sabrinatable" align="center">
<tr class="sabrinatrlight"><td colspan="2" align="center">YOUR TOP SITES</td></tr>
<tr class="sabrinatrdark"><td colspan="2">IMPORTANT! If you change a site's URL, before it will appear on the <a href="index.php" target="_blank">Top Site Rankings</a> page again, you will need to verify your website by adding the vote code to your site. After the code is added,
your site will be re-approved by us shortly.</td></tr>
</table></td></tr>
<?php
	while ($sitesrowz = mysql_fetch_array($sitesr))
	{
		$id = $sitesrowz["id"];
		$url = $sitesrowz["url"];
		$title = $sitesrowz["title"];
		$title = stripslashes($title);
		$title = str_replace('\\', '', $title);
		$description = $sitesrowz["description"];
		$description = stripslashes($description);
		$description = str_replace('\\', '', $description);
		$bannerurl = $sitesrowz["bannerurl"];
		$buttonurl = $sitesrowz["buttonurl"];
		$added = $sitesrowz["added"];
		$dateadded = $sitesrowz["dateadded"];
		$votingcodeadded = $sitesrowz["votingcodeadded"];
		$approved = $sitesrowz["approved"];
		$clicks = $sitesrowz["clicks"];
		$hits = $sitesrowz["hits"];
		$votes = $sitesrowz["votes"];
		$voteforthissite = $sitesrowz["voteforthissite"];
		if ($approved == "yes")
		{
			$showapproved = "Yes";
			$bgapproved = "#99cc99";
		}
		if ($approved != "yes")
		{
			$showapproved = "Pending Admin Approval";
			$bgapproved = "#ff9999";
		}
		if ($voteforthissite == "yes")
		{
			$bgvoteforthissite = "#99cc99";
		}
		if ($voteforthissite != "yes")
		{
			$bgvoteforthissite = "#ff9999";
		}
		$clickurl = $domain . "/index.php?action=vote&v=" . $id;
		?>
		<tr><td align="center" colspan="2"><br>
		<table width="800" border="0" cellpadding="2" cellspacing="2" class="sabrinatable" align="center">
		<tr><td colspan="2" align="center" style="height:5px;"></td></tr>
		<form action="rankings_add.php" method="post" name="saveform">
		<tr class="sabrinatrlight"><td>Top Site ID#:</td><td><?php echo $id ?></td></tr>
		<tr class="sabrinatrlight"><td valign="top">Banner:</td><td align="center"><a href="<?php echo $url ?>" target="_blank"><img src="<?php echo $bannerurl ?>" border="0" alt="<?php echo $title ?>" width="468" height="60"></a></td></tr>
		<tr class="sabrinatrlight"><td valign="top">Button:</td><td align="center"><a href="<?php echo $url ?>" target="_blank"><img src="<?php echo $buttonurl ?>" border="0" alt="<?php echo $title ?>" width="125" height="125"></a></td></tr>
		<tr class="sabrinatrlight"><td valign="top">Voting Code for Your Website (required for approval):</td><td align="center"><textarea rows="3" cols="60" name="rankingcode"><center><a href="<?php echo $clickurl ?>"><img src="<?php echo $domain ?>/images/voteformysite.jpg" border="0" alt="<?php echo $sitename ?>"></a></center></textarea><br><br><a href="javascript: HighlightAll('saveform.rankingcode')">select all code</a></td></tr>
		<tr class="sabrinatrlight" style="background:<?php echo $bgapproved ?>;"><td>Admin Approved:</td><td><?php echo $showapproved ?></td></tr>
		<tr class="sabrinatrlight"><td>Votes:</td><td><?php echo $votes ?></td></tr>
		<tr class="sabrinatrlight"><td>Hits/Impressions:</td><td><?php echo $hits ?></td></tr>
		<tr class="sabrinatrlight"><td>Clicks:</td><td><?php echo $clicks ?></td></tr>
		<tr class="sabrinatrlight"><td>Website URL:</td><td><input type="text" name="saveurl" size="100" maxlength="500" value="<?php echo $url ?>"></td></tr>
		<tr class="sabrinatrlight"><td>Website Title (max 50 characters):</td><td><input type="text" name="savetitle" size="100" maxlength="50" value="<?php echo $title ?>"></td></tr>
		<tr class="sabrinatrlight"><td>Website Description (max 300 characters):</td><td><input type="text" name="savedescription" size="100" maxlength="300" value="<?php echo $description ?>"></td></tr>
		<tr class="sabrinatrlight"><td>Your 468x60 Banner Image URL (jpg, gif, or png):</td><td><input type="text" name="savebannerurl" size="100" maxlength="500" value="<?php echo $bannerurl ?>"></td></tr>
		<tr class="sabrinatrlight"><td>Your 125x125 Button Image URL (jpg, gif, or png):</td><td><input type="text" name="savebuttonurl" size="100" maxlength="500" value="<?php echo $buttonurl ?>"></td></tr>
		<tr class="sabrinatrlight" style="background:<?php echo $bgvoteforthissite ?>;"><td>Enabled:</td><td><select name="savevoteforthissite"><option value="yes" <?php if ($voteforthissite == "yes") { echo "selected"; } ?>>YES</option><option value="no" <?php if ($voteforthissite != "yes") { echo "selected"; } ?>>NO</option></select></td></tr>
		<tr class="sabrinatrlight"><td colspan="2" align="center">
		<input type="hidden" name="action" value="save">
		<input type="hidden" name="saveid" value="<?php echo $id ?>">
		<input type="hidden" name="oldurl" value="<?php echo $oldurl ?>">
		<input type="button" name="preview" value="PREVIEW BANNER" style="width:150px;" onclick="previewad(savebannerurl.value, saveurl.value, 'banner')">&nbsp;&nbsp;<input type="button" name="preview" value="PREVIEW BUTTON" style="width:150px;" onclick="previewad(savebuttonurl.value, saveurl.value, 'button')">&nbsp;&nbsp;<input type="submit" value="SAVE" style="width:150px;">
		</form>
		</td></tr>
		<form action="rankings_add.php" method="post">
		<tr class="sabrinatrlight"><td colspan="2" align="center">
		<input type="hidden" name="action" value="delete">
		<input type="hidden" name="deleteid" value="<?php echo $id ?>">
		<input type="submit" value="DELETE" style="width:150px;">
		</form>
		</td></tr>
		<tr><td colspan="2" align="center" style="height:5px;"></td></tr>
		</table>
		</td></tr>
		<?php
	} # while ($sitesrowz = mysql_fetch_array($sitesr))
} # if ($sitesrows > 0)
?>


</table>
</td></tr>

</table>
<br><br>
<?php
include "footer.php";
exit;
?>