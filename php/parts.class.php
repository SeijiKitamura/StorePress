<?php
require_once("html.class.php");

class parts extends html{

 function __construct(){
  parent::__construct();
 }//function __construct(){

//----------------------------------------------------------//
// ロゴイメージ作成
// $this->divにロゴイメージ(id=logoimg)が作成される
//----------------------------------------------------------//
 public function getLogo(){
  //店舗情報ゲット
  $this->getStoreInfo();
  //$store=$this->items["data"][0];
  $store=$this->items["data"];

  //ロゴイメージ用div作成
  $this->creatediv("id","logoimg");

  //ロゴイメージ作成
  foreach($store as $rows =>$row){
   if($row["colname"]=="logo"){
    $logourl=$row["val"];
   }//if
   if($row["colname"]=="storename"){
    $storename=$row["val"];
   }//if
  }//foreach
  $this->create_img(IMG.$logourl,$storename,$storename);

  //ロゴイメージをdivへ追加
  $this->appenddiv("logoimg");
 }//public function getLogo(){

//----------------------------------------------------------//
// グループリスト作成
// $this->div(div.group)にグループリスト(ul)が作成される
//----------------------------------------------------------//
 public function getGroup($data,$me){
  //ulをセット
  $this->getul($data,$me);

  //divを作成
  $this->creatediv("class","group");

  //ulをdivへ追加
  $this->appenddiv("group");
 }//public function getGroup($group){

//----------------------------------------------------------//
// 営業時間リスト作成
// $this->div(div.eigyo)に作成される
//----------------------------------------------------------//
 public function getEigyo(){
  $this->creatediv("class","eigyo");
  $this->getStoreInfo();
  $ary=array("opentime","address","telephone");
  foreach($this->items["data"] as $rows=>$row){
   foreach($ary as $rows2=>$row2){
    if($row["colname"]==$row2){
     $this->create_span($row["jpnname"]);
     $this->addelement("span",$row["val"]."<br />");
     $this->appenddiv("eigyo");
     break;
    }//if
   }//foreach
  }//foreach

 }//public function getEigyo(){

//----------------------------------------------------------//
// headをセット
//----------------------------------------------------------//
 public function gethead($pagename){
  //店舗情報セット
  $this->getStoreInfo();
  $store=$this->items["data"];
  if(! $store) throw new exception ("店舗情報がありません");
  //print_r($store);

  //ページ情報をゲット
  $this->getPage($pagename);
  $page=$this->items["data"];
  if(! $page) throw new exception ("ページ情報がありません");
  //print_r($page);

  //ヘッダーをセット
  //$this->head_tmp();
  
  //店舗情報を反映
  foreach($store as $rows=>$row){
   $pattern="__".$row["colname"]."__";
   $this->html=str_replace($pattern,$row["val"],$this->html);
  }//foreach

  //ページ情報を反映
  foreach($page as $rows=>$row){
   foreach($row as $col=>$val){
    $pattern="__".$col."__";
    $this->html=str_replace($pattern,$val,$this->html);
   }//foreach
  }//foreach

  //ディレクトリを反映
  $pattern="__IMG__";
  $this->html=str_replace($pattern,IMG,$this->html);

  $pattern="__CSS__";
  $this->html=str_replace($pattern,CSS,$this->html);

  $pattern="__JQUERY__";
  $this->html=str_replace($pattern,JQ,$this->html);

  //echo $this->html;
 }//public function gethead(){


//----------------------------------------------------------//
// フレーム作成
// $this->htmlに3カラムのhtmlがセットされる
//----------------------------------------------------------//
 public function getfram(){
  $this->head_tmp();
  $this->body_tmp();
  $this->addhtml("head");

  $this->header_tmp();
  $this->appendhtml("wrapper");

  $this->leftside_tmp();
  $this->appendhtml("wrapper");

  $this->main_tmp();
  $this->appendhtml("wrapper");

  $this->rightside_tmp();
  $this->appendhtml("wrapper");

  $this->footer_tmp();
  $this->appendhtml("wrapper");
 }//public function getfram(){

