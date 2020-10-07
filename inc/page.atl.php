<?php

class page
{	public $core;
	
	public $page_title = 'ATL title';
	public $text_title = 'ATL title';
	
	function page ()
	{		$this->core = $GLOBALS['core'];
	}
	
	function display ()
	{
		$this->core->error[] = 'STD display is not defined for this page!';
		return;
	}
	
	function print_page ()
	{
		$this->core->error[] = 'Print is not defined for this page!';
		return;
	}
	
	function download_res ()
	{
		$this->core->error[] = 'Downloading is not defined for this page!';
		return;
	}
}
?>