<?php
include_lan(e_PLUGIN."wowprogress/languages/".e_LANGUAGE.".php");

// -- [ PLUGIN INFO ]
$eplug_name        = "WoW Progression Menu";
$eplug_version     = "0.3";
$eplug_author      = "Patrick Weaver";
$eplug_url         = "http://painswitch.com/";
$eplug_email       = "patrickweaver@gmail.com";
$eplug_description = WPPLUGIN_LAN001;
$eplug_compatible  = "e107 0.7+";
$eplug_readme      = "";
$eplug_compliant   = TRUE;
$eplug_module      = FALSE;
$eplug_folder     = "wowprogress";
$eplug_menu_name  = "wowprogress_menu";
$eplug_conffile   = "admin_config.php";
$eplug_logo       = "";
$eplug_icon       = "";
$eplug_icon_small = "";
$eplug_caption    = WPPLUGIN_LAN002;

// -- [ DEFAULT PREFERENCES ]
$eplug_prefs = array(
	"wowprogress_manageclass" => "",
	"wowprogress_showninstances" => "",
	"wowprogress_killstyle" => "normal",
	"wowprogress_headerstyle" => "forumheader"
);

// -- [ MYSQL TABLES ]
$eplug_table_names = array("wowprogress_bosses", "wowprogress_instances");

$eplug_tables = array(
	"CREATE TABLE ".MPREFIX."wowprogress_bosses (
		id int(10) unsigned NOT NULL auto_increment,
		npcid int(10) unsigned NOT NULL,
		npctype varchar(250) NOT NULL,
		bossname varchar(250) NOT NULL,
		instance varchar(250) NOT NULL,
		status int(10) unsigned NOT NULL default '0',
		heroic int(10) unsigned NOT NULL,
		patch varchar(250) NOT NULL default 'null',
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

// -- [ MAIN SITE LINK ]
$eplug_link      = FALSE;
$eplug_link_name = "";
$eplug_link_url  = "";

// -- [ INSTALLED MESSAGE ]
$eplug_done = $eplug_name." ".WPPLUGIN_LAN003."<a href='".e_PLUGIN."wowprogress/datapack.php'>".WPPLUGIN_LAN004."</a>.";

// -- [ UPGRADE INFORMATION ]
$upgrade_add_prefs    = "";
$upgrade_remove_prefs = "";
$upgrade_alter_tables = array(
	"ALTER TABLE ".MPREFIX."wowprogress_bosses ADD patch varchar(250) NOT NULL default 'null';"
);
$eplug_upgrade_done   = $eplug_name." has been successfully upgraded.";

?>