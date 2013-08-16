<?php
require_once("html.class.php");

class parts extends html{
 
 public $me;

 function __construct(){
  parent::__construct();
 }//function __construct(){
//----------------------------------------------------------//
// headをセット
//----------------------------------------------------------//
 public function partshead(){

  //店舗情報セット
  if(! $this->datasetStoreInfo()) throw new exception ("店舗情報がありません");
  $store=$this->storeinfo;
  //print_r($store);

  //ページ情報をゲット
  if(! $this->datasetPageData($this->me)) throw new exception ("ページ情報がありません");
  //print_r($page);

  $this->partsNextPrev();

  $page=$this->pageinfo;

  //ヘッダーをセット
  $html=$this->htmlhead();

  //ページ情報を反映
  foreach($page as $rows=>$row){
   foreach($row as $col=>$val){
    $pattern="__".$col."__";
    $html=str_replace($pattern,$val,$html);
   }//foreach
  }//foreach

  //店舗情報を反映
  foreach($store as $rows=>$row){
   $pattern="__".$row["colname"]."__";
   $html=str_replace($pattern,$row["val"],$html);
  }//foreach


  //ディレクトリを反映
  $pattern="__IMG__";
  $html=str_replace($pattern,IMG,$html);

  $pattern="__CSS__";
  $html=str_replace($pattern,CSS,$html);

  $pattern="__JQUERY__";
  $html=str_replace($pattern,JQ,$html);

  $this->element=$html;
  return $html;
 }//public function partshead(){
 
//----------------------------------------------------------//
// 次ページ、前ページを情報ゲット
// 前提 $this->pageinfoにデータがセット済み
// 引数 $this->saletype
// 引数 $this->saleday
// 引数 $this->jcode
//----------------------------------------------------------//
// $prev 前ページのURLがセット
// $me   ページのdescriptionがセット
// $next 次ページのURLがセット
//----------------------------------------------------------//
 public function partsNextPrev(){
  if($this->me=="tirasidaylist.php"){
   //販売期間をゲット
   if(! $this->datasetSaleSpan()) return false;

   //saledayを退避
   $saleday=$this->saleday;
   $this->saleday=null;

   //販売リストをゲット
   $this->datasetLinGroup();

   if(! $this->items) return false;

   //商品リストデータ作成(日付が変われば、lincode=nullをセット)
   $s=null;
   foreach($this->items as $rows=>$row){
    if($row["saleday"]!=$s){
     $ary[]=array( "saleday"=>$row["saleday"]
                  ,"lincode"=>null
                  ,"linname"=>null
                  ,"flg9"   =>null);
    }//if
    $ary[]=array( "saleday"=>$row["saleday"]
                 ,"lincode"=>$row["lincode"]
                 ,"linname"=>$row["linname"]
                 ,"flg9"   =>$row["flg9"]);
    $s=$row["saleday"];
   }//foreach

   //該当データ抽出
   foreach($ary as $rows=>$row){
    if($row["saleday"]==$saleday && $row["lincode"]==$this->lincode){
     break;
    }//if
   }//foreach
   
   //最初のデータの場合
   if(! $rows){
    $prev=null;
   }//if
   else{
    //前ページデータ
    $prevrows=$rows-1;
    $prev =$this->me."?saleday=".$ary[$prevrows]["saleday"];
    if($ary[$prevrows]["lincode"]){
     $prev.="&lincode=".$ary[$prevrows]["lincode"];
    }//if
   }//else

   //現在ページデータ
   //$me=$ary[$rows]["saleday"]." ".$ary[$rows]["linname"];
   $me=$ary[$rows]["flg9"]." ".$ary[$rows]["linname"]." ".$ary[$rows]["saleday"];

   //次ページデータ
   $nextrows=$rows+1;
   if(! $ary[$nextrows]){
    $next=null;
   }//if
   else{
    $next =$this->me."?saleday=".$ary[$nextrows]["saleday"];
    if($ary[$nextrows]["lincode"]){
     $next.="&lincode=".$ary[$nextrows]["lincode"];
    }//if
   }//else

   //saledayを戻す
   $this->saleday=$saleday;
  }//if

  if($this->me=="tirasitanpin.php" || $this->me=="mailitem.php"){
   //販売期間をゲット
   if(! $this->datasetSaleSpan()) return false;

   //saleday,linocde,jcodeを退避
   $saleday=$this->saleday;
   $lincode=$this->lincode;
   $jcode  =$this->jcode;
   $this->saleday=null;
   $this->lincode=null;
   $this->jcode  =null;

   //販売リストをゲット
   $this->datasetTanpinListData();

   if(! $this->items) return false;

   //該当データ抽出
   $flg=0;
   $ary=$this->items;
   foreach($ary as $rows=>$row){
    if($row["jcode"]==$jcode){
     $flg=1;
     break;
    }//if
   }//foreach
   
   //最初のデータの場合
   if(! $rows){
    $prev=null;
   }//if
   else{
    //前ページデータ
    $prevrows=$rows-1;
    $prev=$this->items[$prevrows];

    $prev =$this->me."?saleday=".$ary[$prevrows]["salestart"];
    if($ary[$prevrows]["jcode"]){
     $prev.="&jcode=".$ary[$prevrows]["jcode"];
    }//if
   }//else

   //現在ページデータ
   $me =$ary[$rows]["flg9"]." ";
   $me.=$ary[$rows]["maker"]." ";
   $me.=$ary[$rows]["sname"]." ";
   $me.=JPNDATE($ary[$rows]["salestart"])." ";
   $me.=$ary[$rows]["tani"]." ";
   $me.=$ary[$rows]["notice"]." ";
   $me.=$ary[$rows]["jcode"]." ";

   //次ページデータ
   $nextrows=$rows+1;
   if(! $this->items[$nextrows]){
    $next=null;
   }//if
   else{
    $next =$this->me."?saleday=".$ary[$nextrows]["salestart"];
    if($ary[$nextrows]["jcode"]){
     $next.="&jcode=".$ary[$nextrows]["jcode"];
    }//if
   }//else

   //saledayを戻す
   $this->saleday=$saleday;
   $this->lincode=$lincode;
   $this->jcode  =$jcode;
  }//if

  if($this->me=="maillist.php"){
   //販売期間をゲット
   if(! $this->datasetSaleSpan()) return false;

   //販売リストをゲット
   $this->partsTirasiDayList();

   if(! $this->items) return false;

   //該当データ抽出
   $flg=0;
   $ary=$this->items;
   foreach($ary as $rows=>$row){
    if($row["saleday"]==$this->saleday){
     $flg=1;
     break;
    }//if
   }//foreach

   //最初のデータの場合
   if(! $rows){
    $prev=null;
   }//if
   else{
    //前ページデータ
    $prevrows=$rows-1;
    $prev=$this->items[$prevrows];

    $prev =$this->me."?saleday=".$ary[$prevrows]["saleday"];
   }//else

   //現在ページデータ
   $me =JPNDATE($ary[$rows]["saleday"])." ";

   //次ページデータ
   $nextrows=$rows+1;
   if(! $this->items[$nextrows]){
    $next=null;
   }//if
   else{
    $next =$this->me."?saleday=".$ary[$nextrows]["saleday"];
   }//else
  }//if

  $this->pageinfo[0]["prev"]=$prev;
  $this->pageinfo[0]["title"]=$me.$this->pageinfo[0]["title"];
  $this->pageinfo[0]["description"].=$me;
  $this->pageinfo[0]["next"]=$next;

  return $this->items;
 }//public function partsNextPrev(){
//----------------------------------------------------------//
// ロゴイメージ作成
// $this->elementにロゴイメージ(id=logoimg)が作成される
//----------------------------------------------------------//
 public function partsLogo(){
  //店舗情報ゲット
  if(! $this->storeinfo){
   if(! $this->datasetStoreInfo()) throw new exception ("店舗情報がありません");
  }//if
  $store=$this->storeinfo;

  //$this->part退避
  $this->htmlescapepart();

  //ロゴイメージ用div作成($this->partにdiv#logoimgが生成)
  $this->htmlcreatediv("class","logoimg");
  $this->stackpart();

  //リンク用a作成($this->elementにaタグが生成)
  $this->htmla("index.php","");
  $this->appendpart("logoimg");

  //ロゴイメージ作成
  foreach($store as $rows =>$row){
   if($row["colname"]=="logo"){
    $logourl=$row["val"];
   }//if
   if($row["colname"]=="storename"){
    $storename=$row["val"];
   }//if
  }//foreach
  $this->htmlimg(IMG.$logourl,$storename,$storename);
  $this->appendpart("a");
  $this->element=$this->part;

  //退避したpartを戻す
  $this->htmlreturnpart();

  return $this->element;
 }//public function partsLogo(){

//----------------------------------------------------------//
// グループリスト作成
// $this->elementにグループリスト(div.group)が作成される
//----------------------------------------------------------//
 public function partsGroup($parent){
  //グループデータゲット
  if(! $this->datasetChildren($parent)) throw new exception("該当グループがありません");
  $data=$this->pageinfo;

  //$this->part退避
  if($this->part) $part=$this->part;
  $this->part="";

  //divを作成($this->partにdiv.groupが生成)
  $this->htmlcreatediv("class","group");
  $this->stackpart();

  //ulをセット($this->elementにulが生成)
  $this->htmlcreateul($data,$this->me);

  //ulをdivへ追加
  $this->appendpart("group");

  $this->element=$this->part;
  if($part) $this->part=$part;

  return $this->element;
 }//public function partsGroup($group){

//----------------------------------------------------------//
// 営業時間リスト作成
// $this->elementにdiv.eigyoが作成される
//----------------------------------------------------------//
 public function partsEigyo(){
  //表示したい項目をここに列記
  $ary=array("opentime","address","telephone");

  //$this->partを退避
  $this->htmlescapepart();

  //divを作成($this->partにdiv.eigyoを生成)
  $this->htmlcreatediv("class","eigyo");
  $this->stackpart();

  //店舗情報をゲット
  if(! $this->storeinfo) $this->datasetStoreInfo();

  foreach($this->storeinfo as $rows=>$row){
   foreach($ary as $rows2=>$row2){
    if($row["colname"]==$row2){
     $this->htmlspan($row["jpnname"]);
     $this->addelement("span",$row["val"]."<br />");
     $this->appendpart("eigyo");
     break;
    }//if
   }//foreach
  }//foreach
  
  $this->element=$this->part;

  //退避したpartを戻す
  $this->htmlreturnpart();

  return $this->element;
 }//public function partsEigyo(){


//==========================================================//
// バナーを作成
// $this->elementにhtmlがセットされる
// $data=array( "url"        =>"リンク先URL",
//             ,"title"      =>"表示するタイトル"
//             ,"img"        =>"表示する画像"
//             ,"discription"=>"表示する文字"
//            )
//==========================================================//
 public function partsBanner($data){
  //$this->partを退避
  $this->htmlescapepart();

  $div="";
  foreach($data as $rows=>$row){
   //div.bigmenuを作成($this->partにdiv.bannerを生成)
   $this->htmlcreatediv("class","banner");
   $this->stackpart();
   
   //div.bigmenuへaタグを追加
   $this->htmla($row["url"]);
   $this->appendpart("banner");

   //h2をaタグへ追加
   $this->htmlh2($row["title"]);
   $this->appendpart("a");

   //imgをaタグへ追加
   $this->htmlimg($row["img"],$row["title"],$row["title"]);
   $this->appendpart("a");

   //spanをaタグへ追加
   $this->htmlspan($row["description"]);
   $this->appendpart("a");

   //div.bigmenuを$divへ追加
   $div.=$this->part;
   $this->part="";
  }//foraech
  $this->element=$div;
  
  $this->htmlreturnpart();

  return $this->element;
 }// public function partsBanner($pagename){

//==========================================================//
// バナーグループ作成
// $this->elementにhtmlが入る
//==========================================================//
 public function partsBrothBanner(){
  if(! $this->me) throw new exception("ページ名をセットしてください");
  if(! $this->datasetBroth($this->me)) return false;
  
  //ul用にデータを加工
  $ary[]=array("title"=>"関連ページ");
  foreach($this->pageinfo as $rows=>$row){
   $ary[]=array( "url"  =>$row["pagename"]
                ,"title"=>$row["title"]
               );
  }//foreach

  $this->htmlcreateul($ary,$this->me);
 }//public function partsTirasiBanner(){

//==========================================================//
// チラシ日程グループ作成
// $this->elementにhtmlが入る
//==========================================================//
 public function partsTirasiDayList(){
  if(! $this->me) throw new exception("リンク先ページを指定してください");

  //チラシ日程データゲット($this->itemsに日程データがセットされる)
  if(! $this->datasetDayListData()){
   $this->element="";
   return false;
  }//if

  //リンク先URLをセット
  $baseurl=$this->me."?saleday=";

  //セールタイプセット
  //$this->saletype=1;
  
  //li用データ作成
  $ary[]=array("title"=>"日程");
  foreach($this->items as $rows=>$row){
   $saleday=JPNDATE($row["saleday"]);
   $ary[]=array( "url"=>$baseurl.$row["saleday"] 
                ,"title"=>$saleday
               );
  }//foreach
   
  //$this->part退避
  $this->htmlescapepart();

  //
  $this->htmlcreateul($ary,$baseurl.$this->saleday);

  //$this->part戻し
  $this->htmlreturnpart();
  return $this->element;
 }//public function partsTirasiDayList(){

//==========================================================//
// チラシライングループ作成
// $this->elementにhtmlが入る
//==========================================================//
 public function partsTirasiLinList(){
  if(! $this->me) throw new exception("リンク先ページを指定してください");

  //lincodeデータゲット($this->itemsに日程データがセットされる)
  if(! $this->datasetLinGroup()){
   $this->element="";
   return false;
  }//if

  //リンク先URLをセット
  //$baseurl=$this->me."?saleday=".$this->saleday."&lincode=";
  $baseurl=$this->me."?saleday=".$this->saleday;

  //セールタイプセット
  $this->saletype=1;
  
  //li用データ作成
  $ary[]=array("title"=>"カテゴリー別");
  $ary[]=array("url"  =>$baseurl,
               "title"=>"すべての商品");

  foreach($this->items as $rows=>$row){
   //$saleday=JPNDATE($row["saleday"]);
   if($row["lincode"]){
    $url=$baseurl."&lincode=".$row["lincode"];
   }//if
   else{
    $url=$baseurl;
   }
   $ary[]=array( "url"=>$url 
                ,"title"=>$row["linname"]."(".$row["jcode"].")"
               );
  }//foreach
  
  //$this->part退避
  $this->htmlescapepart();

  //
  $this->htmlcreateul($ary,$baseurl."&lincode=".$this->lincode);

  //$this->part戻し
  $this->htmlreturnpart();

  return $this->element;
 }//public function partsTirasiLinList(){


//==========================================================//
// イベントタイトル作成
// $this->elementにhtmlが入る
// $dataは単一データを想定
//==========================================================//
 public function partsEventTitle($data){
  $html="";
  $salespan=JPNDATE($data["saleend"]);
  if($data["salestart"]==$data["saleend"]){
   $salespan.="限り";
  }//if
  else{
   $salespan.="まで";
  }//else

  //タイトルをセット
  $title=$salespan." ".$data["flg2"];
  
  $html =$this->htmlclr();
  $html.=$this->htmlh2($title);
  $this->element=$html;

  return $this->element;
 }//public function partsEventTitle($data){

//==========================================================//
// イベント画像作成
// $this->elementにhtmlが入る
// $dataは単一データを想定
//==========================================================//
 public function partsEventImg($data){
  $this->element="";
  $html =$this->htmlclr();
  if(file_exists("../".IMG.$data["flg3"].".jpg")){
   $html.=$this->htmlimg(IMG.$data["flg3"].".jpg");
   $this->htmlcreatediv("class","eventimg");
   $this->appendelement("eventimg",$html);
  }
  return $this->element;

 }//public function partsEventImg($data){
 
//==========================================================//
// 単品をセットする
// $dataは単一データを想定
//==========================================================//
 public function partsTanpinDeteil($data){
  $this->htmltanpin();
  foreach($data as $col=>$val){
   if($col!="price"){
    $this->element=preg_replace("/<!--".$col."-->/",$val,$this->element);
   }//if
  }//foreach

  //リンク先をセット
  //$url=$this->me."?saleday=".$data["salestart"]."&jcode=".$data["jcode"];
  $url=$this->me."?saleday=".$data["salestart"]."&lincode=".$data["lincode"]."&jcode=".$data["jcode"];
  $this->element=preg_replace("/<!--url-->/",$url,$this->element);

  //イメージ対応
  $this->element=preg_replace("/<!--IMG-->/",IMG,$this->element);
  if(file_exists("../".IMG.$data["jcode"].".jpg")){
   $this->element=preg_replace("/<!--img-->/",$data["jcode"].".jpg",$this->element);
  }//if
  else{
   $pattern="/<!--imgstart-->.*<!--imgend-->/s";
   $this->element=preg_replace($pattern,"&nbsp",$this->element);
  }//else

  //$row["price"]に入っている売価を数字と分裂させる
  $pattern="/([P0-9]+)(.*)/";
  preg_match($pattern,$data["price"],$match);

  //売価対応
  $pattern="/<!--price-->/";
  $this->element=preg_replace($pattern,$match[1],$this->element);

  //通貨単位対応(円、割引,%引き)
  $pattern="/<!--yen-->/";
  if($match[2]) $this->element=preg_replace($pattern,$match[2],$this->element);
  if(! $match[2]) $this->element=preg_replace($pattern,"円",$this->element);

  //販売日をセット
  $salespan=JPNDATE($data["saleend"]);
  if($data["salestart"]==$data["saleend"]){
   $salespan.="限り";
  }//if
  else{
   $salespan.="まで";
  }//else
  $pattern="/<!--saleday-->/";
  $this->element=preg_replace($pattern,$salespan,$this->element);

  $html.=$this->element;
  $this->element=$html;
  return $this->element;
 }//public function partsTanpinDeteil($data,$me=null){

//==========================================================//
// 単品をセットする
// $dataは単一データを想定
//==========================================================//
 public function partsBigTanpin($data){
  $this->htmlbigtanpin();
  foreach($data as $col=>$val){
   if($col!="price"){
    $this->element=preg_replace("/<!--".$col."-->/",$val,$this->element);
   }//if
  }//foreach

  //セール画像セット
  if($data["saletype"]){
   $url=IMG.$data["saletype"].".jpg";
   $this->element=preg_replace("/<!--saletypeimg-->/",$url,$this->element);
  }//if
  else{
   $pattern="/<!--saletypeimgstart-->.*<!--saletypeimgend-->/";
   $this->element=preg_replace($pattern,"",$this->element);
  }
  //商品画像セット
  if(file_exists("../".IMG.$data["jcode"].".jpg")){
   $this->element=preg_replace("/<!--img-->/",$data["jcode"].".jpg",$this->element);
  }//if
  else{
   $pattern="/<!--imgstart-->.*<!--imgend-->/s";
   $this->element=preg_replace($pattern,"&nbsp",$this->element);
  }//else

  //画像ディレクトリ反映
  $this->element=preg_replace("/<!--IMG-->/",IMG,$this->element);

  //$row["price"]に入っている売価を数字と分裂させる
  $pattern="/([P0-9]+)(.*)/";
  preg_match($pattern,$data["price"],$match);

  //売価対応
  $pattern="/<!--price-->/";
  $this->element=preg_replace($pattern,$match[1],$this->element);

  //通貨単位対応(円、割引,%引き)
  $pattern="/<!--yen-->/";
  if($match[2]) $this->element=preg_replace($pattern,$match[2],$this->element);
  if(! $match[2]) $this->element=preg_replace($pattern,"円",$this->element);
  $html.=$this->element;

  $this->element=$html;
  return $this->element;
 }//public function partsTanpinDeteil($data,$me=null){


//==========================================================//
// 単品の詳細画像をセットする
// $this->elementに該当データあることが前提
//==========================================================//
 public function partsTanpinImg($data){
  $this->stackpart();
  $html="";
  $url="..".IMG.$data["jcode"];
  foreach(glob($url."*.jpg") as $filename){
   $imgurl=IMG.basename($filename);
   $alt=$data["maker"].$data["sname"].$data["tani"].basename($filename);
   $img=$this->htmlimg($imgurl,$alt);
   $this->htmlcreatediv("class","imgdeteil");
   $this->appendelement("imgdeteil",$img);
   $this->appendpart("imgdiv");
  }//foreach
  //リンクを削除
  $this->part=preg_replace("/<a href.*>/","",$this->part);
  $this->part=preg_replace("/<\/a>/","",$this->part);

  //
  //$this->part=preg_replace('/<div class.*clr.*\/div>/',"",$this->part);

  $this->element=$this->part;
  return $this->element;
 }//public function partsTanpinImg(){
 
//----------------------------------------------------------//
// ニュースリリースを作成
// $this->divにデータがセットされる
//----------------------------------------------------------//
 public function getNews(){
  $this->getNewsData();

  if(! $this->items["data"]) return false;

  foreach($this->items["data"] as $rows=>$row){
   $this->creatediv("class","newsdate");
   $this->element=date("Y年m月d日",strtotime($row["saleday"]));
   $this->appenddiv("newsdate");
   $newsdate=$this->div;

   $this->creatediv("class","newstitle");
   $this->element=$row["notice"];
   $this->appenddiv("newstitle");
   $newstitle=$this->div;

   $li[]=array("title"=>$newsdate.$newstitle,"url"=>$row["flg8"]);
  }//foreach
  $this->htmlcreateul($li);
  $ul=$this->element;

  $this->creatediv("class","news");
  $this->create_span("最新ニュース");
  $this->appenddiv("news");

  $this->element=$ul;
  $this->appenddiv("news");
 }//public function getnews(){

// ================================================================ //
// チラシ単品データ作成
// 対象テーブル TB_SALEITEMS
// ================================================================ //
 public function getTirasiTanpinList($saleday=null){
  //日付ゲット
  if(! $saleday) $saleday=date("Y-m-d");
  if(! ISDATE($saleday)) throw new exception("日付を確認してください");
  
  //単品データゲット
  $this->getTirasiTanpinListData($saleday);
  if(! $this->items["data"]) return false;
  
  //単品HTMLゲット
  $this->getTanpin($this->items["data"]);
  
 }//public function getTirasiTanpinList($saleday=null){
}//class parts extends html{
?>
