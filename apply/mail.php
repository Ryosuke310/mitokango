<?php header("Content-Type:text/html;charset=utf-8"); ?>
<?php //error_reporting(E_ALL | E_STRICT);
###############################################################################################
##
#  PHPメールプログラム　フリー版
#　改造や改変は自己責任で行ってください。
#	
#  今のところ特に問題点はありませんが、不具合等がありましたら下記までご連絡ください。
#  MailAddress: info@php-factory.net
#  name: K.Numata
#  HP: http://www.php-factory.net/
#
#  重要！！サイトでチェックボックスを使用する場合のみですが。。。
#  チェックボックスを使用する場合はinputタグに記述するname属性の値を必ず配列の形にしてください。
#  例　name="当サイトをしったきっかけ[]"  として下さい。
#  nameの値の最後に[と]を付ける。じゃないと複数の値を取得できません！
##
###############################################################################################

// フォームページ内の「名前」と「メール」項目のname属性の値は特に理由がなければ以下が最適です。
// お名前 <input size="30" type="text" name="名前" />　メールアドレス <input size="30" type="text" name="Email" />
// メールアドレスのname属性の値が「Email」ではない場合、または変更したい場合は、以下必須設定箇所の「$Email」の値も変更下さい。


/*
★以下設定時の注意点　
・値（=の後）は数字以外の文字列はすべて（一部を除く）ダブルクオーテーション（"）、またはシングルクォーテーション（'）で囲んでいます。
・これをを外したり削除したりしないでください。後ろのセミコロン「;」も削除しないください。プログラムが動作しなくなります。
・またドルマーク（$）が付いた左側の文字列は絶対に変更しないでください。数字の1または0で設定しているものは必ず半角数字でお願いします。
*/


//---------------------------　必須設定　必ず設定してください　-----------------------

//サイトのトップページのURL　※デフォルトでは送信完了後に「トップページへ戻る」ボタンが表示されますので
$site_top = "http://www.mito.ac.jp/";

// 管理者メールアドレス ※メールを受け取るメールアドレス(複数指定する場合は「,」で区切ってください)
$to = "my1@mito.ac.jp";

//フォームのメールアドレス入力箇所のname属性の値（メール形式チェックに使用。※2重アドレスチェック導入時にも使用します）
$Email = "Email";

/*------------------------------------------------------------------------------------------------
以下スパム防止のための設定　※このファイルとフォームページが同一ドメイン内にある必要があります（XSS対策）
------------------------------------------------------------------------------------------------*/

//スパム防止のためのリファラチェック（フォームページが同一ドメインであるかどうかのチェック）(する=1, しない=0)
$Referer_check = 0;

//リファラチェックを「する」場合のドメイン ※以下例を参考に設置するサイトのドメインを指定して下さい。
$Referer_check_domain = "php-factory.net";

//---------------------------　必須設定　ここまで　------------------------------------


//---------------------- 任意設定　以下は必要に応じて設定してください ------------------------

// このPHPファイルの名前 ※ファイル名を変更した場合は必ずここも変更してください。
$file_name ="mail.php";

// 管理者宛のメールで差出人を送信者のメールアドレスにする(する=1, しない=0)
// する場合は、メール入力欄のname属性の値を「$Email」で指定した値にしてください。
//メーラーなどで返信する場合に便利なので「する」がおすすめです。
$userMail = 1;

// Bccで送るメールアドレス(複数指定する場合は「,」で区切ってください)
$BccMail = "";

// 管理者宛に送信されるメールのタイトル（件名）
$subject = "オープンキャンパス申込：ホームページから";

// 送信確認画面の表示(する=1, しない=0)
$confirmDsp = 1;

// 送信完了後に自動的に指定のページ(サンクスページなど)に移動する(する=1, しない=0)
// CV率を解析したい場合などはサンクスページを別途用意し、URLをこの下の項目で指定してください。
// 0にすると、デフォルトの送信完了画面が表示されます。
$jumpPage = 1;

