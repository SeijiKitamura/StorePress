<?php
//----------------------------------------------------------//
//  calendar.class.php 
//  カレンダー系クラス(db.class.phpをスーパークラス)
//  このクラスを使用するときは必ずtry catchを使用すること
//----------------------------------------------------------//
//メソッド一覧
//----------------------------------------------------------//
//  getLinList()         指定月のラインリストを返す
//  getClsList()         指定月、指定ラインのクラスリストを返す
//  getItemList()        指定月のカレンダー情報を返す
//  getLinItem($lincode) 指定月、指定ラインのカレンダー情報を返す
//  getClsItem($clscode) 指定月、指定クラスのカレンダー情報を返す
//  getCalendar()        指定日のカレンダー情報を返す
//  getMonthCount()      指定月に何回カレンダー情報があるかを返す
//----------------------------------------------------------//
require_once("db.class.php");
require_once("janmas.class.php");
require_once("function.php");
require_once("html.class.php");

class CL extends DB{
 public $items;   //データを格納
 public $saleday; //表示したい日
 public $clscode; //表示したいクラス

 protected $saletype;//セールタイプ番号
 protected $andwhere;//where句
 
 function __construct(){
  parent::__construct();

  //表示したい日
  if(! $this->saleday) $this->saleday=date("Y-m-d");
  
  //セールタイプ番号ゲット
  $this->saletype=3;

 }//__construct
 
 protected function setwhere(){
  $uk=strtotime($this->saleday);
  $sday=date("Y-m-1",$uk);
  $eday=date("Y-m-d",mktime(0,0,0,(date("m",$uk)+1),0,date("Y",$uk)));
  $this->andwhere =" saleday between '".$sday."' and '".$eday."'";
  $this->andwhere.=" and saletype=".$this->saletype;
 }

