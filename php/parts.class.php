<?php
require_once("html.class.php");

class parts extends html{

 function __construct(){
  parent::__construct();
 }//function __construct(){

//----------------------------------------------------------//
// ロゴイメージ作成
// $this->divにロゴイメージ(id=logoimg)が作成される
//----------------------------------------------------------//
 public function getLogo(){
  //店舗情報ゲット
  $this->getStoreInfo();
  //$store=$this->items["data"][0];
  $store=$this->items["data"];

  //ロゴイメージ用div作成
  $this->creatediv("id","logoimg");

  //ロゴイメージ作成
  foreach($store as $rows =>$row){
   if($row["colname"]=="logo"){
    $logourl=$row["val"];
   }//if
   if($row["colname"]=="storename"){
    $storename=$row["val"];
   }//if
  }//foreach
  $this->create_img(IMG.$logourl,$storename,$storename);

  //ロゴイメージをdivへ追加
  $this->append("logoimg");
 }//public function getLogo(){

//----------------------------------------------------------//
// グループリスト作成
// $this->div(div.group)にグループリスト(ul)が作成される
//----------------------------------------------------------//
 public function getGroup($group,$me){
  $this->getGroupList($group);
  $data=$this->items["data"];
  $this->items=null;
  foreach($data as $rows=>$row){
   $this->items["data"][]=array( "url"=>$row["url"]
                                ,"val"=>$row["title"]);
  }//foraech

  //ulをセット
  $this->getul($this->items["data"],$me);

  //
  $this->creatediv("class","group");
  $this->append("group");
 }//public function getGroup($group){

//----------------------------------------------------------//
// 営業時間リスト作成
// $this->div(div.eigyo)に作成される
//----------------------------------------------------------//
 public function getEigyo(){
  $this->creatediv("class","eigyo");
  $this->getStoreInfo();
  $ary=array("opentime","address","telephone");
  foreach($this->items["data"] as $rows=>$row){
   foreach($ary as $rows2=>$row2){
    if($row["colname"]==$row2){
     $this->create_span($row["jpnname"]);
     $this->addelement("span",$row["val"]."<br />");
     $this->append("eigyo");
     break;
    }//if
   }//foreach
  }//foreach

 }//public function getEigyo(){

}//class parts extends html{
?>
