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
 protected function head_tmp(){
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
 protected function body_tmp(){
  $this->div=<<<EOF
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
  $this->div=<<<EOF
<!--headerstart-->
<div id="header">
<!--headerhtmlend-->
 <div class="clr"></div>
</div>
<!--headerend-->
EOF;
 }//private  function header_tmp(){

//----------------------------------------------------------//
// main雛形
//----------------------------------------------------------//
 protected function main_tmp(){
  $this->div=<<<EOF
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
 protected function leftside_tmp(){
  $this->div=<<<EOF
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
 protected function rightside_tmp(){
  $this->div=<<<EOF
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
 protected function footer_tmp(){
  $this->div=<<<EOF
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
// h2雛形(h2にはid,classを指定できない)
//----------------------------------------------------------//
 public function create_h2($val){
  $this->element=<<<EOF
<!--h2start-->
<h2>
{$val}
<!--h2htmlend-->
</h2>
<!--h2end-->
EOF;
 }//private  function create_a(){


//----------------------------------------------------------//
// tanpin雛形(id,classを指定できない)
//----------------------------------------------------------//
 public function createtanpin(){
  $this->div=<<<EOF
 <div class="tanpin">
  <a href="<!--url-->">
   <span class="flg9"><!--flg9-->&nbsp</span>
   <span class="flg2"><!--flg2-->&nbsp</span>
   <div class="imgdiv">&nbsp</div>
   <img src="<!--IMG--><!--img-->" alt="<!--maker--> <!--sname--> <!--tani--><!--jcode-->">
   <span class="maker"><!--maker-->&nbsp</span>
   <span class="sname"><!--sname-->&nbsp</span>
   <span class="tani"><!--tani-->&nbsp</span>
   <span class="price"><!--price--><span class="yen"><!--yen--></span>&nbsp</span>
   <div class="clr"></div>
   <span class="notice"><!--notice-->&nbsp</span>
   <span class="jcode">JAN:<!--jcode-->&nbsp</span>
   <span class="saleday"><!--saleday-->&nbsp</span>
  </a>
 </div>
EOF;
 }// public function createtanpin(){
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
  $this->html=preg_replace("/".$pattern."/",$pattern.$this->div,$this->html);
  $this->div="";
 }//public function addhtml($element){

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
 }//public function appendhtml($element){

//----------------------------------------------------------//
// elementをdivへ追加(削除はできないのでdivごと消してください)
//----------------------------------------------------------//
 public function adddiv($elementname){
  $pattern="<!--".$elementname."end-->";
  $this->div=preg_replace("/".$pattern."/",$this->element.$pattern,$this->div);
  $this->element="";
 }//public function appenddiv($element){


//----------------------------------------------------------//
// elementをdivへ追加(削除はできないのでdivごと消してください)
//----------------------------------------------------------//
 public function appenddiv($elementname){
  $pattern="<!--".$elementname."htmlend-->";
  $this->div=preg_replace("/".$pattern."/",$this->element.$pattern,$this->div);
  $this->element="";
 }//public function appenddiv($element){

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
  $this->element=preg_replace("/".$pattern."/",$pattern.$val,$this->element);
 }//public function addelement($element,$val){


//----------------------------------------------------------//
// ul生成
// $data=array("url"=>ページURL,
//             "title"=>表示させる値
//            )
// $me="現在のページURL"
//----------------------------------------------------------//
 public function getul($data,$me=null){
  $li="";
  foreach($data as $rows=>$row){
   $li.="<li>";
   if($row["url"]!==$me) $li.="<a href='".$row["url"]."'>";
   $li.=$row["title"];
   if($row["url"]!==$me) $li.="</a>";
   $li.="</li>";
  }//foreach
  $this->ul_tmp();
  $pattern="<!--liend-->";
  $this->element=preg_replace("/".$pattern."/",$li.$pattern,$this->element);
 }//public function getul(){

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
