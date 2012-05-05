<?php

if(!defined("e107_INIT")) {
	$eplug_admin = TRUE;
	require_once("../../class2.php");
}
if(!getperms("P")){ header("location:".e_BASE."index.php"); exit;}
require_once(e_ADMIN."auth.php");
include_lan(e_PLUGIN."wowprogress/languages/".e_LANGUAGE.".php");
require_once(e_PLUGIN."wowprogress/patches.php");

if(check_class($pref['wowprogress_manageclass'])){
	if(isset($_POST['update'])){
		extract($_POST);
		while (list($key, $id) = each($_POST['status']))
		{
			$tmp = explode(".", $id);
			$sql->db_Update("wowprogress_bosses", "status=".intval($tmp[0])." WHERE id=".intval($tmp[1]));
		}
		if(isset($_POST['heroic'])){
			extract($_POST);
			while (list($key2, $id2) = each($_POST['heroic']))
			{
				$tmp2 = explode(".", $id2);
				$sql->db_Update("wowprogress_bosses", "heroic=".intval($tmp2[0])." WHERE id=".intval($tmp2[1]));
			}
		}
		extract($_POST);
		while (list($key3, $id3) = each($_POST['patch']))
		{
			$tmp3 = explode("_", $id3);
			$sql->db_Update("wowprogress_bosses", "patch='".$tp->toDB($tmp3[1])."' WHERE id=".intval($tmp3[0]));
		}
		
		extract($_POST);
		while (list($key4, $id4) = each($_POST['hpatch']))
		{
			$tmp4 = explode("_", $id4);
			$sql->db_Update("wowprogress_bosses", "hpatch='".$tp->toDB($tmp4[1])."' WHERE id=".intval($tmp4[0]));
		}

		$message = WPMANAGE_LAN001;
	}
	if (isset($message)) {
		$ns->tablerender("", "<div style='text-align:center'><b>".$message."</b></div>");
	}

	$text = "<div style='text-align:center'>";
	
	$sql->db_Select("wowprogress_instances", "*", "ORDER BY id DESC", "no-where") or die(mysql_error());

	while($row = $sql->db_Fetch()){
		$text .= "<form method='post' name='instance' action='".e_SELF."'>
		<table style='width:75%' class='fborder'>
		<tr>
		<td colspan='".($row['heroic'] == "1" ? "5" : "3")."' class='fcaption' style='text-align:center;'><b><u>".$row['zonename']."</u></b></td>
		</tr>
		<tr>
		<td class='forumheader3' style='width:55%'><b>".WPMANAGE_LAN002."</b></td>
		<td class='forumheader3' style='text-align:center;'><b>".WPMANAGE_LAN003."</b></td>
		<td class='forumheader3' style='text-align:center;'><b>".WPMANAGE_LAN013."</b></td>
		".($row['heroic'] == "1" ? "<td class='forumheader3' style='text-align:center;'><b>".WPMANAGE_LAN004."</b></td>
		<td class='forumheader3' style='text-align:center;'><b>".WPMANAGE_LAN014."</b></td>" : "")."
		</tr>";

		$sql2->db_Select("wowprogress_bosses", "*", "instance='".$tp->toDB($row['zonename'])."'") or die(mysql_error());

		while($row2 = $sql2->db_Fetch()){
			$text .= "<tr>
			<td class='forumheader3'><a href='http://www.wowhead.com/".$row2['npctype']."=".$row2['npcid']."'>".$row2['bossname']."</a></td>
			<td class='forumheader3' style='text-align:center;'>
			<select name='status[]' class='tbox'>
			<option value='0.".$row2['id']."'".($row2['status'] == "0" ? " selected" : "").">".WPMANAGE_LAN005."</option>
			<option value='1.".$row2['id']."'".($row2['status'] == "1" ? " selected" : "").">".WPMANAGE_LAN006."</option>
			<option value='2.".$row2['id']."'".($row2['status'] == "2" ? " selected" : "").">".WPMANAGE_LAN007."</option>
			</select>
			</td>
			
			<td class='forumheader3' style='text-align:center;'>
			<select name='patch[]' class='tbox'>
			<option value='".$row2['id']."_null'".($tp->toHTML($row2['patch']) == "null" ? " selected='selected'" : "").">---</option>\n";
			foreach($patches as $key => $patch){
				$text .= "<option value='".$row2['id']."_".$patch."'".($tp->toHTML($row2['patch']) == $patch ? " selected='selected'" : "").">".$patch."</option>\n";
			}
			$text .= "
			</select>
			</td>";
			
			if($row['heroic'] == "1"){
				$text .= "<td class='forumheader3' style='text-align:center;'>
				<select name='heroic[]' class='tbox'>
				<option value='0.".$row2['id']."'".($row2['heroic'] == "0" ? " selected" : "").">".WPMANAGE_LAN005."</option>
				<option value='1.".$row2['id']."'".($row2['heroic'] == "1" ? " selected" : "").">".WPMANAGE_LAN006."</option>
				<option value='2.".$row2['id']."'".($row2['heroic'] == "2" ? " selected" : "").">".WPMANAGE_LAN007."</option>
				</select>
				</td>
				<td class='forumheader3' style='text-align:center;'>
				<select name='hpatch[]' class='tbox'>
				<option value='".$row2['id']."_null'".($tp->toHTML($row2['hpatch']) == "null" ? " selected='selected'" : "").">---</option>\n";
				foreach($patches as $key => $patch){
					$text .= "<option value='".$row2['id']."_".$patch."'".($tp->toHTML($row2['hpatch']) == $patch ? " selected='selected'" : "").">".$patch."</option>\n";
				}
				$text .= "
				</select>
				</td>";
			}
			
			$text .= "</tr>";
		}

		$text .= "
		<tr>
		<td colspan='".($row['heroic'] == "1" ? "5" : "3")."' class='fcaption' style='text-align:center;'>
		<input type='submit' class='button' name='update[]' value=\"".WPMANAGE_LAN008.$row['zonename']."\">
		<input type='reset' class='button' value='".WPMANAGE_LAN009."'>
		</td>
		</tr></table>
		</form>
		<br /><br />";

	}

	$text .= "</div>";

	$ns->tablerender(WPMANAGE_LAN010, $text);
}else{
	$ns->tablerender(WPMANAGE_LAN011, WPMANAGE_LAN012);
}
require_once(e_ADMIN."footer.php");
?>