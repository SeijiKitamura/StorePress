<?php
// ================================================================= //
// データ抽出クラス　                                                //
// DBからデータを抽出するクラス
// ================================================================= //

require_once("php/db.class.php");

class dataset extends DB{
 public $items;        //データを格納

 function __construct(){
  parent::__construct();
 }//function __construct(){

// ================================================================ //
// 店舗情報を抽出
// 対象テーブル TB_STORE
// 抽出方法 TB_STOREのcolnameを$colarrayに渡す
// ================================================================ //
 protected function getStoreInfo($colarray=null){
  $this->select="colname,jpnname,val";
  $this->from =TB_STORE;
  $this->items["data"]=$this->getArray();
 }//public function getInfo(){
 
// ================================================================ //
// ページ情報を抽出
// 対象テーブル TB_PAGECONF
// 抽出方法     ページ名を指定          
// ================================================================ //
 public function getPage($pagename=null){
  $this->items=null;
  //attrをゲット
  $this->select ="attr";
  $this->from =TB_PAGECONF;
  $this->group =$this->select;
  $this->getArray();
  $attr=$this->ary;

  $this->items=null;
  $this->select =" t.pagename";
  foreach($attr as $rowcnt =>$rowdata){
   $this->select.=",max(case when t.attr='".$rowdata["attr"]."' then t.val else '' end ) as `".$rowdata["attr"]."`";
  }//foreach
  $this->from =TB_PAGECONF." as t ";
  if($pagename) $this->where=" t.pagename='".$pagename."'";
  $this->group=" t.pagename";
  $this->order =" case when t.attr='parent' then t.val else 9999 end";
  $this->order.=",case when t.attr='group'  then t.val else 9999 end";
  $this->getArray();
  $this->items["data"]=$this->ary;
 }//public function getpage($pagename){

// ================================================================ //
// ページグループを抽出
// 対象テーブル TB_PAGECONF
// 抽出方法     グループを指定          
// ================================================================ //
 public function getGroupList($parent){
  $this->getPage();
  if(! $this->items["data"]) throw new exception("ページ情報がありません");
  $data=$this->items["data"];
  $this->items=null;

  foreach($data as $rows=>$row){
   if($row["parent"]==$parent || $row["parent"]===0){
    $this->items["data"][]=$row;
   }//if
  }//foraech
 }//public function getGroupList($group=null){

// ================================================================ //
// セールデータを抽出
// 対象テーブル TB_SALEITEMS
// 抽出方法     日付を指定          
// ================================================================ //
 public function getSaleItem($hiduke=null,$saletype=0){
  if(! $hiduke) $hiduke=date("Y-m-d");
  if(! is_numeric($saletype)) throw new exception("セールタイプを確認してください");
  //TB_SALEITEMSデータを抽出
  $this->select="t.*";
  $this->from =TB_SALEITEMS." as t ";
  $this->where =" t.saleday='".$hiduke."'";
  if($saletype) $this->where.=" and t.saletype=".$saletype;
  $this->order =" t.saletype,t.flg0,t.flg1,t.flg4";
  $this->items["data"]=$this->getArray();

 }//public function getTopMenuData(){

// ================================================================ //
// メニュー用データを抽出
// 対象テーブル TB_SALEITEMS
// 抽出方法     日付を指定 (saletypeごとに1アイテム抽出）         
// ================================================================ //
 public function getMenuData(){
  $this->getSaleItem();
  $saletype=null;
  foreach($this->items["data"] as $rows=>$row){
   if($row["saletype"]!=$saletype){
    $ary[]=$row;
    $saletype=$row["saletype"];
   }//if
  }//foreach

  $this->items["data"]=$ary;
 }// public function getMenuData(){

