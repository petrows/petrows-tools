<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="robots" content="index, follow" />
	<title>WebTools :: {{$page_title|default:"Tools for all"}}</title>
	<link rel="stylesheet" type="text/css" media="all" href="{{$url_abs}}/tpl/style.css" />
	<script src="{{$url_abs}}/tpl/scripts.js" type="text/javascript"></script>
</head>

<body>
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
	<td align="center"><a href="{{$url}}/"><img src="{{$url}}/tpl/petro-ws-logo.png" alt="logo"/></a></td>
	<td>&nbsp;</td>
	<td class="logo"><a href="{{$url}}/">Web Tools {{$version}}</a></td>
</tr>
<tr>
	<td width="200" valign="top" align="left" style="border-top: 1px dotted #FF9933;">
		<!-- menu -->
		<div class="menu">
		<center><h3>Menu</h3></center>
		<ul>
		<li> <a href="{{$url}}">Index</a> </li>
		<li> <a href="{{$url}}/php_func/">PHP functions</a></li>
		<li> <a href="{{$url}}/enum2str/">C++ enum2str</a></li>
		<li> <a href="{{$url}}/time/">Date / Time</a> </li>
		<li> <a href="{{$url}}/browser/">Browser info</a> </li>
		<!--<li> <a href="{{$url}}/create_copyright/">Copyright Builder</a> </li>-->
		</ul>
		</div>
		
		<center>
		<p><a href="http://smarty.net/" target="_blank"><img src="{{$url_abs}}/tpl/smarty_icon.gif" alt="Smarty" border="0"/></a></p>
		<p><a href="http://php.net/" target="_blank"><img src="{{$url_abs}}/tpl/php-power-white.png" alt="PHP"  border="0"/></a></p>
		<p><a href="http://validator.w3.org/check?uri=referer" target="_blank"><img	src="http://www.w3.org/Icons/valid-xhtml10"	alt="Valid XHTML 1.0 Transitional" height="31" width="88" border="0" /></a></p>
		<p><a href="http://jigsaw.w3.org/css-validator/validator?uri=http://tools.berenices.net/tpl/style.css" target="_blank"><img style="border:0;width:88px;height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss" alt="Valid CSS!" /></a></p>
		<p>
<!--LiveInternet counter--><script type="text/javascript"><!--
document.write("<a href='http://www.liveinternet.ru/click' "+
"target=_blank><img src='http://counter.yadro.ru/hit?t22.3;r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";"+Math.random()+
"' alt='' title='LiveInternet: показано число просмотров за 24"+
" часа, посетителей за 24 часа и за сегодня' "+
"border=0 width=88 height=31><\/a>")//--></script><!--/LiveInternet-->
		</p>
		</center>
		<br/>
	</td>
<td width="1" style="border-right: 1px dotted #FF9933; border-top: 1px dotted #FF9933;">&nbsp;</td>
<td valign="top" align="left">
<div class="text_title"> &raquo; {{$text_title|default:"-"}}</div>
<div class="body_main">
{{$main}}
</div>
</td>
</tr>
<tr>
	<td colspan="3" class="copyright">&copy; 2008-2014 : tools.petro.ws; <a href="mailto:petro@petro.ws?subject=From%20tools.petro.ws">petro@petro.ws</a>; v. {{$version}}</td>
</tr>
</table>

</body>
</html>