<?php

$our_url = "http://".$_SERVER['HTTP_HOST'] . rtrim($_SERVER['PHP_SELF'], '/\\');
define ('URL',$our_url);

$our_url = "http://".$_SERVER['HTTP_HOST'] . rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
define ('SITE_URL_ABS',$our_url);
define ('SITE_URL_SCRIPT',$our_url);

function tpl ()
{
		$obj = new smarty ();
		$obj->template_dir 	= ROOT_PATH.'/tpl/';
		$obj->compile_dir 	= ROOT_PATH.'/tpl_c/';
		$obj->debugging 	= false;
		$obj->left_delimiter = '{{';
		$obj->right_delimiter = '}}';

		$obj->assign ('url_abs', SITE_URL_ABS);
		$obj->assign ('url', SITE_URL_SCRIPT);
		
		$obj->assign ('rnd', mt_rand(10,10000));
		$obj->assign ('rnd_b', md5(mt_rand(1000,9000)));
				
		$obj->assign ('server', $_SERVER);
		$obj->assign ('env', $_ENV);
		
		$obj->assign ('version', VERSION);
		
		return $obj;
}

function ClearUrl($url)
{
	$url = eregi_replace ("[^A-zА-я0-9_\?=-]", "", $url);
	$url = str_replace ("\\", "", $url);
	return $url;
};

/*

function js_esc1 ($s)
{
	$s = rawurlencode($s);
	$s = str_replace('%2A', '*', $s);
	$s = str_replace('%40', '@', $s);
	$s = str_replace('%2B', '+', $s);
	$s = str_replace('%2F', '/', $s);
	return $s;
}
function js_esc($str){ 
    $escape_chars = "%u0410 %u0430 %u0411 %u0431 %u0412 %u0432 %u0413 %u0433 %u0490 %u0491 %u0414 %u0434 %u0415 %u0435 %u0401 %u0451 %u0404 %u0454 %u0416 %u0436 %u0417 %u0437 %u0418 %u0438 %u0406 %u0456 %u0419 %u0439 %u041A %u043A %u041B %u043B %u041C %u043C %u041D %u043D %u041E %u043E %u041F %u043F %u0420 %u0440 %u0421 %u0441 %u0422 %u0442 %u0423 %u0443 %u0424 %u0444 %u0425 %u0445 %u0426 %u0446 %u0427 %u0447 %u0428 %u0448 %u0429 %u0449 %u042A %u044A %u042B %u044B %u042C %u044C %u042D %u044D %u042E %u044E %u042F %u044F"; 
    $russian_chars = "А а Б б В в Г г Ґ ґ Д д Е е Ё ё Є є Ж ж З з И и І і Й й К к Л л М м Н н О о П п Р р С с Т т У у Ф ф Х х Ц ц Ч ч Ш ш Щ щ Ъ ъ Ы ы Ь ь Э э Ю ю Я я"; 
    $e = explode(" ",$escape_chars); 
    $r = explode(" ",$russian_chars); 
    $rus_array = str_split($str); 
    $new_word = str_replace($r,$e,$rus_array); 
    $new_word = str_replace(" ","%20",$new_word); 
    $new_word = implode("",$new_word); 
    return ($new_word); 
} 
*/

function js_esc ($s)
{
	return utf16urlencode($s);
}

/*
function utf16urlencode($str)
{
    $str = mb_convert_encoding($str, "cp1251", "utf-8");
    $res = "";
    for ($i = 0; $i < strlen($str); $i++) {
        $res .= "%u";
        #$a = iconv("cp1251", "ucs-2", $str[$i]);
        $a = mb_convert_encoding($str[$i], "ucs-2", "cp1251");
        for ($j = 0; $j < strlen($a); $j++) {
            $n = dechex(ord($a[$j]));
            if (strlen($n) == 1) {
                $n = "0$n";
            }
            $res .= $n;
        }
    }
    return $res;
}
*/

function utf16urlencode($str)
{
	$str = mb_convert_encoding($str, 'UTF-16', 'UTF-8');
	$out = '';
	for ($i = 0; $i < mb_strlen($str, 'UTF-16'); $i++) 
	{
		$out .= '%u'.bin2hex(mb_substr($str, $i, 1, 'UTF-16'));
	}
	return $out;
}

function utf16urldecode($str)
{
	$str = explode('%u', $str);
	$out = '';
	for ($i = 0; $i < count($str); $i++) 
	{
		$out .= pack('H*', $str[$i]);
	}
	$out = mb_convert_encoding($out, 'UTF-8', 'UTF-16');
	return $out;
}

# %u0425%u0443%u0439%u043d%u044f
#echo utf16urldecode('%u0425%u0443%u0439%u043d%u044f');
# echo utf16urlencode('Хуйня')."\n";
# echo utf16urlencode(base64_decode('kdjfhdkjfhkjfdhjk'));
?>