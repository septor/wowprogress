<?php

if(!defined("e107_INIT")) {
	$eplug_admin = TRUE;
	require_once("../../class2.php");
}
if(!getperms("P")){ header("location:".e_BASE."index.php"); exit;}
require_once(e_ADMIN."auth.php");

if(file_exists(e_PLUGIN."wowprogress/dataz.xml")){
	$dp = simplexml_load_file(e_PLUGIN."wowprogress/dataz.xml");

	// add the dataz!
	$iAdded = 0;
	$bAdded = 0;
	foreach($dp->instance as $instance){
		// if the instance isn't already in the database...
		if($sql->db_Count("wowprogress_instances", "(*)", "WHERE zonename='".addslashes($instance['name'])."'") == 0){
			// ... add it
			$sql->db_Insert("wowprogress_instances", "'', '".$instance['id']."', '".addslashes($instance['name'])."', '".$instance['heroic']."'") or die(mysql_error());
			$iAdded++;
		}

		// now the bosses!
		foreach($instance->boss as $boss){
			// if the boss isn't already in the database...
			if($sql->db_Count("wowprogress_bosses", "(*)", "WHERE bossname='".addslashes($boss['name'])."'") == 0){
				$heroic_status = ($instance['heroic'] == "1" ? "0" : "");
				$sql->db_Insert("wowprogress_bosses", "'', '".$boss['id']."', '".$boss['type']."', '".addslashes($boss['name'])."', '".addslashes($instance['name'])."', '0', '".$heroic_status."'") or die(mysql_error());
				$bAdded++;
			}
		}

	}

	$text = "<div style='text-align:center;'>
	You have successfully added ".$iAdded." instance(s) and ".$bAdded." boss(es) to your database.<br /><br />
	<a href='".e_PLUGIN."wowprogress/manage.php'>Click here</a> manage the newly added data.
	</div>";

	$ns->tablerender("WoW Progress Datapack v".$dp->version, $text);

	unset($iAdded, $bAdded);

}else{

	$ns->tablerender("WoW Progress Datapack NOT FOUND!", "You don't appear to have a dataz.xml file in your possesion. Please grab the latest copy <a href='https://github.com/septor/wowprogress/raw/master/dataz.xml'>here</a> and re-run this script!");

}
require_once(e_ADMIN."footer.php");

?>