<?php

//PLUGIN INFO------------------------------------------------------------------------------------------------+

$eplug_name        = "WoW Progression Menu";
$eplug_version     = "ALPHA2";
$eplug_author      = "Patrick Weaver";
$eplug_url         = "http://painswitch.com/";
$eplug_email       = "patrickweaver@gmail.com";
$eplug_description = "World of Warcraft Boss Progression Menu";
$eplug_compatible  = "e107 0.7+";
$eplug_readme      = "";
$eplug_compliant   = TRUE;
$eplug_module      = FALSE;

//PLUGIN FOLDER----------------------------------------------------------------------------------------------+

$eplug_folder     = "wowprogress";

//PLUGIN MENU FILE-------------------------------------------------------------------------------------------+

$eplug_menu_name  = "wowprogress_menu";

//PLUGIN ADMIN AREA FILE-------------------------------------------------------------------------------------+

$eplug_conffile   = "admin_config.php";

//PLUGIN ICONS AND CAPTION-----------------------------------------------------------------------------------+

$eplug_logo       = "";
$eplug_icon       = "";
$eplug_icon_small = "";
$eplug_caption    = "Configure WoW Progression Menu";

//DEFAULT PREFERENCES----------------------------------------------------------------------------------------+

$eplug_prefs = array(
	"wowprogress_manageclass" => "",
	"wowprogress_showninstances" => "",
	"wowprogrss_killstyle" => "normal",
	"wowprogress_headerstyle" => "forumheader"
);

//MYSQL TABLES TO BE CREATED---------------------------------------------------------------------------------+

$eplug_table_names = array("wowprogress_bosses", "wowprogress_instances");

//MYSQL TABLE STRUCTURE--------------------------------------------------------------------------------------+

$eplug_tables = array(
	"CREATE TABLE ".MPREFIX."wowprogress_bosses (
		id int(10) unsigned NOT NULL auto_increment,
		npcid int(10) unsigned NOT NULL,
		npctype varchar(250) NOT NULL,
		bossname varchar(250) NOT NULL,
		instance varchar(250) NOT NULL,
		status int(10) unsigned NOT NULL default '0',
		heroic int(10) unsigned NOT NULL,
		PRIMARY KEY  (id)
	) TYPE=MyISAM AUTO_INCREMENT=1;",

	"CREATE TABLE ".MPREFIX."wowprogress_instances (
		id int(10) unsigned NOT NULL auto_increment,
		zoneid int(10) unsigned NOT NULL,
		zonename varchar(250) NOT NULL,
		heroic int(10) unsigned NOT NULL default '0',
		PRIMARY KEY  (id)
	) TYPE=MyISAM AUTO_INCREMENT=1;"
);

//LINK TO BE CREATED ON SITE MENU--------------------------------------------------------------------------+

$eplug_link      = FALSE;
$eplug_link_name = "";
$eplug_link_url  = "";

//MESSAGE WHEN PLUGIN IS INSTALLED-------------------------------------------------------------------------+

$eplug_done = $eplug_name." has been sucessfully installed! If you wish to install the bosses and instances pack <a href='".e_PLUGIN."wowprogress/datapack.php'>click here</a>.";

//SAME AS ABOVE BUT ONLY RUN WHEN CHOOSING UPGRADE---------------------------------------------------------+

$upgrade_add_prefs    = $eplug_prefs;
$upgrade_remove_prefs = "";
$upgrade_alter_tables = "";
$eplug_upgrade_done   = "";

//---------------------------------------------------------------------------------------------------------+

?>