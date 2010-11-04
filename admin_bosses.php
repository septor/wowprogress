<?php
if(!defined("e107_INIT")) {
	require_once("../../class2.php");
}
if(!getperms("P")){ header("location:".e_BASE."index.php"); exit;}
require_once(e_ADMIN."auth.php");

if(isset($_POST['editboss'])){
	$sql->db_Update("wowprogress_instances", "npcid='".$_POST['npcid']."', npctype='".$_POST['npctype']."', bossname='".$_POST['bossname']."', instance='".$_POST['instance']."' WHERE id='".$_POST['id']."'");

	header("location: ".e_PLUGIN."wowprogress/admin_bosses.php");
}

if(isset($_GET['edit'])){
	
	$sql->db_Select("wowprogress_bosses", "*", "WHERE id='".$_GET['edit']."'") or die(mysql_error());
	$row = $sql->db_Fetch()

	$etext = "<div style='text-align:center'>
	<form method='post' action='".e_SELF."'>
	<table style='width:75%' class='fborder'>
	<tr>
	<td>Boss Name:</td>
	<td><input type='text' name='bossname' class='tbox' value='".$row['bossname']."'></td>
	</tr>
	<tr>
	<td>NPC Type:</td>
	<td><input type='text' name='npctype' class='tbox' value='".$row['npctype']."'></td>
	</tr>
	<tr>
	<td>NPC ID:</td>
	<td><input type='text' name='npcid' class='tbox' value='".$row['npcid']."'></td>
	</tr>
	<tr>
	<td>Instance:</td>
	<td><input type='text' name='instance' class='tbox' value='".$row['instance']."'></td>
	</tr>
	<tr>
	<td colspan='2'>
	<input type='hidden' name='id' value='".$row['id']."'>
	<input type='submit' name='editboss' class='button' value='Save Changes'>
	</td>
	</tr>
	</table>
	</form>
	</div>";

	$ns->tablerender("Editing ".$row['bossname'], $etext);

}else if(isset($_GET['del'])){
	if(is_numeric($_GET['del'])){
		$sql->db_Delete("wowprogress_bosses", "id='".$_GET['del']."'");
	}
}

$text = "
<div style='text-align:center'>
<table style='width:75%' class='fborder'>
<tr>
	<td>Boss Name</td>
	<td>Type</td>
	<td>ID</td>
	<td>Instance</td>
	<td>&nbsp;</td>
</tr>";

sql->db_Select("wowprogress_bosses", "*");

while($row = $sql->db_Fetch()){
	$text .= "<tr>
	<td>".$row['bossname']."</td>
	<td>".$row['npctype']."</td>
	<td>".$row['npcid']."</td>
	<td>".$row['instance']."</td>
	<td><a href='?edit=".$row['id']."'><img src='".e_PLUGIN."wowprogress/images/edit.png' style='border:0;' /></a> - <a href='?del=".$row['id']."' onclick=\"return confirm('Are you sure you want to remove this boss?');\"><img src='".e_PLUGIN."wowprogress/images/delete.png' style='border:0;' /></a></td>
	</tr>";
}

$text .= "</table>
</div>
";

$ns->tablerender("Manage Bosses", $text);
require_once(e_ADMIN."footer.php");
?>