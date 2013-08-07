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
// チラシ単品をセットする
// $this->htmlにmainがある前提
//==========================================================//
 public function pageTanpinList(){
  if(! $this->me) throw new exception("ページを指定してください");

  $this->datasetTanpinListData();
  $this->partsTanpin($this->items);
  $this->stackpart();
  //leftside($this->html)にdiv.linlist($this->part)を追加
  $this->appendhtml("main");
   
 }//public function pageBrothBanner(){


}//class page extends parts{
?>
