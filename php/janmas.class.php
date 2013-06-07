<?php
//----------------------------------------------------------//
//  janmas.class.php 
//  単品系クラス(db.class.phpをスーパークラス)
//  このクラスを使用するときは必ずtry catchを使用すること
//----------------------------------------------------------//
//メソッド一覧
//----------------------------------------------------------//
// getLinList()           ラインリストを返す
// getClsList($lincode)   指定ラインのクラスリストを返す
// getLinItem($lincode)   指定ラインの商品を抽出
// getClsItem($clscode)   指定クラスの商品を抽出
// getJanItem($jcode)     単品を抽出
// getNewItem()           新商品表示(2日前を新商品とする)
// setSaleItem()          セール商品の価格を反映させる
// outJan()               指定単品を除く

//----------------------------------------------------------//
require_once("db.class.php");
require_once("html.class.php");
require_once("function.php");

class JANMAS extends DB{
 public $items;   //データを格納
 public $flg0;    //チラシ番号
 public $saleday; //表示したい日(最終販売日がこの日付以降が表示される）
 public $html;   //表示するHTML(html.class.php）

 function __construct(){
  parent::__construct();

  //表示したい日
  $this->saleday=date("Y-m-d",strtotime("-".SALESTART."days"));
 }//__construct
 
 protected function setwhere(){
  $this->andwhere =" t.lastsale>='".$this->saleday."'";
 }

//----------------------------------------------------------//
// ラインリストを返す
//----------------------------------------------------------//
 public function getLinList(){
  $this->items=null;

  $this->setwhere();
  
  $this->select =" t2.lincode,t2.linname";
  $this->select.=",count(t.jcode) as cnt";
  $this->from =TB_JANMAS." as t ";
  $this->from.=" inner join ".TB_CLSMAS." as t1 on";
  $this->from.=" t.clscode=t1.clscode";
  $this->from.=" inner join ".TB_LINMAS." as t2 on";
  $this->from.=" t1.lincode=t2.lincode";
  $this->where =$this->andwhere;
  $this->group =" t2.lincode,t2.linname";
  $this->order =" t2.lincode";
  $this->items["data"]=$this->getArray();

  for($i=0;$i<count($this->items["data"]);$i++){
   $this->items["data"][$i]["rownum"]=$i;
  }//for
 }//public function getLinList(){

//----------------------------------------------------------//
//指定ラインのクラスリストを返す
//----------------------------------------------------------//
 public function getClsList($lincode){
  $this->items=null;

  $this->setwhere();

  $this->select =" t1.clscode,t1.clsname";
  $this->select.=",count(t.jcode) as cnt";
  $this->from =TB_JANMAS." as t ";
  $this->from.=" inner join ".TB_CLSMAS." as t1 on";
  $this->from.=" t.clscode=t1.clscode";
  $this->where =$this->andwhere;
  $this->where.=" and t1.lincode=".$lincode;
  $this->group =" t1.clscode,t1.clsname";
  $this->order =" t1.clscode";
  $this->items["data"]=$this->getArray();

  for($i=0;$i<count($this->items["data"]);$i++){
   $this->items["data"][$i]["rownum"]=$i;
  }//for

 }//public function getClsList(){

//----------------------------------------------------------//
// クラスリストを返す（ラインコード付き）
//----------------------------------------------------------//
 public function getLinClsList(){
  $this->items=null;

  $this->setwhere();

  $this->select ="t2.lincode,t2.linname,t1.clscode,t1.clsname";
  $this->select.=",count(t.jcode) as cnt";
  $this->from =TB_JANMAS." as t ";
  $this->from.=" inner join ".TB_CLSMAS." as t1 on";
  $this->from.=" t.clscode=t1.clscode";
  $this->from.=" inner join ".TB_LINMAS." as t2 on";
  $this->from.=" t1.lincode=t2.lincode";
  $this->where =$this->andwhere;
  $this->group ="t2.lincode,t2.linname,t1.clscode,t1.clsname";
  $this->order =" t2.lincode,t1.clscode";
  $this->items["data"]=$this->getArray();

  for($i=0;$i<count($this->items["data"]);$i++){
   $this->items["data"][$i]["rownum"]=$i;
  }//for


 }// public function getLinClsList(){

//----------------------------------------------------------//
// 特定ラインの商品を抽出
//----------------------------------------------------------//
 public function getLinItem($lincode){
  $this->items=null;

  $this->setwhere();

  $this->select =" t.jcode,t.clscode,t.sname,t.tani,t.stdprice,t.price";
  $this->select.=",salestart,t.lastsale";
  $this->select.=",t1.clscode,t1.clsname";
  $this->select.=",t2.lincode,t2.linname";
  $this->from =TB_JANMAS." as t ";
  $this->from.=" inner join ".TB_CLSMAS." as t1 on";
  $this->from.=" t.clscode=t1.clscode";
  $this->from.=" inner join ".TB_LINMAS." as t2 on";
  $this->from.=" t1.lincode=t2.lincode";
  $this->where =$this->andwhere;
  $this->where.=" and t2.lincode=".$lincode;
  $this->order =" t2.lincode,t1.clscode,t.jcode";
  //$this->order =" t.lastsale desc,t2.lincode,t1.clscode,t.jcode";
  $this->items["data"]=$this->getArray();

  for($i=0;$i<count($this->items["data"]);$i++){
   $this->items["data"][$i]["rownum"]=$i;
   $this->items["data"][$i]["page"]=floor($i/JANMASLIMIT)+1;
  }//for

  $this->setSaleItem();
  //$this->html=html::setitem($this->items["data"]);
 }//public function LinItem($lincode){

//----------------------------------------------------------//
//特定クラスの商品を抽出
//----------------------------------------------------------//
 public function getClsItem($clscode){
  $this->items=null;

  $this->setwhere();

  $this->select =" t.jcode,t.clscode,t.sname,t.tani,t.stdprice,t.price";
  $this->select.=",salestart,t.lastsale";
  $this->select.=",t1.clscode,t1.clsname";
  $this->select.=",t2.lincode,t2.linname";
  $this->from =TB_JANMAS." as t ";
  $this->from.=" inner join ".TB_CLSMAS." as t1 on";
  $this->from.=" t.clscode=t1.clscode";
  $this->from.=" inner join ".TB_LINMAS." as t2 on";
  $this->from.=" t1.lincode=t2.lincode";
  $this->where =$this->andwhere;
  $this->where.=" and t.clscode=".$clscode;
  $this->order =" t2.lincode,t1.clscode,t.jcode";
  //$this->order =" t.lastsale desc,t2.lincode,t1.clscode,t.jcode";
  $this->items["data"]=$this->getArray();

  for($i=0;$i<count($this->items["data"]);$i++){
   $this->items["data"][$i]["rownum"]=$i;
   $this->items["data"][$i]["page"]=floor($i/JANMASLIMIT)+1;
  }//for

  $this->setSaleItem();
  //$this->html=html::setitem($this->items["data"]);

 }//public function getClsItem($clscode){

//----------------------------------------------------------//
//単品を抽出
//----------------------------------------------------------//
 public function getJanItem($jcode){
  $this->items=null;

  $this->setwhere();

  $this->select =" t.jcode,t.clscode,t.sname,t.tani,t.stdprice,t.price";
  $this->select.=",salestart,t.lastsale";
  $this->select.=",t1.clscode,t1.clsname";
  $this->select.=",t2.lincode,t2.linname";
  $this->from =TB_JANMAS." as t ";
  $this->from.=" inner join ".TB_CLSMAS." as t1 on";
  $this->from.=" t.clscode=t1.clscode";
  $this->from.=" inner join ".TB_LINMAS." as t2 on";
  $this->from.=" t1.lincode=t2.lincode";
  $this->where =$this->andwhere;
  $this->where.=" and t.jcode=".$jcode;
  $this->order =" t2.lincode,t1.clscode,t.jcode";
  $this->items["data"]=$this->getArray();

  $this->setSaleItem();

 }//public function getJanItem($jcode){

//----------------------------------------------------------//
//新商品表示(2日前を新商品とする)
//----------------------------------------------------------//
 public function getNewItem(){
  $this->items=null;

  $this->setwhere();
  $this->andwhere.=" and t.salestart>='".date("Y-m-d",strtotime("-2days"))."'";
  $this->select =" t.jcode,t.clscode,t.sname,t.tani,t.stdprice,t.price";
  $this->select.=",salestart,t.lastsale";
  $this->select.=",t1.clscode,t1.clsname";
  $this->select.=",t2.lincode,t2.linname";
  $this->from =TB_JANMAS." as t ";
  $this->from.=" inner join ".TB_CLSMAS." as t1 on";
  $this->from.=" t.clscode=t1.clscode";
  $this->from.=" inner join ".TB_LINMAS." as t2 on";
  $this->from.=" t1.lincode=t2.lincode";
  $this->where =$this->andwhere;
  //$this->order =" t.lastsale desc,t2.lincode,t1.clscode,t.jcode";
  $this->order =" t2.lincode,t1.clscode,t.jcode";
  $this->items["data"]=$this->getArray();

  $this->setSaleItem();
  $this->html=html::setitem($this->items["data"]);


 }//public function getNewItem(){
//----------------------------------------------------------//
//指定単品を除く
//----------------------------------------------------------//
 public function outJan($jcode){
  foreach($this->items["data"] as $rownum=>$rowdata){
   if($rowdata["jcode"]!=$jcode){
    $items[]=$rowdata;
   }//if
  }//foreach

  for($i=0;$i<count($items);$i++){
   $items[$i]["rownum"]=$i;
  }//for

  $this->items["data"]=$items;
 }// public function outJan($jcode){

//----------------------------------------------------------//
//セール商品の価格を反映させる
//----------------------------------------------------------//
 public function setSaleItem(){
  //チラシ商品をゲット
  $this->select="*";
  $this->from =TB_SALEITEMS." as t ";
  $this->where =" t.saleday='".date("Y-m-d")."'";
  $this->where.=" and jcode>0";
  $this->group =" t.jcode";
  $this->order =" t.jcode,t.price desc";
  $items=$this->getArray();
  if(! is_array($items)) return false;
  foreach($this->items["data"] as $rownum=>$rowdata){
   foreach($items as $rownum1=>$rowdata1){
    if($rowdata["jcode"]==$rowdata1["jcode"]){
     if($rowdata["price"]>$rowdata1["price"]){
      $this->items["data"][$rownum]["price"]=$rowdata1["price"];
      $this->items["data"][$rownum]["tani"] =$rowdata1["tani"];
      $this->items["data"][$rownum]["notice"] =$rowdata1["notice"];
      $this->items["data"][$rownum]["saletype"] =$rowdata1["saletype"];
     }//if
    }//if
   }//foreach
  }//foreach
 }//public function setSaleItem(){

}//JANMAS

?>
