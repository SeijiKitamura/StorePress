<?php
require_once("server.conf.php");

//---------------------------------------------------//
// デバックモード(true で「する」、falseで「しない」 //
//---------------------------------------------------//
define("DEBUG",true);
//---------------------------------------------------//

define("TABLE_PREFIX"   ,"hp2_");   //テーブルプレフィックス
define("JQNAME"         ,"jquery.js");          //jQueryファイル名


define("JANMASLIMIT"    ,10);//1画面に表示させるアイテム数 
define("NAVISTART"      ,5); //ナビ表示開始ページ(現在ページより前ページ）
define("NAVISPAN"       ,10);//ナビ表示ページ数 
define("SALESTART"      ,30);//新商品の抽出基準。何日前までを新商品とするか
define("NEWITEM"        ,20);//新商品の表示件数。
define("PAGETITLE"      ,2); //改ページ挿入位置。1ページに印刷するサブタイトル数
define("PAGEITEM"       ,13);//改ページ挿入位置。1ページに印刷するアイテム数

//---------------------------------------------------//
// Web系ディレクトリ系定数
//---------------------------------------------------//
define("IMG" ,HOME."img/");             //画像ディレクトリ
define("JS"  ,HOME."js/");              //JavaScript Jquery保存場所
define("PHP" ,HOME."php/");             //PHP
define("CSS" ,HOME."css/");             //CSS
define("DATA",HOME."data/");            //データ

//---------------------------------------------------//
// ファイル系定数(Web用)
//---------------------------------------------------//
define("FAV"     ,IMG.FAVNAME);       //ファビコン
define("LOGO"    ,IMG.LOGONAME);      //ロゴ
define("JQ"      ,JS.JQNAME);         //jQueryファイル名

//---------------------------------------------------//
// ファイルディレクトリ系定数(cron用)
//---------------------------------------------------//
define("IMGDIR" ,SITEDIR.IMG);  //画像保存場所
define("JSDIR"  ,SITEDIR.JS);   //JavaScript Jquery保存場所
define("PHPDIR" ,SITEDIR.PHP);  //PHP
define("CSSDIR" ,SITEDIR.CSS);  //css
define("DATADIR",SITEDIR.DATA); //更新データ
//---------------------------------------------------//

//----------------------------------------------------------//
// ファイル名定数(これがそのままテーブル名となる)
//----------------------------------------------------------//
define("JANMAS"   ,"janmas");            //単品マスタ
define("CLSMAS"   ,"clsmas");            //クラスマスタ
define("LINMAS"   ,"linmas");            //部門マスタ

//define("CAL"      ,"calendar");          //カレンダー
//define("ITEMS"    ,"tirasiitem");        //チラシデータ
//define("MAILITEMS","mailitems");         //メールアイテム
//define("GOYOYAKU" ,"goyoyaku");          //ご注文商品

define("SALEITEMS","saleitems");         //セールアイテム
define("PAGECONF" ,"pageconfig");        //ページごとの設定
define("SALETYPE" ,"saletype");          //セールタイプ設定
define("STORE"    ,"storeprofile");      //会社情報
//---------------------------------------------------//

//---------------------------------------------------//
// ファイルパス系定数
//---------------------------------------------------//
define("JANCSV"     ,DATADIR.JANMAS.".csv");    //単品マスタ
define("CLSCSV"     ,DATADIR.CLSMAS.".csv");    //クラスマスタ
define("LINCSV"     ,DATADIR.LINMAS.".csv");    //部門マスタ

//define("CALCSV"     ,DATADIR.CAL.".csv");       //カレンダー
//define("ITEMCSV"    ,DATADIR.ITEMS.".csv");     //チラシデータ
//define("MAILITEMSCSV",DATADIR.MAILITEMS.".csv");//メールアイテム
//define("GOYOYAKUCSV",DATADIR.GOYOYAKU.".csv");  //ご予約商品

define("SALEITEMSCSV"    ,DATADIR.SALEITEMS.".csv");//アイテムデータ
define("PAGECONFCSV",DATADIR.PAGECONF.".csv");  //ページごとの設定
define("SALETYPECSV",DATADIR.SALETYPE.".csv");  //セールタイプ設定
define("STORECSV"   ,DATADIR.STORE.".csv");     //会社情報
//---------------------------------------------------//


//---------------------------------------------------//
// DB 接続系定数
//---------------------------------------------------//

//---------------------------------------------------//
// DB テーブル名定数
//---------------------------------------------------//
//define("TB_CAL"         ,TABLE_PREFIX.CAL);         //カレンダー
define("TB_JANMAS"      ,TABLE_PREFIX.JANMAS);      //単品マスタ
define("TB_CLSMAS"      ,TABLE_PREFIX.CLSMAS);      //クラスマスタ
define("TB_LINMAS"      ,TABLE_PREFIX.LINMAS);      //部門マスタ
define("TB_SALEITEMS"   ,TABLE_PREFIX.SALEITEMS);   //アイテム
define("TB_PAGECONF"    ,TABLE_PREFIX.PAGECONF);    //ページ設定
define("TB_SALETYPE"    ,TABLE_PREFIX.SALETYPE);    //セールタイプ設定
define("TB_STORE"       ,TABLE_PREFIX.STORE);       //会社情報

