<?php
include "db.php";
include "header.php";
$referid = $_REQUEST["referid"];
if ($referid == "")
{
	if ($adminmemberuserid != "")
	{
	$referid = $adminmemberuserid;
	}
	if ($adminmemberuserid == "")
	{
	$referid = "";
	}
}
###########
$visitor_ip = $_SERVER["REMOTE_ADDR"];
$today = date('Y-m-d',strtotime("now"));
$action = $_REQUEST["action"];
if ($action == "vote")
{
$v = $_GET["v"];
$q = "select * from rankings_sites where id=\"$v\"";
$r = mysql_query($q);
$rows = mysql_num_rows($r);
if ($rows < 1)
	{
	?>
	<center>
	<br><br>
	<table cellspacing="2" cellpadding="4" align="center" border="0">
	<tr><td align="center" colspan="2"><br><div class="heading">Site Not Found</div></td></tr>
	<tr><td align="center" colspan="2"><br><a href="index.php">Return to Top Ranked Sites</a></td></tr>
	</table>
	<br><br>&nbsp;
	<?php
	include "footer.php";
	exit;
	} # if ($rows < 1)
if ($rows > 0)
{
$url = mysql_result($r,0,"url");
$clickurl = "rankings_click.php?adid=" . $v;
$q2 = "update rankings_sites set clicks=clicks+1 where id=\"$v\"";
$r2 = mysql_query($q2);

$ipq = "select * from rankings_click_ips where visitorip=\"$visitor_ip\" and rankingsiteidclicked=\"$v\" and datelastclicked=\"$today\"";
$ipr = mysql_query($ipq);
$iprows = mysql_num_rows($ipr);
if ($iprows > 0)
	{
	?>
	<center>
	<br><br>
	<table cellspacing="2" cellpadding="4" align="center" border="0">
	<tr><td align="center" colspan="2"><br><div class="heading">Your Vote Was Already Recorded Today</div></td></tr>
	<tr><td align="center" colspan="2"><br>Please wait to be forwarded to this Top Site's page...</td></tr>
	<tr><td align="center" colspan="2"><br><a href="index.php">Return to Top Ranked Sites</a></td></tr>
	</table>
	<script type="text/javascript">
	function goTo()
	{
	window.top.location = "<?php echo $clickurl ?>";
	}
	setTimeout("goTo()", 2000);		
	</script>
	<br><br>&nbsp;
	<?php
	include "footer.php";
	exit;
	} # if ($iprows > 0)
} # if ($rows > 0)
?>
<center>
<br><br>
<table cellspacing="2" cellpadding="4" align="center" border="0">
<form action="index.php" method="get">
<tr><td align="center" colspan="2"><br><div class="heading">Are You Sure you want to Vote for <a href="<?php echo $url ?>" target="_blank"><?php echo $url ?></a></div></td></tr>
<tr><td align="right"><br><input type="hidden" name="bid" value="<?php echo $v ?>"><input type="hidden" name="burl" value="<?php echo $url ?>"><input type="hidden" name="action" value="confirmvote"><input type="submit" value="YES!!" style="width:100px;height:50px;"></form></td>
<td><br><input type="button" value="NO" onclick="window.location='index.php'" style="width:100px;height:50px;"></td>
</tr>
</table>
<br><br>&nbsp;
<?php
include "footer.php";
exit;
} # if ($action == "vote")
############################
if ($action == "confirmvote")
{
$bid = $_GET["bid"];
$burl = $_GET["burl"];

$ipq = "select * from rankings_click_ips where visitorip=\"$visitor_ip\" and rankingsiteidclicked=\"$bid\" and datelastclicked=\"$today\"";
$ipr = mysql_query($ipq);
$iprows = mysql_num_rows($ipr);
if ($iprows > 0)
	{
	?>
	<center>
	<br><br>
	<table cellspacing="2" cellpadding="4" align="center" border="0">
	<tr><td align="center" colspan="2"><br><div class="heading">Your Vote Was Already Recorded Today</div></td></tr>
	<tr><td align="center" colspan="2"><br><a href="index.php">Return to Top Ranked Sites</a></td></tr>
	</table>
	<br><br>&nbsp;
	<?php
	include "footer.php";
	exit;
	} # if ($iprows > 0)

$q = "update rankings_sites set votes=votes+1 where id=\"$bid\"";
$r = mysql_query($q);
$q2 = "insert into rankings_click_ips (visitorip,rankingsiteidclicked,datelastclicked) values (\"$visitor_ip\",\"$bid\",\"$today\")";
$r2 = mysql_query($q2);
?>
<tr><td align="center" colspan="2"><br><div class="heading">Your Vote Was Successful!</div></td></tr>
<tr><td align="center" colspan="2"><br><a href="index.php">Return to Top Ranked Sites</a></td></tr>
</table>
<br><br>&nbsp;
<?php
include "footer.php";
exit;
} # if ($action == "confirmvote")

