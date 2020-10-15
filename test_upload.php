<?php require_once 'autoload.php';

$db = new db();
echo $db->get(102030, 'owner_id');


?>