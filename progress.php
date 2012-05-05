<?php

require_once("../../class2.php");
require_once(HEADERF);
include_lan(e_PLUGIN."wowprogress/languages/".e_LANGUAGE.".php");
define("WOWPROG", e_PLUGIN."wowprogress/");

$sql3 = new db();
$tick_image = (file_exists(THEME."images/wowprogress/tick.png") ? THEME."images/wowprogress/tick.png" : WOWPROG."images/tick.png");
$cross_image = (file_exists(THEME."images/wowprogress/cross.png") ? THEME."images/wowprogress/cross.png" : WOWPROG."images/cross.png");

$sql->db_Select("wowprogress_instances", "*", "ORDER BY id DESC", "no-where") or die(mysql_error());

$text = "<div align='center'>";

while($row = $sql->db_Fetch()){
	$bosses = $sql2->db_Count("wowprogress_bosses", "(*)", "WHERE instance='".$row['zonename']."'");
	$nkilled = $sql2->db_Count("wowprogress_bosses", "(*)", "WHERE instance='".$row['zonename']."' AND status='2'");
	$hkilled = $sql2->db_Count("wowprogress_bosses", "(*)", "WHERE instance='".$row['zonename']."' AND heroic='2'");
	
	$text .= "<table style='width:95%' class='fborder'>
	<tr>
	<td class='fcaption' style='width:58%'>".$row['zonename']."</td>
	<td class='fcaption' style='text-align:center; width:14%'>".WPPROG_LAN001."</td>
	<td class='fcaption' style='text-align:center; width:14%'>".WPPROG_LAN002."</td>
	</tr>";
	
	$sql3->db_Select("wowprogress_bosses", "*", "instance='".$row['zonename']."'") or die(mysql_error());
	
	while($row2 = $sql3->db_Fetch()){
		$npatch = ($row2['patch'] == "null" ? "&nbsp;" : "<br /><small>(<a title='".WPPROG_LAN003."'>".$row2['patch']."</a>)</small>");
		$hpatch = ($row2['hpatch'] == "null" ? "&nbsp;" : "<br /><small>(<a title='".WPPROG_LAN003."'>".$row2['hpatch']."</a>)</small>");
		$text .= "<tr>
		<td class='forumheader2'><a href='http://www.wowhead.com/".$row2['npctype']."=".$row2['npcid']."'>".$row2['bossname']."</a></td>
		<td class='forumheader2' style='text-align:center;'>".($row2['status'] == "2" ? "<img src='".$tick_image."' />".$npatch : "<img src='".$cross_image."' />")."</td>
		<td class='forumheader2' style='text-align:center;'>".($row2['heroic'] == "2" ? "<img src='".$tick_image."' />".$hpatch : "<img src='".$cross_image."' />")."</td>
		</tr>";
	}
	
	$text .= "</table>
	<table style='width:95%' class='fborder'>
	<tr>
	<td style='width:58%'>&nbsp;</td>
	<td class='fcaption' style='text-align:center; width:14%'>".$nkilled."/".$bosses."</td>
	<td class='fcaption' style='text-align:center; width:14%'>".$hkilled."/".$bosses."</td>
	</tr>
	</table>
	<br />";
}

$text .= "</div>";

$ns->tablerender(WPPROG_LAN004, $text);
	
require_once(FOOTERF);
?>