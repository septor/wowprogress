<?php

if(!defined("e107_INIT")) {
	$eplug_admin = TRUE;
	require_once("../../class2.php");
}
if(!getperms("P")){ header("location:".e_BASE."index.php"); exit;}
require_once(e_ADMIN."auth.php");

$text = "<div style='text-align:center'>
<table style='width:75%' class='fborder'>
<tr>
<td class='fcaption'>Boss Name</td>
<td class='fcaption'>Instance</td>
<td class='fcaption'>Normal Status</td>
<td class='fcaption'>Heroic Status</td>
</tr>";

$sql->db_Select("wowprogress_bosses", "*") or die(mysql_error());

while($row = $sql->db_Fetch()){
	$text .= "<tr>
	<td class='forumheader3'><a href='http://www.wowhead.com/".$row['npctype']."=".$row['npcid']."'>".$row['bossname']."</a></td>
	<td class='forumheader3'>".$row['instance']."</td>
	<td class='forumheader3'>".$row['status']."</td>
	<td class='forumheader3'>".$row['heroic']."</td>
	</td>";
}

$text .= "</table>";

$ns->tablerender("Manage Progression", $text);
require_once(e_ADMIN."footer.php");
?>