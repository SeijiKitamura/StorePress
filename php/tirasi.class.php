<?php
//----------------------------------------------------------//
//  tirasi.class.php 
//  広告系クラス(db.class.phpをスーパークラス)
//  このクラスを使用するときは必ずtry catchを使用すること
//----------------------------------------------------------//
//メソッド一覧
//----------------------------------------------------------//
//
//  getDayList()         指定チラシの日程、アイテム数を表示
//  getLinList()         指定チラシのラインリストを返す
//  getClsList($lincode) 指定ラインのクラスリストを返す
//  getItemList()        商品リストを返す
//  getLinItem($lincode) 指定ラインの商品リストを返す
//  getClsItem($clscode) 指定クラスの商品リストを返す
//  getJanItem($jcode)   指定商品を返す
//  getTitle()           指定チラシのタイトル、アイテム数を表示(未完)
//----------------------------------------------------------//
require_once("db.class.php");
require_once("function.php");

class TIRASI extends DB{
 public $items;   //データを格納
 public $flg0;    //チラシ番号
 public $saleday; //
 public $title;

 protected $saletype;//セールタイプ番号
 protected $andwhere;//where句
 
 function __construct(){
  parent::__construct();

  //表示したい日
  $this->saleday=date("Y-m-d");

  //セールタイプ番号ゲット
  $this->saletype=0;

  //where句生成
 }//__construct
 
