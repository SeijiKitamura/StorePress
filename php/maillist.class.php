<?php
//----------------------------------------------------------//
//  maillist.class.php
//  (db.class.phpをスーパークラス)
//  このクラスを使用するときは必ずtry catchを使用すること
//----------------------------------------------------------//
//メソッド一覧
//----------------------------------------------------------//
// set2mail()       表示する商品を「メール商品」にする
// set2osusume()    表示する商品を「おすすめ商品」にする
// getDayList()     指定月に送信した日付を返す
// getItemList()    指定月のアイテムを返す
// getMailItem()    指定日の商品を返す
//----------------------------------------------------------//
require_once("db.class.php");
require_once("function.php");

class ML extends DB{
 public $items;   //データを格納
 public $saleday; //表示したい日(指定した月のアイテムが表示される）

 protected $saletype;//セールタイプ番号
 protected $andwhere;//where句
 
 function __construct(){
  parent::__construct();

  //表示したい日
  $this->saleday=date("Y-m-d");
  
  //セールタイプ番号ゲット
  $this->saletype="1";

 }//__construct
 
 public function set2mail(){
  $this->saletype="1";
 }

 public function set2osusume(){
  $this->saletype="2";
 }

 protected function setwhere(){
  $uk=strtotime($this->saleday);
  $sday=date("Y-m-1",$uk);
  $eday=date("Y-m-d",mktime(0,0,0,(date("m",$uk)+1),0,date("Y",$uk)));
  $this->andwhere =" saleday between '".$sday."' and '".$eday."'";
  $this->andwhere.=" and saletype=".$this->saletype;
  //echo $this->andwhere."\n";
 }

//----------------------------------------------------------//
// 指定月のメールを送信した日付を返す
//----------------------------------------------------------//
 public function getDayList(){
  $this->items=null;

  $this->setwhere();

  $this->select =" t.saleday,count(t.jcode) as cnt";
  $this->from =TB_SALEITEMS;
  $this->from.=" as t";
  $this->where=$this->andwhere;
  $this->group=" t.saleday";
  $this->order=" t.saleday";
  $this->items["data"]=$this->getArray();
 }//public function getDayList(){

//----------------------------------------------------------//
// 指定月のアイテムを返す
//----------------------------------------------------------//
 public function getItemList(){
  $this->items=null;

  $this->setwhere();

  $this->select =" t.saleday,t.saleday as lastsale,t.clscode,t.sname";
  $this->select.=",t.jcode,t.tani,t.price,t.notice,t.flg0,t.saletype";
  $this->select.=",t.maker";
  $this->select.=",t1.clsname";
  $this->select.=",t2.lincode,t2.linname";
  $this->from =TB_SALEITEMS;
  $this->from.=" as t";
  $this->from.=" inner join ".TB_CLSMAS." as t1 on";
  $this->from.=" t.clscode=t1.clscode";
  $this->from.=" inner join ".TB_LINMAS." as t2 on";
  $this->from.=" t1.lincode=t2.lincode";
  $this->where =$this->andwhere;
  $this->order =" t.saleday,t.clscode,t.jcode";

  $this->items["data"]=$this->getArray();
 }//public function getItemList(){

//----------------------------------------------------------//
// 指定日のメール商品を返す
//----------------------------------------------------------//
 public function getMailItem(){
  $this->items=null;

  $this->getItemList();
  if(! is_array($this->items["data"])) return false;
  foreach($this->items["data"] as $rownum=>$rowdata){
   if(strtotime($rowdata["saleday"])==strtotime($this->saleday)){
    $items[]=$rowdata;
   }//if
  }//foeach

  $this->items["data"]=$items;
 }// public function getMailItem(){

//----------------------------------------------------------//
// 指定日の単品を返す
//----------------------------------------------------------//
 public function getTanpin($jcode){
  $this->items=null;
  $this->getMailItem();

  foreach($this->items["data"] as $rownum=>$rowdata){
   if($rowdata["jcode"]==$jcode){
    $items[]=$rowdata;
   }//if
  }//foeach

  $this->items["data"]=$items;

 }
}//ML

?>
