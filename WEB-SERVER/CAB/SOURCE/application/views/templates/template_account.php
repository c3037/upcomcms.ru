<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<meta name="robots" content="noindex,nofollow">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $data['page_title']; ?> &middot; Личный кабинет клиента управляющей компании</title>

<style type="text/css">
body { min-width: 800px; background-color: #fff; margin: 0; font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; color: #333; }
.wrapper { max-width:1280px; margin: 0 auto; }
div { position: relative; }
a { color: #4183c4; text-decoration: none; }
a:hover { text-decoration: underline; }
h1 { color: #333; line-height: 40px; font-size: 24px; font-weight: 100; margin: 10px 0 20px 0; }
#topline { background-color: #fcfcfc; border-color: #080808; padding: 15px 20px; font-size: 16px; }
#topline a { color: #333; text-decoration: none!important; }
#header { color: #333; display: inline-block; margin-right:100px; line-height: 20px; }
#exit { display: block; position: absolute; right:20px; top:10px; }
#menu { padding: 20px; background-color: #f5f5f5; border-bottom: 1px solid #eee; border-top: 1px solid #eee; }
#menu a.active { color: #fff; background-color: #428bca; padding:10px; border-radius:4px; text-decoration: none !important; }
#content { padding: 10px 20px; }
::-webkit-input-placeholder {opacity: 1; transition: opacity 0.6s ease;}
::-moz-placeholder {opacity: 1; transition: opacity 0.6s ease;}
:-moz-placeholder {opacity: 1; transition: opacity 0.6s ease;}
:-ms-input-placeholder {opacity: 1; transition: opacity 0.6s ease;}
:focus::-webkit-input-placeholder {opacity: 0; transition: opacity 0.6s ease;}
:focus::-moz-placeholder {opacity: 0; transition: opacity 0.6s ease;}
:focus:-moz-placeholder {opacity: 0; transition: opacity 0.6s ease;}
:focus:-ms-input-placeholder {opacity: 0; transition: opacity 0.6s ease;}
.panel { margin-bottom: 20px; background-color: #fff; border: 1px solid transparent; border-radius: 4px; -webkit-box-shadow: 0 1px 1px rgba(0,0,0,.05); box-shadow: 0 1px 1px rgba(0,0,0,0.05); }
.panel-info { border-color: #bce8f1; }
.panel-info>.panel-heading { color: #31708f; background-color: #d9edf7; border-color: #bce8f1; padding: 10px 15px; border-top-left-radius: 2px; border-top-right-radius: 2px; }
.panel-default { border-color: #ddd; }
.panel-default>.panel-heading { color: #333; background-color: #f5f5f5; border-color: #ddd; padding: 10px 15px; border-top-left-radius: 2px; border-top-right-radius: 2px; }
.info { color: #31708f; background-color: #d9edf7; border-color: #bce8f1; padding: 15px; border-radius: 4px; }
table { width: 100%; margin-top: 20px; margin-bottom: 20px; font-size: 14px; border-collapse: collapse; border-spacing: 0; }
th { font-weight: bold; text-align: left; }
th, td {  margin: 0; padding: 10px; border: 0; vertical-align: middle; }
tr { border-bottom: 1px solid #ddd; }
tr:nth-child(even){ background-color: #f9f9f9; border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; }
.panel-body { padding: 15px; font-size: 14px;}
.td-center { text-align: center; }
input[type="text"], textarea { color:#666; width: 100%; height: auto; box-sizing: border-box; font-size: 14px; background-color: #fff; border: 1px solid #ccc; border-radius: 4px; display: block; padding: 10px; }
input[type="text"]:focus, textarea:focus { box-shadow: 0px 0px 0px 1px #66afe9; }
.btn_blue { color: #fff; background-color: #5bc0de; border-color: #46b8da; padding: 10px 15px; text-decoration: none !important; border-radius: 4px; font-size: 14px; display: inline-block; text-align: center; cursor: pointer; }
.btn_default {color: #4183c4; border: 1px solid #ccc; background-color: #fff; }
.left_btn_group, .right_btn_group, .center_btn_group { background-color: #fff; border: 1px solid #ccc; padding: 10px 15px; text-decoration: none !important; }
.right_btn_group { border-left: 0; border-top-right-radius: 4px; border-bottom-right-radius: 4px; }
.left_btn_group { border-top-left-radius: 4px; border-bottom-left-radius: 4px; }
.btn_group { min-width: 230px; font-size: 14px; }
.btn_blue_feedback { border: none; }
.btn_default_feedback { margin-bottom: 30px; }
.btn_group_finances, .btn_group_odns { display: block; margin: 30px 0; }
.left_btn_group_finances, .left_btn_group_odns { border-right: 0; }
.left_btn_group_finances, .right_btn_group_finances, .left_btn_group_odns, .right_btn_group_odns { cursor:pointer; }
.panel-body_messages { text-align: justify; line-height: 1.5; }
.btn_blue_submit { border: none; }
form { margin-bottom: 20px; }
input[readonly] { cursor: not-allowed; background-color: #eee; }
input[readonly]:focus { box-shadow: 0px 0px 0px 0px; }
.mode_site { color: #03899C; }
.mode_site img { vertical-align: bottom; width: 16px; height: 16px; border: 0; }
@media screen and (max-width: 1150px) {
#menu a { display: block; margin-bottom: 10px; }
#menu { padding-bottom: 0px; }
#menu a:not(.active) { padding-left: 10px; }
input, textarea { -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; }
}
.danger { background-color: #f2dede; padding: 15px; font-size: 14px; line-height: 22px; color: #333; border-radius: 4px; margin-top: 0px; }
.redline{ color:#f00; }
.mode_block .left_btn_group, .mode_block .right_btn_group { display:block; }
.mode_block .right_btn_group { border-top-left-radius: 4px; border-bottom-left-radius: 4px; border-left: 1px solid #ccc; margin-top:10px; }
.mode_block .left_btn_group { border-top-right-radius: 4px; border-bottom-right-radius: 4px; }
hr { margin-top: 20px; border: 0; height: 0; border-top: 1px solid rgba(0, 0, 0, 0.1); border-bottom: 1px solid rgba(255, 255, 255, 0.3); }
#tableWrap { overflow-x: auto; }
#table { font-size: 12px; margin-top: 0; }
#table .newBlock { border-top: 2px solid #ddd!important; }
#table:last-child { border-bottom: 2px solid #ddd!important; }
p.legend { font-size: 12px; }
#footer { max-width: 1280px; padding: 0 20px; margin: 0 auto; padding-bottom: 25px; margin-top: -5px; font-size: 12px; color: #888; }
#footer a { font-size: 12px; color: #888; }
p#saldo { font-size: 13px; margin-bottom: 25px; font-weight: bold; font-style: italic; }
p#saldo span{ font-style: normal; font-weight: normal; }
</style>

<!--[if (!IE) | (gt IE 8)]>-->
<style>
.mode-box span { display: inline-block; width: 50%; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; }
</style>
<!--<![endif]-->

<script>
(function(t){"use strict";function e(t,e,r){return t.addEventListener?t.addEventListener(e,r,!1):t.attachEvent?t.attachEvent("on"+e,r):void 0}function r(t,e){var r,n;for(r=0,n=t.length;n>r;r++)if(t[r]===e)return!0;return!1}function n(t,e){var r;t.createTextRange?(r=t.createTextRange(),r.move("character",e),r.select()):t.selectionStart&&(t.focus(),t.setSelectionRange(e,e))}function a(t,e){try{return t.type=e,!0}catch(r){return!1}}t.Placeholders={Utils:{addEventListener:e,inArray:r,moveCaret:n,changeType:a}}})(this),function(t){"use strict";function e(){}function r(){try{return document.activeElement}catch(t){}}function n(t,e){var r,n,a=!!e&&t.value!==e,u=t.value===t.getAttribute(V);return(a||u)&&"true"===t.getAttribute(D)?(t.removeAttribute(D),t.value=t.value.replace(t.getAttribute(V),""),t.className=t.className.replace(R,""),n=t.getAttribute(F),parseInt(n,10)>=0&&(t.setAttribute("maxLength",n),t.removeAttribute(F)),r=t.getAttribute(P),r&&(t.type=r),!0):!1}function a(t){var e,r,n=t.getAttribute(V);return""===t.value&&n?(t.setAttribute(D,"true"),t.value=n,t.className+=" "+I,r=t.getAttribute(F),r||(t.setAttribute(F,t.maxLength),t.removeAttribute("maxLength")),e=t.getAttribute(P),e?t.type="text":"password"===t.type&&M.changeType(t,"text")&&t.setAttribute(P,"password"),!0):!1}function u(t,e){var r,n,a,u,i,l,o;if(t&&t.getAttribute(V))e(t);else for(a=t?t.getElementsByTagName("input"):b,u=t?t.getElementsByTagName("textarea"):f,r=a?a.length:0,n=u?u.length:0,o=0,l=r+n;l>o;o++)i=r>o?a[o]:u[o-r],e(i)}function i(t){u(t,n)}function l(t){u(t,a)}function o(t){return function(){m&&t.value===t.getAttribute(V)&&"true"===t.getAttribute(D)?M.moveCaret(t,0):n(t)}}function c(t){return function(){a(t)}}function s(t){return function(e){return A=t.value,"true"===t.getAttribute(D)&&A===t.getAttribute(V)&&M.inArray(C,e.keyCode)?(e.preventDefault&&e.preventDefault(),!1):void 0}}function d(t){return function(){n(t,A),""===t.value&&(t.blur(),M.moveCaret(t,0))}}function g(t){return function(){t===r()&&t.value===t.getAttribute(V)&&"true"===t.getAttribute(D)&&M.moveCaret(t,0)}}function v(t){return function(){i(t)}}function p(t){t.form&&(T=t.form,"string"==typeof T&&(T=document.getElementById(T)),T.getAttribute(U)||(M.addEventListener(T,"submit",v(T)),T.setAttribute(U,"true"))),M.addEventListener(t,"focus",o(t)),M.addEventListener(t,"blur",c(t)),m&&(M.addEventListener(t,"keydown",s(t)),M.addEventListener(t,"keyup",d(t)),M.addEventListener(t,"click",g(t))),t.setAttribute(j,"true"),t.setAttribute(V,x),(m||t!==r())&&a(t)}var b,f,m,h,A,y,E,x,L,T,N,S,w,B=["text","search","url","tel","email","password","number","textarea"],C=[27,33,34,35,36,37,38,39,40,8,46],k="#ccc",I="placeholdersjs",R=RegExp("(?:^|\\s)"+I+"(?!\\S)"),V="data-placeholder-value",D="data-placeholder-active",P="data-placeholder-type",U="data-placeholder-submit",j="data-placeholder-bound",q="data-placeholder-focus",z="data-placeholder-live",F="data-placeholder-maxlength",G=document.createElement("input"),H=document.getElementsByTagName("head")[0],J=document.documentElement,K=t.Placeholders,M=K.Utils;if(K.nativeSupport=void 0!==G.placeholder,!K.nativeSupport){for(b=document.getElementsByTagName("input"),f=document.getElementsByTagName("textarea"),m="false"===J.getAttribute(q),h="false"!==J.getAttribute(z),y=document.createElement("style"),y.type="text/css",E=document.createTextNode("."+I+" { color:"+k+"; }"),y.styleSheet?y.styleSheet.cssText=E.nodeValue:y.appendChild(E),H.insertBefore(y,H.firstChild),w=0,S=b.length+f.length;S>w;w++)N=b.length>w?b[w]:f[w-b.length],x=N.attributes.placeholder,x&&(x=x.nodeValue,x&&M.inArray(B,N.type)&&p(N));L=setInterval(function(){for(w=0,S=b.length+f.length;S>w;w++)N=b.length>w?b[w]:f[w-b.length],x=N.attributes.placeholder,x?(x=x.nodeValue,x&&M.inArray(B,N.type)&&(N.getAttribute(j)||p(N),(x!==N.getAttribute(V)||"password"===N.type&&!N.getAttribute(P))&&("password"===N.type&&!N.getAttribute(P)&&M.changeType(N,"text")&&N.setAttribute(P,"password"),N.value===N.getAttribute(V)&&(N.value=x),N.setAttribute(V,x)))):N.getAttribute(D)&&(n(N),N.removeAttribute(V));h||clearInterval(L)},100)}M.addEventListener(t,"beforeunload",function(){K.disable()}),K.disable=K.nativeSupport?e:i,K.enable=K.nativeSupport?e:l}(this);
</script>

<link rel="shortcut icon" href="/favicon.ico" />
<link rel="icon" href="/favicon.ico" />

<?php echo $analytics; ?>

</head>
<body>

<div id="topline">
<div class="wrapper">
<span title="" id="header"><strong>УК:</strong> <?php echo $data['uk_name']; ?> <br> <strong>Клиент:</strong> <?php echo $data['user_name']; ?></span>
<a href="/account/logout" title="" id="exit">Выход</a>
</div> <!-- .wrapper -->
</div> <!-- #topline -->

<div id="menu">
<div class="wrapper">
<a href="/account/overview"<?php echo ( $data['current_page']=='index' ) ? ' class="active"' : '' ; ?>>Общая информация</a> &nbsp; &nbsp; &nbsp; 
<a href="/account/counters"<?php echo ( $data['current_page']=='counters' ) ? ' class="active"' : '' ; ?>>Счётчики</a> &nbsp; &nbsp; &nbsp; 
<a href="/account/finances"<?php echo ( $data['current_page']=='finances' ) ? ' class="active"' : '' ; ?>>Начисления и оплаты</a> &nbsp; &nbsp; &nbsp; 
<a href="/account/houses_counters"<?php echo ( $data['current_page']=='houses_counters' ) ? ' class="active"' : '' ; ?>>Домовые счётчики</a> &nbsp; &nbsp; &nbsp; 
<a href="/account/odns"<?php echo ( $data['current_page']=='odns' ) ? ' class="active"' : '' ; ?>>Расчёт ОДН</a> &nbsp; &nbsp; &nbsp; 
<?php if(Config::$use_pay): ?> <a href="/account/pay"<?php echo ( $data['current_page']=='pay' ) ? ' class="active"' : '' ; ?>>Онлайн оплата</a> &nbsp; &nbsp; &nbsp; <?php endif; ?>
<a href="/account/feedback"<?php echo ( $data['current_page']=='feedback' ) ? ' class="active"' : '' ; ?>>Обратная связь</a>
</div> <!-- .wrapper -->
</div> <!-- #menu -->

<div id="content">
<div class="wrapper">

<?php echo $content; ?>

</div> <!-- .wrapper -->
</div> <!-- #content -->

<div id="footer">&copy; <a href="http://www.upcomcms.ru">Upcomcms</a></div>

</body>
</html>