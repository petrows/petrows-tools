<?php
class php_func_core
{
	#############################################################################################
	# GENERIC
	function remove_nl ($s)
	{
		$s = str_replace ("\n", "", $s);
		$s = str_replace ("\r", "", $s);
		return $s;
	}
	function remove_nl_space ($s)
	{
		$s = str_replace ("\n", " ", $s);
		$s = str_replace ("\r", " ", $s);
		return $s;
	}
	function remove_nl_codes ($s)
	{
		$s = str_replace ("\n", "\\n", $s);
		$s = str_replace ("\r", "\\r", $s);
		return $s;
	}
	function nl2br ($s)
	{
		$s = str_replace ("\r", "", $s);
		$s = str_replace ("\n", "<br/>", $s);
		return $s;
	}
	function nl2br_add ($s)
	{
		$s = str_replace ("\r", "", $s);
		$s = str_replace ("\n", "<br/>\n", $s);
		return $s;
	}
	function remove_br_simple ($text)
	{
		$text = preg_replace("'<br\s+/?>'Usimu", "", $text);
		return $text;
	}
	function remove_br_adv ($text)
	{
		$text = preg_replace("'<br\s*/?>\s*(\r?\n?)*'simu", "\n", $text);
		return $text;
	}
	function remove_tags ($text)
	{
		$text = preg_replace("'<script[^>]*>(.*)?</script>'Usimu", "", $text);
		$text = preg_replace("'<noscript[^>]*>(.*)?</noscript>'Usimu", "", $text);
		$text = preg_replace("'<style[^>]*>(.*)?</style>'Usimu", "", $text);
		$text = preg_replace("'<[\/\!]*?[^<>]*?>'Usimu", "", $text);
		return $text;
	}
	function html_entity_decode ($text)
	{
		$text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
		return $text;
	}
	function str_auto_html ($pee, $br = 1) 
	{
		if (!is_string($pee))
			return $pee;
		if (trim($pee) == '')
			return '';
	
		$pee = $pee . "\n"; // just to make things a little easier, pad the end
		$pee = preg_replace('|<br />\s*<br />|', "\n\n", $pee);
		// Space things out a little
		$allblocks = '(?:table|thead|tfoot|caption|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|select|form|map|area|blockquote|address|math|style|input|p|h[1-6]|hr)';
		$pee = preg_replace('!(<' . $allblocks . '[^>]*>)!', "\n$1", $pee);
		$pee = preg_replace('!(</' . $allblocks . '>)!', "$1\n\n", $pee);
		$pee = str_replace(array("\r\n", "\r"), "\n", $pee); // cross-platform newlines
		$pee = preg_replace("/\n\n+/", "\n\n", $pee); // take care of duplicates
		$pee = preg_replace('/\n?(.+?)(?:\n\s*\n|\z)/s', "<p>$1</p>\n", $pee); // make paragraphs, including one at the end
		$pee = preg_replace('|<p>\s*?</p>|', '', $pee); // under certain strange conditions it could create a P of entirely whitespace
		$pee = preg_replace('!<p>([^<]+)\s*?(</(?:div|address|form)[^>]*>)!', "<p>$1</p>$2", $pee);
		$pee = preg_replace( '|<p>|', "$1<p>", $pee );
		$pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee); // don't pee all over a tag
		$pee = preg_replace("|<p>(<li.+?)</p>|", "$1", $pee); // problem with nested lists
		$pee = preg_replace('|<p><blockquote([^>]*)>|i', "<blockquote$1><p>", $pee);
		$pee = str_replace('</blockquote></p>', '</p></blockquote>', $pee);
		$pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)!', "$1", $pee);
		$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee);
		if ($br) {
			$pee = preg_replace('/<(script|style).*?<\/\\1>/se', 'str_replace("\n", "<WPPreserveNewline />", "\\0")', $pee);
			$pee = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $pee); // optionally make line breaks
			$pee = str_replace('<WPPreserveNewline />', "\n", $pee);
		}
		$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!', "$1", $pee);
		$pee = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $pee);
		if (strpos($pee, '<pre') !== false)
			$pee = preg_replace('!(<pre.*?>)(.*?)</pre>!ise', " stripslashes('$1') .  stripslashes(clean_pre('$2'))  . '</pre>' ", $pee);
		#if (strpos($pee, '[src') !== false)
		#	$pee = preg_replace_callback('!([src.*?])(.*?)[/src]!isU', 'clean_code_callback', $pee);
		$pee = preg_replace( "|\n</p>$|", '</p>', $pee );

		return $pee;
	}
	
	#############################################################################################
	# HILIGHT
	function code_hilight ($s, $name)
	{
		error_reporting(E_ALL);
		preg_match('/hl-(.*)/', $name, $res);
		if (!@$res[1]) return $s;
		include_once (ROOT_PATH.'/inc/class.geshi.php');
		$s = geshi_highlight ($s, $res[1], ROOT_PATH.'/inc/geshi/', true);
		return $s;
	}
	
	#############################################################################################
	# CODE/DECODE
	function convert_uudecode ($s)
	{
		return @convert_uudecode($s);
	}
	function convert_uuencode ($s)
	{
		return @convert_uuencode($s);
	}
	function base64_decode ($s)
	{
		return @base64_decode($s);
	}
	function base64_encode ($s)
	{
		return @base64_encode($s);
	}
	function js_escape($str)
	{
		$str = mb_convert_encoding($str, 'UTF-16', 'UTF-8');
		$out = '';
		for ($i = 0; $i < mb_strlen($str, 'UTF-16'); $i++) 
		{
			$out .= '%u'.bin2hex(mb_substr($str, $i, 1, 'UTF-16'));
		}
		return $out;
	}
	function js_escape_bin($str)
	{
		$out = '';
		for ($i = 0; $i < mb_strlen($str); $i++)
		{
			$out .= '%u'.bin2hex(substr($str, $i, 1));
		}
		return $out;
	}
	function js_unescape($str)
	{
		$str = explode('%u', $str);
		$out = '';
		for ($i = 0; $i < count($str); $i++)
		{
			$out .= @pack('H*', $str[$i]);
		}
		$out = mb_convert_encoding($out, 'UTF-8', 'UTF-16');
		return $out;
	}
	function js_unescape_bin($str)
	{
		$str = explode('%u', $str);
		$out = '';
		for ($i = 0; $i < count($str); $i++)
		{
			$out .= @pack('H*', $str[$i]);
		}
		return $out;
	}
	function url_encode ($str)
	{
		return @rawurlencode($str);
	}
	function url_decode ($str)
	{
		return @rawurldecode($str);
	}
	
	#############################################################################################
	# HASHES
	function md5 ($s)
	{
		return md5($s);
	}
	function sha1 ($s)
	{
		return sha1($s);
	}
	function crc32 ($s)
	{
		return crc32($s);
	}
	
	#############################################################################################
	# IN transform
	function tr_in_hex ($s)
	{
		if (strlen($s)%2 != 0)
			$s = '0'.$s;
		return @pack ('H*', $s);
	}
	function tr_in_chex_c ($s)
	{
		$out = '';
		$s = trim ($s);
		preg_match_all('/0x([A-Fa-f0-9]{2})/m', $s, $res);
		$res = $res[1];
		#print_r ($res);
		for ($x=0; $x<count($res); $x++)
			$out .= @pack ('H*', $res[$x]);
		return $out;
	}
	function tr_in_chex_s ($s)
	{
		$out = '';
		$s = trim ($s);
		preg_match_all('/x([A-Fa-f0-9]{2})/m', $s, $res);
		$res = $res[1];
		#print_r ($res);
		for ($x=0; $x<count($res); $x++)
			$out .= @pack ('H*', $res[$x]);
		return $out;
	}
	function tr_in_hex_c ($s)
	{
		$out = '';
		$s = trim ($s);
		$res = explode (',', $s);
		for ($x=0; $x<count($res); $x++)
		{
			$res[$x] = trim($res[$x]);
			$out .= @pack ('H*', $res[$x]);
		}
		return $out;
	}
	function tr_in_char_c ($s)
	{
		$out = '';
		$s = trim ($s);
		preg_match_all('/([0-9]+)/m', $s, $res);
		$res = $res[1];
		for ($x=0; $x<count($res); $x++)
			$out .= chr($res[$x]);
		return $out;
	}
	#############################################################################################
	# OUT transform
	function tr_out_hex_c ($s)
	{
		$out = array();
		$n=-1;
		for ($x=0; $x<strlen($s); $x++)
		{
			$out[] = strtoupper(bin2hex($s[$x]));
			if ($n==16)
			{
				$out[$x-1] = "\n".$out[$x-1];
				$n=1;
			} else
				$n++;
		}
		$out = implode(", ", $out);
		return $out;
	}
	function tr_out_chex_c ($s)
	{
		$out = array();
		$n=-1;
		for ($x=0; $x<strlen($s); $x++)
		{
			$out[] = '0x'.strtoupper(bin2hex($s[$x]));
			if ($n==8)
			{
				$out[$x-1] = "\n".$out[$x-1];
				$n=1;
			} else {
				$n++;
			}
		}
		$out = implode(", ", $out);
		return $out;
	}
	function tr_out_chex_c2 ($s)
	{
		$out = array();
		$n=-1;
		for ($x=0; $x<strlen($s); $x++)
		{
			$out[] = '\\0x'.strtoupper(bin2hex($s[$x]));
			if ($n==8)
			{
				$out[$x-1] = "\n".$out[$x-1];
				$n=1;
			} else
				$n++;
		}
		$out = implode(", ", $out);
		return $out;
	}
	function tr_out_char_c ($s)
	{
		$out = array();
		$n=-1;
		for ($x=0; $x<strlen($s); $x++)
		{
			$out[] = sprintf("%03d",ord($s[$x]));
			if ($n==8)
			{
				$out[$x-1] = "\n".$out[$x-1];
				$n=1;
			} else
				$n++;
		}
		$out = implode(", ", $out);
		return $out;
	}
	function tr_out_char_carray ($s)
	{
		$out = array();
		$s .= 0x00;
		$n=-1;
		$cc = strlen($s);
		for ($x=0; $x<=$cc; $x++)
		{
			if ($x<$cc) $out[] = sprintf("%03d",ord($s[$x])); else $out[] = '000';
			if ($n==8)
			{
				$out[$x-1] = "\n".$out[$x-1];
				$n=1;
			} else
				$n++;
		}
		$out = implode(", ", $out);
		$out = 'char str['.($cc+1).'] = {'."\n".$out."\n".'};';
		return $out;
	}
}
#echo 'test';
?>