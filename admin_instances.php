<?php
/*
+ ----------------------------------------------------------------------------+
|     e107 website system
|
|     ©Steve Dunstan 2001-2002
|     http://e107.org
|     jalist@e107.org
|
|     Released under the terms and conditions of the
|     GNU General Public License (http://gnu.org).
+----------------------------------------------------------------------------+
*/
if(!defined("e107_INIT")) {
	require_once("../../class2.php");
}
if(!getperms("P")){ header("location:".e_BASE."index.php"); exit;}
require_once(e_ADMIN."auth.php");

$text = "
<div style='text-align:center'>
<table style='width:75%' class='fborder'>
<tr>
	<td>Instance Name</td>
	<td>ID</td>
	<td>Has Heroic</td>
	<td>&nbsp;</td>
</tr>";

sql->db_Select("wowprogress_instances", "*");

while($row = $sql->db_Fetch()){
	$text .= "<tr>
	<td>".$row['zonename']."</td>
	<td>".$row['zoneid']."</td>
	<td>".($row['heroic'] == 1 ? "Yes" : "No")."</td>
	<td><a href='#'><img src='".e_PLUGIN."wowprogress/images/edit.png' style='border:0;' /></a> - <a href='#'><img src='".e_PLUGIN."wowprogress/images/delete.png' style='border:0;' /></a></td>
	</tr>";
}

$text .= "</table>
</div>
";

$ns->tablerender("Manage Instances", $text);
require_once(e_ADMIN."footer.php");
?>
