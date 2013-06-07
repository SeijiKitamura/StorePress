<?php
require_once("import.class.php");
try{
 //インスタンス生成
 $db=new ImportData();
 WriteLog("商品マスタ更新");

  //データ更新
 $db->setJanMas();

 //ログ書き込み
 WriteLog(ITEMS,$db->items["data"]);

}//try
catch(Exception $e){
 WriteLog($e->getMessage());
}//catch
?>
