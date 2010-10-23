<?php

$menutitle  = "WoW Progress Navigation";

$butname[]  = "Configuration";
$butlink[]  = "admin_config.php";
$butid[]    = "config";

$butname[]  = "Add Bosses";
$butlink[]  = "admin_bosses.php";
$butid[]    = "bosses";

$butname[]  = "Add Instances";
$butlink[]  = "admin_instances.php";
$butid[]    = "instances"; 

global $pageid;
for ($i=0; $i<count($butname); $i++) {
	$var[$butid[$i]]['text'] = $butname[$i];
	$var[$butid[$i]]['link'] = $butlink[$i];
};

show_admin_menu($menutitle, $pageid, $var);

?>