//---------------------------------------------------//
// DB テーブル列系定数
//---------------------------------------------------//
define("IDATE"   ,"idate"); //作成日時。各テーブルに必ずセットされる。
define("CDATE"   ,"cdate"); //更新日時。各テーブルに必ずセットされる。
define("IDATESQL"," ".IDATE." timestamp not null default current_timestamp");
define("CDATESQL"," ".CDATE." timestamp     null");
 //---------------------------------------------------//

//---------------------------------------------------//
// テーブル情報                                      //
//---------------------------------------------------//

$TABLES=array(
               TB_JANMAS=>array(
                                "jcode"=>array( "type"   =>"varchar(14)"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>0
                                               ,"primary"=>1
                                               ,"local"  =>"JANコード"
                                              )//jcode
                             ,"clscode"=>array( "type"   =>"int"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>0
                                               ,"primary"=>""
                                               ,"local"  =>"クラスコード"
                                              )//clscode
                             ,"maker"    =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"メーカー"
                                                )//maker   
                             ,"sname"  =>array( "type"   =>"varchar(255)"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>"''"
                                               ,"primary"=>""
                                               ,"local"  =>"商品名"
                                              )//sname
                             ,"tani"     =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"販売単位"
                                                )//tani    
                           ,"stdprice" =>array( "type"   =>"int"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>0
                                               ,"primary"=>""
                                               ,"local"  =>"標準売価"
                                              )//stdprice
                          ,"price"    =>array(  "type"   =>"int"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>0
                                               ,"primary"=>""
                                               ,"local"  =>"売価"
                                              )//price
                          ,"salestart" =>array(  "type"  =>"date"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>"'0000-00-00'"
                                               ,"primary"=>""
                                               ,"local"  =>"販売開始日"
                                              )//salestart
                          ,"lastsale" =>array(  "type"   =>"date"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>"'0000-00-00'"
                                               ,"primary"=>""
                                               ,"local"  =>"最終販売日"
                                              )//lastsale
                            )//TB_JANMAS
              ,TB_CLSMAS=>array(
                              "clscode"=>array( "type"   =>"int"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>0
                                               ,"primary"=>""
                                               ,"local"  =>"クラスコード"
                                              )//clscode
                             ,"clsname"=>array( "type"   =>"varchar(255)"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>"''"
                                               ,"primary"=>""
                                               ,"local"  =>"クラス名"
                                              )//clsname
                             ,"lincode"=>array( "type"   =>"int"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>"0"
                                               ,"primary"=>""
                                               ,"local"  =>"部門番号"
                                              )//lincode
                            )//TB_CLSMAS
              ,TB_LINMAS=>array(
                              "lincode"=>array( "type"   =>"int"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>0
                                               ,"primary"=>""
                                               ,"local"  =>"部門番号"
                                              )//lincode
                             ,"linname"=>array( "type"   =>"varchar(255)"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>"''"
                                               ,"primary"=>""
                                               ,"local"  =>"部門名"
                                              )//linname
                             ,"dpscode"=>array( "type"   =>"int"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>"0"
                                               ,"primary"=>""
                                               ,"local"  =>"メジャー番号"
                                              )//dpscode
                            )//TB_LINMAS
              ,TB_PAGECONF=>array(
                               "id"    =>array( "type"   =>"int"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>"auto"
                                               ,"default"=>"0"
                                               ,"primary"=>1
                                               ,"local"  =>"番号"
                                              )//id
                             ,"pagename" =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"ページ名"
                                                )//pagename  
                             ,"attr"     =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"属性"
                                                )//attr  
                             ,"val"      =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"値"
                                                )//val
                                  )//TB_PAGECONF
              ,TB_SALETYPE=> array(
                             "saletype"=>array( "type"   =>"int"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>0
                                               ,"primary"=>1
                                               ,"local"  =>"セールタイプ"
                                              )//saletype
                               ,"title"=>array( "type"   =>"varchar(99)"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>"''"
                                               ,"primary"=>""
                                               ,"local"  =>"タイトル"
                                              )//title
                                  )//TB_SALETYPE
              ,TB_SALEITEMS=>array(
                               "id"    =>array( "type"   =>"int"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>"auto"
                                               ,"default"=>"0"
                                               ,"primary"=>1
                                               ,"local"  =>"番号"
                                              )//id
                             ,"saleday"  =>array( "type"   =>"date"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"'0000-00-00'"
                                                 ,"primary"=>""
                                                 ,"local"  =>"販売日"
                                                )//saleday   
                             ,"saletype" =>array( "type"   =>"int"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"0"
                                                 ,"primary"=>""
                                                 ,"local"  =>"セールタイプ"
                                                )//saletype  
                             ,"clscode"=>array( "type"   =>"int"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>0
                                               ,"primary"=>""
                                               ,"local"  =>"クラスコード"
                                              )//clscode
                             ,"jcode"    =>array( "type"   =>"varchar(14)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"0"
                                                 ,"primary"=>""
                                                 ,"local"  =>"JANコード"
                                                )//jcode   
                             ,"maker"    =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"メーカー"
                                                )//maker   
                              ,"sname"   =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"商品名"
                                                 )//sname   
                             ,"tani"     =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"販売単位"
                                                )//tani    
                             ,"price"    =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"売価"
                                                )//price   
                             ,"notice"   =>array( "type"   =>"varchar(1000)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"コメント"
                                                )//notice  
                             ,"flg0"     =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"フラグ0"
                                                )//flg0  
                             ,"flg1"     =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"フラグ1"
                                                )//flg1  
                             ,"flg2"     =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"フラグ2"
                                                )//flg2  
                             ,"flg3"     =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"フラグ3"
                                                )//flg3  
                             ,"flg4"     =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"フラグ4"
                                                )//flg4  
                             ,"flg5"     =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"フラグ5"
                                                )//flg5  
                             ,"flg6"     =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"フラグ6"
                                                )//flg6  
                             ,"flg7"     =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"フラグ7"
                                                )//flg7  
                             ,"flg8"     =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"フラグ8"
                                                )//flg8  
                             ,"flg9"     =>array( "type"   =>"varchar(255)"
                                                 ,"null"   =>"not null"
                                                 ,"extra"  =>""
                                                 ,"default"=>"''"
                                                 ,"primary"=>""
                                                 ,"local"  =>"フラグ9"
                                                )//flg9  
                                  )//TB_SALEITEMS
              ,TB_STORE   => array(
                               "id"    =>array( "type"   =>"int"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>"auto"
                                               ,"default"=>"0"
                                               ,"primary"=>1
                                               ,"local"  =>"番号"
                                              )//id

                            ,"colname" =>array( "type"   =>"varchar(255)"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>"''"
                                               ,"primary"=>0
                                               ,"local"  =>"列名"
                                              )//colname 
                            ,"jpnname" =>array( "type"   =>"varchar(255)"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>"''"
                                               ,"primary"=>0
                                               ,"local"  =>"日本語列名"
                                              )//jpnname 
                            ,"val"     =>array( "type"   =>"varchar(255)"
                                               ,"null"   =>"not null"
                                               ,"extra"  =>""
                                               ,"default"=>"''"
                                               ,"primary"=>0
                                               ,"local"  =>"値"
                                              )//val 
                                  )//TB_STORE
            );//TABLES

