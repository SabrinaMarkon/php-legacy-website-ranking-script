<?php
include "control.php";
include "../header.php";
function formatDate($val) {
	$arr = explode("-", $val);
	return date("M d Y", mktime(0,0,0, $arr[1], $arr[2], $arr[0]));
}
$action = $_POST["action"];
$error = "";
$show = "";
$orderedby = $_REQUEST["orderedby"];
if ($orderedby == "userid")
{
$orderedbyq = "userid";
}
elseif ($orderedby == "password")
{
$orderedbyq = "password";
}
elseif ($orderedby == "firstname")
{
$orderedbyq = "firstname";
}
elseif ($orderedby == "lastname")
{
$orderedbyq = "lastname";
}
elseif ($orderedby == "email")
{
$orderedbyq = "email";
}
elseif ($orderedby == "country")
{
$orderedbyq = "country";
}
elseif ($orderedby == "referid")
{
$orderedbyq = "referid";
}
elseif ($orderedby == "signupip")
{
$orderedbyq = "signupip";
}
elseif ($orderedby == "signupdate")
{
$orderedbyq = "signupdate desc";
}
elseif ($orderedby == "lastlogin")
{
$orderedbyq = "lastlogin desc";
}
elseif ($orderedby == "verified")
{
$orderedbyq = "verified desc";
}
elseif ($orderedby == "id")
{
$orderedbyq = "id";
}
else
{
$orderedbyq = "userid";
}
#################################################
if ($action == "add")
{
$newuserid = $_POST["newuserid"];
$newtitle = $_POST["newtitle"];
$newdescription = $_POST["newdescription"];
$newbannerurl = $_POST["newbannerurl"];
$newbuttonurl = $_POST["newbuttonurl"];
$newurl = $_POST["newurl"];
$newvoteforthissite = $_POST["newvoteforthissite"];
	if(!$newurl)
	{
	$error .= "<div>Please return and enter the url for the Top Site.</div>";
	}
	if (!$newtitle)
	{
	$error .= "<div>Please return and enter a title for the Top Site.</div>";
	}
	if(!$newdescription)
	{
	$error .= "<div>Please return and enter a short description for the Top Site.</div>";
	}
	if(!$newbannerurl)
	{
	$error .= "<div>Please return and enter the url to the 468x60 banner's image file.</div>";
	}
	if(!$newbuttonurl)
	{
	$error .= "<div>Please return and enter the url to the 125x125 button's image file.</div>";
	}
	if(!$error == "")
	{
	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="600">
	<tr><td align="center" colspan="2"><div class="heading">Error</div></td></tr>
	<tr><td colspan="2" align="center"><br><?php echo $error ?></td></tr>
	<tr><td colspan="2" align="center"><br><a href="rankings_control.php?orderedby=<?php echo $orderedby ?>">RETURN</a></td></tr>
	</table>
	<br><br>
	<?php
	include "../footer.php";
	exit;
	}
$newtitle = mysql_real_escape_string($newtitle);
$newdescription = mysql_real_escape_string($newdescription);
$q = "insert into rankings_sites (userid,title,description,bannerurl,buttonurl,url,added,dateadded,voteforthissite) values (\"$newuserid\",\"$newtitle\",\"$newdescription\",\"$newbannerurl\",\"$newbuttonurl\",\"$newurl\",\"yes\",NOW(),\"$newvoteforthissite\")";
$r = mysql_query($q);
$idq = "select * from rankings_sites where userid=\"$newuserid\" and url=\"$newurl\" order by id desc limit 1";
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
<tr><td align="center" colspan="2"><div class="heading">The Top Site Was Added!</div></td></tr>
<tr><td colspan="2" align="center"><br>IMPORTANT! Before any site will appear on the <a href="<?php echo $domain ?>" target="_blank">Top Site Rankings</a> page, the member needs to verify it by adding the vote code below to their site. Approve sites for entry on the Top Sites page once you see they have indeed added the code to their URL (which should be the same URL they submit).</td></tr>
<form name="rankingcodeform">
<tr><td colspan="2" align="center"><br>
<textarea rows="3" cols="60" name="rankingcode"><center><a href="<?php echo $clickurl ?>"><img src="<?php echo $domain ?>/images/voteformysite.jpg" border="0" alt="<?php echo $sitename ?>"></a></center></textarea><br><br><a href="javascript: HighlightAll('rankingcodeform.rankingcode')">select all code</a></form>
</td></tr>
<tr><td colspan="2" align="center"><br><a href="rankings_control.php?orderedby=<?php echo $orderedby ?>">RETURN</a></td></tr>
</table>
<br><br>
<?php
include "../footer.php";
exit;
} # if ($action == "add")
#######################################
if ($action == "delete")
{
$deleteid = $_POST["deleteid"];
?>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="600">
<tr><td align="center" colspan="2"><div class="heading">Are You Sure You Want to Delete the Top Site Entry?</div></td></tr>
<form action="rankings_control.php" method="post">
<tr><td align="center" colspan="2">
<input type="hidden" name="action" value="deleteconfirm">
<input type="hidden" name="orderedby" value="<?php echo $orderedby ?>">
<input type="hidden" name="deleteid" value="<?php echo $deleteid ?>">
<input type="submit" value="YES - DELETE THIS SITE">
</form>
</td></tr>
<tr><td colspan="2" align="center"><br><a href="rankings_control.php?orderedby=<?php echo $orderedby ?>">NO! CANCEL</a></td></tr>
</table>
<br><br>
<?php
include "../footer.php";
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
<tr><td colspan="2" align="center"><br><a href="rankings_control.php?orderedby=<?php echo $orderedby ?>">RETURN</a></td></tr>
</table>
<br><br>
<?php
include "../footer.php";
exit;
} # if ($action == "deleteconfirm")
#######################################
if ($action == "save")
{
$saveid = $_POST["saveid"];
$title = $_POST["title"];
$description = $_POST["description"];
$bannerurl = $_POST["bannerurl"];
$buttonurl = $_POST["buttonurl"];
$url = $_POST["url"];
$oldurl = $_POST["oldurl"];
$voteforthissite = $_POST["voteforthissite"];
$added = $_POST["added"];
$approved = $_POST["approved"];
$votingcodeadded = $_POST["votingcodeadded"];
	if(!$url)
	{
	$error .= "<div>Please return and enter the url for the Top Site.</div>";
	}
	if (!$title)
	{
	$error .= "<div>Please return and enter a title for the Top Site.</div>";
	}
	if(!$description)
	{
	$error .= "<div>Please return and enter a short description for the Top Site.</div>";
	}
	if(!$bannerurl)
	{
	$error .= "<div>Please return and enter the url to the 468x60 banner's image file.</div>";
	}
	if(!$buttonurl)
	{
	$error .= "<div>Please return and enter the url to the 125x125 button's image file.</div>";
	}
	if(!$error == "")
	{
	?>
	<table cellpadding="4" cellspacing="4" border="0" align="center" width="600">
	<tr><td align="center" colspan="2"><div class="heading">Error</div></td></tr>
	<tr><td colspan="2" align="center"><br><?php echo $error ?></td></tr>
	<tr><td colspan="2" align="center"><br><a href="rankings_control.php?orderedby=<?php echo $orderedby ?>">RETURN</a></td></tr>
	</table>
	<br><br>
	<?php
	include "../footer.php";
	exit;
	}
$title = mysql_real_escape_string($title);
$description = mysql_real_escape_string($description);

	$q = "update rankings_sites set title=\"$title\",description=\"$description\",bannerurl=\"$bannerurl\",buttonurl=\"$buttonurl\",url=\"$url\",voteforthissite=\"$voteforthissite\",added=\"$added\",dateadded=NOW(),votingcodeadded=\"$votingcodeadded\",approved=\"$approved\" where id=\"$saveid\"";
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
	<tr><td align="center" colspan="2"><div class="heading">The Top Site Was Saved!</div></td></tr>
	<?php
	if ($oldurl != $url)
	{
	?>
	<tr><td colspan="2" align="center"><br>IMPORTANT! Since you changed the site's URL, make sure the member has re-added the vote code to their new URL: <a href="<?php echo $url ?>" target="_blank"><?php echo $url ?></a>.</td></tr>
	<form name="rankingcodeform">
	<tr><td colspan="2" align="center"><br>
	<textarea rows="3" cols="60" name="rankingcode"><center><a href="<?php echo $clickurl ?>"><img src="<?php echo $domain ?>/images/voteformysite.jpg" border="0" alt="<?php echo $sitename ?>"></a></center></textarea><br><br><a href="javascript: HighlightAll('rankingcodeform.rankingcode')">select all code</a></form>
	</td></tr>
	<?php
	}
	?>
	<tr><td colspan="2" align="center"><br><a href="rankings_control.php?orderedby=<?php echo $orderedby ?>">RETURN</a></td></tr>
	</table>
	<br><br>
	<?php
	include "../footer.php";
	exit;
} # if ($action == "save")
##############################################################################################
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
<table cellpadding="4" cellspacing="4" border="0" align="center" width="600">
<tr><td align="center" colspan="2"><div class="heading">Top Ranked Sites</div></td></tr>
<?php
if ($show != "")
{
?>
<tr><td align="center" colspan="2"><br><?php echo $show ?></td></tr>
<?php
}

