<?php

define ('VERSION', '1.1');

function magic_quotes ($arr)
{
	if (is_array($arr))
	{
		foreach ($arr as $k=>$v)
			$arr[$k] = magic_quotes ($v);
		return $arr;
	}

	$arr = stripslashes($arr);
	return $arr;
}

class web_tools
{
	var $out = '';
	var $str_in = false;
	var $f_c = 0;

	var $modes = array ('std', 'txt');

	function display ()
	{
		if (!isset($_POST['du']) && !empty($_POST)) {
			setcookie('webtooldu','', time()-999999, '/');
			unset($_COOKIE['webtooldu']);
		} elseif (isset($_POST['du']) || isset($_COOKIE['webtooldu'])) {
			setcookie('webtooldu','1', time()+999999, '/');
			$_POST['du'] = true;
		}

		if (isset($_POST['s'])) {
			setcookie('webtool',base64_encode($_POST['s']), time()+999999, '/');
		} elseif (!isset($_POST['s']) && isset($_COOKIE['webtool'])) {
			$_POST['s'] = base64_decode($_COOKIE['webtool']);
		}



		if (!in_array(@$_GET['m'], $this->modes))
		{
			$_GET['m'] = 'std';
		}

		#if (!isset($_POST['sub_send']))
		#	$_POST['du'] = 'ON';

		if ($_GET['m'] == 'std')
		{
			$this->out .= '<table border="0" width="100%">';
			$this->out .= '<tr><td><b>Current timestamp</b></td><td>'.time().' ['.gmdate('r').']</td></tr>';
			$this->out .= '<tr><td><b>Your IP</b></td><td>'.$_SERVER['REMOTE_ADDR'].'</td></tr>';
			$this->out .= '<tr><td><b>Your User-Agent</b></td><td>'.$_SERVER['HTTP_USER_AGENT'].'</td></tr>';
			$this->out .= '</table><hr/>';

			# Show the form
			$this->out .= $this->show_form ();
		}

		if (!isset($_POST['s']))
		{
			$this->out .= '<br/><br/><div align="center" style="color:red; font-size: 20px;"><b> ---- No string given: Write smth in field! ---- </b></div><br/><br/>';
			return;
		}

		# Send counter!

		if (isset($_POST['du']))
		{
			parse_str($_POST['s'],$this->str_in);
		} else {
			$this->str_in = $_POST['s'];
		}

		if ($_GET['m'] == 'std')
		{
			$this->out .= '<p><a href="?m=txt" target="_blank">Get result as txt</a> (<a href="?m=txt&d=1">Download it</a>)</p>';
			$this->out .= '<table border="0" width="100%" align="center">';
		}

		$this->out .= $this->res ('Raw value(s)', 'ech');

		$this->out .= $this->res ('Timestamp (decode)', 'tms');
		$this->out .= $this->res ('MD5', 'md5');
		$this->out .= $this->res ('SHA 1', 'sha1');
		#$this->out .= $this->res ('HEX', 'bin2hex');
		$this->out .= $this->res ('HEX (Codes)', 'hex2');
		$this->out .= $this->res ('CHAR (Codes)', 'char2');
		$this->out .= $this->res ('URL (decode)', 'rawurldecode');
		$this->out .= $this->res ('URL (encode)', 'rawurlencode');
		$this->out .= $this->res ('JS escape()', 'js_esc');
		$this->out .= $this->res ('HTML special chars', 'html_special');
		$this->out .= $this->res ('BASE64 (HEX decode)', 'base64_hex');
		$this->out .= $this->res ('BASE64 (decode)', 'base64_decode');
		$this->out .= $this->res ('BASE64 (encode)', 'base64_encode');

		if ($_GET['m'] == 'std')
		{
			$this->out .= '</table>';
		}

		if ($_GET['m'] == 'txt')
		{
			if (@$_GET['d'])
			{
				header ('Content-Type: application/x-force-download; charset=UTF-8');
				header ('Content-Disposition: inline; filename=decode-'.time().'.txt');
			} else
				header ('Content-Type: text/plain; charset=UTF-8');

			echo $this->out;
			exit ();
		}
	}

