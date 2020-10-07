<script type="text/javascript">
//<!--
var month=new Array(12);
month[0]="January";
month[1]="February";
month[2]="March";
month[3]="April";
month[4]="May";
month[5]="June";
month[6]="July";
month[7]="August";
month[8]="September";
month[9]="October";
month[10]="November";
month[11]="December";

function set_current ()
{
	var d = new Date();
	my_getbyid ('curr_time').innerHTML = d.toLocaleString() + my_offset();
	my_getbyid ('curr_times').innerHTML = get_timestamp();
}
function get_timestamp (d)
{
	if (!d)
		d = new Date();
	d.setMilliseconds(0);
	var out = d.getTime()/1000;
	out = out.toFixed(0);
	return out;
}
function my_offset ()
{
	var d = new Date();
	var gmtHours = -d.getTimezoneOffset()/60;
	if (gmtHours>=0)
		return ' [GMT +' + gmtHours + ']';
	else
		return ' [GMT ' + gmtHours + ']';
}
function mktime_controls ()
{
	var d = new Date();
	var out = '';
	
	// Date
	out += '<select id="mk_day" onchange="mktime_do();">'
	for (x=1; x<32; x++)
	{
		out += '<option value="' + x + '"';
		if (x == d.getDate()) out += ' selected="selected"';
		out += '>' + x + '</option>';
	}
	out += '</select>';
	out += ' / ';	
	// Month
	out += '<select id="mk_month" onchange="mktime_do();">'
	for (x=0; x<12; x++)
	{
		out += '<option value="' + x + '"';
		if (x == d.getMonth()) out += ' selected="selected"';
		out += '>' + month[x] + '</option>';
	}
	out += '</select>';
	out += ' / ';
	// Year
	out += '<select id="mk_year" onchange="mktime_do();">'
	for (x=1970; x<2055; x++)
	{
		out += '<option value="' + x + '"';
		if (x == d.getFullYear()) out += ' selected="selected"';
		out += '>' + x + '</option>';
	}
	out += '</select>';
	my_getbyid ('mktime_controls_date').innerHTML = out;
	
	// ==== time
	out = '';
	// Hour
	out += '<select id="mk_hour" onchange="mktime_do();">'
	for (x=0; x<24; x++)
	{
		out += '<option value="' + x + '"';
		if (x == d.getHours()) out += ' selected="selected"';
		out += '>' + lead_zeros(x) + '</option>';
	}
	out += '</select>';
	out += ' : ';	
	// Minutes
	out += '<select id="mk_min" onchange="mktime_do();">'
	for (x=0; x<60; x++)
	{
		out += '<option value="' + x + '"';
		if (x == d.getMinutes()) out += ' selected="selected"';
		out += '>' + lead_zeros(x) + '</option>';
	}
	out += '</select>';
	out += ' : ';
	// Seconds
	out += '<select id="mk_sec" onchange="mktime_do();">'
	for (x=0; x<60; x++)
	{
		out += '<option value="' + x + '"';
		if (x == d.getSeconds()) out += ' selected="selected"';
		out += '>' + lead_zeros(x) + '</option>';
	}
	out += '</select>';
	my_getbyid ('mktime_controls_time').innerHTML = out;
}
function lead_zeros (val)
{
	if (val<10) return '0'+val;
	return val;
}
function mktime_do ()
{
	var d = new Date ();
	d.setFullYear(parseInt(my_getbyid('mk_year').value));
	d.setDate(parseInt(my_getbyid('mk_day').value));
	d.setMonth(parseInt(my_getbyid('mk_month').value));

	// alert (parseInt(my_getbyid('mk_month').value));
	
	d.setSeconds(parseInt(my_getbyid('mk_sec').value));
	d.setMinutes(parseInt(my_getbyid('mk_min').value));
	d.setHours(parseInt(my_getbyid('mk_hour').value));	
	d.setMilliseconds(0);
	my_getbyid ('mktime_timestamp').innerHTML = get_timestamp(d);
	my_getbyid ('mktime_timestamp_date').innerHTML = d.toLocaleString() + my_offset();
}
function parse_do ()
{
	var d = new Date ();
	d.setTime(parseInt(my_getbyid('p_timestamp').value)*1000);
	my_getbyid ('p_date').innerHTML = d.toLocaleString() + my_offset();
}
//-->
</script>
<p class="par"><span style="color:red;font-weight:bold;">Achtung!</span> Remember, that dates are shown with your locale settings <b><script type="text/javascript">document.write(my_offset());</script></b>!
<br/>
UNIX-timestamps, whitch are generated here, is absolute, and does not contains any time-offset.<br/>
<b>Info about it:</b> 
<a href="http://en.wikipedia.org/wiki/Unix_time" target="_blank">Wikipedia (EN)</a>, 
<a href="http://ru.wikipedia.org/wiki/%D0%92%D1%80%D0%B5%D0%BC%D1%8F_%28UNIX%29" target="_blank">Wikipedia (RU)</a> .
</p>
<table cellpadding="3" cellspacing="0" width="500">
<tr>
	<td class="s1_title_p" colspan="2">Current</td>
