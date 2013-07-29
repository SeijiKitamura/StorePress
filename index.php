<?php
require_once("php/parts.class.php");
try{
 $db=new parts();
 $db->getheader("index.php");

 $db->getbanner("tirasitop.php");
 $db->appendhtml("leftside");

 $db->getbanner("information.php");
 $db->appendhtml("leftside");

 $db->getbanner("service.php");
 $db->appendhtml("leftside");

 //$db->getbanner("other.php");
 //$db->appendhtml("leftside");

 $db->getbanner("index.php");
 $db->appendhtml("main");
 
 $db->creatediv("class","clr");
 $db->appendhtml("main");

 echo $db->html;

}
catch(Exception $e){
 echo "エラー:".$e->getMessage();
}
?>