$query1 = "select * from pages where name='Top Ranked Sites Home Page'";
$result1 = mysql_query($query1);
$line1 = mysql_fetch_array($result1);
$htmlcode = $line1["htmlcode"];
echo $htmlcode;
?>
<center>



<!-- DELETE BELOW -->
<script type="text/javascript">
function ajaxFunction(){
    var ajaxRequest;  // The variable that makes Ajax possible!
   
    try{
        // Opera 8.0+, Firefox, Safari
        ajaxRequest = new XMLHttpRequest();
    } catch (e){
        // Internet Explorer Browsers
        try{
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            try{
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e){
                // Something went wrong
                alert("Your browser broke!");
                return false;
            }
        }
    }
    // Create a function that will receive data sent from the server
    ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
            var ajaxDisplay = document.getElementById('ajaxDiv');
            ajaxDisplay.innerHTML = ajaxRequest.responseText;
        }
    }
    var order_domain_name = document.getElementById('order_domain_name').value;
    var order_domain_extension = document.getElementById('order_domain_extension').value;
   
    var queryString = "?order_domain_name=" + order_domain_name + "&order_domain_extension=" + order_domain_extension;
    ajaxRequest.open("GET", "script_domain_checker.php" + queryString, true);
    ajaxRequest.send(null);
}
</script>
<br>
<a href="http://demotopsites.phpsitescripts.com/admin" target="_blank"><img src="http://phpsitescripts.com/images/demo.png" border="0"></a>
<br><br><br>
Please check out our interactive DEMO of the Top Ranked Sites Script as an admin <a href="http://demotopsites.phpsitescripts.com/admin" target="_blank">HERE</a> (admin login details are already in the login form for you). <br><br>Examine our DEMO site as a member <a href="http://demotopsites.phpsitescripts.com/login.php" target="_blank">HERE</a> (demo member details are already in the login form)</b><br><br>
<div style="text-align:left;padding-left:100px;">SCRIPT REQUIREMENTS:<br>
<ul>
<li>Unix/Linux (CentOS most CPanel servers run is good)</li>
<li>PHP 5.2 or Greater Version</li>
<li>MySQL Database Support</li>
<li>Ioncube Loader</li>
<li>GD Library</li>
<li>cURL</li>
</ul>
</div>
<br><br>
<table cellpadding="10" cellspacing="2" border="0" align="center" width="600" style="border:2px dashed #f00;background:#fff;">
<tr><td colspan="2" align="center"><br><font size="6" color="ff0000">Buy This Top Ranked Sites Script Now For Only $99.00!</font></td</tr>
<form action="http://phpsitescripts.com/sales_order.php" method="post">
<tr><td align="right">Licence:</td><td>Single Site License for Top Ranked Sites Script</td></tr>
<tr><td align="right">URL of Premade Site you want to adopt:<br>(or leave blank)</td><td valign="top"><input type="text" name="order_premadesiteurl" size="50" maxlength="500"></td></tr>
<tr><td align="right">Register Domain for your site's License URL:<br>(or leave blank)</td><td style="width:350px;" valign="top"><input type="text" name="order_domain_name" id="order_domain_name" size="25" maxlength="500" style="font-size:12px;">
<select name="order_domain_extension" id="order_domain_extension" onchange="javascript:document.getElementById('ajaxDiv').innerHTML=''" style="font-size:12px;">
<option value="info">.info - FREE FOREVER!</option>
<option value="com">.com - 8.00/year</option>
<option value="us">.us - 8.00/year</option>
<option value="net">.net - 8.00/year</option>
<option value="biz">.biz - 8.00/year</option>
<option value="org">.org - 8.00/year</option>
<option value="me">.me - 8.00/year</option>
<option value="ws">.ws - 8.00/year</option>
<option value="co">.co - 8.00/year</option>
<option value="ca">.ca - 8.00/year</option>
</select>
<input type="button" value="Check Availability (may take a moment)" onclick="ajaxFunction()" style="font-size:12px;"><br><span id="ajaxDiv"></span>
<span id="domain_price"></span>
</td></tr>
<tr><td align="right">License Key URL:<br>(exact url where you will install the script. If registering a new domain, this should match the url in that field)</td><td valign="top"><input type="text" name="order_licenseurl" size="50" maxlength="500"></td></tr>

