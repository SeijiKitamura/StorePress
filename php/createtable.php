<?php
require_once("db.class.php");
try{
 $db=new DB();
 $db->CreateTable();
}//try
catch(Exception $e){
 echo "エラー:".$e->getMessage();
}//catch
?>
