<?php
if(!defined("e107_INIT")) {
	require_once("../../class2.php");
}
if(!getperms("P")){ header("location:".e_BASE."index.php"); exit;}
require_once(e_ADMIN."auth.php");


if(isset($_POST['editinstance'])){
	$sql->db_Update("wowprogress_instances", "zoneid='".$_POST['zoneid']."', zonename='".$_POST['zonename']."', heroic='".$_POST['heroic']."' WHERE id='".$_POST['id']."'");
	header("location: ".e_PLUGIN."wowprogress/admin_instances.php");
}

if(isset($_GET['edit'])){
	
	$sql->db_Select("wowprogress_instances", "*", "WHERE id='".$_GET['edit']."'") or die(mysql_error());
	$row = $sql->db_Fetch()

	$etext = "<div style='text-align:center'>
	<form method='post' action='".e_SELF."'>
	<table style='width:75%' class='fborder'>
	<tr>
	<td>Instance Name:</td>
	<td><input type='text' name='zonename' class='tbox' value='".$row['zonename']."'></td>
	</tr>
	<tr>
	<td>Instance ID:</td>
	<td><input type='text' name='zoneid' class='tbox' value='".$row['zoneid']."'></td>
	</tr>
	<tr>
	<td>Has heroic mode:</td>
	<td>
	<select name='heroic' class='tbox'>
	".($row['heroic'] == 0 ? "<option value='0' selected>No</option>\n" : "<option value='0'>No</option>\n")."
	".($row['heroic'] == 1 ? "<option value='1' selected>Yes</option>\n" : "<option value='1'>Yes</option>\n")."
	</select>
	</td>
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

	$ns->tablerender("Editing ".$row['zonename'], $etext);

}else if(isset($_GET['del'])){
	if(is_numeric($_GET['del'])){
		$sql->db_Delete("wowprogress_instances", "id='".$_GET['del']."'");
	}
}

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
	<td><a href='?edit=".$row['id']."'><img src='".e_PLUGIN."wowprogress/images/edit.png' style='border:0;' /></a> - <a href='?del=".$row['id']."' onclick=\"return confirm('Are you sure you want to remove this instance?');\"><img src='".e_PLUGIN."wowprogress/images/delete.png' style='border:0;' /></a></td>
	</tr>";
}

$text .= "</table>
</div>
";

$ns->tablerender("Manage Instances", $text);
require_once(e_ADMIN."footer.php");
?>