	function res ($title, $callback)
	{
		if (!function_exists($callback))
			return '<tr><td align="center"><font color="red">funcion <b>'.$callback.'</b> does not exists!</font></td></tr>';

		if (!is_array($this->str_in))
		{
			if ($_GET['m'] == 'std')
				return $this->res_out($title, html($callback($this->str_in)));
			if ($_GET['m'] == 'txt')
				return $this->res_out($title, $callback($this->str_in));
		}

		# it is an array
		if ($_GET['m'] == 'std')
			$res = '<table width="100%" border="0" cellspacing="0" cellpading="2">';
		if ($_GET['m'] == 'txt')
			$res = '';

		foreach ($this->str_in as $k=>$v)
		{
			if ($_GET['m'] == 'std')
			{
				$res .= '<tr><td align="right" width="1" nowrap="nowrap">[<b>'.htmlspecialchars($k)."</b>]&nbsp;</td><td>".html($callback($v))."</td></tr>";
			}
			if ($_GET['m'] == 'txt')
			{
				$res .= '['.$k."]\n".$callback($v)."\n\n";
			}
		}
		if ($_GET['m'] == 'std')
			$res .= '</table>';
		if ($_GET['m'] == 'txt')
			$res .= "\n";
		return $this->res_out($title, $res);
	}

	function res_out ($title, $res)
	{
		$this->f_c++;
		if ($_GET['m'] == 'std')
		{
			$out = '<tr><td class="r_title"> &raquo; '.$title.' [ <span style="cursor:pointer; color:#2B5555;" OnClick="copy_clip(my_getbyid(\'res_'.$this->f_c.'\').innerHTML, '.$this->f_c.');">copy</span> / <span style="cursor:pointer; color:#2B5555;" OnClick="show_textarea('.$this->f_c.');">in text</span> ]<td></tr>';
			$out .= '<tr style="visibility:collapse;" id="res_tr_1_'.$this->f_c.'"><td id="res_h_'.$this->f_c.'" align="center"></td></tr>'."\n\n";
			$out .= '<tr id="res_tr_2_'.$this->f_c.'"><td class="r_body" id="res_'.$this->f_c.'">'.$res."</td></tr>\n\n";
		}
		if ($_GET['m'] == 'txt')
		{
			$out = " - ".$title."\n";
			$out .= $res."\n\n";
		}
		return $out;
	}

	function show_form ()
	{
		$u_ch = '';

		if (isset($_POST['du']))
			$u_ch = 'checked="checked"';

		$out = '';
		$out .= '<form method="post"><table border="0" cellpadding="5" cellspacing="5" width="100%">';
		$out .= '<tr><td align="center"><textarea name="s" class="inp" style="width:98%" wrap="no" rows="10">'.htmlspecialchars(@$_POST['s']).'</textarea></td>';
		$out .= '<tr><td align="center">Max input: 100 kb</td>';
		$out .= '<tr><td align="center"><label><input type="checkbox" name="du" '.$u_ch.'/> <b>Decode URL string params</b> (if presented)</label></td>';
		$out .= '<tr><td align="center"><input type="submit" name="sub_send" value="  Send  " class="btn" /></td></tr>';
		$out .= '</table></form>';
		return $out;
	}
}

function ech ($t)
{
	return $t;
}

function js_esc ($s)
{
	#$GLOBALS['no_sp_html'] = true;
	#return '<script language="javascript">document.write(escape(\''.$s.'\'));</script>';
	# * @ - _ + . /
	$s = rawurlencode($s);
	$s = str_replace('%2A', '*', $s);
	$s = str_replace('%40', '@', $s);
	$s = str_replace('%2B', '+', $s);
	$s = str_replace('%2F', '/', $s);
	return $s;
}

function base64_hex ($s)
{
	return hex2(base64_decode($s));
}

function hex2 ($s)
{
	$out = '';
	$n=0;
	for ($x=0; $x<strlen($s); $x++)
	{
		$out .= '0x'.strtoupper(bin2hex($s[$x])).', ';
		if ($n>15)
		{
			$out .= "\n";
			$n=0;
		} else
			$n++;
	}
	$out = preg_replace("/,\s+$/", '', $out);
	return $out;
}

function char2 ($s)
{
	$out = '';
	$n=0;
	for ($x=0; $x<strlen($s); $x++)
	{
		$cc = ord($s[$x]);
		if ($cc<10) $cc = '  '.$cc;
		elseif ($cc<100) $cc = ' '.$cc;
		$out .= $cc.", ";
		if ($n>15)
		{
			$out .= "\n";
			$n=0;
		} else
			$n++;
	}
	$out = preg_replace("/,\s+$/", '', $out);
	return $out;
}

function tms ($s)
{
	if (!is_numeric($s)) return ' - Not a timestamp - ';

	return gmdate ('d.m.Y H:i:s', $s).' (GMT)';
}

function html_special ($s)
{
	return htmlentities($s, ENT_QUOTES, 'UTF-8');
}

function nl2nl ($s)
{
	$s = str_replace("\r", '', $s);
	$s = str_replace("\n", '\n', $s);
	return $s;
}

function html($s)
{
	if (@$GLOBALS['no_sp_html'])
	{
		$GLOBALS['no_sp_html'] = false;
		return $s;
	} else return htmlspecialchars($s);
}

