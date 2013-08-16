<?php
require_once("php/page.class.php");
try{
 $saleday=$_GET["saleday"];
 if(! $saleday) $saleday=date("Y-m-d");
 if(! ISDATE($saleday)) throw new exception("日付を確認してください");

// $lincode=$_GET["lincode"];
// if($lincode && ! is_numeric($lincode)) throw new exception("カテゴリー番号を確認してください");

 $db=new page();
 $db->saletype=3;
 $db->saleday=$saleday;
 $db->me=basename($_SERVER["PHP_SELF"]);

 //フレームをセット($db->htmlにhtmlが生成)
 $db->pageFram();
 $db->datasetSaleSpan();
 //ヘッダーをセット
 $db->part=$db->pageHeader();
 $db->appendhtml("header");

 //leftsideに関連ページ表示
 $db->pageBrothBanner();

 //leftsideにバックナンバーを表示
 $db->pageTirasiDayListLeftSide();

 //商品リスト表示
 $db->salestart=$saleday;
 $db->saleend=$saleday;
 $db->me="mailitem.php";
 $db->pageTanpinList();

 //メールのご紹介
 $db->part=$db->htmlclr();
 $db->appendhtml("main");
 $val=<<<EOF
メール会員様特別価格!当店が発行するメールマガジン会員様限定のサービスです。
当店から配信されるメール画面をレジ係員にご提示ください。対象商品を上記価格にて販売させていただきます。

EOF;
 $db->part=$db->htmlcreatediv("class","mail",$val);
 $db->appendhtml("main");
 
 echo $db->html;
}//try
catch(Exception $e){
 echo "エラー:".$e->getMessage();
}//catch

?>
