<?php
require_once("php/page.class.php");
try{
 $saleday=$_GET["saleday"];
 if(! $saleday) $saleday=date("Y-m-d");
 if(! ISDATE($saleday)) throw new exception("日付を確認してください");

 $lincode=$_GET["lincode"];
 if(! is_numeric($lincode)) throw new exception("部門コードを確認してください");

 $jcode=$_GET["jcode"];
 if(! CHKCD($jcode)) throw new exception("JANコードを確認してください");

 $db=new page();
 $db->me=basename($_SERVER["PHP_SELF"]);
 $db->saletype=3;
 $db->saleday=$saleday;
 $db->lincode=$lincode;
 $db->jcode=$jcode;

 //フレームをセット
 $db->pageFram();
 
 //ヘッダーをセット
 $db->part=$db->pageHeader();
 $db->appendhtml("header");

 //セール期間が有効なら
 if($db->datasetSaleSpan()){
  //leftside
  $db->me="maillist.php";
  $db->pageTirasiDayListLeftSide();

  //単品データゲット
  $db->pageTanpin();

  //メールのご紹介
  $db->part=$db->htmlclr();
  $db->appendhtml("main");
  $val=<<<EOF
メール会員様特別価格!当店が発行するメールマガジン会員様限定のサービスです。
当店から配信されるメール画面をレジ係員にご提示ください。対象商品を上記価格にて販売させていただきます。

EOF;
  $db->part=$db->htmlcreatediv("class","mail",$val);
  $db->appendhtml("main");
 
  //その他の単品を表示
  $db->me="mailitem.php";
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
