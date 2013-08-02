<?php
require_once("php/parts.class.php");
try{
 $db=new parts();
 $db->getheader("tirasitop.php");


 $db->getbanner("information.php");
 $db->appendhtml("leftside");

 $db->getbanner("service.php");
 $db->appendhtml("leftside");

 //$db->getbanner("other.php");
 //$db->appendhtml("leftside");

 $db->getbanner("tirasitop.php");
 $db->appendhtml("main");
 
 $db->creatediv("class","clr");
 $db->appendhtml("main");

echo $db->html;

}//try
catch(Exception $e){
 echo "エラー:".$e->getMessage();
}//catch
?>
