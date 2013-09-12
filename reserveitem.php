<?php
require_once("php/page.class.php");
try{
 $saleday=$_GET["saleday"];
 if(! $saleday) $saleday=date("Y-m-d");
 if(! ISDATE($saleday)) throw new exception("日付を確認してください");

 $jcode=$_GET["jcode"];
 if(! CHKCD($jcode)) throw new exception("JANコードを確認してください");

 $db=new page();
 $db->me=basename($_SERVER["PHP_SELF"]);
 $db->saletype=2;
 $db->saleday=$saleday;
 $db->jcode=$jcode;

 //フレームをセット
 $db->pageFram();
 
 //ヘッダーをセット
 $db->part=$db->pageHeader();
 $db->appendhtml("header");

 //セール期間が有効なら
 if($db->datasetSaleSpan()){

  //単品データゲット
  $db->pageTanpin();

 
  //その他の単品を表示
  $db->me="reserveitem.php";
  $db->lincode=null;
  $db->jcode=null;
  $db->pageTanpinList();

 }
 
 //画像変更を追加(jQuery)
 $db->part=$db->htmlImageChange();
 $db->appendhtml("head");
  
 echo $db->html;

}//try
catch(Exception $e){
 echo "エラー:".$e->getMessage();
}
?>