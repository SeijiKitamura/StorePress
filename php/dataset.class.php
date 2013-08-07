<?php
// ================================================================= //
// データ抽出クラス　                                                //
// DBからデータを抽出するクラス
// ================================================================= //

require_once("php/db.class.php");

class dataset extends DB{
 public $storeinfo;    //店舗情報
 public $pageinfo;     //ページ情報
 public $flg0;         //flg0(主にチラシ番号)
 public $items;        //データを格納
 public $saleday;      //販売日
 public $saletype;     //セールタイプ
 public $lincode;      //ラインコード
 public $clscode;      //ラインコード
 public $jcode;      //ラインコード

 function __construct(){
  parent::__construct();
 }//function __construct(){

// ================================================================ //
// 店舗情報を抽出
// 対象テーブル TB_STORE
// 抽出方法 TB_STOREのcolnameを$colarrayに渡す
// ================================================================ //
 public function datasetStoreInfo(){
  $this->select="colname,jpnname,val";
  $this->from =TB_STORE;
  $this->storeinfo=$this->getArray();
  if(! $this->ary) return false;
  return true;
 }//protected function datasetStoreInfo(){
 
// ================================================================ //
// 全ページ情報を抽出
// 対象テーブル TB_PAGECONF
// ================================================================ //
 public function datasetPageInfo(){
  //attrをゲット
  $this->select ="attr";
  $this->from =TB_PAGECONF;
  $this->group =$this->select;
  $attr=$this->getArray();
  if(! $this->ary) throw new exception("列情報がありません");

  $this->pageinfo=null;
  $this->select =" t.pagename";
  foreach($attr as $rowcnt =>$rowdata){
   $this->select.=",max(case when t.attr='".$rowdata["attr"]."' then t.val else '' end ) as `".$rowdata["attr"]."`";
  }//foreach
  $this->from =TB_PAGECONF." as t ";
  $this->group=" t.pagename";
  $this->order =" case when t.attr='parent' then t.val else 9999 end";
  $this->order.=",case when t.attr='group'  then t.val else 9999 end";
  $this->getArray();
  $this->pageinfo=$this->ary;
  if(! $this->ary) return false;
  return true;
 }//public function datasetPageInfo(){

// ================================================================ //
// ページ情報を抽出
// 対象テーブル TB_PAGECONF
// ================================================================ //
  public function datasetPageData($pagename){
   if(! $this->datasetPageInfo()) return false;
   $ary="";

   foreach($this->pageinfo as $rows=>$row){
    if($row["pagename"]==$pagename){
     $ary[]=$this->pageinfo[$rows];
     break;
    }//if
   }//foreach
   if(! $ary) return false;
   $this->pageinfo=$ary;
   return true;
  }// public function datasetPageData($pagename){

// ================================================================ //
// グループ情報を抽出(兄弟)
// 対象テーブル TB_PAGECONF
// ================================================================ //
  public function datasetBroth($pagename){
   if(! $this->datasetPageInfo()) return false;
   $ary="";
   
   //$pagenameのparentをゲット
   foreach($this->pageinfo as $rows=>$row){
    if($row["pagename"]==$pagename){
     $parent=$row["parent"];
     break;
    }//if
   }//foreach

   //同じparentを持つページをゲット
   foreach($this->pageinfo as $rows=>$row){
    if($row["parent"]==$parent){
     $ary[]=$this->pageinfo[$rows];
    }
   }//foreach

   if(! $ary) return false;
   $this->pageinfo=$ary;
   return true;
  }//public function datasetBroth($parent){


// ================================================================ //
// グループ情報を抽出(子供)
// 対象テーブル TB_PAGECONF
// ================================================================ //
  public function datasetChildren($parent){
   if(! $this->datasetPageInfo()) return false;
   $ary="";

   foreach($this->pageinfo as $rows=>$row){
    if($row["parent"]==$parent || $row["parent"]==="0"){
     $ary[]=$this->pageinfo[$rows];
    }//if
   }//foreach

   if(! $ary) return false;
   $this->pageinfo=$ary;
   return true;

  }//public function datasetChildren($parent){

// ================================================================ //
// セールデータを抽出
// 対象テーブル TB_SALEITEMS
// 抽出方法     日付、セールタイプが指定可能        
// ================================================================ //
 public function datasetSaleItem(){
  if(! $this->saleday) $this->saleday=date("Y-m-d");
  if(! ISDATE($this->saleday)) throw new exception("日付を確認してください");
  if($this->saletype && ! is_numeric($this->saletype)) throw new exception("セールタイプを確認してください");

  //TB_SALEITEMSデータを抽出
  $this->select="t.*";
  $this->from =TB_SALEITEMS." as t ";
  $this->where =" t.saleday='".$this->saleday."'";
  $this->where.=" and t.saletype=".$this->saletype;
  $this->order =" t.saletype,t.flg0,t.flg1,t.flg4";
  $this->items=$this->getArray();
  if(! $this->ary) return false;

 }//public function getTopMenuData(){

// ================================================================ //
// ニュースリリース用データ抽出
// 対象テーブル TB_SALEITEMS
// ================================================================ //
 public function datasetNewsData(){
  if(! $this->saleday) $this->saleday=date("Y-m-d");
  if(! ISDATE($this->saleday)) throw new exception("日付を確認してください");
  if(! $this->saletype) throw new exception("セールタイプを選択してください");

  //TB_SALEITEMSデータを抽出
  $this->select =" t.saleday,t.notice,t.flg8";
  $this->from =TB_SALEITEMS." as t ";
  $this->where =" t.saleday<='".$this->saleday."'";
  $this->where.=" and t.saletype=".$this->saletype;
  $this->order =" t.saletype desc";
  $this->items=$this->getArray();
  if(! $this->ary) return false;
 }//public function getNewsData(){

// ================================================================ //
// flg0抽出(チラシ番号)
// 対象テーブル TB_SALEITEMS
// 抽出方法     日付選択可能
// ================================================================ //
 public function datasetGetFlg0(){
  if(! $this->saleday) $this->saleday=date("Y-m-d");
  if(! ISDATE($this->saleday)) throw new exception("日付を確認してください");
  if(! $this->saletype) throw new exception("セールタイプを選択してください");
  //本日のデータを検索
  $this->select="*";
  $this->from =TB_SALEITEMS;
  $this->where =" saleday='".$this->saleday."'";
  $this->where.=" and saletype=".$this->saletype;
  $this->items=$this->getArray();
  if(! $this->ary) return false;

  $this->flg0=$this->items[0]["flg0"];
  return true;
 }//public function datasetGetFlg0(){

// ================================================================ //
// 日程データ抽出
// 対象テーブル TB_SALEITEMS
// ================================================================ //
 public function datasetDayListData(){
  if(! $this->saleday) $this->saleday=date("Y-m-d");
  if(! ISDATE($this->saleday)) throw new exception("日付を確認してください");
  if(! $this->saletype) throw new exception("セールタイプを選択してください");

  //本日のデータを検索
  if(! $this->datasetGetFlg0()) return false;

  //期間中の日程をゲット
  $this->select="saleday,count(jcode) as jcode";
  $this->from =TB_SALEITEMS;
  $this->where =" saletype=".$this->saletype;
  $this->where.=" and flg0='".$this->flg0."'";
  $this->group ="saleday";
  $this->order ="saleday";
  $this->items=$this->getArray();
  if(! $this->ary) return false;
  return true;
 }//public function getTirasiDayListData(){

// ================================================================ //
// lincodeグループデータ抽出
// 対象テーブル TB_SALEITEMS
// ================================================================ //
 public function datasetLinGroup(){
  if(! $this->saleday) $this->saleday=date("Y-m-d");
  if(! ISDATE($this->saleday)) throw new exception("日付を確認してください");
  if(! $this->saletype) throw new exception("セールタイプを選択してください");
  //本日のデータを検索
  if(! $this->datasetGetFlg0()) return false;

  //期間中のlincodeをゲット
  $this->select=" t2.lincode,t2.linname,count(t.jcode) as jcode";
  $this->from =TB_SALEITEMS." as t ";
  $this->from.=" inner join ".TB_CLSMAS." as t1 on";
  $this->from.=" t.clscode=t1.clscode";
  $this->from.=" inner join ".TB_LINMAS." as t2 on";
  $this->from.=" t1.lincode=t2.lincode";
  $this->where =" t.saletype=".$this->saletype;
  $this->where.=" and t.flg0='".$this->flg0."'";
  $this->where.=" and t.saleday='".$this->saleday."'";
  $this->group ="t2.lincode,t2.linname";
  $this->order ="t2.lincode";
  $this->items=$this->getArray();
  if(! $this->ary) return false;
  return true;

 }//public function datasetLinGroup(){
// ================================================================ //
// チラシ単品データ抽出
// 対象テーブル TB_SALEITEMS
// 表示順 1.イベント(日替わり イベント 通し)
// 表示順 2.販売日
// 表示順 3.アイテム表示順
// 表示順 4.クラスコード
// 表示順 5.JANコード
// ================================================================ //
 public function datasetTanpinListData(){
  //日付確認
  if(! $this->saleday) $this->saleday=date("Y-m-d");
  if(! ISDATE($this->saleday)) throw new exception("日付を確認してください");
  if(! $this->saletype) throw new exception("セールタイプを選択してください");
  //チラシ番号ゲット
  if(! $this->datasetGetFlg0()) return false;
  
  //$saleday以降の商品ゲット
  $this->select =" min(t.saleday) as salestart";
  $this->select.=",max(t.saleday) as saleend,";
  $this->select.=" t.clscode,t.jcode,t.maker,t.sname,t.tani,t.price,t.notice";
  $this->select.=",t.flg0,t.flg1,t.flg2,t.flg3,t.flg4,t.flg5";
  $this->select.=",t.flg6,t.flg7,t.flg8,t.flg9";
  $this->from =TB_SALEITEMS." as t";
  $this->from.=" inner join ".TB_CLSMAS." as t1 on";
  $this->from.=" t.clscode=t1.clscode";
  $this->where =" t.flg0='".$this->flg0."'";
  $this->where.=" and t.saleday>='".$this->saleday."'";
  if($this->lincode) $this->where.=" and t1.lincode=".$this->lincode;
  $this->group.=" t.clscode,t.jcode,t.maker,t.sname,t.tani,t.price,t.notice";
  $this->group.=",t.flg0,t.flg1,t.flg2,t.flg3,t.flg4,t.flg5";
  $this->group.=",t.flg6,t.flg7,t.flg8,t.flg9";
  $this->having=" min(t.saleday)<='".$this->saleday."'";
  $this->order =" cast(t.flg1 as SIGNED)";
  $this->order.=",min(t.saleday),t.flg4,t.clscode,t.jcode";
  $this->items=$this->getArray();
  if(! $this->ary) return false;
  return true;
 }//public function datasetTanpinListData($saleday=null){
 
// ================================================================ //
// クラスデータ抽出(lincode編)
// 対象テーブル TB_CLSMAS
// 抽出方法 $this->lincodeに属するclscode
// ================================================================ //
 public function datasetClsList(){
  $this->select="*";
  $this->from =TB_CLSMAS;
  if($this->lincode) $this->where="lincode=".$this->lincode;
  $this->order ="clscode";
  $this->getArray();
  if(! $this->ary) return false;
  $this->items=$this->ary;
  return true;
 }// public function datasetClsList(){

}//class dataset extends DB{
?>