 public function getheader($pagename){
  //メインフレームをゲット
  $this->getfram();

  //headをゲット
  $this->gethead($pagename);

  //ロゴイメージをゲット
  $this->getLogo();

  //ロゴをhaederに追加
  $this->appendhtml("header");

  //トップナビをゲット
  $this->getGroupList(1);
  $this->getGroup($this->items["data"],$pagename);

  //トップナビをheaderに追加
  $this->appendhtml("header");

  //営業情報をゲット
  $this->getEigyo();
  $this->appendhtml("header");
 }//public function getheader($pagename){

//----------------------------------------------------------//
// バナーを作成
// $this->divにデータがセットされる
// $pagename 親ページのページ番号を入力
//----------------------------------------------------------//
 public function getbanner($pagename){

  $div="";

  $this->getChildren($pagename);

  if(! $this->items["data"]) return false;
   
  foreach($this->items["data"] as $rows=>$row){
   //div.bigmenuを作成
   $this->creatediv("class","banner");
   
   //div.bigmenuへaタグを追加
   $this->create_a($row["url"]);
   $this->appenddiv("banner");

   //h2をaタグへ追加
   $this->create_h2($row["title"]);
   $this->appenddiv("a");

   //imgをaタグへ追加
   $this->create_img($row["url"],$row["title"],$row["title"]);
   $this->appenddiv("a");

   //spanをaタグへ追加
   $this->create_span($row["description"]);
   $this->appenddiv("a");

   //div.bigmenuを$divへ追加
   //$this->appendhtml("main");
   $div.=$this->div;
  }//foraech
  $this->div=$div;
 }// public function getChildrenMenu($pagename){

 public function getTanpin($data,$me=null){
  $this->div="";
  $flg2="null";
  $salestart="";
  $saleend="";
  foreach($data as $rows=>$row){
   //販売期間をセット
   if($salestart!=$row["salestart"] && $saleend!=$row["saleend"]){
    if($row["salestart"]==$row["saleend"]){
     $salespan=date("n月j日",strtotime($row["salestart"]))."限り";
    }//if
    else{
     $salespan=$row["saleend"]."まで";
    }//else
   }//if

   //タイトルをセット
   if($flg2!=$row["flg2"]){
    $title=$salespan." ".$row["flg2"];
   }//if
   

   if($salestart!=$row["salestart"] || $saleend!=$row["saleend"] ||
      $flg2!=$row["flg2"]){
    $this->create_clr();
    $this->div.=$this->element;
    $this->create_h2($title);
    $this->div.=$this->element;
   }//if
   
   //フラグリセット
   $salestart=$row["salestart"];
   $saleend=$row["saleend"];
   $flg2=$row["flg2"];
   $h2="";
   //単品枠作成
   $this->createtanpin();
   foreach($row as $col=>$val){
    $this->element=preg_replace("/<!--".$col."-->/",$val,$this->element);
   }//foreach
   $this->div.=$this->element;
  }//foreach
 }// public function getTanpin($data,$me=null){

//----------------------------------------------------------//
// ニュースリリースを作成
// $this->divにデータがセットされる
//----------------------------------------------------------//
 public function getNews(){
  $this->getNewsData();

  if(! $this->items["data"]) return false;

  foreach($this->items["data"] as $rows=>$row){
   $this->creatediv("class","newsdate");
   $this->element=date("Y年m月d日",strtotime($row["saleday"]));
   $this->appenddiv("newsdate");
   $newsdate=$this->div;

   $this->creatediv("class","newstitle");
   $this->element=$row["notice"];
   $this->appenddiv("newstitle");
   $newstitle=$this->div;

   $li[]=array("title"=>$newsdate.$newstitle,"url"=>$row["flg8"]);
  }//foreach
  $this->getul($li);
  $ul=$this->element;

  $this->creatediv("class","news");
  $this->create_span("最新ニュース");
  $this->appenddiv("news");

  $this->element=$ul;
  $this->appenddiv("news");
 }//public function getnews(){

// ================================================================ //
// チラシ日程データ作成
// 対象テーブル TB_SALEITEMS
// ================================================================ //
 public function getTirasiDayList($saleday=null){
  if(! $saleday) $saleday=date("Y-m-d");
  if(! ISDATE($saleday)) throw new exception("日付を確認してください");

  //日付データをゲット
  $this->getTirasiDayListData($saleday);
  if(! $this->items["data"]) return false;

  //li用データ作成
  foreach($this->items["data"] as $rows=>$row){
   $hiduke=strtotime($row["saleday"]);
   $url ="tirasiitem.php?saleday=".$row["saleday"];
   $title =date("Y年n月j日",$hiduke);
   $title.="(".$GLOBALS["YOUBI"][date("w",$hiduke)].")~";
   $li[]=array("url"=>$url,"title"=>$title);
  }//foreach
  
  $this->getul($li);
  $this->creatediv("class","daylist");
  $this->appenddiv("daylist");
 }//public function getTirasiDayList($saleday=null){

// ================================================================ //
// チラシ単品データ作成
// 対象テーブル TB_SALEITEMS
// ================================================================ //
 public function getTirasiTanpinList($saleday=null){
  //日付ゲット
  if(! $saleday) $saleday=date("Y-m-d");
  if(! ISDATE($saleday)) throw new exception("日付を確認してください");
  
  //単品データゲット
  $this->getTirasiTanpinListData($saleday);
  if(! $this->items["data"]) return false;
  
  //単品HTMLゲット
  $this->getTanpin($this->items["data"]);
  
 }//public function getTirasiTanpinList($saleday=null){
}//class parts extends html{
?>