//---------------------------------------------------//

//---------------------------------------------------//
// CSV並び順配列
//---------------------------------------------------//
$CSVCOLUMNS=array( JANMAS   =>array(
                                     "jcode"
                                    ,"clscode"
                                    ,"maker"
                                    ,"sname"
                                    ,"tani"
                                    ,"stdprice"
                                    ,"price"
                                    ,"salestart"
                                    ,"lastsale"
                                   )//JANMAS
                  ,CLSMAS   =>array(
                                     "clscode"
                                    ,"clsname"
                                    ,"lincode"
                                   )//CLSMAS
                  ,LINMAS   =>array(
                                     "lincode"
                                    ,"linname"
                                    ,"dpscode"
                                   )//LINMAS
                  ,PAGECONF=>array ( 
                                     "pagename"
                                    ,"attr"
                                    ,"val"
                                   )//PAGECONF
                  ,SALETYPE=>array ( 
                                     "saletype"
                                    ,"title"
                                   )//SALETYPE
                  ,SALEITEMS=>array(
                                       "saleday"
                                      ,"saletype"
                                      ,"clscode"
                                      ,"jcode"
                                      ,"maker"
                                      ,"sname"
                                      ,"tani"
                                      ,"price"
                                      ,"notice"
                                      ,"flg0"
                                      ,"flg1"
                                      ,"flg2"
                                      ,"flg3"
                                      ,"flg4"
                                      ,"flg5"
                                      ,"flg6"
                                      ,"flg7"
                                      ,"flg8"
                                      ,"flg9"
                                   )//SALEITEMS
                  ,STORE=>array(
                                       "colname"
                                      ,"jpnname"
                                      ,"val"
                                   )//STORE
                 );//CSVCOLUMNS
//---------------------------------------------------//

//---------------------------------------------------//
// twitter timeline
//---------------------------------------------------//
$TWITTER=<<<EOF
<a class="twitter-timeline" href="https://twitter.com/Super_Kitamura" data-widget-id="318233150339809280">@Super_Kitamura からのツイート</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
EOF;

$TWIBTN=<<<EOF
<a href="https://twitter.com/share" class="twitter-share-button" data-lang="ja">ツイート</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
EOF;

$FACEBTN=<<<EOF
<div class="fb-like" data-href="__URL__" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false"></div>
EOF;

?>
