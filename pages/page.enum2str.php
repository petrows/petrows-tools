<?php

class page_enum2str extends page
{
	public $page_title = 'C++ Enum 2 String (enum2str)';
	public $text_title = 'C++ Enum 2 String (enum2str)';
	
	function display ()
	{
		$tpl = tpl ();
		return $tpl->fetch ('enum2str.tpl');
	}
}
?>