<?php
require_once("config.php");
require_once("function.php");
require_once("db.class.php");
require_once("calendar.class.php");
require_once("html.class.php");

class ImportData extends db{
 public $filename; //読み込むファイル名
 public $tablename;   //テーブル名
 public $items;       //CSVデータ

 private $csvfilepath; //CSVファイルパス
 private $csvcol;      //CSV列情報
 private $csvdata;     //CSVデータ
 private $tablecol;    //テーブル列情報

 function __construct(){
  parent::__construct();
 }//function __construct(){
 
//---------------------------------------------------------//
// CSVファイルを変数へ格納
// $this->items["data"][データ数][列名][値]
// $this->items["data"][データ数][status][true|false]
// $this->items["data"][データ数][err][エラー内容]
// $this->csvdata[データ数][列番号][値]
//---------------------------------------------------------//
 public function getData(){
  //メンバセット
  $this->csvfilepath=DATADIR.$this->filename.".csv";
  $this->csvcol     =$GLOBALS["CSVCOLUMNS"][$this->filename];
  $this->tablecol   =$GLOBALS["TABLES"][$this->tablename];
  $this->items=null;
  $this->csvdata=null;

  //エラーチェック
  if(! file_exists($this->csvfilepath)){
   throw new exception($this->csvfilepath."が存在しません");
  }//if

  if(! $this->csvcol){
   throw new exception($this->csvcol.":CSV列情報が存在しません");
  }//if

  if(! $this->tablecol){
   throw new exception($this->tablecol.":テーブル列情報が存在しません");
  }//if

  //CSVファイル読み込み($csvdataへ格納)
  if(! $fl=fopen($this->csvfilepath,"r")){
   throw new exception ($this->csvfilepath.":ファイルが開けません");
  }//if

  while($line=fgets($fl)){
   $line=str_replace("\n","",$line);
   $line=str_replace("\r","",$line);
   $line=mb_convert_encoding($line,"UTF-8","SJIS");
   $this->csvdata[]=explode(",",$line);
  }//while

  if(! $this->csvdata){
   //throw new exception ($this->csvfilepath.":データが空ですよ...");
  }
  //列情報をもとに$this->itemsへ格納
  foreach($this->csvdata as $rownum=>$rowdata){
   foreach($rowdata as $colnum=>$val){
    $colname=$this->csvcol[$colnum];
    $this->items["data"][$rownum][$colname]=$val;
   }//foreach
  }//foreach

  //データ整合性チェック($this->items[i]["err"]へ格納)
  foreach($this->items["data"] as $rownum =>$rowdata){
   foreach($rowdata as $col=>$val){
    $msg=null;
    if(! CHKTYPE($this->tablecol[$col]["type"],$val)){
     $msg=$this->tablecol[$col]["local"]."の値が不正です";
    }//if

    //JANコード
    if($col==="jcode"){
     if(! $jcode=GETJAN($val)){
      $msg="JANコードの値が不正です";
     }//if
     $this->items["data"][$rownum][$col]=$jcode;
    }//if
    if(! $msg) $this->items["data"][$rownum]["status"]=true;
    else{
     $this->items["data"][$rownum]["status"]=false;
     $this->items["data"][$rownum]["err"]=$msg;
    }//else
   }//foreach
  }//foreach
 }//function getData(){

//---------------------------------------------------------//
// 商品マスタをデータを更新
// 更新方法:既存データ上書き
//---------------------------------------------------------//
 public function setJanMas(){
  $this->filename=JANMAS;
  $this->tablename=TB_JANMAS;

  //データゲット
  $this->getData();

  try{
   //トランザクション開始
   $this->BeginTran();

   //データ更新
   foreach($this->items["data"] as $rownum =>$rowdata){
    if (! $rowdata["status"]) continue;  //エラーデータを除く

    foreach($rowdata as $col=>$val){
     //ステータス列、エラー列を除く
     if($col==="status"||$col==="err") continue;
     $this->updatecol[$col]=$val;
    }//foreach
    $this->from=TB_JANMAS;
    $this->where="jcode=".$rowdata["jcode"]; //既存データ上書き
    $this->update();
   }//foreach($this->items["data"] as $rownum =>$rowdata){
   //コミット
   $this->Commit();

  }//try
  catch(Exception $e){
   $this->RollBack();
   throw $e;
  }//catch

 }//public function setTitle(){

//---------------------------------------------------------//
// 売価更新(既存マスタのみ更新)
// 更新方法:既存データ上書き
//---------------------------------------------------------//
 public function setJanPrice(){
  $this->filename=JANPRICE;
  $this->tablename=TB_JANMAS;

  //データゲット
  $this->getData();
  try{
   //トランザクション開始
   $this->BeginTran();

   //データ更新
   foreach($this->items["data"] as $rownum =>$rowdata){
    if (! $rowdata["status"]) continue;  //エラーデータを除く

    //既存データかつ売価が変更されている商品を抽出
    //(これをしないと新規として登録されてしまう)
    $this->select="jcode";
    $this->from =TB_JANMAS;
    $this->where ="jcode='".$rowdata["jcode"]."'";
    $this->where.=" and price <>".$rowdata["price"];
    if($this->getArray()){
     //データ更新
     foreach($rowdata as $col=>$val){
      //ステータス列、エラー列を除く
      if($col==="status"||$col==="err") continue;
      $this->updatecol[$col]=$val;
     }//foreach
     $this->from=TB_JANMAS;
     $this->where="jcode=".$rowdata["jcode"]; //既存データ上書き
     $this->update();
    }//if($this->getArray()){
   }//foreach($this->items["data"] as $rownum =>$rowdata){
   //コミット
   $this->Commit();
  }//try
  catch(Exception $e){
   $this->RollBack();
   throw $e;
  }//catch
 
 }//public function setJanPrice(){

//---------------------------------------------------------//
// ラインマスタ更新
// 更新方法:該当データを全削除後、CSVデータを登録
//---------------------------------------------------------//
 public function setLinMas(){
  $this->filename=LINMAS;
  $this->tablename=TB_LINMAS;

  //データゲット
  $this->getData();
  
  try{
   //トランザクション開始
   $this->BeginTran();

   //データ削除
   $this->from=$this->tablename;
   $this->where="lincode>0";
   $this->delete();

   //データ更新
   foreach($this->items["data"] as $rownum=>$rowdata){
    if (! $rowdata["status"]) continue;  //エラーデータを除く
    foreach($rowdata as $col=>$val){
     if($col=="status") continue;
     //echo $col." ".$val."\n";
     $this->updatecol[$col]=$val;
    }//foreach
    $this->from=$this->tablename;
    $this->where="lincode=0";
    $this->update();
   }//foreach
   $this->Commit();
  }//try
  catch(Exception $e){
   $this->RollBack();
   throw $e;
  }//catch
 }// public function setLinMas(){

//---------------------------------------------------------//
// クラスマスタ更新
// 更新方法:該当データを全削除後、CSVデータを登録
//---------------------------------------------------------//
 public function setClsMas(){
  $this->filename=CLSMAS;
  $this->tablename=TB_CLSMAS;

  //データゲット
  $this->getData();
  
  try{
   //トランザクション開始
   $this->BeginTran();

   //データ削除
   $this->from=$this->tablename;
   $this->where="clscode>0";
   $this->delete();

   //データ更新
   foreach($this->items["data"] as $rownum=>$rowdata){
    if (! $rowdata["status"]) continue;  //エラーデータを除く
    foreach($rowdata as $col=>$val){
     if($col=="status") continue;
     //echo $col." ".$val."\n";
     $this->updatecol[$col]=$val;
    }//foreach
    $this->from=$this->tablename;
    $this->where="clscode=0";
    $this->update();
   }//foreach
   $this->Commit();
  }//try
  catch(Exception $e){
   $this->RollBack();
   throw $e;
  }//catch
 }// public function setClsMas(){

//---------------------------------------------------------//
// アイテム更新
// 更新方法:該当データを全削除後、CSVデータを登録
//---------------------------------------------------------//
 public function setSaleItems(){
  $this->filename=SALEITEMS;
  $this->tablename=TB_SALEITEMS;

  //データゲット
  $this->getData();
  
  try{
   //トランザクション開始
   $this->BeginTran();

//   //データ削除
//   $this->from=$this->tablename;
//   $this->where="id>0";
//   $this->delete();

   //データ更新
   $saleday=null;
   $saletype=null;
   foreach($this->items["data"] as $rownum=>$rowdata){
    if($rowdata["saleday"]!=$saleday || $rowdata["saletype"]!=$saletype){
     $saleday=$rowdata["saleday"];
     $saletype=$rowdata["saletype"];
     $this->from=$this->tablename;
     $this->where="saleday='".$saleday."' and saletype=".$saletype;
     $this->delete();
    }//if

    if (! $rowdata["status"]) continue;  //エラーデータを除く
    foreach($rowdata as $col=>$val){
     if($col=="status") continue;
     //echo $col." ".$val."\n";
     $this->updatecol[$col]=$val;
    }//foreach
    $this->from=$this->tablename;
    $this->where="id=0";
    $this->update();
   }//foreach
   $this->Commit();
  }//try
  catch(Exception $e){
   $this->RollBack();
   throw $e;
  }//catch
 }// public function setSaleItems(){

//---------------------------------------------------------//
// ページ情報を更新
// 更新方法:該当データを全削除後、CSVデータを登録
//---------------------------------------------------------//
 public function setPageConf(){
  $this->filename=PAGECONF;
  $this->tablename=TB_PAGECONF;

  //データゲット
  $this->getData();
  
  try{
   //トランザクション開始
   $this->BeginTran();

   //データ削除
   $this->from=TB_PAGECONF;
   $this->where="id>0";
   $this->delete();

   //データ更新
   foreach($this->items["data"] as $rownum=>$rowdata){
    if (! $rowdata["status"]) continue;  //エラーデータを除く
    foreach($rowdata as $col=>$val){
     if($col=="status") continue;
     //echo $col." ".$val."\n";
     $this->updatecol[$col]=$val;
    }//foreach
    $this->from=TB_PAGECONF;
    $this->where="id=0";
    $this->update();
   }//foreach
   $this->Commit();
  }//try
  catch(Exception $e){
   $this->RollBack();
   throw $e;
  }//catch
 }// public function setPageConf(){

//---------------------------------------------------------//
// 店舗情報を更新
// 更新方法:該当データを全削除後、CSVデータを登録
//---------------------------------------------------------//
 public function setStore(){
  $this->filename=STORE;
  $this->tablename=TB_STORE;

  //データゲット
  $this->getData();
  
  try{
   //トランザクション開始
   $this->BeginTran();

   //データ削除
   $this->from=TB_STORE;
   $this->where="id>0";
   $this->delete();

   //データ更新
   foreach($this->items["data"] as $rownum=>$rowdata){
    if (! $rowdata["status"]) continue;  //エラーデータを除く
    foreach($rowdata as $col=>$val){
     if($col=="status") continue;
     //echo $col." ".$val."\n";
     $this->updatecol[$col]=$val;
    }//foreach
    $this->from=TB_STORE;
    $this->where="id=0";
    $this->update();
   }//foreach
   $this->Commit();
  }//try
  catch(Exception $e){
   $this->RollBack();
   throw $e;
  }//catch
 }// public function setPageConf(){


}//class IMPORTDATA extends db{

?>
