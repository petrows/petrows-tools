<?php

class page_browser extends page
{
	public $page_title = 'Browser Info';
	public $text_title = 'Browser Info';
	function display ()
	{
		$tpl = tpl ();
		$heads = array ();
		foreach ($_SERVER as $h=>$v)
		{
			if (preg_match('/^HTTP_/', $h))
			{
				$h = preg_replace ('/^HTTP_/i', '', $h);
				$h = str_replace ('_', ' ', $h);
				$h = ucwords(strtolower($h));
				$h = str_replace (' ', '-', $h);
				$heads[$h] = $v;
			}
		}
		$tpl->assign('heads', $heads);
		$tpl->assign('ip_long', ip2long($_SERVER['REMOTE_ADDR']));
		return $tpl->fetch ('browser-index.tpl');
	}
}
?>