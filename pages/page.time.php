<?php

class page_time extends page
{
	public $page_title = 'Date / time';
	public $text_title = 'Date / time';
	
	function display ()
	{
		$tpl = tpl ();
		return $tpl->fetch ('time.tpl');
	}
}
?>