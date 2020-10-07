<script type="text/javascript">
//<!--
var func_query = new Array ();
var func_list = new Array (
{{$func_list}}
);
var func_cat = new Array (
{{$func_cat}}
);

var qw_result = '';
var res_mode = 'div';
var html_res = '';

var wait_t;
var wait_c = 0;

var sended = false;

function qw_add (func)
{
	var func_info = get_func(func);
	if (func_info['callc'])
	{
		var call_count = 1;
		for (y=0; y<func_query.length; y++)
		{
			if (func_query[y] == func)
				call_count++;
		}
		if (call_count > func_info['callc'])
		{
			alert ('Too many call of function "'+func_info['title']+'"!');
			return;
		}
	}
	func_query.push(func);
	qw_draw ();
}
function qw_remove (id)
{
	var tmp = new Array ();
	for (var x=0; x<func_query.length; x++)
	{
		if (x != id)
			tmp[tmp.length] = func_query[x];
	}
	func_query = tmp;
	qw_draw ();
}
function qw_draw ()
{
	if (func_query.length == 0)
	{
		my_getbyid('func_query').innerHTML = 'Query is empty';
		return;
	}
	// Fill the query
	//var out = '<div>&darr; <b>Text</b><br/>';
	var out = '<table cellpadding="3" cellspacing="0" border="0" width="500">';
	out += '<tr><th align="center">#</th><th align="center">Category</th><th>Function</th><th>Action</th></tr>';
	var c_f = '';
	for (var x=0; x<func_query.length; x++)
	{
		c_f = get_func(func_query[x]);
		out += '<tr><td align="center"><b>'+(x+1)+'</b></td><td align="center">'+get_cat(c_f['cat'])+'</td><td> [<a href="javascript:void(0);" onclick="draw_func_info (\''+c_f['name']+'\');">?</a>] <b>'+c_f['title']+'</b></td><td>[<a href="javascript:void(0);" onclick="qw_remove('+x+');">Remove</a>]</td></tr>';
	}
	out += '</table>';
	out += '[<a href="javascript:void(0);" onclick="func_query=new Array();qw_draw();">Clear Query</a>]';
	my_getbyid('func_query').innerHTML = out;
}
function get_func (name)
{
	for (n=0; n<func_list.length; n++)
	{
		if (name == func_list[n]['name'])
		{
			return func_list[n];
		}
	}
	return false;
}
function get_cat (id)
{
	for (n=0; n<func_cat.length; n++)
	{
		if (id == func_cat[n][0])
		{
			return func_cat[n][1];
		}
	}
	return false;
}
function draw_func_info (func)
{
	var out = '';
	//alert (func);	
	var data = get_func (func);
	if (!data) return;
	my_getbyid('descr_title').innerHTML = data['title'];
	my_getbyid('descr_body').innerHTML = data['descr'];
	if (data['link'])
	{
		my_getbyid('descr_link').innerHTML = 'Function info: <a href="'+data['link']+'" target="_blank">'+data['link']+'</a>';
	} else {
		my_getbyid('descr_link').innerHTML = '';
	}
	my_getbyid('descr_btn').innerHTML = '<input type="button" class="btn" value=" Add to Query " onclick="qw_add(\''+data['name']+'\');"/> <input type="button" class="btn" value=" Quick Apply " onclick="func_query = new Array (\''+data['name']+'\'); qw_draw(); apply();"/>';
}
function func_cat_draw ()
{
	// Cats selector
	var out = '<select class="inp" size="10" style="width:150px" onclick="func_select_draw(this.options[this.selectedIndex].value);">';
	for (x=0; x<func_cat.length; x++)
	{
		out += '<option value="'+func_cat[x][0]+'">'+func_cat[x][1]+'</option>';
	}
	
	out += '</select>';
	my_getbyid('func_cat').innerHTML = out;
}

