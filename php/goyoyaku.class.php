<?php
//----------------------------------------------------------//
//  goyoyaku.class.php 
//  ご予約商品系クラス(db.class.phpをスーパークラス)
//  このクラスを使用するときは必ずtry catchを使用すること
//----------------------------------------------------------//
//メソッド一覧
//----------------------------------------------------------//
//  getGrpList()         ご予約商品のグループリストを返す
//  getItemList()        商品リストを返す
//  getGrpItem($group)   指定グループの商品リストを返す
//  getJanItem($jcode)   指定商品を返す
//----------------------------------------------------------//
require_once("db.class.php");
require_once("function.php");

class GOYOYAKU extends DB{
 public $items;       //データを格納
 protected $saletype; //セールタイプ番号
 protected $andwhere; //where句

 function __construct(){
  parent::__construct();
  $this->saletype=5;   //config.php $SALETYPE
 }// function __construct(){

 //ベースとなるwhere句
 protected function setwhere(){
  $this->andwhere =" saletype='".$this->saletype."'";
 }

//----------------------------------------------------------//
// ご予約商品のグループリストを返す
//----------------------------------------------------------//
  public function getGrpList(){
  $this->items=null;

  $this->setwhere();

  $this->select =" t.flg0 as grpcode,t.flg1 as grpname";
  $this->select.=",count(t.jcode) as cnt";
  $this->from ="( select flg0,flg1,jcode from ".TB_SALEITEMS;
  $this->from.=" where ".$this->andwhere;
  $this->from.=" group by flg0,flg1,jcode) as t";
  $this->group =" t.flg0,t.flg1";
  $this->order =" cast(t.flg0 as signed)";
  $this->items["data"]=$this->getArray();
 }//public function getGrpList(){

//----------------------------------------------------------//
// ご予約商品のグループリストを返す(New)
//----------------------------------------------------------//
 public function getGrpList2(){
  $this->items=null;

  $this->setwhere();
  
  $this->select =" t.flg0 as grpcode,t.flg1 as grpname";
  $this->select.=",count(t.jcode) as cnt,min(jcode) as jcode";
  $this->from ="( select flg0,flg1,jcode from ".TB_SALEITEMS;
  $this->from.=" where ".$this->andwhere;
  $this->from.=" group by flg0,flg1,jcode) as t";
  $this->group =" t.flg0,t.flg1";
  $this->order =" cast(t.flg0 as signed)";
  $this->items["data"]=$this->getArray();

 }//public function getGrpList2(){

//----------------------------------------------------------//
// ご予約商品すべてのアイテムリストを返す
//----------------------------------------------------------//
 public function getItemList(){
  $this->items=null;

  $this->setwhere();

  $this->select =" t.flg0 as grpcode,t.flg1 as grpname ,t.flg2 as datanum";
  $this->select.=",t.clscode,t.jcode,t.sname";
  $this->select.=",t.tani,t.price,t.notice,t.saletype";
  $this->select.=",t1.clsname";
  $this->select.=",t2.lincode,t2.linname";
  $this->select.=",min(t.saleday) as kaisi,max(t.saleday) as owari";
  $this->from =TB_SALEITEMS." as t ";
  $this->from.=" inner join ".TB_CLSMAS." as t1 on";
  $this->from.=" t.clscode=t1.clscode";
  $this->from.=" inner join ".TB_LINMAS." as t2 on";
  $this->from.=" t1.lincode=t2.lincode";
  $this->where =$this->andwhere;
  $this->group =" t.flg0,t.flg1,t.flg2";
  $this->group.=",t.clscode,t.jcode,t.sname";
  $this->group.=",t.tani,t.price,t.notice,t.saletype";
  $this->group.=",t1.clsname";
  $this->group.=",t2.lincode,t2.linname";
  $this->order =" cast(t.flg0 as signed),cast(t.flg2 as signed)";
  $this->order.=",t.jcode,t.price";
  $this->items["data"]=$this->getArray();
 }//public function getItemList(){

//----------------------------------------------------------//
//商品一覧から特定グループの商品を抽出
//----------------------------------------------------------//
 public function getGrpItem($grp){
  $this->items=null;

  //データゲット
  $this->getItemList();
  
  //該当商品抽出
  foreach($this->items["data"] as $rownum=>$rowdata){
   if($rowdata["grpcode"]==$grp){
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
}//class GOYOYAKU extends DB{
?>
