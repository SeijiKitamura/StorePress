<?php
require_once("php/import.class.php");

try{
 $db=new ImportData();

 $db->setJanMas();
 $db->setClsMas();
 $db->setLinMas();
 $db->setSaleItems();
 $db->setPageConf();
 $db->setStore();
 echo "success";
}
catch(Exception $e){
 echo "エラー：".$e->getMessage();
}

?>