<tr><td align="right">Order Hosting for your Script:<br>(kindly allow time for setup after purchase)</td><td valign="top">
<select name="order_hosting" style="font-size:12px;width:322px;">
<option value="No Hosting Needed (zipped script or premade site only)">No Hosting Needed (zipped script or premade site only)</option>
<option value="Shared Hosting for ONE domain - adds 9.99/month to order">Shared Hosting for ONE domain - adds 9.99/month to order</option>
<option value="Dedicated VPS Hosting 4 GB RAM - adds 99.99/month to order">Dedicated VPS Hosting 4 GB RAM - adds 99.99/month to order</option>
</select>
</td></tr>

<tr><td align="right">UserID:</td><td><input type="text" name="userid" size="50" maxlength="255"></td></tr>
<tr><td align="right">Password:</td><td><input type="text" name="password" size="50" maxlength="255"></td></tr>
<tr><td align="right">First Name:</td><td><input type="text" name="firstname" size="50" maxlength="255"></td></tr>
<tr><td align="right">Last Name:</td><td><input type="text" name="lastname" size="50" maxlength="255"></td></tr>
<tr><td align="right">Email:</td><td><input type="text" name="email" size="50" maxlength="255"></td></tr>
<?php
$cq = "select * from countries order by country_id";
$cr = mysql_query($cq);
$crows = mysql_num_rows($cr);
if ($crows > 0)
{
?>
<tr><td align="right">Country:</td><td><select name="country" style="width:322px;" class="pickone">
<?php
	while ($crowz = mysql_fetch_array($cr))
	{
	$country_name = $crowz["country_name"];
?>
<option value="<?php echo $country_name ?>" <?php if ($country_name == "United States") { echo "selected"; } ?>><?php echo $country_name ?></option>
<?php
	}
?>
</select>
</td></tr>
<?php
}
?>
<tr><td align="right">Your Sponsor:</td><td><?php echo $referid ?></td></tr>
<tr><td colspan="2" align="center">
<input type="hidden" name="order_script" value="top_sites_ranking_v2.1">
<input type="hidden" name="referid" value="<?php echo $referid ?>">
<input type="image" src="http://phpsitescripts.com/images/btn.png" border="0" name="submit" alt="Order!">
</form><br>&nbsp;
</td></tr>
</table>

<br>
<font color="#ff0000" style="background:#ff0;">IMPORTANT:</font> After payment please allow us up to 24 hours to process your order. Please whitelist sabrina@phpsitescripts.com.
<!-- DELETE ABOVE -->



