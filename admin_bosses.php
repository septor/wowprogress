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
	<td>Boss Name</td>
	<td>ID</td>
	<td>Instance</td>
	<td>&nbsp;</td>
</tr>";

sql->db_Select("wowprogress_bosses", "*");

while($row = $sql->db_Fetch()){
	$text .= "<tr>
	<td>".$row['bossname']."</td>
	<td>".$row['npcid']."</td>
	<td>".$row['instance']."</td>
	<td><a href='#'>Edit</a> - <a href='#'>Delete</a></td>
	</tr>";
}

$text .= "</table>
</div>
";

$ns->tablerender("Manage Bosses", $text);
require_once(e_ADMIN."footer.php");
?>