 protected function setwhere(){
  //掲載号確定
  $this->select="saleday,flg0";
  $this->from =TB_SALEITEMS;
  $this->where =" saletype=".$this->saletype;
  $this->where.=" and saleday>='".$this->saleday."'";
  $this->order =" saleday";
  $titles=$this->getArray();
  $this->flg0=$titles[0]["flg0"];

  $this->andwhere =" flg0='".$this->flg0."'";
  $this->andwhere.=" and saleday>='".$this->saleday."'";
  $this->andwhere.=" and saletype=".$this->saletype;
 }

//----------------------------------------------------------//
// 指定チラシの日程、アイテム数を表示
//----------------------------------------------------------//
 public function getDayList(){
  $this->items=null;

  $this->setwhere();
  
  $this->select="t.saleday,count(t.jcode) as cnt";
  $this->from =TB_SALEITEMS." as t";
  $this->where=" t.flg0='".$this->flg0."'";
  $this->where.=" and t.saletype=".$this->saletype;
  $this->group="t.saleday";
  $this->order="t.saleday";
  $this->items["data"]=$this->getArray();
  
 }//public function getDayList(){
//----------------------------------------------------------//
// 単一チラシの指定日以降のラインリストを返す
//----------------------------------------------------------//
 public function getLinList(){
  $this->items=null;

  $this->setwhere();

  $this->select =" t2.lincode,t2.linname";
  $this->select.=",count(t.jcode) as cnt";
  $this->from =" (select clscode,jcode from ".TB_SALEITEMS;
  $this->from.=" where ".$this->andwhere;
  $this->from.=" group by clscode,jcode";
  $this->from.=" ) as t";
  $this->from.=" inner join ".TB_CLSMAS." as t1 on";
  $this->from.=" t.clscode=t1.clscode";
  $this->from.=" inner join ".TB_LINMAS." as t2 on";
  $this->from.=" t1.lincode=t2.lincode";
  $this->group =" t2.lincode,t2.linname";
  $this->order =" t2.lincode";
  $this->items["data"]=$this->getArray();
 }//public function getLinList(){

//----------------------------------------------------------//
// 単一チラシの指定日以降のクラスリストを返す
//----------------------------------------------------------//
 public function getClsList($lincode){
  $this->items=null;

  $this->setwhere();

  $this->select =" t1.clscode,t1.clsname";
  $this->select.=",count(t.jcode) as cnt";
  $this->from =" (select clscode,jcode from ".TB_SALEITEMS;
  $this->from.=" where ".$this->andwhere;
  $this->from.=" group by clscode,jcode";
  $this->from.=" ) as t";
  $this->from.=" inner join ".TB_CLSMAS." as t1 on";
  $this->from.=" t.clscode=t1.clscode";
  $this->from.=" inner join ".TB_LINMAS." as t2 on";
  $this->from.=" t1.lincode=t2.lincode";
  $this->where=" t2.lincode=".$lincode;
  $this->group =" t1.clscode,t1.clsname";
  $this->order =" t1.clscode";
  $this->items["data"]=$this->getArray();

 }//public function getClsList(){

//----------------------------------------------------------//
// 単一チラシの指定日以降のアイテムリストを返す
//----------------------------------------------------------//
 public function getItemList(){
  $this->items=null;

  $this->setwhere();

  $this->select =" t.flg0,t.clscode,t.jcode,t.sname,t.maker";
  $this->select.=",t.tani,t.price,t.notice,t.flg1,t.flg2,t.saletype";
  $this->select.=",t1.clsname";
  $this->select.=",t2.lincode,t2.linname";
  $this->select.=",min(t.saleday) as sday";
  $this->select.=",max(t.saleday) as eday";
  $this->from =" (select * from ".TB_SALEITEMS;
  $this->from.=" where ".$this->andwhere;
  $this->from.=" ) as t";
  $this->from.=" inner join ".TB_CLSMAS." as t1 on";
  $this->from.=" t.clscode=t1.clscode";
  $this->from.=" inner join ".TB_LINMAS." as t2 on";
  $this->from.=" t1.lincode=t2.lincode";
  $this->where =$this->andwhere;
  $this->group =" t.flg0,t.clscode,t.jcode,t.sname,t.maker";
  $this->group.=",t.tani,t.price,t.notice,t.flg1,t.flg2,t.saletype";
  $this->group.=",t1.clsname";
  $this->group.=",t2.lincode,t2.linname";
  $this->order =" min(t.saleday)";
  $this->order.=",max(t.saleday)";
  $this->order.=",t.flg1,t.flg2";
  $this->order.=",t.clscode,t.sname";
  $this->items["data"]=$this->getArray();
 }//public function getItemList(){

//----------------------------------------------------------//
//商品一覧から特定ラインの商品を抽出
//----------------------------------------------------------//
 public function getLinItem($lincode){
  $this->items=null;

  //データゲット
  $this->getItemList();
  
  //該当商品抽出
  foreach($this->items["data"] as $rownum=>$rowdata){
   if($rowdata["lincode"]==$lincode){
    $item[]=$rowdata;
   }//if
  }//foreach

  $this->items["data"]=$item;
 }//public function LinItem($lincode){

//----------------------------------------------------------//
//商品一覧から特定クラスの商品を抽出
//----------------------------------------------------------//
 public function getClsItem($clscode){
  $this->items=null;

  //データゲット
  $this->getItemList();
  
  //該当商品抽出
  foreach($this->items["data"] as $rownum=>$rowdata){
   if($rowdata["clscode"]==$clscode){
    $item[]=$rowdata;
   }//if
  }//foreach

  $this->items["data"]=$item;
 }//public function getClsItem($clscode){

//----------------------------------------------------------//
//商品一覧から特定商品を抽出
//----------------------------------------------------------//
 public function getJanItem($jcode){
  $this->items=null;

  //データゲット
  $this->getItemList();
  
  //該当商品抽出
  foreach($this->items["data"] as $rownum=>$rowdata){
   if($rowdata["jcode"]==$jcode){
    $item[]=$rowdata;
    break;
   }//if
  }//foreach

  $this->items["data"]=$item;
 }//public function getJanItem($jcode){

//----------------------------------------------------------//
// 指定日から始まる商品の一覧を返す
//----------------------------------------------------------//
 public function getItemDay($sday,$lin=null){
  
  //該当商品抽出
  foreach($this->items["data"] as $rownum=>$rowdata){
   if(strtotime($rowdata["sday"])==strtotime($sday)){
    $item[]=$rowdata;
   }//if
  }//foreach
  $this->items["data"]=$item;
 
 }// public function getItemDay($sday){
}//TIRASI

?>
