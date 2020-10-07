<?php
#echo base64_decode('Hello world!');
class page_php_func extends page
{
	public $page_title = 'Apply Functions';
	public $text_title = 'Apply Functions';
	public $f_list;
	public $ajax;
	public $ajax_out = '';
	#public $response = array
	function display ()
	{
		include (ROOT_PATH.'/inc/page.php.func.list.php');
		$this->f_list = $f_list;
		$this->c_list = $f_cat;

		# We have BackEnd request?
		if (@$GLOBALS['core']->input[1] == 'ajax')
			return $this->backend ();
		
		$tpl = tpl ();
		$js_f_list = array ();
		foreach ($this->f_list as $k=>$v)
		{
			$tmp = array ();
			foreach ($v as $fk=>$fv)
			{
				$tmp[] = '\''.$fk.'\':\''.$fv.'\'';
			}
			$js_f_list[] = '{'.implode(",",$tmp).'}';
		}
		$js_f_list = implode (",\n", $js_f_list);
		$tpl->assign ('func_list', $js_f_list);
		$js_c_list = array ();
		foreach ($this->c_list as $k=>$v)
		{
			$js_c_list[] = '['.$k.', \''.$v.'\']';
		}
		$js_c_list = implode (",\n", $js_c_list);
		$tpl->assign ('func_cat', $js_c_list);
		return $tpl->fetch ('php_func.tpl');
	}
	
	function backend ()
	{
		$this->proc_text ();
		echo $this->ajax_out;
		exit ();		
		$this->ajax = new JsHttpRequest('UTF-8');
		$this->ajax_out = 'No String given';
		$this->proc_text ();
		$this->send_js ();
	}
	
	function send_js ($text)
	{
		#$rep_js = mt_rand(10,10000).substr(md5(uniqid('f%')), 4, 4);
		#$text = str_replace ('<', '', $text);
		#$text = str_replace ('>', '', $text);
		
		if (isset($_POST['result_as_file']))
		{
			# Send the file!
			header ('Content-Length: '.strlen($text));
			header ('Content-Type: application/x-force-download');
			header ('Content-Disposition: attachment; filename="decode-'.time().'.txt"');
			echo $text;
			exit ();
		}

		$js_rep = array
		(
                array("\\", "/", "\n", "\t", "\r", "\b", "\f", '"'),
                array('\\\\', '\\/', '\\n', '\\t', '\\r', '\\b', '\\f', '\"')
  		);
		$text = str_replace($js_rep[0], $js_rep[1], $text);
		echo '<script type="text/javascript">';
		echo 'var res = "'.$text.'";';
		echo 'top.get_request(res);';
		echo '</script></body></html>';
		exit ();
	}
	
	function proc_text ()
	{
		#print_r ($_POST);
		#if (!isset($_REQUEST['qw'], $_REQUEST['text'])) return;
		#$qw_list = $_REQUEST['qw'];
		if (empty($_POST)) exit ();
		
		if (is_uploaded_file(@$_FILES['req_file']['tmp_name']))
		{
			# Upload a file!
			#echo 'Fileeee!';
			if (filesize($_FILES['req_file']['tmp_name']) > 102400) // 100 kb
			{
				$this->send_js('[[hl-red]File is too big! (Max allowed: 100 kb)]');
				exit ();
			}
			$this->ajax_out = file_get_contents($_FILES['req_file']['tmp_name']);
		} else {
			# Simple text
			$this->ajax_out = @$_POST['input_text'];
			$this->ajax_out = substr ($this->ajax_out, 0, 102400);
		}
		$qw_list = explode (',', @$_POST['req_query']);
		if (empty($qw_list)) return;
		require_once(ROOT_PATH.'/inc/page.php.func.core.php');
		$func_core = new php_func_core ();
		ksort($qw_list); reset($qw_list);
		foreach ($qw_list as $k=>$v)
		{
			# Special: hilight
			if (ereg('^hl-', $v))
			{
				$this->ajax_out = $func_core->code_hilight ($this->ajax_out, $v);
				continue;
			}
			if (!method_exists($func_core, $v))
				continue;
			$this->ajax_out = $func_core->$v ($this->ajax_out);
		}
		$this->send_js($this->ajax_out);
	}
}
?>