?>

<tr><td align="center" colspan="2"><br><img src="<?php echo $domain ?>/images/voteformysite.jpg" border="0" alt="<?php echo $sitename ?>"></td></tr>
<tr><td align="center" colspan="2"></td></tr>

<?php
$userq = "select * from members where verified=\"yes\" order by userid";
$userr = mysql_query($userq);
$userrows = mysql_num_rows($userr);
if ($userrows > 0)
{
?>
<tr><td align="center" colspan="2"><br>
<form action="rankings_control.php" method="post">
<table width="800" border="0" cellpadding="2" cellspacing="2" class="sabrinatable" align="center">
<tr class="sabrinatrlight"><td align="center" colspan="2">ADD NEW TOP SITE</td></tr>
<tr class="sabrinatrdark"><td colspan="2">IMPORTANT! Before any site will appear on the <a href="<?php echo $domain ?>" target="_blank">Top Site Rankings</a> page, the member needs to verify it by adding the vote code to their site. Approve sites for entry on the Top Sites page once you see they have indeed added the code to their URL (which should be the same URL they submit).</td></tr>
<tr class="sabrinatrlight"><td>UserID:</td><td>
<select name="newuserid">
<?php
	while ($userrowz = mysql_fetch_array($userr))
	{
	$newuserid = $userrowz["userid"];
	?>
	<option value="<?php echo $newuserid ?>"><?php echo $newuserid ?></option>
	<?php
	}
?>
</select>
</td></tr>
<tr class="sabrinatrlight"><td>Website URL:</td><td><input type="text" name="newurl" size="100" maxlength="500"></td></tr>
<tr class="sabrinatrlight"><td>Website Title (max 50 characters):</td><td><input type="text" name="newtitle" size="100" maxlength="50"></td></tr>
<tr class="sabrinatrlight"><td>Website Description (max 300 characters):</td><td><input type="text" name="newdescription" size="100" maxlength="300"></td></tr>
<tr class="sabrinatrlight"><td>Your 468x60 Banner Image URL (jpg, gif, or png):</td><td><input type="text" name="newbannerurl" size="100" maxlength="500"></td></tr>
<tr class="sabrinatrlight"><td>Your 125x125 Button Image URL (jpg, gif, or png):</td><td><input type="text" name="newbuttonurl" size="100" maxlength="500"></td></tr>
<tr class="sabrinatrlight"><td>Enabled:</td><td><select name="newvoteforthissite"><option value="yes">YES</option><option value="no">NO</option></select></td></tr>
<tr class="sabrinatrdark"><td colspan="2" align="center">
<input type="hidden" name="action" value="add">
<input type="button" name="preview" value="PREVIEW BANNER" style="width:150px;" onclick="previewad(newbannerurl.value, newurl.value, 'banner')">&nbsp;&nbsp;<input type="button" name="preview" value="PREVIEW BUTTON" style="width:150px;" onclick="previewad(newbuttonurl.value, newurl.value, 'button')">&nbsp;&nbsp;<input type="submit" value="ADD" style="width:150px;"></form>
</td></tr>
</table>
</td></tr>

<tr><td align="center" colspan="2"></td></tr>
<?php
} # if ($userrows > 0)
?>

