<?php

class page_index extends page
{
	public $page_title = 'Welcome';
	public $text_title = 'Welcome';
	
	function display ()
	{
		$tpl = tpl ();
		return $tpl->fetch('text-index.tpl');
	}
}
?>