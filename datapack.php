<?php

if(!defined("e107_INIT")) {
	require_once("../../class2.php");
}

// data pack version, format is ddmmyyyy
// number represents the date an instance or boss was added NOT when code is updated
$dpversion = "10232010";

// instance format is: "instance name" => array(zone id, has heroic)
$instances = array(
	"Icecrown Citadel" => array(4812, 1),
	"The Ruby Sanctum" => array(4987, 1)
);

// boss format is: "boss name" => array("type", id, "instance name");
// type accepts: npc, object, item
$bosses = array(
	"Lord Marrowgar" => array("npc", 36612, "Icecrown Citadel"),
	"Lady Deathwhisper" => array("npc", 36855, "Icecrown Citadel"),
	"Gunship Battle" => array("object", 201873, "Icecrown Citadel"),
	"Deathbringer Saurfang" => array("npc", 37813, "Icecrown Citadel"),
	"Festergut" => array("npc", 36626, "Icecrown Citadel"),
	"Rotface" => array("npc", 36627, "Icecrown Citadel"),
	"Professor Putricide" => array("npc", 36678, "Icecrown Citadel"),
	"Blood Prince Council" => array("npc", 37970, "Icecrown Citadel"),
	"Blood-Queen Lana'thel" => array("npc", 37955, "Icecrown Citadel"),
	"Valithria Dreamwalker" => array("npc", 36789, "Icecrown Citadel"),
	"Sindragosa" => array("npc", 36853, "Icecrown Citadel"),
	"The Lich King" => array("npc", 36597, "Icecrown Citadel"),

	"Baltharus the Warborn" => array("npc", 39751, "The Ruby Sanctum"),
	"General Zarithrian" => array("npc", 39746, "The Ruby Sanctum"),
	"Saviana Ragefire" => array("npc", 39747, "The Ruby Sanctum"),
	"Halion" => array("npc", 39863, "The Ruby Sanctum")
);


// add the instances
foreach($instances as $instance => $info){
	// if the instance isn't already in the database...
	if($sql->db_Count("wowprogress_instances", "(*)", "WHERE zonename='".$instance."'") == 0){
		// ... add it
		$sql->db_Insert("wowprogress_instances", "'', '".$info[0]."', '".$instance."', '".$info[1]."'");
	}
}

// add the bosses
foreach($bosses as $boss => $info){
	// if the boss isn't already in the database...
	if($sql->db_Count("wowprogress_bosses", "(*)", "WHERE bossname='".$boss."'") == 0){
		// ... add it
		$sql->db_Insert("wowprogress_bosses", "'', '".$info[1]."', '".$info[0]."', '".$boss."', '".$info[2]."', '0'");
	}
}

?>