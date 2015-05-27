<?php
include "control.php";
include "header.php";
if ($_POST["newlogin"])
{
$newloginq = "update members set lastlogin=NOW() where userid=\"$userid\"";
$newloginr = mysql_query($newloginq);
}
?>
<table cellpadding="4" cellspacing="4" border="0" align="center" width="100%">
<tr><td align="center" colspan="2"><div class="heading">Welcome <?php echo $firstname ?></div></td></tr>
<tr><td align="center" colspan="2" style="height: 15px;"></td></tr>
<tr><td align="center" colspan="2">
<?php
$q = "select * from pages where name='Members Area Main Page'";
$r = mysql_query($q);
$rowz = mysql_fetch_array($r);
$htmlcode = $rowz["htmlcode"];
echo $htmlcode;
?>
</td></tr>

</table>
<br><br>
<?php
include "footer.php";
exit;
?>