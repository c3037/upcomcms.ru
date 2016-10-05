<!DOCTYPE html>
<html>
<head>

<meta charset="UTF-8">
<meta name="robots" content="noindex,nofollow">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $data['page_title']; ?> &middot; Личный кабинет клиента управляющей компании</title>

<style type="text/css">
body { background-color: #f1f1f1; margin: 0; font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; }
.container { margin: 50px auto 40px auto; width: 370px; padding: 8px 15px; }
a { color: #4183c4; text-decoration: none; }
a:hover { text-decoration: underline; }
h1 { color: rgba(0, 0, 0, 0.8); line-height: 60px; font-size: 24px; font-weight: 100; margin: 0px 0 13px 0; }
input, select, option { color:#555; }
input, select { width: 100%; height: auto; padding: 12px; font-size: 16px; background-color: #fff; border: 1px solid #ccc; border-radius: 4px; display: block; margin-bottom: 20px; }
input:focus, select:focus { box-shadow: 0px 0px 0px 1px #66afe9; }
input[type='submit'] { cursor:pointer; color: #fff; background-color: #428bca; border-color: #357ebd; }
::-webkit-input-placeholder {opacity: 1; transition: opacity 0.6s ease;}
::-moz-placeholder {opacity: 1; transition: opacity 0.6s ease;}
:-moz-placeholder {opacity: 1; transition: opacity 0.6s ease;}
:-ms-input-placeholder {opacity: 1; transition: opacity 0.6s ease;}
:focus::-webkit-input-placeholder {opacity: 0; transition: opacity 0.6s ease;}
:focus::-moz-placeholder {opacity: 0; transition: opacity 0.6s ease;}
:focus:-moz-placeholder {opacity: 0; transition: opacity 0.6s ease;}
:focus:-ms-input-placeholder {opacity: 0; transition: opacity 0.6s ease;}
.danger { background-color: #f2dede; padding: 15px; font-size: 14px; line-height: 22px; color: #333; border-radius: 4px; }
select { margin-bottom: 35px; }
input { -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box; }
#footer { width: 370px; margin: -15px auto 25px auto; text-align: center; font-size: 12px; color: #666; }
#footer a { font-size: 12px; color: #666; }
@media screen and (max-width: 420px) {
.container, #footer { width: 290px; }
#footer, #footer a { font-size:9px; }
}
</style>

<!--[if lte IE 7]>
<style type="text/css">
input[type='text'], input[type='password'] { z-index: expression(runtimeStyle.zIndex = 1, runtimeStyle.width = parentNode.offsetWidth/2 + 158 + 'px'); }
</style>
<![endif]-->

<script>
(function(t){"use strict";function e(t,e,r){return t.addEventListener?t.addEventListener(e,r,!1):t.attachEvent?t.attachEvent("on"+e,r):void 0}function r(t,e){var r,n;for(r=0,n=t.length;n>r;r++)if(t[r]===e)return!0;return!1}function n(t,e){var r;t.createTextRange?(r=t.createTextRange(),r.move("character",e),r.select()):t.selectionStart&&(t.focus(),t.setSelectionRange(e,e))}function a(t,e){try{return t.type=e,!0}catch(r){return!1}}t.Placeholders={Utils:{addEventListener:e,inArray:r,moveCaret:n,changeType:a}}})(this),function(t){"use strict";function e(){}function r(){try{return document.activeElement}catch(t){}}function n(t,e){var r,n,a=!!e&&t.value!==e,u=t.value===t.getAttribute(V);return(a||u)&&"true"===t.getAttribute(D)?(t.removeAttribute(D),t.value=t.value.replace(t.getAttribute(V),""),t.className=t.className.replace(R,""),n=t.getAttribute(F),parseInt(n,10)>=0&&(t.setAttribute("maxLength",n),t.removeAttribute(F)),r=t.getAttribute(P),r&&(t.type=r),!0):!1}function a(t){var e,r,n=t.getAttribute(V);return""===t.value&&n?(t.setAttribute(D,"true"),t.value=n,t.className+=" "+I,r=t.getAttribute(F),r||(t.setAttribute(F,t.maxLength),t.removeAttribute("maxLength")),e=t.getAttribute(P),e?t.type="text":"password"===t.type&&M.changeType(t,"text")&&t.setAttribute(P,"password"),!0):!1}function u(t,e){var r,n,a,u,i,l,o;if(t&&t.getAttribute(V))e(t);else for(a=t?t.getElementsByTagName("input"):b,u=t?t.getElementsByTagName("textarea"):f,r=a?a.length:0,n=u?u.length:0,o=0,l=r+n;l>o;o++)i=r>o?a[o]:u[o-r],e(i)}function i(t){u(t,n)}function l(t){u(t,a)}function o(t){return function(){m&&t.value===t.getAttribute(V)&&"true"===t.getAttribute(D)?M.moveCaret(t,0):n(t)}}function c(t){return function(){a(t)}}function s(t){return function(e){return A=t.value,"true"===t.getAttribute(D)&&A===t.getAttribute(V)&&M.inArray(C,e.keyCode)?(e.preventDefault&&e.preventDefault(),!1):void 0}}function d(t){return function(){n(t,A),""===t.value&&(t.blur(),M.moveCaret(t,0))}}function g(t){return function(){t===r()&&t.value===t.getAttribute(V)&&"true"===t.getAttribute(D)&&M.moveCaret(t,0)}}function v(t){return function(){i(t)}}function p(t){t.form&&(T=t.form,"string"==typeof T&&(T=document.getElementById(T)),T.getAttribute(U)||(M.addEventListener(T,"submit",v(T)),T.setAttribute(U,"true"))),M.addEventListener(t,"focus",o(t)),M.addEventListener(t,"blur",c(t)),m&&(M.addEventListener(t,"keydown",s(t)),M.addEventListener(t,"keyup",d(t)),M.addEventListener(t,"click",g(t))),t.setAttribute(j,"true"),t.setAttribute(V,x),(m||t!==r())&&a(t)}var b,f,m,h,A,y,E,x,L,T,N,S,w,B=["text","search","url","tel","email","password","number","textarea"],C=[27,33,34,35,36,37,38,39,40,8,46],k="#ccc",I="placeholdersjs",R=RegExp("(?:^|\\s)"+I+"(?!\\S)"),V="data-placeholder-value",D="data-placeholder-active",P="data-placeholder-type",U="data-placeholder-submit",j="data-placeholder-bound",q="data-placeholder-focus",z="data-placeholder-live",F="data-placeholder-maxlength",G=document.createElement("input"),H=document.getElementsByTagName("head")[0],J=document.documentElement,K=t.Placeholders,M=K.Utils;if(K.nativeSupport=void 0!==G.placeholder,!K.nativeSupport){for(b=document.getElementsByTagName("input"),f=document.getElementsByTagName("textarea"),m="false"===J.getAttribute(q),h="false"!==J.getAttribute(z),y=document.createElement("style"),y.type="text/css",E=document.createTextNode("."+I+" { color:"+k+"; }"),y.styleSheet?y.styleSheet.cssText=E.nodeValue:y.appendChild(E),H.insertBefore(y,H.firstChild),w=0,S=b.length+f.length;S>w;w++)N=b.length>w?b[w]:f[w-b.length],x=N.attributes.placeholder,x&&(x=x.nodeValue,x&&M.inArray(B,N.type)&&p(N));L=setInterval(function(){for(w=0,S=b.length+f.length;S>w;w++)N=b.length>w?b[w]:f[w-b.length],x=N.attributes.placeholder,x?(x=x.nodeValue,x&&M.inArray(B,N.type)&&(N.getAttribute(j)||p(N),(x!==N.getAttribute(V)||"password"===N.type&&!N.getAttribute(P))&&("password"===N.type&&!N.getAttribute(P)&&M.changeType(N,"text")&&N.setAttribute(P,"password"),N.value===N.getAttribute(V)&&(N.value=x),N.setAttribute(V,x)))):N.getAttribute(D)&&(n(N),N.removeAttribute(V));h||clearInterval(L)},100)}M.addEventListener(t,"beforeunload",function(){K.disable()}),K.disable=K.nativeSupport?e:i,K.enable=K.nativeSupport?e:l}(this);
</script>

<link rel="shortcut icon" href="/favicon.ico" />
<link rel="icon" href="/favicon.ico" />

<?php echo $analytics; ?>

</head>
<body>

<?php echo $content; ?>

<div id="footer">&copy; <a href="http://www.upcomcms.ru">Upcomcms</a> ( Дата синхронизации: <?php echo $data['upd_date']; ?> )</div>

</body>
</html>