function func_select_draw (cat)
{
	var out = '';
	out = '<select class="inp" size="10" style="width:180px" onclick="draw_func_info(this.options[this.selectedIndex].value);" ondblclick="qw_add(this.options[this.selectedIndex].value);">';
	var sel_count = 0;
	for (x=0; x<func_list.length; x++)
	{
		if (func_list[x]['cat'] == cat)
		{
			out += '<option value="'+func_list[x]['name']+'">'+func_list[x]['title']+'</option>';
			sel_count++;
		}
	}
	if (sel_count == 0)
	{
		out += '<option style="font-style:italic">No functions ...</option>';
	}
	out += '</select>';

	my_getbyid('func_select').innerHTML = out;
}
function get_request (result) 
{
	res_wait_stop();
	qw_result = result;
	if (qw_result == '')
	{
		alert ('Empty string returned');
	}

	if (res_mode == 'div')
	{
		res_in_div ();
		return;
	}
	if (res_mode == 'div_html')
	{
		res_in_div_html ();
		return;
	}
	if (res_mode == 'text')
	{
		res_in_textarea ();
		return;
	}
	if (res_mode == 'text_code')
	{
		res_in_textarea_code ();
		return;
	}
}

function apply ()
{
	if (func_query.length == 0)
	{
		alert ('Function query is empty! Add something for izvrat');
		return;
	}
	my_getbyid('req_query').value = func_query.join(',');
	if (my_getbyid('result_as_file').checked)
	{
		my_getbyid('req_form').target = 'parent';
		my_getbyid('req_form').target = 'req_frame';
		my_getbyid('req_form').submit ();
	} else {
		my_getbyid('req_form').target = 'req_frame';
		my_getbyid('req_form').submit ();
		res_wait_start ();
	}
}