<tr><td align="center" colspan="2"><br>
<table width="800" border="0" cellpadding="2" cellspacing="2" class="sabrinatable" align="center">
<tr class="sabrinatrlight"><td align="center" colspan="2">TOP SITES</td></tr>
<tr class="sabrinatrdark"><td colspan="2">IMPORTANT! If you change a site's URL, before it will appear on the <a href="<?php echo $domain ?>" target="_blank">Top Site Rankings</a> page again, approve the website after making sure the member has re-added the vote code to the new URL.</td></tr>
<?php
$q = "select * from rankings_sites order by $orderedbyq";
$r = mysql_query($q);
$rows = mysql_num_rows($r);
if ($rows < 1)
{
?>
<tr class="sabrinatrlight"><td align="center" colspan="2">There are no Top Sites in the system yet.</td></tr>
<?php
}
if ($rows > 0)
{
################################################################
$pagesize = 50;
	$page = (empty($_GET['p']) || !isset($_GET['p']) || !is_numeric($_GET['p'])) ? 1 : $_GET['p'];
	$s = ($page-1) * $pagesize;
	$queryexclude1 = $q ." LIMIT $s, $pagesize";
	$resultexclude=mysql_query($queryexclude1);
	$numrows = @mysql_num_rows($resultexclude);
	if($numrows == 0){
		$queryexclude1 = $q ." LIMIT $pagesize";
		$resultexclude=mysql_query($queryexclude1);
	}
	$count = 0;
	$pagetext = "<center>Total Top Sites: <b>" . $rows . "</b>";

	if($rows > $pagesize){ // show the page bar
		$pagetext .= "<br>";
		$pagecount = ceil($rows/$pagesize);
		$pagetext .= "<div class='pagination'> ";
		if($page>1){ //show previoust link
			$pagetext .= "<a href='?p=".($page-1)."&orderedby=$orderedbyq' title='previous page'>previous</a>";
		}
		for($i=1;$i<=$pagecount;$i++){
			if($page == $i){
				$pagetext .= "<span class='current'>".$i."</span>";
			}else{
				$pagetext .= "<a href='?p=".$i."&orderedby=$orderedbyq'>".$i."</a>";
			}
		}
		if($page<$pagecount){ //show previoust link
			$pagetext .= "<a href='?p=".($page+1)."&orderedby=$orderedbyq' title='next page'>next</a>";
		}			
		$pagetext .= " </div>";
	}
################################################################
?>
<tr class="sabrinatrlight"><td align="center" colspan="2"><div style="width:800px;overflow:auto;"><?php echo $pagetext ?></div></td></tr>

<tr class="sabrinatrlight"><td align="center" colspan="2">
<table cellpadding="0" cellspacing="1" border="0" align="center" class="sabrinatable" width="800">
<?php
while ($rowz = mysql_fetch_array($resultexclude))
	{
	$id = $rowz["id"];
	$userid = $rowz["userid"];
	$url = $rowz["url"];
	$title = $rowz["title"];
	$title = stripslashes($title);
	$title = str_replace('\\', '', $title);
	$description = $rowz["description"];
	$description = stripslashes($description);
	$description = str_replace('\\', '', $description);
	$bannerurl = $rowz["bannerurl"];
	$buttonurl = $rowz["buttonurl"];
	$added = $rowz["added"];
	$dateadded = $rowz["dateadded"];
	if (($dateadded == 0) or ($dateadded == "") or ($dateadded == "0000-00-00 00:00:00"))
		{
		$showdateadded = "N/A";
		}
	else
		{
		$showdateadded = formatDate($dateadded);
		}
	$votingcodeadded = $rowz["votingcodeadded"];
	$approved = $rowz["approved"];
	$clicks = $rowz["clicks"];
	$hits = $rowz["hits"];
	$votes = $rowz["votes"];
	$voteforthissite = $rowz["voteforthissite"];
	if ($approved == "yes")
	{
		$bgapproved = "#99cc99";
	}
	if ($approved != "yes")
	{
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
	if (($approved != "yes") or ($voteforthissite != "yes"))
	{
		$bgstatus = "#ff9999";
	}
	else
	{
		$bgstatus = "#99cc99";
	}
	$clickurl = $domain . "/index.php?action=vote&v=" . $id;
?>
<tr class="sabrinatrdark"><td align="center" style="font-size:10px;">Status</td><td align="center" style="font-size:10px;">ID</td><td align="center" style="font-size:10px;">UserID</td><td align="center" style="font-size:10px;">Enabled</td><td align="center" style="font-size:10px;">Votes</td><td align="center" style="font-size:10px;">Added</td><td align="center" style="font-size:10px;">Date Added</td><td align="center" style="font-size:10px;">Approved</td><td align="center" style="font-size:10px;">URL</td><td align="center" style="font-size:10px;">Title</td><td align="center" style="font-size:10px;">Description</td><td align="center" style="font-size:10px;">Banner</td><td align="center" style="font-size:10px;">Banner URL</td><td align="center" style="font-size:10px;">Button</td><td align="center" style="font-size:10px;">Button URL</td><td align="center" style="font-size:10px;">Clicks</td><td align="center" style="font-size:10px;">Hits</td><td align="center" style="font-size:10px;">Vote Code</td><td align="center" style="font-size:10px;">Vote Code Added to Site</td><td align="center" style="font-size:10px;">Save</td><td align="center" style="font-size:10px;">Delete</td></tr>
<form action="rankings_control.php" method="post" name="saveform<?php echo $id ?>">
<tr class="sabrinatrlight">
<td align="center" style="background:<?php echo $bgstatus ?>;"></td>
<td align="center" style="font-size:10px;"><?php echo $id ?></td>
<td align="center" style="font-size:10px;"><?php echo $userid ?></td>
<td align="center" style="background:<?php echo $bgvoteforthissite ?>;"><select name="voteforthissite" style="font-size:10px;"><option value="yes" <?php if ($voteforthissite == "yes") { echo "selected"; } ?>>YES</option><option value="no" <?php if ($voteforthissite != "yes") { echo "selected"; } ?>>NO</option></select></td>
<td align="center" style="font-size:10px;"><?php echo $votes ?></td>
<td align="center"><select name="added" style="font-size:10px;"><option value="yes" <?php if ($added == "yes") { echo "selected"; } ?>>YES</option><option value="no" <?php if ($added != "yes") { echo "selected"; } ?>>NO</option></select></td>
<td align="center" style="font-size:10px;"><?php echo $showdateadded ?></td>
<td align="center" style="background:<?php echo $bgapproved ?>;"><select name="approved" style="font-size:10px;"><option value="yes" <?php if ($approved == "yes") { echo "selected"; } ?>>YES</option><option value="no" <?php if ($approved != "yes") { echo "selected"; } ?>>NO</option></select></td>
<td align="center"><input type="text" name="url" size="25" maxlength="500" value="<?php echo $url ?>" style="font-size:10px;"></td>
<td align="center"><input type="text" name="title" size="25" maxlength="50" value="<?php echo $title ?>" style="font-size:10px;"></td>
<td align="center"><input type="text" name="description" size="25" maxlength="300" value="<?php echo $description ?>" style="font-size:10px;"></td>
<td align="center"><a href="<?php echo $url ?>" target="_blank"><img src="<?php echo $bannerurl ?>" border="0" width="200" height="26"></td>
<td align="center"><input type="text" name="bannerurl" size="25" maxlength="500" value="<?php echo $bannerurl ?>" style="font-size:10px;"></td>
<td align="center"><a href="<?php echo $url ?>" target="_blank"><img src="<?php echo $buttonurl ?>" border="0" width="26" height="26"></td>
<td align="center"><input type="text" name="buttonurl" size="25" maxlength="500" value="<?php echo $buttonurl ?>" style="font-size:10px;"></td>
<td align="center" style="font-size:10px;"><?php echo $clicks ?></td>
<td align="center" style="font-size:10px;"><?php echo $hits ?></td>
<td align="center"><textarea rows="2" cols="40" name="rankingcode<?php echo $id ?>" style="font-size:10px;"><center><a href="<?php echo $clickurl ?>"><img src="<?php echo $domain ?>/images/voteformysite.jpg" border="0" alt="<?php echo $sitename ?>"></a></center></textarea><br><a href="javascript: HighlightAll('saveform<?php echo $id ?>.rankingcode<?php echo $id ?>')" style="font-size:10px;">select all code</a></td>
<td align="center"><select name="votingcodeadded" style="font-size:10px;"><option value="yes" <?php if ($votingcodeadded == "yes") { echo "selected"; } ?>>YES</option><option value="no" <?php if ($votingcodeadded != "yes") { echo "selected"; } ?>>NO</option></select></td>
<td align="center">
<input type="hidden" name="saveid" value="<?php echo $id ?>">
<input type="hidden" name="action" value="save">
<input type="hidden" name="oldurl" value="<?php echo $url ?>">
<input type="submit" value="SAVE" style="font-size:10px;">
</form>
</td>
<form action="rankings_control.php" method="post">
<td align="center">
<input type="hidden" name="deleteid" value="<?php echo $id ?>">
<input type="hidden" name="action" value="delete">
<input type="submit" value="DELETE" style="font-size:10px;">
</form>
</td>
</tr>
<?php

	} # while ($rowz = mysql_fetch_array($resultexclude))
?>
</table></td></tr>

<tr class="sabrinatrdark"><td align="center" colspan="2"><div style="width:800px;overflow:auto;"><?php echo $pagetext ?></div></td></tr>
<?php
} # if ($rows > 0)
?>
</table><br><br>
</td></tr>
</table>
<br><br>
<?php
include "../footer.php";
exit;
?>