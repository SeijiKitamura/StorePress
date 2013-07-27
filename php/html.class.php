<?php

require_once("dataset.class.php");
class html extends dataset{
 public $html;
 public $div;
 public $element;

 function __construct(){
  parent::__construct();
 }//function __construct(){

//----------------------------------------------------------//
// head雛形
//----------------------------------------------------------//
 private  function head_tmp(){
  $this->html=<<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ja">
<!--headstart-->
 <head>
  <meta http-equiv="Content-language" content="ja">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="ROBOTS" content="__index__">
  <meta name="ROBOTS" content="__follow__">
  <meta http-equiv="Content-Script-Type" content="text/javascript">
  <meta http-equiv="Content-Style-Type" content="text/css">
  <meta http-equiv="pragma" content="no-cache">
  <meta http-equiv="cache-control" content="no-cache">
  <!--meta http-equiv="expires" content="__CACHEDATE__"-->
  <!--titlestart-->
  <title>
    __title__ | __storename__ 
  </title>
  <!--titleend-->
  <meta name="description" content="__description__ __jcode__">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,minimau-scale=1.0,maximum-scale=2,user-scalable=yes">
  <meta name="format-detection" content="telephone=no">
  <link rel="icon" href="__IMG____favcon__" type="type/ico" sizes="16x16" /> 
  <link rel="stylesheet" href="__CSS____css__" media="screen"/> 
  <link rel="stylesheet" href="__CSS__print.css" media="print"/> 
  <link rel="next" href="__next__" />
  <link rel="prev" href="__prev__"/> 
  
  
  <script type="text/javascript" src="__JQUERY__"></script>
<!--headhtmlend-->
 </head>
<!--headend-->

EOF;
 }//private  function head(){

//----------------------------------------------------------//
// body雛形
//----------------------------------------------------------//
 private  function body_tmp(){
  $this->html.=<<<EOF
<!--bodystart-->
<body>
<!--wrapperstart-->
<div id="wrapper">
<!--wrapperhtmlend-->
</div>
<!--wrapperend-->
</body>
<!--bodyend-->
</html>
EOF;
 }//private  function body_tmp(){

//----------------------------------------------------------//
// header雛形
//----------------------------------------------------------//
 protected function header_tmp(){
  $this->html.=<<<EOF
<!--headerstart-->
<div id="header">
<!--headerhtmlend-->
</div>
<!--headerend-->
EOF;
 }//private  function header_tmp(){

//----------------------------------------------------------//
// main雛形
//----------------------------------------------------------//
 private  function main_tmp(){
  $this->html.=<<<EOF
<!--mainstart-->
<div id="main">
<!--mainhtmlend-->
</div>
<!--mainend-->
EOF;
 }//private  function main_tmp(){

//----------------------------------------------------------//
// leftside雛形
//----------------------------------------------------------//
 private  function leftside_tmp(){
  $this->html.=<<<EOF
<!--leftsidestart-->
<div id="leftside">
<!--leftsidehtmlend-->
</div>
<!--leftsideend-->
EOF;
 }//private  function leftside_tmp(){

//----------------------------------------------------------//
// rightside雛形
//----------------------------------------------------------//
 private  function rightside_tmp(){
  $this->html.=<<<EOF
<!--rightsidestart-->
<div id="rightside">
<!--rightsidehtmlend-->
</div>
<!--rightsideend-->
EOF;
 }//private  function rightside_tmp(){

//----------------------------------------------------------//
// footerside雛形
//----------------------------------------------------------//
 private  function footer_tmp(){
  $this->html.=<<<EOF
<!--footerstart-->
<div id="footer">
<!--footerhtmlend-->
</div>
<!--footerend-->
EOF;
 }//private  function footer_tmp(){

//----------------------------------------------------------//
// div雛形
//----------------------------------------------------------//
 private  function div_tmp(){
  $this->div=<<<EOF
<!--elementnamestart-->
<div elementtype "elementname">
<!--elementnamehtmlend-->
</div>
<!--elementnameend-->
EOF;
 }//private  function div_tmp(){

//----------------------------------------------------------//
// ul雛形(ulにはid,classを指定できない)
//----------------------------------------------------------//
 private  function ul_tmp(){
  $this->element=<<<EOF
<!--ulstart-->
<ul>
 <!--liend-->
</ul>
<!--ulend-->
EOF;
 }//private  function ul_tmp(){

//----------------------------------------------------------//
// menu雛形(id,classを指定できない)
//----------------------------------------------------------//
 private function bigicon_tmp(){
  $this->element=<<<EOF
   <div class="bigicon">
    <a href="<!--url-->">
     <h3><!--flg9--></h3>
     <span class="subtitle"><!--flg3--></span>
     <div class="imgdiv">
      <img src="__TANPINIMG__" alt="<!--maker--><!--sname-->" title="<!--maker--><!--sname-->" >
     </div>
     <div class="tanpindiv">
      <span class="maker"><!--maker--></span>
      <span class="sname"><!--sname--></span>
      <span class="tani"><!--tani--></span>
      <span class="price"><!--price--></span>
      <span class="yen"><!--yen--></span>
      <span class="notice"><!--notice--></span>
      <span class="description"><!--description--></span>
     </div>
    </a>
   </div>
EOF;
 }// private function bigmenu_tmp(){
//----------------------------------------------------------//
// img雛形(imgにはid,classを指定できない)
//----------------------------------------------------------//
 public function create_img($src,$alt=null,$title=null){
  $this->element=<<<EOF
<!--imgstart-->
<img src="{$src}" alt="{$alt}" title="{$title}">
<!--imgend-->
EOF;
 }//private  function create_img(){

//----------------------------------------------------------//
// a雛形(aにはid,classを指定できない)
//----------------------------------------------------------//
 public function create_a($url,$val=null){
  $this->element=<<<EOF
<!--astart-->
<a href="{$url}">
{$val}
<!--ahtmlend-->
</a>
<!--aend-->
EOF;
 }//private  function create_a(){

//----------------------------------------------------------//
// span雛形(aにはid,classを指定できない)
//----------------------------------------------------------//
 public function create_span($val){
  $this->element=<<<EOF
<!--spanstart-->
<span>
{$val}
<!--spanhtmlend-->
</span>
<!--spanend-->
EOF;
 }//private  function create_a(){



//----------------------------------------------------------//
// headを追加
//----------------------------------------------------------//
 public function sethead($data=null){
  $this->head_tmp();
  $this->body_tmp();
 }//public function sethead($elementtype=null,$elementname=null){

//----------------------------------------------------------//
// div生成
//----------------------------------------------------------//
 public function creatediv($elementtype=null,$elementname=null){
  $this->div_tmp();
  if($elementtype==="id"){
   $this->div=preg_replace("/elementtype/","id=",$this->div);
  }//if

  if($elementtype==="class"){
   $this->div=preg_replace("/elementtype/","class=",$this->div);
  }//if

  if(! $elementtype){
   $this->div=preg_replace("/elementtype/","",$this->div);
   $this->div=preg_replace("/elementname/","",$this->div);
  }//if

  if($elementname){
   $this->div=preg_replace("/elementname/",$elementname,$this->div);
  }//if

  if(! $elementname){
   $this->div=preg_replace("/elementtype/","",$this->div);
   $this->div=preg_replace("/elementname/","",$this->div);
  }//if
 }//public function create($elementtype=null,$elementname=null){

//----------------------------------------------------------//
// divをhtmlの最後尾へ追加
//----------------------------------------------------------//
 public function addhtml($elementname){
  $pattern="<!--".$elementname."end-->";
  $this->html=preg_replace("/".$pattern."/",$this->div.$pattern,$this->html);
  $this->div="";
 }//public function add($element){

//----------------------------------------------------------//
// html内のdivを削除
//----------------------------------------------------------//
 public function delhtml($elementname){
  $pattern="/<!--".$elementname."start-->.*<!--".$elementname."end-->/s";
  $this->html=preg_replace($pattern,"",$this->html);
  $this->div="";
 }//public function del($element){


//----------------------------------------------------------//
// html内へdivを追加
//----------------------------------------------------------//
 public function appendhtml($elementname){
  $pattern="<!--".$elementname."htmlend-->";
  $this->html=preg_replace("/".$pattern."/",$this->div.$pattern,$this->html);
  $this->div="";
 }//public function add($element){


//----------------------------------------------------------//
// elementをdivへ追加(削除はできないのでdivごと消してください)
//----------------------------------------------------------//
 public function append($elementname){
  $pattern="<!--".$elementname."htmlend-->";
  $this->div=preg_replace("/".$pattern."/",$this->element.$pattern,$this->div);
  $this->element="";
 }//public function add($element){

//----------------------------------------------------------//
// elementに値を追加
//----------------------------------------------------------//
 public function appendelement($elementname,$val){
  $pattern="<!--".$elementname."htmlend-->";
  $this->element=preg_replace("/".$pattern."/",$val.$pattern,$this->element);
 }//public function appendelement($element){

//----------------------------------------------------------//
// elementに値を追加
//----------------------------------------------------------//
 public function addelement($elementname,$val){
  $pattern="<!--".$elementname."end-->";
  $this->element=preg_replace("/".$pattern."/",$val.$pattern,$this->element);
 }//public function addelement($element,$val){


//----------------------------------------------------------//
// ul生成
// $data=array("url"=>ページURL,
//             "val"=>表示させる値
//            )
// $me="現在のページURL"
//----------------------------------------------------------//
 public function getul($data,$me=null){
  $li="";
  foreach($data as $rows=>$row){
   $li.="<li>";
   if($row["url"]!==$me) $li.="<a href='".$row["url"]."'>";
   $li.=$row["val"];
   if($row["url"]!==$me) $li.="</a>";
   $li.="</li>";
  }//foreach
  $this->ul_tmp();
  $pattern="<!--liend-->";
  $this->element=preg_replace("/".$pattern."/",$li.$pattern,$this->element);
 }//public function getul(){

//----------------------------------------------------------//
// headをセット
//----------------------------------------------------------//
 public function gethead($pagename){
  //店舗情報セット
  $this->getStoreInfo();
  $store=$this->items["data"];
  if(! $store) throw new exception ("店舗情報がありません");
  //print_r($store);

  //ページ情報をゲット
  $this->getPage($pagename);
  $page=$this->items["data"];
  if(! $page) throw new exception ("ページ情報がありません");
  //print_r($page);
  
  //ヘッダーをセット
  $this->head_tmp();
  
  //店舗情報を反映
  foreach($store as $rows=>$row){
   $pattern="__".$row["colname"]."__";
   $this->html=str_replace($pattern,$row["val"],$this->html);
  }//foreach

  //ページ情報を反映
  foreach($page as $rows=>$row){
   foreach($row as $col=>$val){
    $pattern="__".$col."__";
    $this->html=str_replace($pattern,$val,$this->html);
   }//foreach
  }//foreach

  //ディレクトリを反映
  $pattern="__IMG__";
  $this->html=str_replace($pattern,IMG,$this->html);

  $pattern="__CSS__";
  $this->html=str_replace($pattern,CSS,$this->html);

  $pattern="__JQUERY__";
  $this->html=str_replace($pattern,JQ,$this->html);

  //echo $this->html;
 }//public function gethead(){

 public function gelBigIcon($data){
  foreach($data as $rows=>$row){
   $this->bigicon_tmp();
   foreach($row as $col=>$val){
    $this->element=preg_replace("/<!--".$col."-->/",$val,$this->element);
    //ここから
   }//foreach
  }//foreach

 }// public function gelBigIcon($data){
}//class html{

function is_mobile () {
 $useragents = array(
 'iPhone', // Apple iPhone
 'iPod', // Apple iPod touch
 'Android', // 1.5+ Android
 'dream', // Pre 1.5 Android
 'CUPCAKE', // 1.5+ Android
 'blackberry9500', // Storm
 'blackberry9530', // Storm
 'blackberry9520', // Storm v2
 'blackberry9550', // Storm v2
 'blackberry9800', // Torch
 'webOS', // Palm Pre Experimental
 'incognito', // Other iPhone browser
 'webmate' // Other iPhone browser
 );
 $pattern = '/'.implode('|', $useragents).'/i';
 return preg_match($pattern, $_SERVER['HTTP_USER_AGENT']);
}

?>
