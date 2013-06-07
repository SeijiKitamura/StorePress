<?php
//----------------------------------------------------------//
//  html.class.php 
//  html生成用クラス
//----------------------------------------------------------//
//メソッド一覧
//----------------------------------------------------------//
// setpagelink($data,$page)  ページリンク用(<ul>を含むhtmlを返す)
// setfooter($page)          フッター用($pageは表示するページを代入)
//----------------------------------------------------------//

class html{
//----------------------------------------------------------//
// head
//----------------------------------------------------------//
 private static function head(){
  $html=<<<EOF
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html lang="ja">
 <head>
  <meta http-equiv="Content-language" content="ja">
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="ROBOTS" content="__index__">
  <meta name="ROBOTS" content="__follow__">
  <meta http-equiv="Content-Script-Type" content="text/javascript">
  <meta http-equiv="Content-Style-Type" content="text/css">
  <meta http-equiv="pragma" content="no-cache">
  <meta http-equiv="cache-control" content="no-cache">
  <meta http-equiv="expires" content="__CACHEDATE__">
  <title> __jcode__ __title__ | __CORPNAME__ </title>
  <meta name="description" content="__description__ __jcode__">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,minimau-scale=1.0,maximum-scale=2,user-scalable=yes">
  <meta name="format-detection" content="telephone=no">
  <link rel="icon" href="__FAV__" type="type/ico" sizes="16x16" /> 
  <link rel="stylesheet" href="__CSS____css__" media="screen"/> 
  <link rel="stylesheet" href="__CSS__print.css" media="print"/> 
  <link rel="next" href="__next__" />
  <link rel="prev" href="__prev__"/> 
  
  
  <script type="text/javascript" src="__JQUERY__"></script>
  <script>
   (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){ (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o), m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m) })(window,document,'script','//www.google-analytics.com/analytics.js','ga'); ga('create', 'UA-40148125-1', 'kita-grp.co.jp'); ga('send', 'pageview'); 
  </script>

 </head>

EOF;
  return $html;
 }//private static function head(){

//----------------------------------------------------------//
// head用($dataは単一データとする）
//----------------------------------------------------------//
 public static function sethead($data){
  $html=self::head();
  foreach($data as $col=>$val){
   $pattern="__".$col."__";
   $replace=$val;
   $html=str_replace($pattern,$val,$html);
  }//foreach

  //CSSディレクトリをセット
  $pattern="__CSS__";
  $val=CSS;//config.php
  $html=str_replace($pattern,$val,$html);

  //ファビコンをセット
  $pattern="__FAV__";
  $val=FAV;//config.php
  $html=str_replace($pattern,$val,$html);

  //Javascriptをセット
  $pattern="__JQUERY__";
  $val=JQ;//config.php
  $html=str_replace($pattern,$val,$html);

  //会社名をセット
  $pattern="__CORPNAME__";
  $val=CORPNAME;//config.php
  $html=str_replace($pattern,$val,$html);

  //キャッシュ有効日をセット
  $pattern="__CACHEDATE__";
  $val=gmdate("D,d M Y H:i:s",strtotime("1day"))." GMT";
  $html=str_replace($pattern,$val,$html);

  if(is_mobile()){
   $pattern="/\.css/";
   $replace=".smart.css";
   $html=preg_replace($pattern,$replace,$html);
  }
  return $html;
 }//public static function sethead($page){