function copy_text ()
{
	var text = my_getbyid('input_text').value = qw_result;
}
function res_in_textarea_code ()
{
	res_mode = 'text_code';
	
	html_res = qw_result;
	// Quote tags for proper displaying in DIV layer
	html_res = html_res.replace(/&/g, '&amp;');
	html_res = html_res.replace(/</g, '&lt;');
	html_res = html_res.replace(/>/g, '&gt;');
	
	// Hilight
	html_res = html_res.replace(/\[\[hl-([a-z0-9#]+)\](.*)\]/gim, '<font color="$1">$2</font>');

	my_getbyid('result').innerHTML = '<center><textarea id="res_textarea" style="width:98%" rows="20" cols="40" class="result" wrap="off"></textarea></center>';
	
	my_getbyid('res_textarea').value = html_res;
}
function res_in_textarea ()
{
	res_mode = 'text';
	var text_res = qw_result;
	text_res = text_res.replace(/\[\[hl-([a-z0-9#]+)\](.*)\]/gim, '$2');
	my_getbyid('result').innerHTML = '<center><textarea id="res_textarea" style="width:98%" rows="20" cols="40" class="result" wrap="off"></textarea></center>';

	my_getbyid('res_textarea').value = text_res;
}
function res_in_div ()
{
	res_mode = 'div';
	
	html_res = qw_result;
	// Quote tags for proper displaying in DIV layer
	html_res = html_res.replace(/&/g, '&amp;');
	html_res = html_res.replace(/</g, '&lt;');
	html_res = html_res.replace(/>/g, '&gt;');
	
	// Hilight
	html_res = html_res.replace(/\[\[hl-([a-z0-9#]+)\](.*)\]/gim, '<font color="$1">$2</font>');

	if (html_res == '')
		html_res = '<center><b>Empty sting returned</b></center>';
	my_getbyid('result').innerHTML = '<pre class="result">'+html_res+'</pre>';
}
function res_in_div_html ()
{
	res_mode = 'div_html';
	
	html_res = qw_result;
	// Hilight
	html_res = html_res.replace(/\[\[hl-([a-z0-9#]+)\](.*)\]/gim, '<font color="$1">$2</font>');
	if (html_res == '')
		html_res = '<center><b>Empty sting returned</b></center>';
	my_getbyid('result').innerHTML = '<div class="result">'+html_res+'</div>';
}
function res_wait_start ()
{
	wait_c=0;
	clearInterval(wait_t);
	wait_t = setInterval ('wait_do()', 1000);
}
function res_wait_stop()
{
	clearInterval(wait_t);
	my_getbyid('res_wait').innerHTML = '';
}
function wait_do ()
{
	wait_c ++;
	my_getbyid('res_wait').innerHTML = '<center><font color="red">Please, wait ...</font> (Wait <b>'+wait_c+'</b> sec)</center>';
}

//-->
</script>
<iframe src="about:blank" width="1" height="1" style="width:1px; height:1px; overflow:hidden; border:none" id="req_frame" name="req_frame"></iframe>
<form enctype="multipart/form-data" action="{{$url}}/php_func/ajax/" target="req_frame" method="post" name="req_form" id="req_form">
<input type="hidden" name="req_query" id="req_query"/>
<table cellpadding="3" cellspacing="0" width="100%">
<tr>
	<td class="s1_title_p">String to process</td>
</tr>
<tr>
	<td class="s1_text" align="left">
		<textarea id="input_text" name="input_text" style="width:100%" rows="8" cols="40"></textarea>
		<b>OR</b> upload a file: <input type="file" name="req_file" id="req_file" /> [<a href="javascript:void(0);" onclick="my_getbyid('req_file').value='';">Clear File</a>] [<a href="javascript:void(0);" onclick="my_getbyid('input_text').value='';">Clear Text</a>]
		<p class="par"><b>Note:</b> Max input is 100 kb</p>
	</td>
</tr>
<tr>
	<td class="s1_title_p">Select Functions</td>
</tr>
<tr>
	<td class="s1_text" align="left">
		<table cellpadding="3" cellspacing="0" width="100%">
		<tr>
			<td valign="top" align="center" width="100">
				<table cellpadding="3" cellspacing="0" border="0">
				<tr><th>Category</th><th>Function</th></tr>
				<tr>
					<td align="center" valign="top"><div id="func_cat"></div></td>
					<td align="center" valign="top"><div id="func_select"></div></td>
				</tr>
				</table>
			</td>
			<td valign="top">
				<table cellpadding="3" cellspacing="0" border="0" width="100%">
				<tr><td id="descr_title" class="par" style="font-weight:bold;">Please, select the function!</td></tr>
				<tr><td id="descr_body" class="par">Function description will be showed here.<br/><b>Note:</b> You can quickly add function to the query by doble clicking in it in the functions list!</td></tr>
				<tr><td id="descr_link" class="s1_text"></td></tr>
				<tr><td id="descr_btn" class="s1_text"></td></tr>
				</table>
			</td>
		</tr>
		</table>	
	</td>
</tr>
<tr>
	<td class="s1_title_p">Selected Functions Query</td>
</tr>
<tr>
	<td class="s1_text" align="left"><div id="func_query">Query is empty</div></td>
</tr>
<tr>
<td align="left" style="padding: 5px;" valign="middle">
	
</td>
</tr>
<tr>
<td align="center">
	<label style="font-weight:bold;"><input type="checkbox" name="result_as_file" id="result_as_file" value="ON" /> Get result as file</label>
</td>
</tr>
<tr>
<td align="center">
	<input type="button" onclick="apply ();" class="btn" value=" Apply Selected Functions " />
</td>
</tr>
</table>
</form>

<table cellpadding="3" cellspacing="0" width="100%">
<tr>
	<td class="s1_title_p" >Result</td>
</tr>
<tr>
	<td class="s1_text" id="res_wait" align="center"></td>
</tr>
<tr>
	<td class="s1_text">[<a href="javascript:void(0);" onclick="copy_text();">Copy to Input Text</a>]<br/>
	[Result: <a href="javascript:void(0);" onclick="res_in_textarea();">TextArea</a> | <a href="javascript:void(0);" onclick="res_in_textarea_code();">TextArea (HTML code)</a> | <a href="javascript:void(0);" onclick="res_in_div();">Div</a> | <a href="javascript:void(0);" onclick="res_in_div_html();">Div (HTML)</a>]</td>
</tr>
<tr>
	<td class="s1_text" align="left" id="result"></td>
</tr>
<tr>
	<td class="s1_text">
	[Result: <a href="javascript:void(0);" onclick="res_in_textarea();">TextArea</a> | <a href="javascript:void(0);" onclick="res_in_textarea_code();">TextArea (HTML code)</a> | <a href="javascript:void(0);" onclick="res_in_div();">Div</a> | <a href="javascript:void(0);" onclick="res_in_div_html();">Div (HTML)</a>]<br/>
	[<a href="javascript:void(0);" onclick="copy_text();">Copy to Input Text</a>]</td>
</tr>
</table>
<script type="text/javascript">
//<!--
func_cat_draw ();
func_select_draw (0);
res_in_div ();
//-->
</script>