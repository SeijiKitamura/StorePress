<?php
//----------------------------------------------------------//
//  clsmas.class.php 
//  商品マスタ系クラス(db.class.phpをスーパークラス)
//  このクラスを使用するときは必ずtry catchを使用すること
//----------------------------------------------------------//
//  メソッド一覧
//  checkData()     CSVファイルのデータ整合性をチェック
//  setData()       CSVファイルをDBへ登録
//----------------------------------------------------------//
require_once("db.class.php");
require_once("function.php");

class CLSMAS extends DB{
 public  $items;   //データを格納
 private $columns;//テーブル情報
 private $csvcol; //CSV列情報
 public  $linmas; //lincodeマスター
 public  $clsmas; //clscodeマスター

 function __construct(){
  parent::__construct();
 }//__construct

 //---------------------------------------------------------//
 // CSVファイル分割
 // 以下の列順で並んでいるCSVファイルを分割する
 // 分割前:lincode,linname,clscode,clsname
 // 分割1 :lincode,linname,0
 // 分割2 :clscode,clsname,lincode
 // 返り値:true false
 //---------------------------------------------------------//
 public function splitCsv(){
  //初期化
  $this->linmas=null;
  $this->clsmas=null;

  //アップロードされたCSVをDATADIRへコピーし文字コード変換
  UPLOADCSV(CLSMAS);

  //ファイル読み込み
  $filepath=DATADIR.CLSMAS.".csv";

  if(! $data=file($filepath)) throw new exception("ファイル読み込みに失敗しました");

  //分割開始
  foreach($data as $key=>$line){
   //改行削除
   if(! $line=str_replace("\n","",$line)){
    throw new exception("改行コード削除に失敗しました。");
   }//if

   //カンマ区切りをデータ化
   if(! $line=explode(",",$line)) throw new exception("カンマ区切りの分割に失敗しました");

   //分割1
   $this->linmas[]=array($line[0],$line[1],0);

   //分割2
   $this->clsmas[]=array($line[2],$line[3],$line[0]);

  }//foreach

  //配列をCSVに変換
  $line="";
  foreach($this->linmas as $key=>$col){
   $line.=$col[0].",".$col[1].",".$col[2]."\n";
  }//foreach
  if(! file_put_contents(LINCSV,$line)) throw new exception(LINCSV."ファイルの保存に失敗しました");

  $line="";
  foreach($this->clsmas as $key=>$col){
   $line.=$col[0].",".$col[1].",".$col[2]."\n";
  }//foreach
  if(! file_put_contents(CLSCSV,$line)) throw new exception(CLSCSV.".csvファイルの保存に失敗しました");

  return true;
 }

 //---------------------------------------------------------//
 // CSVファイルの整合性をチェック
 // 返り値:true false
 //       :$this->items[data]   CSVデータを格納
 //       :$this->items[local]  列名を格納
 //       :$this->items[status] データの状態を格納(true false)
 //---------------------------------------------------------//
 public function checkData($csvpath,$csvcol){
  //データ初期化
  $this->items=null;

  //CSVファイルをゲット
  //(入力した値に不正があれば配列[err]にエラーメッセージが付加される)
  //$this->items=CHKDATA($csvpath,$csvcol);//function.php内参照
  $this->items=GETARRAYCSV($csvpath,$csvcol);//function.php内参照
  return true;
 }//checkData

 //---------------------------------------------------------//
 // CSVファイルをDBへ登録
 // 返り値:true false
 //       :$this->items[data]   CSVデータを格納
 //       :$this->items[local]  列名を格納
 //       :$this->items[status] データの状態を格納(true false)
 //---------------------------------------------------------//
 public function setDataCLS(){
  $this->columns=null;
  $this->csvcol=null;
  //テーブル列情報ゲット
  $this->columns=$GLOBALS["TABLES"][TB_CLSMAS];
  if(! $this->columns){
   $msg="テーブル情報がありません。設定を見直してください。";
   throw new exception($msg);
  }

  //CSV列情報ゲット
  $this->csvcol =$GLOBALS["CSVCOLUMNS"][TB_CLSMAS];
  if(! $this->csvcol){
   $msg="CSV列情報がありません。設定を見直してください。";
   throw new exception($msg);
  }

  //データ初期化
  $this->items=null;

  //CSVファイルをゲット
  $this->checkData(CLSCSV,TB_CLSMAS);
  
  //データ登録
  try{
   $this->BeginTran();
   //全クラス削除
   $this->from=TB_CLSMAS;
   $this->where="clscode>0";
   $this->delete();
   
   foreach($this->items["data"] as $rownum=>$row){
    //SQL生成
    foreach($this->csvcol as $colnum=>$colname){
     $this->updatecol[$colname]=$row[$colname];
    }//foreach
    $this->from=TB_CLSMAS;
    $this->where="clscode=".$row["clscode"];
    $this->update();
   }//foreach

   $this->Commit();
  }//try
  catch(Exception $e){
   $this->RollBack();
   $this->items["status"]=false;
   throw $e;
  }
 }//setDataCLS

