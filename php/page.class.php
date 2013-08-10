<?php
require_once("parts.class.php");

class page extends parts{

 function __construct(){
  parent::__construct();
 }// function __construct(){

//==========================================================//
// ベースフレーム作成
// $this->htmlにhtmlがセットされる
//==========================================================//
 public function pageFram(){
  if(! $this->me) throw new exception("ページを指定してください");
  //headを作成($this->elementにheadが生成)
  $this->partshead();
  $this->stackpart();
  
  //bodyを作成($db->elementにbodyが生成)
  $this->htmlbody();
  $this->addpart("head");

  //wrapperを作成($db->elementにdiv#wrapperが生成)
  $this->htmlcreatediv("id","wrapper");
  $this->appendpart("body");

  //headerを作成($db->elementにdiv#headerが生成)
  $this->htmlcreatediv("class","header");
  $this->appendpart("wrapper");
  $this->htmlclr();
  $this->addpart("header");
  
  //leftsideを作成($db->elementにdiv#leftsideが生成)
  $this->htmlcreatediv("class","leftside");
  $this->appendpart("wrapper");
  //$this->htmlclr();
  //$this->addpart("leftside");
 
  //rightsideを作成($db->elementにdiv#rightsideが生成)
  $this->htmlcreatediv("class","rightside");
  $this->appendpart("wrapper");
  //$this->htmlclr();
  //$this->addpart("rightside");
 
  //mainを作成($db->elementにdiv#mainが生成)
  $this->htmlcreatediv("class","main");
  $this->appendpart("wrapper");
  $this->htmlclr();
  $this->addpart("main");
 
  //footerを作成($db->elementにdiv#footerが生成)
  $this->htmlcreatediv("class","footer");
  $this->appendpart("wrapper");
  $this->htmlclr();
  $this->addpart("footer");
   
  $this->html="";
  $this->stackhtml();
 }//public function pageFram(){

//==========================================================//
// ヘッダー作成
// $this->elementにhtmlが入る
//==========================================================//
 public function pageHeader(){

  //$this->part退避
  $this->htmlescapepart();

  //ロゴイメージをゲット
  $this->partsLogo();
  $this->stackpart();

  //トップナビをゲット
  $this->partsGroup(1);
  $this->addpart("logoimg");

  //店舗情報をゲット
  $this->partsEigyo();
  $this->addpart("group");

  $this->htmlclr();
  $this->addpart("eigyo");
  $this->element=$this->part;

  //対比した退避したpartを戻す
  $this->htmlreturnpart();
  return $this->element;
 }//public function pageHeader($pagename){


//==========================================================//
// leftsideにチラシ日程をセットする
// $this->htmlにleftsideがある前提
//==========================================================//
 public function pageTirasiDayListLeftSide(){
  //div.daylist作成
  $this->htmlcreatediv("class","daylist");
  $this->stackpart();

  //チラシ日程ulを作成($this->elementにチラシ日程が生成)
  $this->partsTirasiDayList();

  //$this->partにulを追加
  $this->appendpart("daylist");
  
  //leftside($this->html)にdiv.daylist($this->part)を追加
  $this->appendhtml("leftside");
   
 }//public function pageTirasiDayListLeftSide(){

//==========================================================//
// leftsideにチラシlincodeグループをセットする
// $this->htmlにleftsideがある前提
//==========================================================//
 public function pageTirasiLinListLeftSide(){
  //div.linlist作成
  $this->htmlcreatediv("class","linlist");
  $this->stackpart();

  //ライングループulを作成($this->elementにライングループが生成)
  $this->partsTirasiLinList();

  //$this->partにulを追加
  $this->appendpart("linlist");
  
  //leftside($this->html)にdiv.linlist($this->part)を追加
  $this->appendhtml("leftside");
   
 }//public function pageTirasiDayListLeftSide(){

//==========================================================//
// leftsideに兄弟ページのグループをセットする
// $this->htmlにleftsideがある前提
//==========================================================//
 public function pageBrothBanner(){
  if(! $this->me) throw new exception("ページを指定してください");

  //div.banner作成
  $this->htmlcreatediv("class","broth");
  $this->stackpart();

  //ライングループulを作成($this->elementにライングループが生成)
  $this->partsBrothBanner();

  //$this->partにulを追加
  $this->appendpart("broth");
  
  //leftside($this->html)にdiv.linlist($this->part)を追加
  $this->appendhtml("leftside");
   
 }//public function pageBrothBanner(){

//==========================================================//
// 商品リストをセットする
// $this->htmlにmainがある前提
//==========================================================//
 public function pageTanpinList(){
  if(! $this->me) throw new exception("ページを指定してください");
  $flg2=null;
  $salestart="";
  $saleend="";
  $html="";
  $eventimg="";

  if(! $this->datasetTanpinListData()) return false;
  $data=$this->items;
  foreach($data as $rows=>$row){

   //販売期間をセット
   if($salestart!=$row["salestart"] || $saleend!=$row["saleend"] ||
      $row["flg2"]!==$flg2){ 
    //日程を表示
    $html.=$this->partsEventTitle($data[$rows]);

    //イベント画像表示
    $html.=$this->partsEventImg($data[$rows]);
   }//if
   
   //フラグセット
   $salestart=$row["salestart"];
   $saleend=$row["saleend"];
   $flg2=$row["flg2"];
   $eventimg=$row["flg3"];
   $h2="";

   //単品枠作成
   $html.=$this->partsTanpinDeteil($data[$rows]);
  }//foreach

  $this->element=$html;
  $this->stackpart();
  $this->appendhtml("main"); 
 }//public function pageTanpinList(){

//==========================================================//
// 単品をセットする
// $this->htmlにmainがある前提
//==========================================================//
 public function pageTanpin(){
  if(! $this->me) throw new exception("ページを指定してください");
  if(! $this->jcode || ! CHKCD($this->jcode)) throw new exception("JANコードを確認してください");
  if(! $this->datasetTanpinListData()) return false;

  $html="";
  $data=$this->items[0];
  //イベント作成
  $html =$this->partsEventTitle($data);

  //単品枠作成
  $this->partsBigTanpin($data);
  $this->partsTanpinImg($data);
  $html.=$this->element;
  $this->element=$html;
  $this->stackpart();
 
  $this->appendhtml("main");
 }//public function pageTanpin(){


}//class page extends page{
?>
