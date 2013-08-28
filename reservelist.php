<?php
require_once("php/page.class.php");
try{
 $saleday=$_GET["saleday"];
 if(! $saleday) $saleday=date("Y-m-d");
 if(! ISDATE($saleday)) throw new exception("日付を確認してください");

//$lincode=$_GET["lincode"];
//if($lincode && ! is_numeric($lincode)) throw new exception("カテゴリー番号を確認してください");

 $db=new page();
 $db->saletype=2;
 $db->saleday=$saleday;
 $db->me=basename($_SERVER["PHP_SELF"]);

 //フレームをセット($db->htmlにhtmlが生成)
 $db->pageFram();

 //ヘッダーをセット
 $db->part=$db->pageHeader();
 $db->appendhtml("header");

 //leftsideに関連ページ表示
 $db->pageBrothBanner();

 //商品リスト表示
 if($db->datasetSaleSpan()){
  $db->me="reserveitem.php";
  $db->pageTanpinList();
 }
 
 echo $db->html;
 echo "<pre>";
 print_r($db->items);

}//try
catch(Exception $e){
 echo "エラー:".$e->getMessage();
}//catch

?>
