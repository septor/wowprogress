<?php

if(!defined("e107_INIT")) {
	$eplug_admin = TRUE;
	require_once("../../class2.php");
}
if(!getperms("P")){ header("location:".e_BASE."index.php"); exit;}
require_once(e_ADMIN."auth.php");

if(check_class($pref['wowprogress_manageclass'])){
	if(isset($_POST['update'])){
		extract($_POST);
		while (list($key, $id) = each($_POST['status']))
		{
			$tmp = explode(".", $id);
			$sql->db_Update("wowprogress_bosses", "status=".$tmp[0]." WHERE id=".$tmp[1]);
		}
		if(isset($_POST['heroic'])){
			extract($_POST);
			while (list($key2, $id2) = each($_POST['heroic']))
			{
				$tmp2 = explode(".", $id2);
				$sql->db_Update("wowprogress_bosses", "heroic=".$tmp2[0]." WHERE id=".$tmp2[1]);
			}
		}
		$message = "Updated progression statuses successfully!";
	}
	if (isset($message)) {
		$ns->tablerender("", "<div style='text-align:center'><b>".$message."</b></div>");
	}

	$text = "<div style='text-align:center'>";

	$sql->db_Select("wowprogress_instances", "*") or die(mysql_error());

	while($row = $sql->db_Fetch()){

		$text .= "<form method='post' name='instance' action='".e_SELF."'>
		<table style='width:75%' class='fborder'>
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
			<td class='forumheader3'>
			<select name='status[]' class='tbox'>
			<option value='0.".$row2['id']."'".($row2['status'] == "0" ? " selected" : "").">Not Killed</option>
			<option value='1.".$row2['id']."'".($row2['status'] == "1" ? " selected" : "").">Attempting</option>
			<option value='2.".$row2['id']."'".($row2['status'] == "2" ? " selected" : "").">Killed</option>
			</select>
			</td>
			".($row['heroic'] == "1" ? "<td class='forumheader3'>
			<select name='heroic[]' class='tbox'>
			<option value='0.".$row2['id']."'".($row2['heroic'] == "0" ? " selected" : "").">Not Killed</option>
			<option value='1.".$row2['id']."'".($row2['heroic'] == "1" ? " selected" : "").">Attempting</option>
			<option value='2.".$row2['id']."'".($row2['heroic'] == "2" ? " selected" : "").">Killed</option>
			</select>
			</td>" : "")."
			</tr>";
		}

		$text .= "
		<tr>
		<td colspan='".($row['heroic'] == "1" ? "3" : "2")."' class='fcaption' style='text-align:center;'>
		<input type='submit' class='button' name='update[]' value=\"Update ".$row['zonename']."\">
		<input type='reset' class='button' value='Reset'>
		</td>
		</tr></table>
		</form>
		<br /><br />";

	}

	$text .= "</div>";

	$ns->tablerender("Manage Progression", $text);
}else{
	$ns->tablerender("Error!", "You aren't able to manage progression. Speak to your guild master!");
}
require_once(e_ADMIN."footer.php");
?>