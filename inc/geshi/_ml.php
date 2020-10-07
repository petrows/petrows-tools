<?php
error_reporting (~E_NOTICE);
$dir = dirname(__FILE__).'/';
$dh = opendir ($dir);
$out = '';
$f_list = array ();
while (($file = readdir($dh)) !== false) 
{	if (!ereg('\.php$', $file))
		continue;
	if (isset($f_list[$file])) break;
	$f_list[$file] = true;
	$l_name = str_replace ('.php', '', $file);
	
	include ($dir.'/'.$file);
	$l_title = $language_data['LANG_NAME'];
	
	$out = '$f_list[] = array (
	\'cat\'	=> $cat,
	\'name\'	=> \'hl-'.$l_name.'\',
	\'callc\'	=> 1,
	\'title\'	=> \'Hilight: '.$l_title.'\',
	\'descr\'	=> \'This function makes <b>'.$l_title.'</b> language hilight.<br/><br/><b>Note:</b> This function use the <a href="http://qbnz.com/highlighter/" target="_blank">Geshi Library</a>\',
	\'link\'	=> \'http://qbnz.com/highlighter/\'
);
';
	#$out .= "}\n";
	echo $out;
}
?>