 public function getChildren($pagename){
  //ページ情報をゲット
  $this->getPage();

  //$pagenameのページ番号をゲット
  foreach($this->items["data"] as $rows=>$row){
   if($row["pagename"]==$pagename){
    $page=$row["page"];
    break;
   }//if
  }//foreach

  //parentが$pagenameになっているページを抽出
  foreach($this->items["data"] as $rows=>$row){
   if($row["parent"]==$page){
    $ary[]=$row;
   }
  }//foreach
  $this->items=null;
  $this->items["data"]=$ary;

 }//public function getChildren($pagename){

// ================================================================ //
// ニュースリリース用データ抽出
// 対象テーブル TB_SALEITEMS
// ================================================================ //
 public function getNewsData(){
  $hiduke=date("Y-m-d");
  $saletype=7;

  //TB_SALEITEMSデータを抽出
  $this->select =" t.saleday,t.notice,t.flg8";
  $this->from =TB_SALEITEMS." as t ";
  $this->where =" t.saleday<='".$hiduke."'";
  if($saletype) $this->where.=" and t.saletype=".$saletype;
  $this->order =" t.saletype desc";
  $this->items["data"]=$this->getArray();
 }//public function getNewsData(){

// ================================================================ //
// チラシ日程データ抽出
// 対象テーブル TB_SALEITEMS
// ================================================================ //
 public function getTirasiDayListData($saleday=null){
  if(! $saleday) $saleday=date("Y-m-d");
  if(! ISDATE($saleday)) throw new exception("日付を確認してください");

  //本日のデータを検索
  $this->select="*";
  $this->from =TB_SALEITEMS;
  $this->where =" saleday='".$saleday."'";
  $this->where.=" and saletype=1";
  $this->items["data"]=$this->getArray();

  if(! $this->items["data"]) return false;
  
  $tirasiid=$this->items["data"][0]["flg0"];

  //チラシの掲載日をゲット
  $this->select="saleday,count(jcode) as jcode";
  $this->from =TB_SALEITEMS;
  $this->where =" saletype=1";
  $this->where.=" and flg0='".$tirasiid."'";
  $this->group ="saleday";
  $this->order ="saleday";
  $this->items["data"]=$this->getArray();
 }//public function getTirasiDayListData(){

// ================================================================ //
// チラシ単品データ抽出
// 対象テーブル TB_SALEITEMS
// 表示順 1.イベント(日替わり イベント 通し)
// 表示順 2.販売日
// 表示順 3.アイテム表示順
// 表示順 4.クラスコード
// 表示順 5.JANコード
// ================================================================ //
 public function getTirasiTanpinListData($saleday=null){
  //日付確認
  if(! $saleday) $saleday=date("Y-m-d");
  if(! ISDATE($saleday)) throw new exception("日付を確認してください");
  
  //チラシ番号ゲット
  $this->select="*";
  $this->from =TB_SALEITEMS;
  $this->where =" saleday='".$saleday."'";
  $this->where.=" and saletype=1";
  $this->items["data"]=$this->getArray();
  if(! $this->items["data"]) return false;
  $tirasiid=$this->items["data"][0]["flg0"];
  
  //$saleday以降の商品ゲット
  $this->select =" min(saleday) as salestart";
  $this->select.=",max(saleday) as saleend,";
  $this->select.=" clscode,jcode,maker,sname,tani,price,notice";
  $this->select.=",flg0,flg1,flg2,flg3,flg4,flg5";
  $this->select.=",flg6,flg7,flg8,flg9";
  $this->from =TB_SALEITEMS;
  $this->where =" flg0='".$tirasiid."'";
  $this->where.=" and saleday>='".$saleday."'";
  $this->group =" clscode,jcode,maker,sname,tani,price,notice";
  $this->group.=",flg0,flg1,flg2,flg3,flg4,flg5";
  $this->group.=",flg6,flg7,flg8,flg9";
  $this->having=" min(saleday)<='".$saleday."'";
  $this->order =" cast(flg1 as SIGNED)";
  $this->order.=",min(saleday),flg4,clscode,jcode";
  $this->getArray();
  if(! $this->ary) return false;
  $this->items["data"]=$this->ary;
 }//public function getTirasiTanpinListData($saleday=null){
}//class dataset extends DB{
?>