<br><br>
<table cellspacing="2" cellpadding="4" align="center" border="0" class="sabrinatable" width="1000">
<tr class="sabrinatrdark"><td align="center" colspan="4"><div class="heading">TOP RANKED SITES</div></td></tr>
<?php
$rankingpagesize = 20;
$query = "select * from rankings_sites where voteforthissite=\"yes\" and approved=\"yes\" order by votes desc, clicks desc";
$result = mysql_query($query);
$totalrows = mysql_num_rows($result);
if ($totalrows < 1)
{
?>
<tr class="sabrinatrlight"><td align="center" colspan="4">There are currently no sites in the system.</td></tr>
<?php
}
if ($totalrows > 0)
{
################################################################
	$page = (empty($_GET['p']) || !isset($_GET['p']) || !is_numeric($_GET['p'])) ? 1 : $_GET['p'];
	$s = ($page-1) * $rankingpagesize;
	$queryexclude1 = $query ." LIMIT $s, $rankingpagesize";
	$resultexclude=mysql_query($queryexclude1);
	$numrows = @mysql_num_rows($resultexclude);
	if($numrows == 0){
		$queryexclude1 = $query ." LIMIT $rankingpagesize";
		$resultexclude=mysql_query($queryexclude1);
	}
	$count = 0;
	$pagetext = "<b>Total Top Sites: " . $totalrows . "</b><br>";

	if($totalrows > $rankingpagesize){ // show the page bar
		$pagecount = ceil($totalrows/$rankingpagesize);
		$pagetext .= "<div class='pagination'> ";
		if($page>1){ //show previoust link
			$pagetext .= "<a href='?p=".($page-1)."' title='previous page'>previous</a>";
		}
		for($i=1;$i<=$pagecount;$i++){
			if($page == $i){
				$pagetext .= "<span class='current'>".$i."</span>";
			}else{
				$pagetext .= "<a href='?p=".$i."'>".$i."</a>";
			}
		}
		if($page<$pagecount){ //show previoust link
			$pagetext .= "<a href='?p=".($page+1)."' title='next page'>next</a>";
		}			
		$pagetext .= " </div>";
	}
################################################################
?>
<tr class="sabrinatrlight"><td align="center" colspan="4"><div style="width:800px;overflow:auto;"><?php echo $pagetext ?></div></td></tr>
<tr class="sabrinatrdark"><td align="center"><b>RANK</b></td><td align="center"><b>ABOUT MY SITE</b></td><td align="center"><b>MY BANNER</b></td><td align="center"><b>VOTES</b></td></tr>
<?php
$bg = 0;
$rank = 1;
while ($rankrowz = mysql_fetch_array($resultexclude))
	{
	$rankid = $rankrowz["id"];
	$banneruser = $rankrowz["userid"];
	$bannerurl = $rankrowz["bannerurl"];
	$url = $rankrowz["url"];
	$title = $rankrowz["title"];
	$title = stripslashes($title);
	$title = str_replace('\\', '', $title);
	$description = $rankrowz["description"];
	$description = stripslashes($description);
	$description = str_replace('\\', '', $description);
	$votes = $rankrowz["votes"];
	$clickurl = "rankings_click.php?adid=" . $rankid;
	$hitq = "update rankings_sites set hits=hits+1 where id=\"$rankid\"";
	$hitr = mysql_query($hitq);
		?>
		<tr class="sabrinatrlight"><td align="center"><div class="heading"><?php echo $rank ?></div></td>
		<td align="center">
		<div style="width: 300px; height: 20px; padding:4px; overflow:auto; border:2px solid #000000; background: #ffffff;"><a href="<?php echo $clickurl ?>" target="_blank"><?php echo $title ?></a></div>
		<div style="width: 300px; height: 100px; padding:4px; overflow:auto; border:2px solid #000000; background: #ffffff; border-top: 0px;"><?php echo $description ?></div>		
		</td>
		<td align="center"><a href="<?php echo $clickurl ?>" target="_blank"><img src="<?php echo $bannerurl ?>" border="0" alt="<?php echo $title ?>" width="468" height="60"></a></td>
		<td align="center"><font style="font-size:18px;font-weight:bold;"><?php echo $votes ?></font> <font style="font-size:18px;">votes<br><a href="index.php?action=vote&v=<?php echo $rankid ?>" style="font-size:16px;font-weight:bold;">Vote For Me Now!</a></td></tr> 
		<?php
	$rank = $rank+1;
	} # while ($rankrowz = mysql_fetch_array($result))
?>
</tr>
<?php
} # if ($totalrows > 0)
?>
<tr class="sabrinatrdark"><td align="center" colspan="4"><div style="width:800px;overflow:auto;"><?php echo $pagetext ?></div></td></tr>
</table>
<br><br>&nbsp;
<?php
include "footer.php";
?>