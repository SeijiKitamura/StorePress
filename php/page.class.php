<?php
require_once("config.php");
require_once("db.class.php");
require_once("html.class.php");

class PAGE extends DB{
 public $pagename;
 public $items;
 public $rtnhtml;

 function __construct(){
  parent::__construct();
 }//__construct

//-------------------------------------------------------//
// グループごとのページ詳細を返す                        //
//-------------------------------------------------------//
 public function getGroup($group){
  $this->items=null;
  //attrをゲット
  $this->select ="attr";
  $this->from =TB_PAGECONF;
  $this->group =$this->select;
  $this->getArray();
  $attr=$this->ary;

  $this->items=null;
  $this->select =" t.pagename";
  foreach($attr as $rowcnt =>$rowdata){
   $this->select.=",max(case when t.attr='".$rowdata["attr"]."' then t.val else '' end ) as `".$rowdata["attr"]."`";
  }//foreach
  $this->from =TB_PAGECONF." as t ";
  $this->from.="inner join (";
  $this->from.=" select pagename,val from ".TB_PAGECONF;
  $this->from.=" where attr='group' and val='".$group."'";
  $this->from.=" group by pagename,val) as t1 on";
  $this->from.=" t.pagename=t1.pagename";
  $this->group=" t.pagename";
  $this->order=" case when t.attr='page' then t.val else 999999 end";
  $this->getArray();
  $this->items=$this->ary;
 }// public function getGroup($flg0){

//-------------------------------------------------------//
// 単一のページ詳細を返す                                //
//-------------------------------------------------------//
 public function getPage($page){
  $this->items=null;
  //attrをゲット
  $this->select ="attr";
  $this->from =TB_PAGECONF;
  $this->group =$this->select;
  $this->getArray();
  $attr=$this->ary;

  $this->items=null;
  $this->select =" t.pagename";
  foreach($attr as $rowcnt =>$rowdata){
   $this->select.=",max(case when t.attr='".$rowdata["attr"]."' then t.val else '' end ) as `".$rowdata["attr"]."`";
  }//foreach
  $this->from =TB_PAGECONF." as t ";
  $this->where=" t.pagename='".$page."'";
  $this->group=" t.pagename";
  $this->order=" case when t.attr='flg1' then t.val else 999999 end";
  $this->getArray();
  $this->items=$this->ary;
 }// public function getPage($page){
 

//-------------------------------------------------------//
// ヘッダーを返す                                        //
//-------------------------------------------------------//
 public function setHeader($base){
  //ページ情報をゲット
  $this->getPage($base);
  $head=$this->items[0];

  //ページ上部のナビゲーションリンクをゲット
  $this->getGroup(1);
  $topgrp=$this->items;
  
  $html =html::sethead($head);
  $html.=html::setheader($base,$topgrp);

  //タイトルに単品名を表示させるため、ここでは出力しない。
  //各ページにて表示するように仕様変更
  $this->rtnhtml=$html;
 }// public function setHeader($base){

//-------------------------------------------------------//
// ヘッダーを返す(商品以外)                              //
//-------------------------------------------------------//
 public function setHeader2($base){
  //ページ情報をゲット
  $this->getPage($base);
  $head=$this->items[0];

  //ページ上部のリンクをゲット
  //$this->getGroup(2);
  //$topgrp=$this->items;

  //ページ中央のリンクをゲット
  $this->getGroup(2);
  $centergrp=$this->items;
  
  $html =html::sethead($head);
  $html.=html::setheader($base,$topgrp,$centergrp);
  
  //__jcode__削除
  $html=preg_replace("/__jcode__/","",$html);
  echo $html;
 }// public function setHeader($base){

//-------------------------------------------------------//
// ヘッダーを返す(商品以外)                              //
//-------------------------------------------------------//
 public function setHeader5($base){
  //ページ情報をゲット
  $this->getPage($base);
  $head=$this->items[0];

  //ページ上部のリンクをゲット
  //$this->getGroup(2);
  //$topgrp=$this->items;

  //ページ中央のリンクをゲット
  $this->getGroup(5);
  $centergrp=$this->items;
  
  $html =html::sethead($head);
  $html.=html::setheader($base,$topgrp,$centergrp);

  //__jcode__削除
  $html=preg_replace("/__jcode__/","",$html);
  echo $html;
 }// public function setHeader($base){



//-------------------------------------------------------//
// フッターを返す                                        //
//-------------------------------------------------------//
 public function setFooter($base){
  //ページ情報をゲット
  $this->getPage($base);
  $head=$this->items[0];

  //ページ上部のリンクをゲット
  $this->getGroup(2);
  $topgrp=$this->items;

  //ページ中央のリンクをゲット
  $this->getGroup(1);
  $centergrp=$this->items;
  
  $html=html::setfooter($base,$topgrp,$centergrp);

  echo $html;
 }//public function setFooter($base){

}//class page
?>