// 送信完了後に表示するページURL（上記で1を設定した場合のみ）※httpから始まるURLで指定ください。
$thanksPage = "http://www.mito.ac.jp/opencampus/thanks.html";

// 必須入力項目を設定する(する=1, しない=0)
$esse = 1;

/* 必須入力項目(入力フォームで指定したname属性の値を指定してください。（上記で1を設定した場合のみ）
値はシングルクォーテーションで囲んで下さい。複数指定する場合は「,」で区切ってください)*/
$eles = array('氏名','ふりがな','年齢','性別','Email','郵便番号','住所','電話番号','学校名','学年','参加希望の学校','送迎バス希望の有無','オープンキャンパス参加歴','今回の参加は');


//----------------------------------------------------------------------
//  自動返信メール設定(START)
//----------------------------------------------------------------------

// 差出人に送信内容確認メール（自動返信メール）を送る(送る=1, 送らない=0)
// 送る場合は、フォーム側のメール入力欄のname属性の値が上記「$Email」で指定した値と同じである必要があります
$remail = 1;

//自動返信メールの送信者欄に表示される名前　※あなたの名前や会社名など（もし自動返信メールの送信者名が文字化けする場合ここは空にしてください）
$refrom_name = "";

// 差出人に送信確認メールを送る場合のメールのタイトル（上記で1を設定した場合のみ）
$re_subject = "オープンキャンパス受付　確認メール";

//フォーム側の「名前」箇所のname属性の値　※自動返信メールの「○○様」の表示で使用します。
//指定しない、または存在しない場合は、○○様と表示されないだけです。あえて無効にしてもOK
$dsp_name = 'お名前';

//自動返信メールの文言 ※日本語部分は変更可です
$remail_text = <<< TEXT

この度は、オープンキャンパスのお申し込みを頂き、ありがとうございました。

ご記入いただきました個人情報は、漏えい・流用等がないように、学校法人八文字学園にて厳重に管理させていただきます。

学校法人　八文字学園
茨城県水戸市浜田2-11-18

TEXT;


//自動返信メールに署名を表示(する=1, しない=0)※管理者宛にも表示されます。
$mailFooterDsp = 0;

//上記で「1」を選択時に表示する署名（FOOTER〜FOOTER;の間に記述してください）
$mailSignature = <<< FOOTER

──────────────────────
学校法人八文字学園
茨城県水戸市浜田2-16-12
TEL：029-221-8800
URL: http://www.mito.ac.jp/
──────────────────────

FOOTER;


//----------------------------------------------------------------------
//  自動返信メール設定(END)
//----------------------------------------------------------------------


//メールアドレスの形式チェックを行うかどうか。(する=1, しない=0)
//※デフォルトは「する」。特に理由がなければ変更しないで下さい。メール入力欄のname属性の値が上記「$Email」で指定した値である必要があります。
$mail_check = 1;

//------------------------------- 任意設定ここまで ---------------------------------------------



// 以下の変更は知識のある方のみ自己責任でお願いします。

//----------------------------------------------------------------------
//  関数定義(START)
//----------------------------------------------------------------------
function checkMail($str){
	$mailaddress_array = explode('@',$str);
	if(preg_match("/^[\.!#%&\-_0-9a-zA-Z\?\/\+]+\@[!#%&\-_0-9a-z]+(\.[!#%&\-_0-9a-z]+)+$/", "$str") && count($mailaddress_array) ==2){
		return true;
	}
	else{
		return false;
	}
}
function h($string) {
  return htmlspecialchars($string, ENT_QUOTES,'utf-8');
}
function sanitize($arr){
	if(is_array($arr)){
		return array_map('sanitize',$arr);
	}
	return str_replace("\0","",$arr);
}
if(isset($_GET)) $_GET = sanitize($_GET);//NULLバイト除去//
if(isset($_POST)) $_POST = sanitize($_POST);//NULLバイト除去//
if(isset($_COOKIE)) $_COOKIE = sanitize($_COOKIE);//NULLバイト除去//

