<?php

define ('ROOT_PATH', dirname (__FILE__));
define ('VERSION', '2.0');

require (ROOT_PATH.'/inc/page.atl.php');
require (ROOT_PATH.'/inc/functions.php');
require (ROOT_PATH.'/inc/smarty/Smarty.class.php');

session_start();

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

if (get_magic_quotes_gpc())
{
	$_POST 		= magic_quotes ($_POST);
	$_GET 		= magic_quotes ($_GET);
	$_COOKIE 	= magic_quotes ($_COOKIE);
	$_REQUEST 	= magic_quotes ($_REQUEST);
}

# Main class
class tools2
{
	public $params = array ();
	public $input  = array ();
	
	public $page_class;
	public $page_name;
	
	public $mainhref;
	public $page_title = '';
	public $text_title = '';
	public $error  = array ();
	
	public $user_id = 0;
	public $raw_output = false;
	
	function display ()
	{
		$this->init_session ();
		$this->parse_input_vars ();
		$this->mainhref = $this->load_page ();
		
		if (!empty($this->error))
		{
			$this->page_title = 'Error';
			$this->text_title = 'Error';
			$err_out = '<div class="error">';
			foreach ($this->error as $err)
				$err_out .= ' &raquo; '.$err."<br/>\n";
			$err_out .= '</div>';
			$this->mainhref = $err_out;
		}
		
		if ($this->raw_output)
		{
			echo $this->mainhref;
		} else {
			$main_tpl = tpl ();
			$main_tpl->assign ('main', $this->mainhref);
			$main_tpl->assign ('page_title', $this->page_title);
			$main_tpl->assign ('text_title', $this->text_title);
			
			$main_tpl->display ('index.tpl');
		}
	}
	
	function init_session ()
	{
		if (!preg_match('/^[a-f0-9]{32}$/', @$_COOKIE['wt-user']))
		{
			$this->user_id = md5(uniqid('wt-tools') . mt_rand(0,100000));
			setcookie('wt-user', $this->user_id, time()+360000000, '/');
		} else {
			$this->user_id = $_COOKIE['wt-user'];
		}
	}
	
	function load_page ()
	{
		# Load page
		$this->page_name = 'index';
		if (isset($this->input[0]))
		{
			$this->page_name = strtolower(eregi_replace('[^a-z0-9\-_]','',$this->input[0]));
		}
		
		if (!file_exists(ROOT_PATH.'/pages/page.'.$this->page_name.'.php'))
		{
			# Error!
			$this->error[] = 'Error loading page! (page not found)';
			return '';
		}
		include_once (ROOT_PATH.'/pages/page.'.$this->page_name.'.php');

		if (!is_subclass_of('page_'.$this->page_name, 'page'))
		{
			# Error!
			$this->error[] = 'Error loading page! (class not found)';
			return '';
		}
		$t = 'page_'.$this->page_name;
		$this->page_class = new $t ();
		
		$out = $this->page_class->display ();
		$this->page_title = $this->page_class->page_title;
		$this->text_title = $this->page_class->text_title;
		return $out;
	}
	
	function parse_input_vars ()
	{
		$this->params = array ();
		$this->input  = array ();
		
		if (!isset($_GET['url']))
			return;
			
		$_GET['url'] = trim ($_GET['url'], '/');
		$_GET['url'] = eregi_replace ("[^a-zA-Z0-9\/_-]", "", $_GET['url']);
		
		if ($_GET['url'] == '')
		{
			unset($_GET['url']);
			return;
		}
		$_GET['url'] = strtolower ($_GET['url']);
		$this->input = explode ('/',$_GET['url']);
		
		$url = parse_url($_SERVER['REQUEST_URI']);
		if (!isset($url['query']))
			return;
		if (strlen($url['query'])>255)
		{
			return;
		}
		if (false)
		{
			$m = false;
			preg_match ('!(\?=)?(url=(.*))\?(.*)!', $url['query'], $m);
			if (!isset($m[4]))
				return;

			parse_str($m[4],$this->params);
		} else {
			parse_str($url['query'],$this->params);
		}
		foreach ($this->params as $k=>$v)
		{
			$this->params[$k] = ClearUrl ($v);
		}
		
		$_GET = $this->params;
	}	
}

$GLOBALS['core'] = new tools2();
$GLOBALS['core']->display ();

?>