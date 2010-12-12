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
require_once(e_HANDLER."userclass_class.php");
if(!getperms("P")){ header("location:".e_BASE."index.php"); exit;}
require_once(e_ADMIN."auth.php");

	
if (isset($_POST['updatesettings'])) {
	$si = $_POST['showinstances'];
	$instances = "";
	if(!empty($si)){
		$n = count($si);
		for($i=0; $i < $n; $i++){
			$instances .= $si[$i]." ";
		}
	}
	$pref['wowprogress_showinstances'] = $instances;
	$pref['wowprogress_manageclass'] = $_POST['wowprogress_manageclass'];
	save_prefs();
	$message = "Settings saved successfully!";
}

if (isset($message)) {
	$ns->tablerender("", "<div style='text-align:center'><b>".$message."</b></div>");
}

$text = "
<div style='text-align:center'>
<form method='post' action='".e_SELF."'>
<table style='width:75%' class='fborder'>
<tr>
<td style='width:50%' class='forumheader3'>Who can manage the boss kills?</td>
<td style='width:50%; text-align:right' class='forumheader3'>
".r_userclass('wowprogress_manageclass', $pref['wowprogress_manageclass'], 'off', 'nobody,member,admin,classes')."
</td>
</tr>
<tr>
<td style='width:50%' class='forumheader3'>Which instances do you want displayed on the menu item?</td>
<td style='width:50%; text-align:right' class='forumheader3'>";

$sql->db_Select("wowprogress_instances", "*") or die(mysql_error());

while($row = $sql->db_Fetch()){
	$showinstances = explode(" ", $pref['wowprogress_showinstances']);
	if(in_array($row['id'], $showinstances)){
		$text .= $row['zonename']." <input type='checkbox' name='showinstances[]' value='".$row['id']."' checked /><br />";
	}else{
		$text .= $row['zonename']." <input type='checkbox' name='showinstances[]' value='".$row['id']."' /><br />";
	}
}

$text .= "</td>
</tr>
<tr>
<td colspan='2' style='text-align:center' class='forumheader'>
<input class='button' type='submit' name='updatesettings' value='Save Settings' />
</td>
</tr>
</table>
</form>
</div>
";

$ns->tablerender("Configure WoW Progression Menu", $text);
require_once(e_ADMIN."footer.php");
?>
