<?php

if (!defined('e107_INIT')) { exit; }

include_lan(e_PLUGIN."wowprogress/languages/".e_LANGUAGE.".php");
define("WOWPROG", e_PLUGIN."wowprogress/");

$text = WPMENU_LAN001."<br /><br />";

$sql->db_Select("wowprogress_instances", "*") or die(mysql_error());

$heroic_image = (file_exists(THEME."images/heroic.gif") ? THEME."images/heroic.gif" : WOWPROG."images/heroic.gif");
$normal_image = (file_exists(THEME."images/normal.gif") ? THEME."images/normal.gif" : WOWPROG."images/normal.gif");

$notkilled_image = (file_exists(THEME."images/notkilled.png") ? THEME."images/notkilled.png" : WOWPROG."images/notkilled.png");
$killed_image = (file_exists(THEME."images/killed.png") ? THEME."images/killed.png" : WOWPROG."images/killed.png");
$attempting_image = (file_exists(THEME."images/attempting.png") ? THEME."images/attempting.png" : WOWPROG."images/attempting.png");

$sql3 = new db();
$sql4 = new db();

while($row = $sql->db_Fetch()){
	$showinstances = explode(" ", $pref['wowprogress_showinstances']);
	if(in_array($row['id'], $showinstances)){
		$bosses = $sql3->db_Count("wowprogress_bosses", "(*)", "WHERE instance='".$tp->toDB($row['zonename'])."'");
		$nkilled = $sql3->db_Count("wowprogress_bosses", "(*)", "WHERE instance='".$tp->toDB($row['zonename'])."' AND status='2'");
		$hkilled = $sql3->db_Count("wowprogress_bosses", "(*)", "WHERE instance='".$tp->toDB($row['zonename'])."' AND heroic='2'");

		if($pref['wowprogress_killstyle'] == "total"){
			if($row['heroic'] == "1"){
				$killstyle = "(".($nkilled + $hkilled)."/".($bosses * 2).") ";
			}else{
				$killstyle = "(".$nkilled."/".$bosses.") ";
			}
		}else if($pref['wowprogress_killstyle'] == "normal"){
			$killstyle = "(".$nkilled."/".$bosses.") ";
		}else if($pref['wowprogress_killstyle'] == "heroic"){
			$killstyle = "(".$hkilled."/".$bosses.") ";
		}else{
			$killstyle = "";
		}

		$text .= "<div onclick='expandit(\"".$row['zoneid']."\");' class='".$pref['wowprogress_headerstyle']."' style='cursor: pointer;'>
		".$killstyle.$row['zonename']."
		</div>
		
		<table style='width:90%; display:none;' id='".$row['zoneid']."'>
		<tr>
		<td style='width: 70%;'>&nbsp;</td>
		<td style='text-align:center;'><img src='".$normal_image."' title='".WPMENU_LAN002."' /></td>
		".($row['heroic'] == "1" ? "<td style='text-align:center;'><img src='".$heroic_image."' title='".WPMENU_LAN003."' /></td>" : "")."
		</tr>";

		$sql4->db_Select("wowprogress_bosses", "*", "instance='".$tp->toDB($row['zonename'])."'") or die(mysql_error());
		

		while($row2 = $sql4->db_Fetch()){
			if($row2['status'] == "0"){
				$status = "<img src='".$notkilled_image."' title='".WPMENU_LAN004."' />";
			}else if($row2['status'] == "1"){
				$status = "<img src='".$attempting_image."' title='".WPMENU_LAN005."' />";
			}else if($row2['status'] == "2"){
				$status = "<img src='".$killed_image."' title='".WPMENU_LAN006."' />";
			}

			if($row2['heroic'] == "0"){
				$heroic = "<img src='".$notkilled_image."' title='".WPMENU_LAN004."' />";
			}else if($row2['heroic'] == "1"){
				$heroic = "<img src='".$attempting_image."' title='".WPMENU_LAN005."' />";
			}else if($row2['heroic'] == "2"){
				$heroic = "<img src='".$killed_image."' title='".WPMENU_LAN006."' />";
			}

			$text .= "<tr>
			<td style='width: 70%;'><a href='http://www.wowhead.com/".$row2['npctype']."=".$row2['npcid']."'>".$row2['bossname']."</a></td>
			<td style='text-align:center;'>".$status."</td>
			".($row['heroic'] == "1" ? "<td style='text-align:center;'>".$heroic."</td>" : "")."
			</tr>";

		}

		$text .= "<tr>
		<td style='width: 70%;'>&nbsp;</td>
		<td style='text-align:center;'>(".$nkilled."/".$bosses.")</td>
		".($row['heroic'] == "1" ? "<td style='text-align:center;'>(".$hkilled."/".$bosses.")</td>" : "")."
		</tr>
		</table>";
	}
	
}

$ns->tablerender(WPMENU_LAN007, $text);

?>