//----------------------------------------------------------------------
//  関数定義(END)
//----------------------------------------------------------------------
$copyrights = '<a style="display:block;text-align:center;margin:15px 0;font-size:11px;color:#aaa;text-decoration:none" href="http://www.php-factory.net/" target="_blank">- PHP工房 -</a>';

if($Referer_check == 1 && !empty($Referer_check_domain)){
	if(strpos($_SERVER['HTTP_REFERER'],$Referer_check_domain) === false){
		echo '<p align="center">リファラチェックエラー。フォームページのドメインとこのファイルのドメインが一致しません</p>';exit();
	}
}
$sendmail = 0;
$empty_flag = 0;
$post_mail = '';
$errm ='';
$header ='';

// 必須設定項目のチェック
if($esse == 1) {
	$length = count($eles) - 1;
	foreach($_POST as $key=>$val) {
		if($val != "confirm_submit"){
			for($i=0; $i<=$length; $i++) {
				if($key == $eles[$i] && empty($val)) {
					$errm .= "<p class=\"error_messe\">「".$key."」は必須入力項目です。</p>\n";
					$empty_flag = 1;
				}
			}
		}
	}
	foreach($_POST as $key=>$val) {
		for($i=0; $i<=$length; $i++) {
			if($key == $eles[$i]) {
				$eles[$i] = "confirm_ok";
			}
		}
	}
	for($i=0; $i<=$length; $i++) {
		if($eles[$i] != "confirm_ok") {
			$errm .= "<p class=\"error_messe\">「".$eles[$i]."」が未選択です。</p>\n";
			$eles[$i] = "confirm_ok";
			$empty_flag = 1;
		}
	}
}
//メールチェック
if(empty($errm)){
	foreach($_POST as $key=>$val) {
		if($val == "confirm_submit") $sendmail = 1;
		if($key == $Email) $post_mail = h($val);
		if($key == $Email && $mail_check == 1){
			if(!checkMail($val)){
				$errm .= "<p class=\"error_messe\">「".$key."」はメールアドレスの形式が正しくありません。</p>\n";
				$empty_flag = 1;
			}
		}
	}
}
// 管理者宛に届くメールの編集$body="「".$subject."」からメールが届きました\n\n";
foreach($_POST as $key=>$val) {
	$out = '';
	if(is_array($val)){
		foreach($val as $item){ 
			$out .= $item . ', '; 
		}
		$out = rtrim($out,', ');
	}else{ $out = $val;} //チェックボックス（配列）追記ここまで
	if(get_magic_quotes_gpc()) { $out = stripslashes($out); }
	if($out != "confirm_submit" && $key != "httpReferer") {
		$body.="【 ".$key." 】 ".$out."\n";
	}
}
$body.="\n＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n";
$body.="送信された日時：".date( "Y/m/d (D) H:i:s", time() )."\n";
$body.="問い合わせのページURL：".@$_POST['httpReferer']."\n";
if($mailFooterDsp == 1) $body.= $mailSignature;
//--- 管理者宛に届くメールの編集終了


