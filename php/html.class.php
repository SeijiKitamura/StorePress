<?php

require_once("dataset.class.php");
class html extends dataset{
 public $html;
 public $part;
 public $element;

 private $escape;

 function __construct(){
  parent::__construct();
 }//function __construct(){

//----------------------------------------------------------//
// head雛形
//----------------------------------------------------------//
 public function htmlhead(){
  $this->element=<<<EOF
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
  return $this->element;
 }//private  function htmlhead(){

//----------------------------------------------------------//
// body雛形
//----------------------------------------------------------//
 public function htmlbody(){
  $this->element=<<<EOF
<!--bodystart-->
<body>
<!--bodyhtmlend-->
</body>
<!--bodyend-->
</html>
EOF;
  return $this->element;
 }//private  function htmlbody(){

//----------------------------------------------------------//
// header雛形
//----------------------------------------------------------//
 public function htmlheader(){
  $this->element=<<<EOF
<!--headerstart-->
<div class="header">
<!--headerhtmlend-->
</div>
<!--headerend-->
EOF;
  return $this->element;
 }//private  function htmlheader(){

//----------------------------------------------------------//
// main雛形
//----------------------------------------------------------//
 public function htmlmain(){
  $this->element=<<<EOF
<!--mainstart-->
<div id="main">
<!--mainhtmlend-->
</div>
<!--mainend-->
EOF;
  return $this->element;
 }//private  function htmlmain(){

//----------------------------------------------------------//
// leftside雛形
//----------------------------------------------------------//
 public function htmlleftside(){
  $this->element=<<<EOF
<!--leftsidestart-->
<div id="leftside">
<!--leftsidehtmlend-->
</div>
<!--leftsideend-->
EOF;
  return $this->element;
 }//private  function htmlleftside(){

//----------------------------------------------------------//
// rightside雛形
//----------------------------------------------------------//
 public function htmlrightside(){
  $this->element=<<<EOF
<!--rightsidestart-->
<div id="rightside">
<!--rightsidehtmlend-->
</div>
<!--rightsideend-->
EOF;
  return $this->element;
 }//private  function htmlrightside(){

//----------------------------------------------------------//
// footerside雛形
//----------------------------------------------------------//
 public function htmlfooter(){
  $this->element=<<<EOF
<!--footerstart-->
<div id="footer">
<!--footerhtmlend-->
</div>
<!--footerend-->
EOF;
  return $this->element;
 }//private  function htmlfooter(){

//----------------------------------------------------------//
// div雛形
//----------------------------------------------------------//
 private  function htmldiv(){
  $this->element=<<<EOF
<!--elementnamestart-->
<div elementtype "elementname">
<!--elementnamehtmlend-->
</div>
<!--elementnameend-->
EOF;
  return $this->element;
 }//private  function htmldiv(){

//----------------------------------------------------------//
// ul雛形(ulにはid,classを指定できない)
//----------------------------------------------------------//
 private  function htmlul(){
  $this->element=<<<EOF
<!--ulstart-->
<ul>
 <!--liend-->
</ul>
<!--ulend-->
EOF;
  return $this->element;
 }//private  function htmlul(){

//----------------------------------------------------------//
// clr雛形
//----------------------------------------------------------//
 public function htmlclr(){
  $this->element=<<<EOF
<!--divstart-->
<div class="clr">
<!--divhtmlend-->
</div>
<!--divend-->
EOF;
  return $this->element;
 }//private  function htmlclr(){


//----------------------------------------------------------//
// img雛形(imgにはid,classを指定できない)
//----------------------------------------------------------//
 public function htmlimg($src,$alt=null,$title=null){
  $this->element=<<<EOF
<!--imgstart-->
<img src="{$src}" alt="{$alt}" title="{$title}">
<!--imgend-->
EOF;
  return $this->element;
 }//private  function htmlimg(){

//----------------------------------------------------------//
// a雛形(aにはid,classを指定できない)
//----------------------------------------------------------//
 public function htmla($url,$val=null){
  $this->element=<<<EOF
<!--astart-->
<a href="{$url}">
{$val}
<!--ahtmlend-->
</a>
<!--aend-->
EOF;
  return $this->element;
 }//private  function htmla(){

//----------------------------------------------------------//
// span雛形(id,classを指定できない)
//----------------------------------------------------------//
 public function htmlspan($val){
  $this->element=<<<EOF
<!--spanstart-->
<span>
{$val}
<!--spanhtmlend-->
</span>
<!--spanend-->
EOF;
  return $this->element;
 }//private  function htmla(){

//----------------------------------------------------------//
// h2雛形(h2にはid,classを指定できない)
//----------------------------------------------------------//
 public function htmlh2($val){
  $this->element=<<<EOF
<!--h2start-->
<h2>
{$val}
<!--h2htmlend-->
</h2>
<!--h2end-->
EOF;
  return $this->element;
 }//private  function htmlh2(){


//----------------------------------------------------------//
// tanpin雛形(id,classを指定できない)
//----------------------------------------------------------//
 public function htmltanpin(){
  $this->element=<<<EOF
 <div class="tanpin">
  <a href="<!--url-->">
   <div class="imgdiv">
    <!--imgstart-->
    <img src="<!--IMG--><!--img-->" alt="<!--maker--> <!--sname--> <!--tani--><!--jcode-->">
    <!--imgend-->
   </div>
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
  return $this->element;
 }// public function htmltanpin(){

//----------------------------------------------------------//
// div生成
//----------------------------------------------------------//
 public function htmlcreatediv($elementtype=null,$elementname=null,$val=null){
  $this->htmldiv();
  if($elementtype==="id"){
   $this->element=preg_replace("/elementtype/","id=",$this->element);
  }//if

  if($elementtype==="class"){
   $this->element=preg_replace("/elementtype/","class=",$this->element);
  }//if

  if(! $elementtype){
   $this->element=preg_replace("/elementtype/","",$this->element);
   $this->element=preg_replace("/elementname/","",$this->element);
  }//if

  if($elementname){
   $this->element=preg_replace("/elementname/",$elementname,$this->element);
  }//if

  if(! $elementname){
   $this->element=preg_replace("/elementtype/","",$this->element);
   $this->element=preg_replace("/elementname/","",$this->element);
  }//if

  if($val){
   $this->appendelement($elementname,$val);
  }
  return $this->element;
 }//public function htmlcreatediv($elementtype=null,$elementname=null){

//----------------------------------------------------------//
// $valをelementnameの最後尾へ追加
//----------------------------------------------------------//
 public function addhtml($elementname,$val){
  $pattern="<!--".$elementname."end-->";
  $this->html=preg_replace("/".$pattern."/",$pattern.$val,$this->html);
  return $this->html;
 }//public function addhtml($element){

//----------------------------------------------------------//
// html内のelementnameを削除
//----------------------------------------------------------//
 public function delhtml($elementname){
  $pattern="/<!--".$elementname."start-->.*<!--".$elementname."end-->/s";
  $this->html=preg_replace($pattern,"",$this->html);
  return $this->html;
 }//public function del($element){


//----------------------------------------------------------//
// $valをelementname内へ追加
//----------------------------------------------------------//
 public function appendhtml($elementname){
  $pattern="<!--".$elementname."htmlend-->";
  $this->html=preg_replace("/".$pattern."/",$this->part.$pattern,$this->html);
  return $this->html;
 }//public function appendhtml($element){

//----------------------------------------------------------//
// $valをpartへ追加(削除はできないのでdivごと消してください)
//----------------------------------------------------------//
 public function addpart($elementname){
  $pattern="<!--".$elementname."end-->";
  $this->part=preg_replace("/".$pattern."/",$pattern.$this->element,$this->part);
  return $this->part;
 }//public function addpart($element){


//----------------------------------------------------------//
// elementnameをpartへ追加(削除はできないのでdivごと消してください)
//----------------------------------------------------------//
 public function appendpart($elementname){
  $pattern="<!--".$elementname."htmlend-->";
  $this->part=preg_replace("/".$pattern."/",$this->element.$pattern,$this->part);
  return $this->part;
 }//public function appendpart($element){

//----------------------------------------------------------//
// $valをelementnameの中に追加
//----------------------------------------------------------//
 public function appendelement($elementname,$val){
  $pattern="<!--".$elementname."htmlend-->";
  $this->element=preg_replace("/".$pattern."/",$val.$pattern,$this->element);
  return $this->element;
 }//public function appendelement($element){

//----------------------------------------------------------//
// $valをelementnameの最後に追加
//----------------------------------------------------------//
 public function addelement($elementname,$val){
  $pattern="<!--".$elementname."end-->";
  $this->element=preg_replace("/".$pattern."/",$pattern.$val,$this->element);
  return $this->element;
 }//public function addelement($element,$val){

//----------------------------------------------------------//
// elementをpartへ追加
//----------------------------------------------------------//
 public function stackpart(){
  $this->part=$this->element;
  $this->element="";
 }

//----------------------------------------------------------//
// partをhtmlへ追加
//----------------------------------------------------------//
 public function stackhtml(){
  $this->html.=$this->part;
  $this->part="";
 }

//----------------------------------------------------------//
// ul生成
// $data=array("url"=>ページURL,
//             "title"=>表示させる値
//            )
// $me="現在のページURL"
//----------------------------------------------------------//
 public function htmlcreateul($data,$me=null){
  $li="";
  foreach($data as $rows=>$row){
   $li.="<li>";
   if($row["url"] && $row["url"]!==$me) $li.="<a href='".$row["url"]."'>";
   $li.=$row["title"];
   if($row["url"] && $row["url"]!==$me) $li.="</a>";
   $li.="</li>";
  }//foreach
  $this->htmlul();
  $pattern="<!--liend-->";
  $this->element=preg_replace("/".$pattern."/",$li.$pattern,$this->element);

  return $this->element;
 }//public function htmlcreateul(){


// ================================================================ //
// $this->partの退避
// ================================================================ //
 public function htmlescapepart(){
  $this->escape="";
  if($this->part) $this->escape=$this->part;

  $this->part="";
 }//public function htmlescapepart(){

// ================================================================ //
// $this->partの戻し
// ================================================================ //
 public function htmlreturnpart(){
  if($this->escape) $this->part=$this->escape;
  else $this->part="";

  $this->escape="";
 }//public function htmlescapepart(){


}//class html{


?>
