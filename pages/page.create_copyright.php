<?php

class page_create_copyright extends page
{
	public $page_title = 'Create Code Copyright';
	public $text_title = 'Create Code Copyright';
	
	function display ()
	{
		$tpl = tpl ();
		return $tpl->fetch('page-create-copyright.tpl');
	}
}
?>