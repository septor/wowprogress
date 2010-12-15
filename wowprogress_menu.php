<?php

if (!defined('e107_INIT')) { exit; }

define("WOWPROG", e_PLUGIN."wowprogress/");

$text = "We have cleared the following:<br /><br />";

$sql->db_Select("wowprogress_instances", "*") or die(mysql_error());

$sql3 = new db();
$sql4 = new db();

while($row = $sql->db_Fetch()){
	$showinstances = explode(" ", $pref['wowprogress_showinstances']);
	if(in_array($row['id'], $showinstances)){
		$bosses = $sql3->db_Count("wowprogress_bosses", "(*)", "WHERE instance='".addslashes($row['zonename'])."'");
		$nkilled = $sql3->db_Count("wowprogress_bosses", "(*)", "WHERE instance='".addslashes($row['zonename'])."' AND status='2'");
		$hkilled = $sql3->db_Count("wowprogress_bosses", "(*)", "WHERE instance='".addslashes($row['zonename'])."' AND heroic='2'");

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
		<td style='text-align:center;'><img src='".WOWPROG."images/normal.gif' title='Normal Mode' /></td>
		".($row['heroic'] == "1" ? "<td style='text-align:center;'><img src='".WOWPROG."images/heroic.gif' title='Heroic Mode' /></td>" : "")."
		</tr>";

		$sql4->db_Select("wowprogress_bosses", "*", "instance='".addslashes($row['zonename'])."'") or die(mysql_error());
		

		while($row2 = $sql4->db_Fetch()){
			if($row2['status'] == "0"){
				$status = "<img src='".WOWPROG."images/notkilled.png' title='Not Killed' />";
			}else if($row2['status'] == "1"){
				$status = "<img src='".WOWPROG."images/attempting.png' title='Attempting' />";
			}else if($row2['status'] == "2"){
				$status = "<img src='".WOWPROG."images/killed.png' title='Killed' />";
			}

			if($row2['heroic'] == "0"){
				$heroic = "<img src='".WOWPROG."images/notkilled.png' title='Not Killed' />";
			}else if($row2['heroic'] == "1"){
				$heroic = "<img src='".WOWPROG."images/attempting.png' title='Attempting' />";
			}else if($row2['heroic'] == "2"){
				$heroic = "<img src='".WOWPROG."images/killed.png' title='Killed' />";
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

$ns->tablerender("Raid Progress", $text);

?>