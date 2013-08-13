<?php
require_once("php/page.class.php");
try{
 $saleday=$_GET["saleday"];
 if(! $saleday) $saleday=date("Y-m-d");
 if(! ISDATE($saleday)) throw new exception("日付を確認してください.createtirasi.php");

 $db=new page();

 $db->me="tirasitanpin.php";

 //セールタイプセット
 $db->saletype=1;

 //作成するチラシの日付をセット
 $db->saleday=$saleday;
 if(! $db->datasetSaleSpan()) throw new exception("該当日のチラシデータがありません");

 $db->saleday=null;
 $db->datasetTanpinListData();

 //商品リスト分だけ繰り返す
 foreach($db->items as $rows=>$row){
  $db->saleday=$row["salestart"];
  $db->jcode=$row["jcode"];
  $db->pageCreateTanpin();

  //URL変更(tirasidaylist全商品)
  $pattern ="/(tirasidaylist)(\.php)(\?saleday=)([0-9\-]+)/";
  $replace ="$1_".$db->flg0."_$4.html";
  $db->html=preg_replace($pattern,$replace,$db->html);

  //URL変更(tirasidaylistライン別)
  $pattern ="/(tirasidaylist_".$db->flg0."_".$row["salestart"].")(\.html)(&lincode=)([0-9]+)/";
  $replace ="$1_$4$2";
  $db->html=preg_replace($pattern,$replace,$db->html);
 
  $url= "html/tirasitanpin_".$db->flg0."_";
  $url.=$row["salestart"]."_";
  $url.=$row["jcode"].".html";
  if(! file_put_contents($url,$db->html)) throw new exception("書き込みエラー");
  echo $url."<br />";
  
 }//foreach

 //日別全商品ページを作成
 $db->lincode=null;
 $db->jcode=null;

 //日付リストをゲット
 $db->datasetDayListData();
 $daylist=$db->items;

 foreach($daylist as $rows=>$row){
  $db->me="tirasidaylist.php";
  $db->saleday=$row["saleday"];

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
  $db->me="tirasitanpin.php";
  $db->pageTanpinList();

  //URL変更(tirasidaylist全商品)
  $pattern ="/(tirasidaylist)(\.php)(\?saleday=)([0-9\-]+)/";
  $replace ="$1_".$db->flg0."_$4.html";
  $db->html=preg_replace($pattern,$replace,$db->html);
  
  //URL変更(tirasidaylistライン別)
  $pattern ="/(tirasidaylist_".$db->flg0."_".$row["saleday"].")(\.html)(&lincode=)([0-9]+)/";
  $replace ="$1_$4$2";
  $db->html=preg_replace($pattern,$replace,$db->html);

//URL変更(tirasitanpin用)
  $pattern ="/(tirasitanpin)(\.php)(\?saleday=)([0-9\-]+)";
  $pattern.="(&jcode=)([0-9]+)/";
  $replace ="$1_".$db->flg0."_$4_$6.html";
  $db->html=preg_replace($pattern,$replace,$db->html);

  //ファイル保存
  $url= "html/tirasidaylist_".$db->flg0."_".$row["saleday"].".html";
  if(! file_put_contents($url,$db->html)) throw new exception("書き込みエラー");
  echo $url."<br/>";
  
 }//foreach


 //ライン別ページ作成
 foreach($daylist as $rows=>$row){
  //日程をセット
  $db->saleday=$row["saleday"];

  //lincodeリストを作成
  $db->datasetLinGroup();
  $lingroup=$db->items;

  foreach($lingroup as $rows2=>$row2){
   $db->me="tirasidaylist.php";
   $db->lincode=$row2["lincode"];

   //フレームをセット
   $db->pageFram();
   
   //ヘッダーをセット
   $db->part=$db->pageHeader();
   $db->appendhtml("header");
  
   //チラシ日程をセット(leftside)
   $db->pageBrothBanner();
   $db->pageTirasiDayListLeftSide();
   $db->pageTirasiLinListLeftSide();
  
   //商品リストをセット
   $db->me="tirasitanpin.php";
   $db->pageTanpinList();

   //URL変更(tirasidaylist全商品)
   $pattern ="/(tirasidaylist)(\.php)(\?saleday=)([0-9\-]+)/";
   $replace ="$1_".$db->flg0."_$4.html";
   $db->html=preg_replace($pattern,$replace,$db->html);
   
   //URL変更(tirasidaylistライン別)
   $pattern ="/(tirasidaylist_".$db->flg0."_".$row["saleday"].")(\.html)(&lincode=)([0-9]+)/";
   $replace ="$1_$4$2";
   $db->html=preg_replace($pattern,$replace,$db->html);
 
   //URL変更(tirasitanpin用)
   $pattern ="/(tirasitanpin)(\.php)(\?saleday=)([0-9\-]+)";
   $pattern.="(&jcode=)([0-9]+)/";
   $replace ="$1_".$db->flg0."_$4_$6.html";
   $db->html=preg_replace($pattern,$replace,$db->html);

   $url= "html/tirasidaylist_".$db->flg0."_";
   $url.=$row["saleday"]."_";
   $url.=$row2["lincode"].".html";
   if(! file_put_contents($url,$db->html)) throw new exception("書き込みエラー");
   echo $url."<br/>";
  
  }//foreach
 }//foreach

 echo "success";
}//try
catch(Exception $e){
 echo "エラー:".$e->getMessage();
}//catch
?>