//----------------------------------------------------------//
// ヘッダー雛形
//----------------------------------------------------------//
 private static function header_tmp(){
  $html=<<<EOF
 <body>
  <div id="fb-root"></div>
  <script>
   (function(d, s, id) {
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) return;
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/ja_JP/all.js#xfbml=1";
     fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
   </script>

  <div id="wrapper">
<!-- -------------- div header start ---------------------- -->
   <div id="header">

<!-- -------------- div logo   start ---------------------- -->
    <div class="logo">
     <a href="index.php">
      <img src="__LOGO__" alt="__CORPNAME__">
     </a>
    </div>
<!-- -------------- div logo   end   ---------------------- -->

<!-- -------------- div mininavi start -------------------- -->
    <div class="mininavi">
    __MININAVI__
    </div>
<!-- -------------- div mininavi end   -------------------- -->

<!-- -------------- div timesale start -------------------- -->
    <div class="timesale">
    __TIMESALE__
    </div>

<!-- -------------- div timesale end   -------------------- -->
    <div class='clr'></div>
   </div>
<!-- -------------- div header end   ---------------------- -->
EOF;
  return $html;
 }//private static function header_tmp(){

 public static function otherservice(){
  $html=<<<EOF
  <ul class="group">
   <li class='htitle'>各種サービスのご案内</li>
   <li> ポイントカード(準備中) </li>
   <li> <a href="haitatu.php">配達承り中 </a> </li>
   <li> <a href="mailitem.php">メール会員募集中</a> </li>
   <li> <a href="https://twitter.com/Super_Kitamura">twitter</a> </li>
   <li> facebook(準備中) </li>
  </ul>

  <ul class="group">
   <li class='htitle'>スーパーキタムラ</li>
   <li>定休日: なし</li>
   <li>営業時間: 9:30~22:00</li>
   <li>電話: 03-3771-8284</li>
   <li>住所: 大田区南馬込4-21-10</li>
  </ul>
  <ul class="group">
   <li class='htitle'>グループリンク</li>
   <li> <a href="http://www2.kita-grp.co.jp/modules/contents17/index.html">ゆたかゴルフ練習場 </a> </li>
   <li> <a href="http://k-jisho.jp/">キタムラ地所</a> </li>

  </ul>
EOF;
  return $html;
 }

//----------------------------------------------------------//
// ヘッダー出力
//----------------------------------------------------------//
 public static function setheader($base,$topgrp,$centergrp){
  $html=self::header_tmp();
  //ロゴをセット
  $pattern="__LOGO__";
  $replace=LOGO;
  $html=str_replace($pattern,$replace,$html);

  //ロゴメッセージをセット
  $pattern="__CORPNAME__";
  $replace=CORPNAME;
  $html=str_replace($pattern,$replace,$html);

  //トップグループをセット
  $pattern="__MININAVI__";
  $replace=self::setpagelink($topgrp,$base);
  $html=str_replace($pattern,$replace,$html);

  //センターグループをセット
  $pattern="__TIMESALE__";
  $replace=self::setpagelink($centergrp,$base);
  $html=str_replace($pattern,$replace,$html);

  return $html;
 }

//----------------------------------------------------------//
// フッター
//----------------------------------------------------------//
private static function footer(){
 $html=<<<EOF
   <div class="clr"></div>
   <div id="footer">
    <!-- div class="corp">__CORP__</div -->
    <div class="footerlink">__TIMESALE__</div>
   </div>
   <div class="clr"></div>
  </div>
 </body>
</html>
EOF;
 return $html;
}

//----------------------------------------------------------//
// フッター用
//----------------------------------------------------------//
 public static function setfooter($base,$topgrp,$centergrp){
  $html=self::footer();
  $html=str_replace("__CORP__",$GLOBALS["KAISYAMEI"],$html);
  $replace =self::setpagelink($centergrp,$base);
  $replace.=self::setpagelink($topgrp,$base);
  $html=str_replace("__TIMESALE__",$replace,$html);
  return $html;
 }

//----------------------------------------------------------//
// ページリンク用(<ul>を含むhtmlを返す)
//----------------------------------------------------------//
 public static function setpagelink($data,$page=null){
  if (! is_array($data)) return false;
  $html ="<ul>\n";
  foreach($data as $rownum=>$rowdata){
   $html.="<li>";

   if($rowdata["url"] && $rowdata["url"]!=$page){
    $html.="<a href='".$rowdata["url"]."'>";
   }//if

   $html.=$rowdata["title"];

   if($rowdata["url"] && $rowdata["url"]!=$page){
    $html.="</a>";
   }//if

   $html.="</li>\n";
  }//foreach
  $html.="</ul>\n";
  return $html;
 }//public static function setlink($data,$page=null){
//----------------------------------------------------------//
// グループ用
//----------------------------------------------------------//
 public static function group(){
$html=<<<EOF
 <li>
  <a href='__LINK__' target='_blank'>
   __GROUP__
  </a>
 </li>
EOF;
  return $html;
 }// public static function group(){

//----------------------------------------------------------//
// グループ生成
//----------------------------------------------------------//
 public static function setgroup($data,$link,$group,$groupname){
  $html="";
  foreach($data as $rownum=>$rowdata){
   $n=$rowdata[$groupname]."(".$rowdata["cnt"].")";
   $base=self::group();
   $base=str_replace("__LINK__",$link.$rowdata[$group],$base);
   $base=str_replace("__GROUP__",$n,$base);
   $html.=$base;
  }//foreach
  $html="<ul class='group'>\n".$html."</ul>\n";
  return $html;
 }//public static function setgroup(){

//----------------------------------------------------------//
// 単品一覧用
//----------------------------------------------------------//
 private static function item(){
$html=<<<EOF
<div class='item'>
 <div class='imgdiv'>
  <div class='saleday'>__SALEDAY__</div>
   <a href='__LINK__' target="">
    <img src='__IMGLINK__' alt='__MAKER__ __SNAME__ __JCODE__ ' title='__MAKER__ __SNAME__ __IMGJCODE__'>
   </a>
 </div> 
 <div class='datadiv'>
  <div class='saletype'>__SALETYPE__</div>
  <h3 class='sname'>   
   <a href='__LINK__' target="">
    __MAKER__ __SNAME__
   </a>
  </h3>

  <div class='tani'>__TANI__&nbsp;</div>
  <div class='price'>__PRICE__<span>__EN__</span></div>
  <div class='clr'></div>
  <div class='notice'>__NOTICE__&nbsp;</div>
  <div class='jcode'>__JCODE__</div>
  <div class='lastsale'>__LASTSALE__&nbsp;</div>
 </div>
</div>
EOF;

  return $html;
 }//public static function item(){

//----------------------------------------------------------//
// グループ一覧生成
//----------------------------------------------------------//
 public static function setgroupitem($data){
  $html="";
  if(! is_array($data)) return false;
  foreach ($data as $rownum=>$rowdata){

   $base=self::item();

   //リンク作成
   $url ="?lincode=".$rowdata["lincode"]."&clscode=".$rowdata["clscode"];
   $base=str_replace("__LINK__",$url,$base);

   //SALEDAY非表示
   $base=str_replace("__SALEDAY__","",$base);

   //画像非表示
   $img="./img/".$rowdata["lincode"].".jpg";
   if(! file_exists($img)){
    $pattern="/<img.*/";
    $base=preg_replace($pattern,"",$base);
   }//if
   $base=str_replace("__IMGLINK__",$img,$base);

   //saletype 非表示
   $pattern="/<div class='saletype'>.*<\/div>/";
   $base=preg_replace($pattern,"",$base);

   //メーカー非表示
   $base=str_replace("__MAKER__",$rowdata["maker"],$base);

   //SNAMEにグループ名をセット
   $sname=$rowdata["linname"]."(".$rowdata["cnt"].")";
   $base=str_replace("__SNAME__",$sname,$base);

   //単位を非表示
   $base=str_replace("__TANI__",$rowdata["tani"],$base);

   //売価を非表示
   $pattern="/<div class='price'>.*<\/div>/";
   $base=preg_replace($pattern,"<div class='price'></div>",$base);
   $base=str_replace("__EN__","",$base);

   //コメント非表示
   $base=str_replace("__NOTICE__",$rowdata["notice"],$base);
   
   //JANコードを非表示
   $base=str_replace("__JCODE__","",$base);

   //更新日を非表示
   $base=str_replace("__LASTSALE__","",$base);

   $html.=$base;
  }//foreach ($data as $rownum=>$rowdata){

  $html.="<div class='clr'></div>\n";
  return $html;

 }// public static function setgroupitem($grplist){

//----------------------------------------------------------//
// 単品一覧生成
//----------------------------------------------------------//
 public static function setitem($data,$jcode=null){
  $html="";
  if(! is_array($data)) return false;
  foreach ($data as $rownum=>$rowdata){
   $base=self::item();

   //リンク作成
   $url ="?lincode=".$rowdata["lincode"]."&clscode=".$rowdata["clscode"];
   $url.="&jcode=".$rowdata["jcode"]."&page=".$rowdata["page"];
   $base=str_replace("__LINK__",$url,$base);

   //リスト中の商品が単品と同じならリンクを消去
   if($rowdata["jcode"]==$jcode){
    $pattern="/<a.*>/";
    $base=preg_replace($pattern,"",$base);

    $pattern="/<\/a>/";
    $base=preg_replace($pattern,"",$base);
   }//if

   //画像がなければ非表示
   $img="./img/".$rowdata["jcode"].".jpg";
   if(! file_exists($img)){
    $pattern="/<img.*/";
    $base=preg_replace($pattern,"",$base);
   }//if
   $base=str_replace("__IMGLINK__",$img,$base);
   $base=str_replace("__IMGJCODE__",$rowdata["jcode"],$base);

   $base=str_replace("__SALEDAY__","",$base);
   if(! preg_match("/^[0-9]+$/",$rowdata["saletype"])){
    $base=str_replace("saletype","saletype_blank",$base);
    $base=str_replace("__SALETYPE__","",$base);
   }//if
   if(is_numeric($rowdata["saletype"])){
    $base=str_replace("__SALETYPE__",$GLOBALS["SALETYPE"][$rowdata["saletype"]],$base);
   }
   else{
    $pattern="/<div class='saletype'>.*<\/div>/";
    $base=preg_replace($pattern,"",$base);
   }
   $base=str_replace("__MAKER__",$rowdata["maker"],$base);
   $base=str_replace("__SNAME__",$rowdata["sname"],$base);
   $base=str_replace("__TANI__",$rowdata["tani"],$base);
   if($rowdata["price"]==0){
    $pattern="/<div class='price'>.*<\/div>/";
    $base=preg_replace($pattern,"<div class='price'></div>",$base);
   }
   $pattern="/(^[Pp]?[0-9]+|半額)(割引|倍)?/";
   preg_match($pattern,$rowdata["price"],$match);
   $base=str_replace("__PRICE__",$match[1],$base);
   if($match[2]){
    $base=str_replace("__EN__",$match[2],$base);
   }
   else{
    if(preg_match("/^[0-9]+$/",$match[1])){
     $base=str_replace("__EN__","円",$base);
    }
    else{
     $base=str_replace("__EN__","",$base);
    }
   }
   $base=str_replace("__NOTICE__",$rowdata["notice"],$base);
   $base=str_replace("__JCODE__","",$base);
   $lastsale=date("n月j日",strtotime($rowdata["lastsale"]))."__LASTSALE__";
   $base=str_replace("__LASTSALE__",$lastsale,$base);
   $html.=$base;
  }//foreach
  
  $html.="<div class='clr'></div>\n";
  return $html;
 }//public static function setitem($data){

 public static function setListGoyoyaku($data){
  $html="";
  $html="<div class='goyoyaku'>\n";
  if (! is_array($data)) return false;
  foreach($data as $rownum=>$rowdata){
   $base=self::item();
   //リンク作成
   $url ="?grpcode=".$rowdata["grpcode"];
   $base=str_replace("__LINK__",$url,$base);

   //画像がなければ非表示
   $img="./img/".$rowdata["jcode"].".jpg";
   if(! file_exists($img)){
    $pattern="/<img.*/";
    $base=preg_replace($pattern,"",$base);
   }//if
   $base=str_replace("__IMGLINK__",$img,$base);

   $base=str_replace("__SALEDAY__","",$base);
   if(! preg_match("/^[0-9]+$/",$rowdata["saletype"])){
    $base=str_replace("saletype","saletype_blank",$base);
    $base=str_replace("__SALETYPE__","",$base);
   }//if
   if(is_numeric($rowdata["saletype"])){
    $base=str_replace("__SALETYPE__",$GLOBALS["SALETYPE"][$rowdata["saletype"]],$base);
   }
   else{
    $pattern="/<div class='saletype'>.*<\/div>/";
    $base=preg_replace($pattern,"",$base);
   }
   $base=str_replace("__IMGJCODE__",$rowdata["jcode"],$base);
   $base=str_replace("__MAKER__","",$base);
   $base=str_replace("__SNAME__",$rowdata["grpname"],$base);
   $base=str_replace("__TANI__","",$base);
   $base=str_replace("__EN__","",$base);
   $base=str_replace("__NOTICE__","",$base);
   $base=str_replace("__JCODE__","",$base);
   $base=str_replace("__LASTSALE__","",$base);

   $pattern="/<div class='saletype_blank'>.*<\/div>/";
   $base=preg_replace($pattern,"",$base);
   $pattern="/<div class='tani'>.*<\/div>/";
   $base=preg_replace($pattern,"",$base);
   $pattern="/<div class='price'>.*<\/div>/";
   $base=preg_replace($pattern,"",$base);
   $pattern="/<div class='notice'>.*<\/div>/";
   $base=preg_replace($pattern,"",$base);
   $pattern="/<div class='jcode'>.*<\/div>/";
   $base=preg_replace($pattern,"",$base);
   $pattern="/<div class='lastsale'>.*<\/div>/";
   $base=preg_replace($pattern,"",$base);

   $html.=$base;
  }//foreach
  $html.="<div class='clr'></div>\n";
  $html.="</div>\n";
  return $html;
 }

 public static function setitemGoyoyaku($data,$jcode){
  $html="";
  $html="<div class='goyoyaku'>\n";
  if (! is_array($data)) return false;
  foreach ($data as $rownum=>$rowdata){
   $base=self::item();

   //リンク作成
   $url ="?grpcode=".$rowdata["grpcode"];
   $url.="&jcode=".$rowdata["jcode"];
   $base=str_replace("__LINK__",$url,$base);

   //リスト中の商品が単品と同じならリンクを消去
   if($rowdata["jcode"]==$jcode){
    $pattern="/<a.*>/";
    $base=preg_replace($pattern,"",$base);

    $pattern="/<\/a>/";
    $base=preg_replace($pattern,"",$base);
   }//if

   //画像がなければ非表示
   $img="./img/".$rowdata["jcode"].".jpg";
   if(! file_exists($img)){
    $pattern="/<img.*/";
    $base=preg_replace($pattern,"",$base);
   }//if
   $base=str_replace("__IMGLINK__",$img,$base);

   $base=str_replace("__SALEDAY__","",$base);
   if(! preg_match("/^[0-9]+$/",$rowdata["saletype"])){
    $base=str_replace("saletype","saletype_blank",$base);
    $base=str_replace("__SALETYPE__","",$base);
   }//if
   if(is_numeric($rowdata["saletype"])){
    $base=str_replace("__SALETYPE__",$GLOBALS["SALETYPE"][$rowdata["saletype"]],$base);
   }
   else{
    $pattern="/<div class='saletype'>.*<\/div>/";
    $base=preg_replace($pattern,"",$base);
   }
   $base=str_replace("__MAKER__",$rowdata["maker"],$base);
   $base=str_replace("__SNAME__",$rowdata["sname"],$base);
   $base=str_replace("__TANI__",$rowdata["tani"],$base);
   if($rowdata["price"]==0){
    $pattern="/<div class='price'>.*<\/div>/";
    $base=preg_replace($pattern,"",$base);
   }
   $pattern="/(^[Pp]?[0-9]+|半額)(割引|倍)?/";
   preg_match($pattern,$rowdata["price"],$match);
   $base=str_replace("__PRICE__",$match[1],$base);
   if($match[2]){
    $base=str_replace("__EN__",$match[2],$base);
   }
   else{
    if(preg_match("/^[0-9]+$/",$match[1])){
     $base=str_replace("__EN__","円",$base);
    }
    else{
     $base=str_replace("__EN__","",$base);
    }
   }
   $base=str_replace("__NOTICE__",$rowdata["notice"],$base);
   $base=str_replace("__JCODE__","",$base);
   $base=str_replace("__LASTSALE__",$rowdata["lastsale"],$base);
   $html.=$base;
  }//foreach
  
  $html.="<div class='clr'></div>\n";
  $html.="</div>\n";
  return $html;
 }//public static function setitemGoyoyaku($data){


//----------------------------------------------------------//
// 単品用
//----------------------------------------------------------//
 private static function tanpin(){
$html=<<<EOF
<div class='tanpin'>
 <div class='imgdiv'>
  <img src='__IMGLINK__' alt='__MAKER__ __SNAME__ __JCODE__ ' title='__MAKER__ __SNAME__ __JCODE__'>
 </div> 
 <div class='datadiv'>
  <div class='saletype'>__SALETYPE__</div>
  <h3 class='sname'>__MAKER__ __SNAME__</h3>
  <div class='tani' >__TANI__&nbsp;</div>
  <div class='price'>__PRICE__<span>__EN__</span></div>
  <div class='clr'></div>
  <div class='notice'>__NOTICE__&nbsp;</div>
  <div class='jcode'>__JCODE__</div>
  <div class='lastsale'>__LASTSALE__&nbsp;</div>
  <div class='social'><!--URL--></div>
 </div>
</div>
<div class='clr'></div>
EOF;

  return $html;
 }//private static function tanpin(){
//----------------------------------------------------------//
// 単品一覧生成
//----------------------------------------------------------//
 public static function settanpin($data){
  $html="";
  foreach ($data as $rownum=>$rowdata){
   $base=self::tanpin();
 
   //画像がなければ非表示
   $img="./img/".$rowdata["jcode"].".jpg";
   if(! file_exists($img)){
    $pattern="/<img.*/";
    $base=preg_replace($pattern,"",$base);
   }//if
   $base=str_replace("__IMGLINK__",$img,$base);
   $base=str_replace("__SALEDAY__","",$base);
   $base=str_replace("__MAKER__",$rowdata["maker"],$base);
   $base=str_replace("__SNAME__",$rowdata["sname"],$base);
   $base=str_replace("__TANI__",$rowdata["tani"],$base);
   if($rowdata["price"]==0){
    $pattern="/<div class='price'>.*<\/div>/";
    $base=preg_replace($pattern,"",$base);
   }
   $pattern="/(^[Pp]?[0-9]+|半額)(割引|倍)?/";
   preg_match($pattern,$rowdata["price"],$match);
   $base=str_replace("__PRICE__",$match[1],$base);
   if($match[2]){
    $base=str_replace("__EN__",$match[2],$base);
   }
   else{
    if(preg_match("/^[0-9]+$/",$match[1])){
     $base=str_replace("__EN__","円",$base);
    }
    else{
     $base=str_replace("__EN__","",$base);
    }
   }
   if(is_numeric($rowdata["saletype"])){
    $base=str_replace("__SALETYPE__",$GLOBALS["SALETYPE"][$rowdata["saletype"]],$base);
   }
   else{
    $pattern="/<div class='saletype'>.*<\/div>/";
    $base=preg_replace($pattern,"",$base);

   }
   $base=str_replace("__JCODE__","JAN:".$rowdata["jcode"],$base);
   $base=str_replace("__NOTICE__",$rowdata["notice"],$base);
   if(! $rowdata["sday"] && ! $rowdata["eday"]){
    $base=str_replace("__LASTSALE__",$rowdata["lastsale"],$base);
   }//if
   else{
    if($rowdata["sday"]==$rowdata["eday"]){
     $kikan=date("m月d日",strtotime($rowdata["sday"]))."限り";
    }//if
    else{
     $kikan=date("m月d日",strtotime($rowdata["sday"]))."から".date("m月d日",strtotime($rowdata["eday"]))."まで";
    }//else
    $base=str_replace("__LASTSALE__",$kikan,$base);
   }//else
   $html.=$base;
  }//foreach
  return $html;

 }//public static function settanpin($data){

//----------------------------------------------------------//
// カレンダー用
//----------------------------------------------------------//
 private static function calendar(){
  $html="";
  $html=<<<EOF
<div class='calitem'>
 <div class='saleday'>__SALEDAY__</div>
 <div class='datadiv'>
  <h3 class='sname'>
   <a href='__LINK__' target="">
    __MAKER__ __SNAME__
   </a>
  </h3>
  <div class='tani' >__TANI__&nbsp;</div>
  <div class='price'>__PRICE__<span>__EN__</span></div>
  <div class='notice'>__NOTICE__&nbsp;</div>
 </div>
</div>
EOF;
  return $html;
 }//private static function calendar(){

//----------------------------------------------------------//
// カレンダー用
//----------------------------------------------------------//
 public static function setcalendar($data){
  $youbi=array("日","月","火","水","木","金","土");

  //最初の日付
  $d=strtotime($data[0]["saleday"]);

  //開始日をセット(前月の最終日曜日)
  $s=mktime(0,0,0,date("m",$d),1,date("Y",$d));
  $y=date("w",$s);
  $s=$s-($y*60*60*24);
  
  //終了日をセット(翌月の最初土曜日)
  $e=mktime(0,0,0,date("m",$d)+1,0,date("Y",$d));
  $y=date("w",$e);
  $e=$e+(6-$y)*60*60*24;

  $html="<div class='calendar'>";
  //曜日をセット
  for($i=0;$i<count($youbi);$i++){
   $html.="<div class='youbi ";
   if($i==(count($youbi)-1)) $html.=" colend";
   $html.="'>".$youbi[$i]."</div>\n";
  }//for
  $html.="<div class='clr'></div>";

  //echo "start".date("Y-m-d",$s)." end ".date("Y-m-d",$e);

  //開始日から終了日まで繰り返し
  $daycnt=1;
  for($i=$s;$i<=$e;$i=$i+60*60*24){
   $css="calitem ";
   //枠表示
   $base=self::calendar();
   if(date("w",$i)==6) $css.="colend ";
   if($daycnt / 7>4) $css.=" rowend";
   $base=str_replace("calitem",$css,$base);

   //日付表示
   $base=str_replace("__SALEDAY__",date("j",$i),$base);

   $flg=0;
   //データ表示
   foreach($data as $rownum=>$rowdata){
    if($i==strtotime($rowdata["saleday"])){
     $url ="calendar.php?saleday=".$rowdata["saleday"];
     $base=str_replace("__LINK__",$url,$base);

     //画像がなければ非表示
     $img="./img/".$rowdata["jcode"].".jpg";
     if(! file_exists($img)){
      $pattern="/<img.*/";
      $base=preg_replace($pattern,"",$base);
     }//if
     $base=str_replace("__IMGLINK__",$img,$base);
     $base=str_replace("__MAKER__",$rowdata["maker"],$base);
     $base=str_replace("__SNAME__",$rowdata["sname"],$base);
     $base=str_replace("__TANI__",$rowdata["tani"],$base);
     $pattern="/(^[Pp]?[0-9]+|半額)(割引|倍)?/";
     preg_match($pattern,$rowdata["price"],$match);
     $base=str_replace("__PRICE__",$match[1],$base);
     if($match[2]){
      $base=str_replace("__EN__",$match[2],$base);
     }
     else{
      if(preg_match("/^[0-9]+$/",$match[1])){
       $base=str_replace("__EN__","円",$base);
      }
      else{
       $base=str_replace("__EN__","",$base);
      }
     }
     $base=str_replace("__NOTICE__",$rowdata["notice"],$base);

     $flg=1;
     break;
    }//if
   }//foreach
   if(! $flg){
    $pattern="/<img.*/";
    $base=preg_replace($pattern,"",$base);
    $base=str_replace("__LINK__","",$base);
    $base=str_replace("__MAKER__","",$base);
    $base=str_replace("__SNAME__","",$base);
    $base=str_replace("__TANI__","",$base);
    $base=str_replace("__PRICE__","",$base);
    $base=str_replace("__EN__","",$base);
    $base=str_replace("__NOTICE__","",$base);
   }//if
   $base=str_replace("__JCODE__","",$base);
   $base=str_replace("__LASTSALE__","",$base);
   $html.=$base;
   if(date("w",$i)==6) $html.="<div class='clr'></div>\n";
   $daycnt++;
  }//for
  $html.="</div>\n";//<div class='calendar'>

  return $html;
 }//private static function calendar(){

//----------------------------------------------------------//
// チラシアイテム一覧用
//----------------------------------------------------------//
 public static function setitemTirasi($data,$jcode=null){
  $html="";
  $sday=0;//開始日
  $eday=0;//終了日
  $flg1="";//サブタイトル

  $html="<div class='tirasiitem'>\n";

  if(! is_array($data)) return false;
  $datacnt=0;
  $titlecnt=0;
  foreach($data as $rownum=>$rowdata){
   //開始日、終了日が変更なら日付表示
   if($sday!=strtotime($rowdata["sday"]) || $eday!=strtotime($rowdata["eday"])){
    $kaisi=date("n月j日",strtotime($rowdata["sday"]));
    $owari=date("n月j日",strtotime($rowdata["eday"]));
    if($kaisi==$owari) $kikan=$kaisi."限り";
    else $kikan=$kaisi."から".$owari."まで";
    //$html.="<div class='clr'></div>\n";
    //$html.="<h4>".$kikan."</h4>\n";
   }//if

   //サブタイトル変更なら表示
   if($flg1!=$rowdata["flg1"]){
    $title=$rowdata["flg1"];
    //$html.="<div class='clr'></div>\n";
    //$html.="<h3>".$title."</h3>\n";
   }//if

   if($sday!=strtotime($rowdata["sday"]) || $eday!=strtotime($rowdata["eday"]) || $flg1!=$rowdata["flg1"]){
    $titlecnt++;
    if($titlecnt > PAGETITLE){ //config.php(PAGETITLEごとに改ページ)
     $html.="<div class='pageview'>\n";
     $html.="<pre>".$GLOBALS["MENSEKI"]."</pre>\n";
     $html.="</div>\n";
     $html.="<div class='pagebreak'></div>\n";
     $html.="<div class='pageview'>\n";
     $html.="<div class='clr'></div>\n";
     $html.="<img src='".IMG.LOGONAME."'>\n";
     //$html.="<h3>".$kikan." ".$title."</h3>\n";
     $html.="</div>\n";
     $datacnt=1;
     $titlecnt=1;
    }
    $html.="<div class='clr'></div>\n";
    //$html.="<h3>".$kikan." ".$title."</h3>\n";
    $html.="<br><hr><br>";
    $html.="<h3>".$title." ".$kikan."</h3>\n";
   }
   //アイテム表示
   $base=self::item();

   //画像がなければ非表示
   $img="./img/".$rowdata["jcode"].".jpg";
   if(! file_exists($img)){
    $pattern="/<img.*/";
    $base=preg_replace($pattern,"",$base);
   }//if
   $base=str_replace("__IMGLINK__",$img,$base);
   //単品用URLをセット
   $url ="?lincode=".$rowdata["lincode"]."&clscode=".$rowdata["clscode"];
   $url.="&jcode=".$rowdata["jcode"]."&saleday=".$rowdata["sday"];
   $base=str_replace("__LINK__",$url,$base);

   //リスト中の商品が単品と同じならリンクを消去
   if($rowdata["jcode"]==$jcode){
    $pattern="/<a.*>/";
    $base=preg_replace($pattern,"",$base);

    $pattern="/<\/a>/";
    $base=preg_replace($pattern,"",$base);
   }//if

   $base=str_replace("__SALEDAY__","",$base);
   $base=str_replace("__MAKER__",$rowdata["maker"],$base);
   $base=str_replace("__SNAME__",$rowdata["sname"],$base);
   $base=str_replace("__TANI__",$rowdata["tani"],$base);
   $pattern="/(^[Pp]?[0-9]+|半額)(割引|倍)?/";
   preg_match($pattern,$rowdata["price"],$match);
   $base=str_replace("__PRICE__",$match[1],$base);
   if($match[2]){
    $base=str_replace("__EN__",$match[2],$base);
   }
   else{
    if(preg_match("/^[0-9]+$/",$match[1])){
     $base=str_replace("__EN__","円",$base);
    }
    else{
     $base=str_replace("__EN__","",$base);
    }
   }
   $base=str_replace("__SALETYPE__",$GLOBALS["SALETYPE"][0],$base);
   $base=str_replace("__NOTICE__",$rowdata["notice"],$base);
   $base=str_replace("__JCODE__","",$base);
   $base=str_replace("__IMGJCODE__",$rowdata["jcode"],$base);
   $base=str_replace("__LASTSALE__",$kikan,$base);
   $html.=$base;
 
   //変数更新
   $sday=strtotime($rowdata["sday"]);
   $eday=strtotime($rowdata["eday"]);
   $flg1=$rowdata["flg1"];

   $datacnt++;
   if($datacnt % PAGEITEM ===0){ //config.php(PAGEITEMごとに改ページ)
    $html.="<div class='pageview'>\n";
    $html.="<div class='clr'></div>\n";
    $html.="<pre>".$GLOBALS["MENSEKI"]."</pre>\n";
    $html.="</div>\n";
    $html.="<div class='pagebreak'></div>\n";
    $html.="<div class='pageview'>\n";
    $html.="<div class='clr'></div>\n";
    $html.="<img src='".IMG.LOGONAME."'>\n";
    $html.="<h3>".$kikan." ".$title."</h3>\n";
    $html.="</div>\n";
    $datacnt=1;
    $titlecnt=1;
   }
  }//foreach
  $html.="<div class='clr'></div>\n";
  $html.="</div>\n";
  return $html;
 }//public static function setitemTirasi($data){

 public static function outJan($data,$jcode){
  foreach($data as $rownum=>$rowdata){
   if($rowdata["jcode"]!=$jcode){
    $item[]=$rowdata;
   }//if
  }//foreach
  return $item;
 }//public static function outJan($data,$jcode){
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
