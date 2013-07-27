<?php
require_once("db.class.php");
class SALE extends db{
 public $saleday;
 public $items;
 function __construct(){
  parent::__construct();
  $this->saleday=date("Y-m-d");
 }//function 

 public function gettopitem(){
  $this->select="t.*";
  $this->from =TB_SALEITEMS." as t ";
  $this->from.=" inner join( ";
  $this->from.=" select saletype,min(id) as id from ".TB_SALEITEMS;
  $this->from.=" where saleday='".$this->saleday."'";
  $this->from.=" group by saletype";
  $this->from.=" ) as t1 on ";
  $this->from.=" t.id=t1.id ";
  $this->where="t.saleday='".$this->saleday."'";
  $this->order ="t.saletype";
  $this->getArray();
  $this->items["data"]=$this->ary;
 }//public function getToday(){
}//class
?>
