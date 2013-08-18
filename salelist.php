<?php
require_once("php/page.class.php");
try{
 $saleday=$_GET["saleday"];
 if(! $saleday) $saleday=date("Y-m-d");
 if(! ISDATE($saleday)) throw new exception("日付を確認してください");

// $lincode=$_GET["lincode"];
// if($lincode && ! is_numeric($lincode)) throw new exception("カテゴリー番号を確認してください");

 $db=new page();
 $db->saletype=4;
 $db->saleday=$saleday;
 $db->me=basename($_SERVER["PHP_SELF"]);

 //フレームをセット($db->htmlにhtmlが生成)
 $db->pageFram();

 //販売期間をゲット
 $db->datasetSaleSpan();

 //ヘッダーをセット
 $db->part=$db->pageHeader();
 $db->appendhtml("header");

 //leftsideに関連ページ表示
 $db->pageBrothBanner();

 //leftsideにバックナンバーを表示
 $db->pageTirasiDayListLeftSide();

 //商品リスト表示
 $db->me="saleitem.php";
 $db->pageTanpinList();

 //HTML表示
 echo $db->html;
}//try
catch(Exception $e){
 echo "エラー:".$e->getMessage();
}//catch

?>