if($remail == 1) {
//--- 差出人への自動返信メールの編集
if(isset($_POST[$dsp_name])){ $rebody = h($_POST[$dsp_name]). " 様\n";}
$rebody.= $remail_text;
$rebody.="\n＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n\n";
foreach($_POST as $key=>$val) {
	$out = '';
	if(is_array($val)){
		foreach($val as $item){ 
			$out .= $item . ', '; 
		}
		$out = rtrim($out,', ');
	}else { $out = $val; }//チェックボックス（配列）追記ここまで
	if(get_magic_quotes_gpc()) { $out = stripslashes($out); }
	if($out != "confirm_submit" && $key != "httpReferer"){
		$rebody.="【 ".$key." 】 ".$out."\n";
	}
}
$rebody.="\n＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝\n\n";
$rebody.="送信日時：".date( "Y/m/d (D) H:i:s", time() )."\n";
if($mailFooterDsp == 1) $rebody.= $mailSignature;
//--- 差出人への自動返信メールの編集 終了

$reto = $post_mail;
$rebody=mb_convert_encoding($rebody,"JIS","utf-8");
$re_subject="=?iso-2022-jp?B?".base64_encode(mb_convert_encoding($re_subject,"JIS","utf-8"))."?=";

	if(!empty($refrom_name)){
	
		$default_internal_encode = mb_internal_encoding();
		if($default_internal_encode != 'utf-8'){
		  mb_internal_encoding('utf-8');
		}
		$reheader="From: ".mb_encode_mimeheader($refrom_name)." <".$to.">\nReply-To: ".$to."\nContent-Type: text/plain;charset=iso-2022-jp\nX-Mailer: PHP/".phpversion();
	
	}else{
		$reheader="From: $to\nReply-To: ".$to."\nContent-Type: text/plain;charset=iso-2022-jp\nX-Mailer: PHP/".phpversion();
	}
}
$body=mb_convert_encoding($body,"JIS","utf-8");
$subject="=?iso-2022-jp?B?".base64_encode(mb_convert_encoding($subject,"JIS","utf-8"))."?=";

if($userMail == 1 && !empty($post_mail)) {
  $from = $post_mail;
  $header="From: $from\n";
	  if($BccMail != '') {
		$header.="Bcc: $BccMail\n";
	  }
	$header.="Reply-To: ".$from."\n";
}else {
	  if($BccMail != '') {
		$header="Bcc: $BccMail\n";
	  }
	$header.="Reply-To: ".$to."\n";
}
	$header.="Content-Type:text/plain;charset=iso-2022-jp\nX-Mailer: PHP/".phpversion();
  

