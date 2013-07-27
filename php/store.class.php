<?php
// ================================================================= //
//                   データ抽出クラス　                              //
// ================================================================= //
require_once("php/db.class.php");

class STOREDATA extends DB{
 public    $items;   //データを格納
 protected $colarray;//抽出したい列を格納
 function __construct(){
  parent::__construct();
 }//function __construct(){

 protected function getInfo(){
  $this->select="colname,jpnname,val";
  $this->from =TB_STORE;
  $i=0;
  foreach ($this->colarray as $rows =>$row){
   if($this->where) $this->where.=" or ";
   $this->where.=" colname='".$row."' ";

   if(! $this->order) $this->order=" case ";
   $this->order.=" when colname='".$row."' then ".$i." ";
   $i++;
  }
  $this->order.=" else 99";
  $this->order.=" end";
  $this->items["data"]=$this->getArray();

  //デバック用
  //echo "where ".$this->where."<br />";
  //echo "order ".$this->order."<br />";
 }//public function getInfo(){
 
 public function getInfo1(){
  $this->colarray=array("opentime","address");
  $this->getInfo();
 }// public function getInfo1(){
}// class STOREDATA extends DB{
?>
