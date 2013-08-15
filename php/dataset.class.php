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
 public $salestart;    //対象期間(開始）
 public $saleend;      //対象期間(終了)
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
// 日程データ抽出
// 対象テーブル TB_SALEITEMS
// ================================================================ //
 public function datasetDayListData(){
  if(! ISDATE($this->saleday)) throw new exception("日付を確認してください");
  if(! $this->saletype) throw new exception("セールタイプを選択してください");

  //本日のデータを検索
  //if(! $this->datasetSaleSpan()) return false;

  //期間中の日程をゲット
  $this->select="saleday,count(jcode) as jcode";
  $this->from =TB_SALEITEMS;
  $this->where =" saletype=".$this->saletype;
  if($this->salestart==$this->saleend){
   $this->where.=" and saleday='".$this->saleday."'";
  }//if
  else{
   $this->where.=" and saleday between '".$this->salestart."'";
   $this->where.=" and '".$this->saleend."'";
  }
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
  //期間中のlincodeをゲット
  $this->select =" t.saleday,t.flg9";
  $this->select.=",t2.lincode,t2.linname,count(t.jcode) as jcode";
  $this->from =TB_SALEITEMS." as t ";
  $this->from.=" inner join ".TB_CLSMAS." as t1 on";
  $this->from.=" t.clscode=t1.clscode";
  $this->from.=" inner join ".TB_LINMAS." as t2 on";
  $this->from.=" t1.lincode=t2.lincode";
  $this->where =" t.saletype=".$this->saletype;
  if($this->saleday){
   $this->where.=" and t.saleday='".$this->saleday."'";
  }//if
  elseif($this->salestart==$this->saleend){
   $this->where.=" and t.saleday='".$this->salestart."'";
  }//if
  else{
   $this->where.=" and t.saleday between '".$this->salestart."'";
   $this->where.=" and '".$this->saleend."'";
  }//else
  $this->group ="t.saleday,t.flg9,t2.lincode,t2.linname";
  $this->order ="t.saleday,t2.lincode";
  $this->items=$this->getArray();
  if(! $this->ary) return false;
  return true;

 }//public function datasetLinGroup(){

// ================================================================ //
// 商品リスト抽出
// 対象テーブル TB_SALEITEMS
// 抽出方法 1.$this->saletype(必須)
// 抽出方法 2.$this->salestart (必須)
// 抽出方法 3.$this->saleend   (必須)
// 表示順 1.イベント(日替わり イベント 通し)
// 表示順 2.販売日
// 表示順 3.アイテム表示順
// 表示順 4.クラスコード
// 表示順 5.JANコード
// ================================================================ //
 public function datasetTanpinListData(){
  if(! $this->saletype) throw new exception("セールタイプを選択してください");

  if(! $this->salestart || ! $this->saleend) throw new exception("開始日と終了日を確認してください");

  //$saleday以降の商品ゲット
  $this->select =" min(t.saleday) as salestart";
  $this->select.=",max(t.saleday) as saleend,";
  $this->select.=" t.clscode,t.jcode,t.maker,t.sname,t.tani,t.price,t.notice";
  $this->select.=",t.flg0,t.flg1,t.flg2,t.flg3,t.flg4,t.flg5";
  $this->select.=",t.flg6,t.flg7,t.flg8,t.flg9,t.saletype";
  $this->select.=",t1.clsname,t2.lincode,t2.linname";
  $this->from =TB_SALEITEMS." as t";
  $this->from.=" inner join ".TB_CLSMAS." as t1 on";
  $this->from.=" t.clscode=t1.clscode";
  $this->from.=" inner join ".TB_LINMAS." as t2 on";
  $this->from.=" t1.lincode=t2.lincode";
  $this->where=" t.saletype=".$this->saletype;
  if($this->salestart==$this->saleend){
   $this->where.=" and t.saleday='".$this->salestart."'";
  }//if
  else{
   $this->where.=" and t.saleday between '".$this->salestart."'";
   $this->where.=" and '".$this->saleend."'";
  }
  if($this->lincode) $this->where.=" and t1.lincode=".$this->lincode;
  if($this->clscode) $this->where.=" and t1.clscode=".$this->clscode;
  if($this->jcode)   $this->where.=" and t.jcode='".$this->jcode."'";
  $this->group.=" t.clscode,t.jcode,t.maker,t.sname,t.tani,t.price,t.notice";
  $this->group.=",t.flg0,t.flg1,t.flg2,t.flg3,t.flg4,t.flg5";
  $this->group.=",t.flg6,t.flg7,t.flg8,t.flg9,t.saletype";
  $this->group.=",t1.clsname,t2.lincode,t2.linname";
  if($this->saleday){
   $this->having =" min(t.saleday)<='".$this->saleday."'";
   $this->having.=" and max(t.saleday)>='".$this->saleday."'";
  }//if
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

 
// ================================================================ //
// セール期間抽出
// 対象テーブル TB_SALEITEMS
// 抽出方法 $this->saletype,$this->saledayを指定
// 結果     $this->salestartと$this->saleendに日付が入る
// ================================================================ //
 public function datasetSaleSpan(){
  if(! $this->saletype) throw new exception("セールタイプを指定してください");
  if(! $this->saleday) throw new exception("販売日を指定してください");
  if(! ISDATE($this->saleday)) throw new exception("販売日を確認してください");

  //チラシの場合
  if($this->saletype==1){
   $this->datasetGetFlg0();//$this->flg0にチラシ番号が入る
   if(! $this->flg0) return false;
   $this->select =" min(saleday) as salestart";
   $this->select.=",max(saleday) as saleend";
   $this->from =TB_SALEITEMS;
   $this->where ="flg0='".$this->flg0."'";
   $this->getArray();
   if(! $this->ary) return false;
   $this->salestart=$this->ary[0]["salestart"];
   $this->saleend  =$this->ary[0]["saleend"];
  }//if
  else{
   $this->salestart=$this->saleday;
   $this->saleend  =$this->saleday;
  }//else
  return true;
 }// public function datasetSaleSpan(){

// ================================================================ //
// flg0抽出(チラシ番号)
// 対象テーブル TB_SALEITEMS
// 抽出方法     日付選択可能
// ================================================================ //
 public function datasetGetFlg0(){
  if(! ISDATE($this->saleday)) throw new exception("日付を確認してください。datasetGetFlg0");
  if($this->saletype!=1) throw new exception("セールタイプを確認してください");
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

}//class dataset extends DB{
?>