</tr>
<tr>
	<td class="s1_title" align="right" width="150" nowrap="nowrap">Current time :</td>
	<td class="s1_text" align="left"><div id="curr_time"></div></td>
</tr>
<tr>
	<td class="s1_title" align="right" width="150" nowrap="nowrap">Current timestamp :</td>
	<td class="s1_text" align="left"><div id="curr_times"></div></td>
</tr>
<tr>
<td align="center" colspan="2" style="padding: 5px;">
	<input type="button" onclick="set_current();" class="btn" value=" Update Time " />
</td>
</tr>
</table>

<table cellpadding="3" cellspacing="0" width="500">
<tr>
	<td class="s1_title_p" colspan="2">Make timestamp</td>
</tr>
<tr>
	<td class="s1_title" align="right" width="150" nowrap="nowrap">Timestamp :</td>
	<td class="s1_text" align="left"><div id="mktime_timestamp" style="font-weight:bold;"></div></td>
</tr>
<tr>
	<td class="s1_title" align="right" width="150" nowrap="nowrap">Timestamp Date :</td>
	<td class="s1_text" align="left"><div id="mktime_timestamp_date"></div></td>
</tr>
<tr>
	<td class="s1_title" align="right" width="150" nowrap="nowrap">Date :</td>
	<td class="s1_text" align="left"><div id="mktime_controls_date"></div></td>
</tr>
<tr>
	<td class="s1_title" align="right" width="150" nowrap="nowrap">Time :</td>
	<td class="s1_text" align="left"><div id="mktime_controls_time"></div></td>
</tr>
<tr>
<td align="center" colspan="2" style="padding: 5px;">
	<input type="button" onclick="mktime_do();" class="btn" value=" Create TimeStamp " />
</td>
</tr>
</table>

<table cellpadding="3" cellspacing="0" width="500">
<tr>
	<td class="s1_title_p" colspan="2">Parse timestamp</td>
</tr>
<tr>
	<td class="s1_title" align="right" width="150" nowrap="nowrap">Timestamp Date :</td>
	<td class="s1_text" align="left"><div id="p_date">Give me timestamp, please!</div></td>
</tr>
<tr>
	<td class="s1_title" align="right" width="150" nowrap="nowrap">Timestamp :</td>
	<td class="s1_text" align="left"><input id="p_timestamp" type="text" class="inp" value="0" onkeyup="parse_do();"/></td>
</tr>
<tr>
<td align="center" colspan="2" style="padding: 5px;">
	<input type="button" onclick="parse_do();" class="btn" value=" Parse TimeStamp " />
</td>
</tr>
</table>

<script type="text/javascript">
//<!--
// Set current on load
set_current ();
mktime_controls ();
mktime_do ();
parse_do();
//-->
</script>