 //---------------------------------------------------------//
 // CSVファイルをDBへ登録
 // 返り値:true false
 //       :$this->items[data]   CSVデータを格納
 //       :$this->items[local]  列名を格納
 //       :$this->items[status] データの状態を格納(true false)
 //---------------------------------------------------------//
 public function setDataLIN(){
  $this->columns=null;
  $this->csvcol=null;
  //テーブル列情報ゲット
  $this->columns=$GLOBALS["TABLES"][TB_LINMAS];
  if(! $this->columns){
   $msg="テーブル情報がありません。設定を見直してください。";
   throw new exception($msg);
  }

  //CSV列情報ゲット
  $this->csvcol =$GLOBALS["CSVCOLUMNS"][TB_LINMAS];
  if(! $this->csvcol){
   $msg="CSV列情報がありません。設定を見直してください。";
   throw new exception($msg);
  }

  //データ初期化
  $this->items=null;

  //CSVファイルをゲット
  $this->checkData(LINCSV,TB_LINMAS);

  //データ存在チェック
  if(! $this->items["data"]) throw new exception("データがありません");

  //データ登録
  try{
   $this->BeginTran();
   //全データ削除
   $this->from=TB_LINMAS;
   $this->where="lincode>0";
   $this->delete();

   foreach($this->items["data"] as $rownum=>$row){
    if($row["err"]!=="OK"){
     $row["rownum"]=$rownum;
     $this->items["errdata"][]=$row;
     continue;
    }
    if($lincode!==$row["lincode"]){
     foreach($this->csvcol as $colnum=>$colname){
      $this->updatecol[$colname]=$row[$colname];
     }//foreach
     $this->from=TB_LINMAS;
     $this->where="lincode=".$row["lincode"];
     $this->update();
    }//if
    $lincode=$row["lincode"];
   }//foreach
   $this->Commit();
  }//try
  catch(Exception $e){
   $this->RollBack();
   $this->items["status"]=false;
   throw $e;
  }//catch
/*
  //if(! $this->items["status"]) return false;
  //エラーフラグ
  $flg=0;

  //CSVのlincode列をゲット
  for($i=0;$i<count($this->csvcol);$i++){
   if($this->csvcol[$i]==="lincode"){
    $clscol=$i;
    $flg=1;
    break;
   }
  }//for

  if(! $flg){
   $this->items["status"]=false;
   $msg="クラスコード列がありません。設定を見なおしてください config CSVCOLUMNS";
   throw new exception($msg);
  }//if
  
  try{
   $this->BeginTran();
   //全データ削除
   $this->from=TB_LINMAS;
   $this->where="lincode>0";
   $this->delete();

   //データ登録
   for($i=0;$i<count($this->items["data"]);$i++){
    //エラーデータチェック
    if($this->items["data"][$i]["err"]!="OK"){
     $this->items["errdata"][$i]=$this->items["data"][$i];
     continue;
    }
    //UPDATEデータ生成
    foreach($this->csvcol as $key=>$val){
     $this->updatecol[$val]=$this->items["data"][$i][$key];
    }//foreach
    $this->from=TB_LINMAS;
    $this->where="lincode=".$this->items["data"][$i][$clscol];
    $this->update();
   }//for

   //
   $this->Commit();

   return true;
  }//try
  catch(Exception $e){
   $this->RollBack();
   $this->items["status"]=false;
   throw $e;
  }//catch
*/
 }//setDataLIN
}//CLSMAS
?>
