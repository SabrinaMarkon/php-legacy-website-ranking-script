<?php
include "db.php";
$adid = $_GET["adid"];
$url = $siteurl;
$q = "select * from rankings_sites where id=\"$adid\"";
$r = mysql_query($q);
$rows = mysql_num_rows($r);
if ($rows > 0)
{
$url = mysql_result($r,0,"url");
$q2 = "update rankings_sites set clicks=clicks+1 where id=\"$adid\"";
$r2 = mysql_query($q2);
}
@header("Location: " . $url);
?>