if(($confirmDsp == 0 || $sendmail == 1) && $empty_flag != 1){
  mail($to,$subject,$body,$header);
  if($remail == 1) { mail($reto,$re_subject,$rebody,$reheader); }
}
else if($confirmDsp == 1){ 


/*　▼▼▼送信確認画面のレイアウト※編集可　オリジナルのデザインも適用可能▼▼▼　*/
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<meta name='robots' content='noindex,nofollow' />
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">
<title>オープンキャンパス参加フォーム｜オープンキャンパス｜学校法人 八文字学園</title>
<link rel="stylesheet" type="text/css" href="https://www.mito.ac.jp/css/import.css" media="screen,print,tv" />
<link href="https://www.mito.ac.jp/css/page.css" rel="stylesheet" type="text/css" />
<link href="https://www.mito.ac.jp/css/oc.css" rel="stylesheet" type="text/css" />
</head>
<body>
<!-- wrapper -->
<div id="wrapper">
<!-- headeer -->
<div id="header">
<a name="top" id="top"></a><p class="logo"><a href="http://www.mito.ac.jp/">学校法人 八文字学園</a></p>
<!-- head_nave -->
<div id="head_navi">
<ul>
<li id="hnavi01"><a href="http://www.mito.ac.jp/school.html">進路指導ご担当の先生へ</a></li>
<li id="hnavi02"><a href="http://www.mito.ac.jp/parents.html">ご家族のみなさまへ</a></li>
<li id="hnavi03"><a href="http://www.mito.ac.jp/company.html">企業の採用ご担当の方へ</a></li>
<li id="hnavi04"><a href="http://www.mito.ac.jp/recruit/index.html">教職員募集</a></li>
</ul>
</div>
<!-- /head_navi -->
</div><!-- /header -->
<div id="splogo"><p><img src="https://www.mito.ac.jp/ui/logo.gif" alt="学校法人八文字学園" /></p></div>
<!-- school_tab -->
<div id="stab">
<ul>
<li id="stab01"><a href="http://www.mito.ac.jp/business/index.html">水戸経理専門学校</a></li>
<li id="stab02"><a href="http://www.mito.ac.jp/technology/index.html">水戸電子専門学校</a></li>
<li id="stab03"><a href="http://www.mito.ac.jp/automobile/index.html">水戸自動車大学校</a></li>
<li id="stab04"><a href="http://www.mito.ac.jp/beauty/index.html">水戸ビューティカレッジ</a></li>
<li id="stab05"><a href="http://www.mito.ac.jp/welfare/index.html">水戸看護福祉専門学校</a></li>
</ul>
</div>
<!-- gNavi -->
<div id="pagetitle" class="pc">
<h1 class="oc">2019年度オープンキャンパス開催</h1>
</div>
<div id="title" class="sp">
<h1><img src="https://www.mito.ac.jp/images/tit_oc.png" alt="オープンキャンパス" /></h1>
</div>
<!-- gNavi -->
<div id="gNavi">
<ul>
<li id="gnavi01"><a href="http://www.mito.ac.jp/about/index.html">学園紹介</a></li>
<li id="gnavi02"><a href="http://www.mito.ac.jp/campus/index.html">キャンパス紹介</a></li>
<li id="gnavi03"><a href="http://www.mito.ac.jp/guide/index.html">入学案内</a></li>
<li id="gnavi04"><a href="http://www.mito.ac.jp/quali/index.html">資格</a></li>
<li id="gnavi05"><a href="http://www.mito.ac.jp/job/index.html">就職</a></li>
<li id="gnavi06"><a href="http://www.mito.ac.jp/access/index.html">交通アクセス</a></li>
</ul>
</div>
<!-- gNavi -->

<!-- content -->
<div id="contents">
 <ul id="breadcrumb">
  <li class="home"><a href="http://www.mito.ac.jp/">ホーム</a></li>
  <li><a href="http://www.mito.ac.jp/opencampus/index.html">オープンキャンパス</a></li>
  <li>オープンキャンパス参加フォーム</li>
 </ul>

<!-- maincontents -->
<div id="maincontents">
<h2 class="oc02">オープンキャンパス参加フォーム</h2>
<!-- main -->
<div id="main">

<!-- ▲ Headerやその他コンテンツなど　※編集可 ▲-->

<!-- ▼************ 送信内容表示部　※編集は自己責任で ************ ▼-->
<?php if($empty_flag == 1){ ?>
<p>入力にエラーがあります。下記をご確認の上「戻る」ボタンにて修正をお願い致します。</p><?php echo $errm; ?><br><br><input type="button" value=" 前画面に戻る " onClick="history.back()">
<?php
		}else{
?>
<p>以下の内容で間違いがなければ、「送信する」ボタンを押してください。</p><br><br>
<form action="<?php echo $file_name; ?>" method="POST">
<table>
<?php
foreach($_POST as $key=>$val) {
	$out = '';
	if(is_array($val)){
		foreach($val as $item){ 
			$out .= $item . ', '; 
		}
		$out = rtrim($out,', ');
	}else { $out = $val; }//チェックボックス（配列）追記ここまで
	if(get_magic_quotes_gpc()) { $out = stripslashes($out); }
	$out = nl2br(h($out));//※追記 改行コードを<br>タグに変換
	$key = h($key);
	echo "<tr><th class=\"l_Cel\">".$key."</th><td>".$out;
	$out = str_replace("<br />","",$out);//※追記 メール送信時には<br>タグを削除
?>
<input type="hidden" name="<?php echo $key; ?>" value="<?php echo $out; ?>">
<?php
	echo "</td></tr>\n";
}
?>
</table><br>
<div align="center"><input type="hidden" name="mail_set" value="confirm_submit">
<input type="hidden" name="httpReferer" value="<?php echo $_SERVER['HTTP_REFERER'] ;?>">
<input type="submit" value="　送信する　">
<input type="button" value="前画面に戻る" onClick="history.back()">
</div>
</form>
<?php } ?>
<!-- ▲ *********** 送信内容確認部　※編集は自己責任で ************ ▲-->

<!-- ▼ Footerその他コンテンツなど　※編集可 ▼-->
<!-- linkNavi -->
<div id="linkNavi">
<!-- linkNavi 学校案内 -->
<div id="linknavi01">
<h2>学校案内</h2>
  <ul>
    <li><a href="http://www.mito.ac.jp/business/index.html">水戸経理専門学校</a></li>
    <li><a href="http://www.mito.ac.jp/technology/index.html">水戸電子専門学校</a></li>
    <li><a href="http://www.mito.ac.jp/automobile/index.html">水戸自動車大学校</a></li>
    <li><a href="http://www.mito.ac.jp/beauty/index.html">水戸ビューティカレッジ</a></li>
    <li><a href="http://www.mito.ac.jp/welfare/index.html">水戸看護福祉専門学校</a></li>
  </ul>
</div><!-- /linkNavi 学校案内 -->
<!-- linkNavi オープンキャンパス -->
<div id="linknavi02">
<h2>オープンキャンパス</h2>
  <ul>
    <li><a href="http://www.mito.ac.jp/opencampus/index.html">OC概要</a></li>
    <li><a href="https://www.mito.ac.jp/apply.html">参加フォーム</a></li>
  </ul>
</div><!-- /linkNavi オープンキャンパス -->
<!-- linkNavi 資料請求 -->
<div id="linknavi03">
<h2>資料請求</h2>
  <ul>
    <li><a href="https://www.mito.ac.jp/request.html">資料請求フォーム</a></li>
    <li><a href="http://www.mito.ac.jp/digitalpamphlet.html">デジタルパンフレット</a></li>
  </ul>
</div><!-- /linkNavi 資料請求 -->
<!-- linkNavi 入学案内 -->
<div id="linknavi04">
<h2>入学案内</h2>
  <ul>
    <li><a href="http://www.mito.ac.jp/guide/index.html">出願について</a></li>
    <li><a href="http://www.mito.ac.jp/guide/business.html">各校募集要項</a></li>
    <li><a href="http://www.mito.ac.jp/guide/college.html">大学・短大併修制度</a></li>
    <li><a href="http://www.mito.ac.jp/guide/loan.html">奨学金制度</a></li>
    <li><a href="http://www.mito.ac.jp/guide/scholarship.html">特待生要項</a></li>
  </ul>
</div><!-- /linkNavi 入学案内 -->
<!-- linkNavi 資格 -->
<div id="linknavi05">
<h2>資格</h2>
  <ul>
    <li><a href="http://www.mito.ac.jp/quali/index.html">資格サポート</a></li>
    <li><a href="http://www.mito.ac.jp/quali/business.html">各校目標とする資格・検定</a></li>
  </ul>
</div><!-- /linkNavi 資格 -->
  <!-- linkNavi 就職 -->
<div id="linknavi06">
<h2>就職</h2>
  <ul>
    <li><a href="http://www.mito.ac.jp/job/index.html">就職サポート</a></li>
    <li><a href="http://www.mito.ac.jp/job/reasons.html">就職に強い理由</a></li>
    <li><a href="http://www.mito.ac.jp/job/performance.html">就職実績</a></li>
    <li><a href="http://www.mito.ac.jp/job/support.html">キャリアサポート</a></li>
    <li><a href="http://www.mito.ac.jp/job/interview.html">卒業生インタビュー</a></li>
  </ul>
</div><!-- /linkNavi 就職 -->
<div class="clr"></div>
</div><!-- /linkNavi -->
</div><!-- /main -->
</div><!-- /maincontents -->

<!-- subcontents -->
<div id="subcontents">
     <h2><img src="https://www.mito.ac.jp/images/sub_oc.jpg" alt="オープンキャンパス" width="200" height="40" /></h2>
     <div id="submenubox">
     <ul>
	 <li><a href="http://www.mito.ac.jp/opencampus/index.html">オープンキャンパスについて</a></li>
	 <li><a href="https://www.mito.ac.jp/apply.html">オープンキャンパス参加フォーム</a></li>
	 <li><a href="https://www.mito.ac.jp/apply2.html">オープンキャンパス参加フォーム(看護学科)</a></li>
   </ul>
   </div>


<ul id="banner">
<li><a href="http://www.mito.ac.jp/opencampus/index.html"><img src="http://www.mito.ac.jp/images/banner/bn_oc.jpg" alt="オープンキャンパス開催！" /></a></li>
<li><a href="https://www.mito.ac.jp/request.html"><img src="http://www.mito.ac.jp/images/banner/bn_sg.jpg" alt="資料請求" /></a></li>
<li><a href="http://www.mito.ac.jp/movie/index.html"><img src="http://www.mito.ac.jp/images/banner/bn_movie.jpg" alt="ヤツモンジ動画" /></a></li>
<li><a href="http://blog.goo.ne.jp/8monji-kawakami"><img src="http://www.mito.ac.jp/images/banner/bn_blog.jpg" alt="ヤツモンジ学園ブログ" /></a></li>
<li><img src="http://www.mito.ac.jp/images/banner/bn_kouza.jpg" alt="高校生対象 公務員受験講座" /></li>
<li><a href="http://www.mito.ac.jp/digitalpamphlet.html"><img src="http://www.mito.ac.jp/images/banner/bn_digitalpamphlet.jpg" alt="デジタルパンフレット" /></a></li>
<li><a href="http://www.mito.ac.jp/my1/index.html"><img src="http://www.mito.ac.jp/images/banner/bn_my1.jpg" alt="八文字学園ケータイサイト「my1」" /></a></li>
<li><a href="http://www.mito.ac.jp/microsoft/index.html"><img src="http://www.mito.ac.jp/images/banner/bn_mos.jpg" alt="MOS一般受験をお考えの方へ" /></a></li>
<li><a href="http://www.jasso.go.jp/"><img src="http://www.mito.ac.jp/images/banner/bn_jasso.jpg" alt="独立行政法人 日本学生支援機構" /></a></li>
</ul></div><!-- /subcontents -->
</div><!-- /subcontents -->

</div><!-- /content -->
</div><!-- /wrapper -->
<div id="pagetop"><a href="#top">このページのトップへ</a></div>
<!-- footer -->
<div id="footer">
<!-- fcont -->
<div id="fcont">
<!-- f_school --><div id="f_school"><img src="https://www.mito.ac.jp/ui/foot_logo.gif" alt="学校法人 八文字学園" width="190" height="30" class="floatL" />
<p>茨城県水戸市浜田2-11-18<br />
TEL：029-221-8800　FAX：029-221-8800</p></div><!-- /f_school -->
<!-- fnavi -->
<div id="fnavi">
<ul>
<li><a href="mailto:&#109;&#121;&#49;&#64;&#109;&#105;&#116;&#111;&#46;&#97;&#99;&#46;&#106;&#112;"><img src="ui/fnavi01.gif" alt="メール：&#109;&#105;&#116;&#111;&#64;&#109;&#105;&#116;&#111;&#46;&#97;&#99;&#46;&#106;&#112;" /></a></li>
<li><a href="http://www.mito.ac.jp/privacy.html"><img src="https://www.mito.ac.jp/ui/fnavi02.gif" alt="プライバシーポリシー" /></a></li>
<li><a href="http://www.mito.ac.jp/sitemap.html"><img src="https://www.mito.ac.jp/ui/fnavi03.gif" alt="サイトマップ" /></a></li>
</ul>
</div><!-- /fnavi -->
<!-- fschoollist -->
<div id="school_list">
<ul>
<li id="fbusiness"><a href="http://www.mito.ac.jp/business/index.html">水戸経理専門学校</a></li>
<li id="ftechnology"><a href="http://www.mito.ac.jp/technology/index.html">水戸電子専門学校</a></li>
<li id="fautomobile"><a href="http://www.mito.ac.jp/automobile/index.html">水戸自動車大学校</a></li>
<li id="fbeauty"><a href="http://www.mito.ac.jp/beauty/index.html">水戸ビューティカレッジ</a></li>
<li id="fwelfare"><a href="http://www.mito.ac.jp/welfare/index.html">水戸総合福祉専門学校</a></li>
</ul>
</div><!-- /fschoollist -->
<!-- fsitelist -->
<div id="fsitelist">
<ul>
<li><a href="http://www.mito.ac.jp/about/index.html">学園紹介</a></li>
<li><a href="http://www.mito.ac.jp/campus/index.html">キャンパス紹介</a></li>
<li><a href="http://www.mito.ac.jp/life/index.html">キャンパスライフ</a></li>
<li><a href="http://www.mito.ac.jp/guide/index.html">入学案内</a></li>
<li><a href="http://www.mito.ac.jp/quali/index.html">資格</a></li>
<li><a href="http://www.mito.ac.jp/job/index.html">就職</a></li>
</ul>
<ul>
<li><a href="http://www.mito.ac.jp/opencampus/index.html">オープンキャンパス</a></li>
<li><a href="https://www.mito.ac.jp/request.html">資料請求</a></li>
<li><a href="http://www.mito.ac.jp/movie/index.html">ヤツモンジ動画</a></li>
<li><a href="http://blog.goo.ne.jp/8monji-kawakami">学園ブログ</a></li>
<li><a href="http://www.mito.ac.jp/digitalpamphlet.html">デジタルパンフレット</a></li>
<li><a href="http://www.mito.ac.jp/my1/index.html">ケータイサイト「my1」</a></li>
</ul>
<ul>
<li><a href="http://www.mito.ac.jp/school.html">進路指導ご担当の先生へ</a></li>
<li><a href="http://www.mito.ac.jp/parents.html">ご家族のみなさまへ</a></li>
<li><a href="http://www.mito.ac.jp/company.html">企業の採用ご担当の方へ</a></li>
<li><a href="http://www.mito.ac.jp/recruit/index.html">教職員募集</a></li>
</ul>
</div><!-- /fsitelist -->
<address>Copyright yatsumonji-gakuen.all rights reserved.</address>
</div><!-- /fcont -->
</div><!-- /footer -->
</body>
</html>
<?php
/* ▲▲▲送信確認画面のレイアウト　※オリジナルのデザインも適用可能▲▲▲　*/
}