 protected function setwhere2(){
  $this->andwhere =" saleday ='".$this->saleday."'";
  $this->andwhere.=" and saletype=".$this->saletype;
 }

//----------------------------------------------------------//
// 指定月のラインリストを返す
// (cntは指定月に何回特売があるかを示す）
//----------------------------------------------------------//
 public function getLinList(){
  $this->items=null;

  $this->setwhere();

  $this->select ="t3.lincode,t3.linname,count(t3.saleday) as cnt";
  $this->from =" (select t2.lincode,t2.linname,t.saleday from ";
  $this->from.=" (select saleday,clscode from ".TB_SALEITEMS;
  $this->from.=" where ".$this->andwhere;
  $this->from.=" ) as t";
  $this->from.=" inner join ".TB_CLSMAS." as t1 on";
  $this->from.=" t.clscode=t1.clscode";
  $this->from.=" inner join ".TB_LINMAS." as t2 on";
  $this->from.=" t1.lincode=t2.lincode";
  $this->from.=" group by t2.lincode,t2.linname,t.saleday ) as t3";
  $this->group =" t3.lincode,t3.linname";
  $this->order =" t3.lincode";
  $this->items["data"]=$this->getArray();
 }//public function getLinList(){

//----------------------------------------------------------//
// 指定月、指定ラインのクラスリストを返す
// (cntはそのクラスに何アイテムあるかを示す）
//----------------------------------------------------------//
 public function getClsList($lincode){
  $this->items=null;

  $this->setwhere();

  $this->select =" t2.clscode,t2.clsname,t1.cnt ";
  $this->from =" (select clscode from ".TB_SALEITEMS;
  $this->from.=" where ".$this->andwhere;
  $this->from.=" group by clscode ";
  $this->from.=" ) as t";
  $this->from.=" inner join ";
  $this->from.=" (select clscode,count(jcode) as cnt from ".TB_JANMAS;
  $this->from.="  group by clscode) as t1 on ";
  $this->from.=" t.clscode=t1.clscode";
  $this->from.=" inner join ".TB_CLSMAS." as t2 on";
  $this->from.=" t1.clscode=t2.clscode ";
  $this->from.=" inner join ".TB_LINMAS." as t3 on";
  $this->from.=" t2.lincode=t3.lincode";
  $this->where=" t2.lincode=".$lincode;
  $this->order =" t1.clscode";
  $this->items["data"]=$this->getArray();

 }//public function getClsList(){


//----------------------------------------------------------//
// 指定日の月以降の年月リストを返す
//----------------------------------------------------------//
 public function getMonthList(){
  $uk=strtotime($this->saleday);
  $sday=date("Y-m-1",$uk);
  $this->andwhere =" saleday >= '".$sday."'";
  $this->andwhere.=" and saletype=".$this->saletype;
  $this->select="t.nen,t.tuki,count(saleday) as cnt";
  $this->from ="  (select";
  $this->from.="  date_format(saleday,'%Y') as nen";
  $this->from.=" ,date_format(saleday,'%m') as tuki";
  $this->from.=" ,saleday";
  $this->from.=" ,sname";
  $this->from.=" from ".TB_SALEITEMS;
  $this->from.=" where ".$this->andwhere;
  $this->from.=" group by ";
  $this->from.="  date_format(saleday,'%Y')";
  $this->from.=" ,date_format(saleday,'%m')";
  $this->from.=" ,saleday";
  $this->from.=" ,sname) as t";
  $this->group=" t.nen,t.tuki";
  $this->order=" t.nen,t.tuki";
  $this->items["data"]=$this->getArray();
 }//public function getMonthList(){

//----------------------------------------------------------//
// 指定月のカレンダー情報を返す
//----------------------------------------------------------//
 public function getItemList(){
  $this->items=null;

  $this->setwhere();

  $this->select =" t.saleday,t.clscode,t.sname";
  $this->select.=",t.tani,t.price,t.notice,t.flg0";
  $this->select.=",t1.clsname";
  $this->select.=",t2.lincode,t2.linname";
  $this->from =" (select * from ".TB_SALEITEMS;
  $this->from.=" where ".$this->andwhere;
  $this->from.=" ) as t";
  $this->from.=" inner join ".TB_CLSMAS." as t1 on";
  $this->from.=" t.clscode=t1.clscode";
  $this->from.=" inner join ".TB_LINMAS." as t2 on";
  $this->from.=" t1.lincode=t2.lincode";
  $this->where =$this->andwhere;
  $this->order =" t.saleday,t.clscode";

  $this->items["data"]=$this->getArray();
 }//public function getItemList(){

//----------------------------------------------------------//
//指定月の特定ラインの商品を抽出
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
//指定月の特定クラスの商品を抽出
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
//指定日の商品を抽出
//----------------------------------------------------------//
 public function getCalendar(){
  $this->items=null;

  //データゲット
  $this->getItemList();
  
  //該当商品抽出
  if(! $this->items["data"]) return false;

  foreach($this->items["data"] as $rownum=>$rowdata){
   if(strtotime($rowdata["saleday"])==strtotime($this->saleday)){
    $item[]=$rowdata;
   }//if
  }//foreach

  $this->items["data"]=$item;
 }//public function getClsItem($clscode){


//----------------------------------------------------------//
//指定月に何回カレンダー情報があるかを返す
//----------------------------------------------------------//
 public function getMonthCount(){
  $this->items=null;

  //データゲット
  $this->getItemList();

  $saleday=0;
  $cnt=0;
  foreach($this->items["data"] as $rownum=>$rowdata){
   if(strtotime($saleday)!==strtotime($rowdata["saleday"])){
    $cnt++;
   }//if
   $saleday=$rowdata["saleday"];
  }//foreach

  $this->items=null;
  $nen=date("Y",strtotime($this->saleday));
  $tuki=date("m",strtotime($this->saleday));
  $this->items["data"]["nen"]=$nen;
  $this->items["data"]["tuki"]=$tuki;
  $this->items["data"]["cnt"]=$cnt;
 }//public function getMonthCount(){
 
//----------------------------------------------------------//
//カレンダーHTMLを作成する
//----------------------------------------------------------//
 public function setHTML(){
  //登録されているデータをゲット
  $this->select="saleday";
  $this->from =TB_SALEITEMS;
  $this->where="saletype=".$this->saletype;
  $this->group=$this->select;
  $this->order=$this->select;
  $daylist=$this->getArray();

  if(! is_array($daylist)){
   //YYYYMM.htmlを削除
   return false;
  }//if

  $nen=0;
  $tuki=0;
  foreach ($daylist as $rownum=>$rowdata){
   if($tuki!=date("m",strtotime($rowdata["saleday"]))){
    $this->saleday=$rowdata["saleday"];
    $this->getItemList();
    $html=html::setcalendar($this->items["data"]);
    $filename=SITEDIR.HOME.date("Y",strtotime($rowdata["saleday"])).date("m",strtotime($rowdata["saleday"])).".html";
    file_put_contents($filename,$html);
   }//if
      
   $nen=date("Y",strtotime($rowdata["saleday"]));
   $tuki=date("m",strtotime($rowdata["saleday"]));
  }//foreach
 }//public function setHTML(){

//----------------------------------------------------------//
//1ヶ月分のカレンダー情報を表示(flg0 タイトルを表示）
//----------------------------------------------------------//
 public function getDayEvent(){
  $this->items=null;

  $this->setwhere();

  $this->select="t.saleday,t.flg0 as sname,t.tani,t.price,t.notice ";
  $this->from=TB_SALEITEMS." as t ";
  $this->where=$this->andwhere;
  $this->group="t.saleday,t.flg0,t.tani,t.price,t.notice";
  $this->order="t.saleday";
  $this->items["data"]=$this->getArray();
 }// public function getDayEvent(){

//----------------------------------------------------------//
//単日のアイテムを表示(）
//----------------------------------------------------------//
 public function getDayItem(){

  $this->items=null;

  $this->setwhere2();

  //該当日のデータをゲット
  $this->select ="t.saleday,t.clscode,t.jcode,t.maker,t.sname";
  $this->select.=",t.tani,t.price,t.notice,t.flg0";
  $this->select.=",t1.clsname";
  $this->from =TB_SALEITEMS ." as t";
  $this->from.=" inner join ".TB_CLSMAS." as t1 on";
  $this->from.=" t.clscode=t1.clscode";
  $this->where=$this->andwhere;
  $this->order="t.saleday,t.clscode";
  $list=$this->getArray();
  
  if(! $list) return false;
 
  $itemlist=null;
  foreach($list as $row=>$rowdata){
   //JANが有効ならアイテムリストを作成
   if($rowdata["jcode"]){
    $itemlist[]=$rowdata;
   }//if

   $clslist[]=$rowdata;
  }//foreach
  
  //アイテムリストが無効なら最初のクラスのアイテムを抽出
  //($clscodeが指定されていればclscodeを優先)
  if(! $itemlist){
   $lastsale=date("Y-m-d",strtotime("-".SALESTART."days"));

   $this->select =" t.clscode,t.jcode,t.maker,t.sname";
   $this->select.=",t.tani,t.stdprice as price,t.lastsale";
   $this->from =TB_JANMAS." as t";

   //クラスコードセット
   if($this->clscode) $this->where="t.clscode=".$this->clscode;
   else $this->where="t.clscode=".$clslist[0]["clscode"];
   $this->where.=" and t.lastsale>='".$lastsale."'";

   $this->order="t.clscode,t.stdprice,t.jcode";

   $itemlist=$this->getArray();

  }//if

  if(preg_match("/割引|半額/",$clslist[0]["price"])){
   $notice="表示価格より".$clslist[0]["price"]."となります。";
  }//if

  if(preg_match("/P[0-9]+倍/",$clslist[0]["price"],$match)){
   $notice="さらに".$clslist[0]["price"]."となります。";
  }

  for($i=0;$i<count($itemlist);$i++){
   $itemlist[$i]["notice"]=$notice;
   $itemlist[$i]["lastsale"]=$this->saleday;
  }//for
  $this->items["data"]["clscode"]=$clslist;
  $this->items["data"]["item"]=$itemlist;


 }//public function getDayItem(){
}//CL

?>
