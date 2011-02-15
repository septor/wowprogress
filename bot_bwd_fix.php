<?php

if(!defined("e107_INIT")) {
	require_once("../../class2.php");
}


$sql->db_Update("wowprogress_instances", "heroic='1' WHERE zonename='Blackwing Descent'");
$sql->db_Update("wowprogress_instances", "heroic='1' WHERE zonename='The Bastion of Twilight'");


echo "Blackwing Descent and The Bastion of Twilight have now been updated to support heroic mode. <b>You should now remove this file!</b>";

?>