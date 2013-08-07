<?php
require_once("php/page.class.php");
try{
 $saleday=$_GET["saleday"];
 if(! $saleday) $saleday=date("Y-m-d");
 if(! ISDATE($saleday)) throw new exception("日付を確認してください");

 $lincode=$_GET["lincode"];
 if($lincode && ! is_numeric($lincode)) throw new exception("カテゴリー番号を確認してください");

 $db=new page();
 $db->saleday=$saleday;
 //$db->saleday="2013-08-04";
 $db->lincode=$lincode;
 $db->me=basename($_SERVER["PHP_SELF"]);
 //フレームをセット
 $db->pageFram();
 
 //ヘッダーをセット
 $db->part=$db->pageHeader();
 $db->appendhtml("header");

 //チラシ日程をセット(leftside)
 $db->pageBrothBanner();
 $db->pageTirasiDayListLeftSide();
 $db->pageTirasiLinListLeftSide();

 //
 $db->pageTanpinList();
 echo $db->html;

}//try
catch(Exception $e){
 echo "エラー:".$e->getMessage();
}//catch

?>
