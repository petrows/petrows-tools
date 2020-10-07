<table cellpadding="3" cellspacing="0">
<tr>
	<td class="s1_title" align="right" width="150" nowrap="nowrap">IP Address :</td><td class="s1_text" align="left">{{$server.REMOTE_ADDR}} (<a href="http://www.nic.ru/whois/?query={{$server.REMOTE_ADDR}}" target="_blank">Lookup</a>)</td>
</tr>
<tr>
	<td class="s1_title" align="right" width="150" nowrap="nowrap">IP Address (long) :</td><td class="s1_text" align="left">{{$ip_long}}</td>
</tr>
<tr>
	<td class="s1_title_p" align="left" colspan="2">HTTP Headers :</td>
</tr>

{{foreach from=$heads key=key item=item}}
<tr>
	<td class="s1_title" align="right" width="150" nowrap="nowrap">{{$key}} :</td><td class="s1_text" align="left">{{$item}}</td>
</tr>
{{/foreach}}

</table>