if(($jumpPage == 0 && $sendmail == 1) || ($jumpPage == 0 && ($confirmDsp == 0 && $sendmail == 0))) { 

/* ▼▼▼送信完了画面のレイアウト　編集可 ※送信完了後に指定のページに移動しない場合のみ表示▼▼▼　*/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>お問い合わせ完了画面</title>
</head>
<body>
<div align="center">
<?php if($empty_flag == 1){ ?>
<h5>入力にエラーがあります。下記をご確認の上「戻る」ボタンにて修正をお願い致します。</h5><div style="color:red"><?php echo $errm; ?></div><br><br><input type="button" value=" 前画面に戻る " onClick="history.back()">
</div>
</body>
</html>
<?php
  }else{
?>
送信ありがとうございました。<br>
送信は正常に完了しました。<br><br>
<a href="<?php echo $site_top ;?>">トップページへ戻る⇒</a>
</div>
<?php if(!empty($copyrights)) echo $copyrights; ?>
<!--  CV率を計測する場合ここにAnalyticsコードを貼り付け -->
</body>
</html>
<?php 
/* ▲▲▲送信完了画面のレイアウト 編集可 ※送信完了後に指定のページに移動しない場合のみ表示▲▲▲　*/
  }
}
//完了時、指定のページに移動する設定の場合、エラーチェックで問題が無ければ指定ページヘリダイレクト
else if(($jumpPage == 1 && $sendmail == 1) || $confirmDsp == 0) { 
	 if($empty_flag == 1){ ?>
<div align="center"><h5>入力にエラーがあります。下記をご確認の上「戻る」ボタンにて修正をお願い致します。</h5><div style="color:red"><?php echo $errm; ?></div><br><br><input type="button" value=" 前画面に戻る " onClick="history.back()"></div>
<?php }else{ header("Location: ".$thanksPage); }
} ?>
