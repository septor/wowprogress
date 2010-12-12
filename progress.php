<?php

if(!defined("e107_INIT")) {
	$eplug_admin = TRUE;
	require_once("../../class2.php");
}
if(!getperms("P")){ header("location:".e_BASE."index.php"); exit;}
require_once(e_ADMIN."auth.php");

$text = "<div style='text-align:center'>";

$sql->db_Select("wowprogress_instances", "*") or die(mysql_error());

while($row = $sql->db_Fetch()){

	$text .= "<table style='width:75%' class='fborder'>
	<tr>
	<td colspan='".($row['heroic'] == "1" ? "3" : "2")."' class='fcaption' style='text-align:center;'><b><u>".$row['zonename']."</u></b></td>
	</tr>
	<tr>
	<td class='forumheader3' style='width:70%'><b>Boss Name</b></td>
	<td class='forumheader3'><b>Normal Status</b></td>
	".($row['heroic'] == "1" ? "<td class='forumheader3'><b>Heroic Status</b></td>" : "")."
	</tr>";

	$sql2->db_Select("wowprogress_bosses", "*", "instance='".addslashes($row['zonename'])."'") or die(mysql_error());

	while($row2 = $sql2->db_Fetch()){
		$text .= "<tr>
		<td class='forumheader3'><a href='http://www.wowhead.com/".$row2['npctype']."=".$row2['npcid']."'>".$row2['bossname']."</a></td>
		<td class='forumheader3'>".$row2['status']."</td>
		".($row['heroic'] == "1" ? "<td class='forumheader3'>".$row2['heroic']."</td>" : "")."
		</tr>";
	}

	$text .= "</table>
	<br />";

}

$text .= "</div>";

$ns->tablerender("Manage Progression", $text);
require_once(e_ADMIN."footer.php");
?>