$c = new web_tools();
$c->display ();
?>
<html>
<head>
	<title>Web Tools v.<?php echo VERSION; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<style>
body
{
	padding: 10px;
	margin: 10px;
}

td, p, body
{
	font-family: "courier new", courier, mono;
	font-size: 13px;
	line-height: 135%;
}

.inp
{
	border-top: 1px solid #CCC;
	border-left: 1px solid #CCC;
	border-right: 2px solid #333;
	border-bottom: 2px solid #333;
	padding: 2px;
	padding-left: 5px;
	padding-right: 5px;
	background-color: #FFF;
	font-family: "courier new", courier, mono;
	font-size: 13px;
	vertical-align: middle;
}

.btn
{
	border-top: 1px solid #CCC;
	border-left: 1px solid #CCC;
	border-right: 2px solid #333;
	border-bottom: 2px solid #333;
	padding: 1px;
	padding-left: 5px;
	padding-right: 5px;
	cursor: pointer;
	font-weight: bold;
	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-size: 12px;
	background-image: url('../img/btn_bg.jpg');
	background-color: #CCC;
	color: #333;
	vertical-align: middle;
}

.btn:hover
{
	background-color: #FFF;
	background-image: none;
}

label
{
	cursor: hand;
	cursor: pointer;
}

.r_title
{
	font-size: 14px;
	font-weight: bold;
	color: #CC0000;
	border-bottom: 1px dotted #CCC;
	padding-top: 10px;
}

.r_body
{
	font-size: 14px;
	border-bottom: 1px dotted #666;
	border-right: 1px dotted #666;
	border-left: 1px dotted #666;
	white-space: pre;
	padding: 3px;
	color: #2B5555;
}
</style>
<script language="javascript">
function my_getbyid(id)
{
	itm = null;

	if (document.getElementById)
	{
		itm = document.getElementById(id);
	}
	else if (document.all)
	{
		itm = document.all[id];
	}
	else if (document.layers)
	{
		itm = document.layers[id];
	}

	return itm;
}

function show_textarea (id)
{
	if (<?php echo isset($_POST['du'])?'true':'false'; ?>)
	{
		alert ('Not avaliable in DECODE URI mode');
		return;
	}

	if (my_getbyid('res_h_'+id))
	{
		my_getbyid('res_h_'+id).innerHTML = '<textarea wrap="on" style="width:98%" rows="5" id="res_text_'+id+'">'+my_getbyid('res_'+id).innerHTML+'</textarea>';

		my_getbyid('res_text_'+id).select();
		my_getbyid('res_text_'+id).focus ();

		copy_clip(my_getbyid('res_'+id).innerHTML, id, true);

		if (my_getbyid('res_tr_1_'+id).style.visibility == 'visible')
		{
			my_getbyid('res_tr_1_'+id).style.visibility = 'collapse';
			my_getbyid('res_tr_2_'+id).style.visibility = 'visible';
		} else {
			my_getbyid('res_tr_1_'+id).style.visibility = 'visible';
			my_getbyid('res_tr_2_'+id).style.visibility = 'collapse';
		}
	}
}

function copy_clip(meintext, id, hide)
{
	if (window.clipboardData)
	{
		window.clipboardData.setData("Text", meintext);
	} else if (window.netscape)
	{
		try {
			netscape.security.PrivilegeManager.enablePrivilege('UniversalXPConnect');
		} catch (e) {
			if (!hide)
				alert('Your browser does not support Clipboard operations!');
			return;
		}
		var clip = Components.classes['@mozilla.org/widget/clipboard;1'].createInstance(Components.interfaces.nsIClipboard);
		if (!clip) return;
		var trans = Components.classes['@mozilla.org/widget/transferable;1'].createInstance(Components.interfaces.nsITransferable);
		if (!trans) return;
		trans.addDataFlavor('text/unicode');
		var str = new Object();
		var len = new Object();
		var str = Components.classes["@mozilla.org/supports-string;1"].createInstance(Components.interfaces.nsISupportsString);
		var copytext=meintext;
		str.data=copytext;
		trans.setTransferData("text/unicode",str,copytext.length*2);
		var clipid=Components.interfaces.nsIClipboard;
		if (!clip) return false;
		clip.setData(trans,null,clipid.kGlobalClipboard);
	}
	return false;
}
</script>
<body>
<center>
<div align="center">
<p><b>Web Tools <?php echo VERSION; ?></b> : just do it</p>
<?php echo $c->out; ?>
</div>
<br/>
<div style="padding:3px; background-color: #CCCCCC; color: #333333;" align="center">&copy; <a href="mailto:admin@berenices.net">Admin</a>; &copy; <a href="http://berenices.net/">berenices.net</a>; Jan 2008</div>
</center>
</body>
</html>