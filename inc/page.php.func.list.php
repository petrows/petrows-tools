<?php
$f_cat = array ();
$f_list = array ();
$cat = -1;

#############################################################################################
# GENERIC functions
$cat++;
$f_cat[] = 'Text / HTML';
$f_list[] = array (
	'cat'	=> $cat,
	'name'	=> 'remove_nl',
	'callc'	=> 10,
	'title'	=> 'NL -> [null]',
	'descr'	=> 'This function removes all <code>\\\n</code> and <code>\\\r</code> symbols from the entrie string.'
);
$f_list[] = array (
	'cat'	=> $cat,
	'name'	=> 'remove_nl_space',
	'callc'	=> 10,
	'title'	=> 'NL -> [space]',
	'descr'	=> 'This function replaces all <code>\\\n</code> and <code>\\\r</code> symbols to space in the entrie string.'
);
$f_list[] = array (
	'cat'	=> $cat,
	'name'	=> 'remove_nl_codes',
	'callc'	=> 10,
	'title'	=> 'NL -> \\\n',
	'descr'	=> 'This function replaces all <code>\\\n</code> and <code>\\\r</code> symbols to their quoted-representation in the entrie string.'
);
$f_list[] = array (
	'cat'	=> $cat,
	'name'	=> 'nl2br',
	'callc'	=> 10,
	'title'	=> 'NL -> &lt;br/&gt;',
	'descr'	=> 'This function replaces all <code>\\\n</code> symbols to HTML <code>&lt;br/&gt;</code> codes. <code>\\\r</code> will be removed.'
);
$f_list[] = array (
	'cat'	=> $cat,
	'name'	=> 'nl2br_add',
	'callc'	=> 10,
	'title'	=> 'NL -> &lt;br/&gt;\\\n',
	'descr'	=> 'This function add HTML <code>&lt;br/&gt;</code> codes after all <code>\\\n</code>. <code>\\\r</code> will be removed.'
);
$f_list[] = array (
	'cat'	=> $cat,
	'name'	=> 'remove_br_simple',
	'callc'	=> 10,
	'title'	=> 'Remove &lt;br/&gt;',
	'descr'	=> 'This function removes all HTML <code>&lt;br/&gt;</code> tags from the entrie string.'
);
$f_list[] = array (
	'cat'	=> $cat,
	'name'	=> 'remove_br_adv',
	'callc'	=> 10,
	'title'	=> 'Remove &lt;br/&gt; (ADV)',
	'descr'	=> 'This function removes all HTML <code>&lt;br/&gt;</code> tags from the entrie string, but preservs \\\n after tag, or add it, if not presents.'
);
$f_list[] = array (
	'cat'	=> $cat,
	'name'	=> 'remove_tags',
	'callc'	=> 10,
	'title'	=> 'Remove HTML',
	'descr'	=> 'This function removes all HTML tags from the entrie string.'
);
$f_list[] = array (
	'cat'	=> $cat,
	'name'	=> 'html_entity_decode',
	'callc'	=> 10,
	'title'	=> 'HTML Ent -> Symbols',
	'descr'	=> 'This function replaces HTML-entites to their real UTF-8 symbols. Example:<span class="ex">&amp;copy; -> &copy;<br/>&amp;euro; -> &euro;</span>'
);
$f_list[] = array (
	'cat'	=> $cat,
	'name'	=> 'str_auto_html',
	'callc'	=> 1,
	'title'	=> 'HTML Auto',
	'descr'	=> 'This function creates valid HTML from the plain text. Creates paragraphs, adds correct newlines, <code>&lt;p&gt;</code> tags, etc.'
);

#############################################################################################
# HILIGHT functions
$cat++;
$f_cat[] = 'Highlight';

# Include HILIGHT functions
include (ROOT_PATH.'/inc/page.php.func.list.hl.php');

#############################################################################################
# CODE/ENCODE functions
$cat++;
$f_cat[] = 'Encode/Decode';
$f_list[] = array (
	'cat'	=> $cat,
	'name'	=> 'base64_encode',
	'callc'	=> 10,
	'title'	=> 'Base 64: Encode',
	'descr'	=> 'Standart PHP function <code>base64_encode()</code><br/>Convertion example:<span class="ex">Say Hello!</span>will be converted to:<span class="ex">U2F5IEhlbGxvIQ==</span>',
	'link'	=> 'http://www.php.net/manual/ru/function.base64-encode.php'
);
$f_list[] = array (
	'cat'	=> $cat,
	'name'	=> 'base64_decode',
	'callc'	=> 10,
	'title'	=> 'Base 64: Decode',
	'descr'	=> 'Standart PHP function <code>base64_decode()</code><br/>Convertion example:<span class="ex">U2F5IEhlbGxvIQ==</span>will be converted to:<span class="ex">Say Hello!</span><b>Note:</b> this function may return raw binary data, so using of functions from <b>Output</b> after it is recomended.',
	'link'	=> 'http://www.php.net/manual/ru/function.base64-decode.php'
);
$f_list[] = array (
	'cat'	=> $cat,
	'name'	=> 'convert_uuencode',
	'callc'	=> 10,
	'title'	=> 'UU: Encode',
	'descr'	=> 'Standart PHP function <code>convert_uuencode()</code> - Converts string to uuencode format.',
	'link'	=> 'http://www.php.net/manual/ru/function.convert-uuencode.php'
);
$f_list[] = array (
	'cat'	=> $cat,
	'name'	=> 'convert_uudecode',
	'callc'	=> 10,
	'title'	=> 'UU: Decode',
	'descr'	=> 'Standart PHP function <code>convert_uudecode()</code> - Converts string from uuencode format.',
	'link'	=> 'http://www.php.net/manual/ru/function.convert-uudecode.php'
);
$f_list[] = array (
	'cat'	=> $cat,
	'name'	=> 'js_escape',
	'callc'	=> 10,
	'title'	=> 'JS escape ()',
	'descr'	=> 'Javascript function <code>escape()</code> - Converts any data to safe string.',
	'link'	=> 'http://www.w3schools.com/jsref/jsref_escape.asp'
);
$f_list[] = array (
	'cat'	=> $cat,
	'name'	=> 'js_unescape',
	'callc'	=> 10,
	'title'	=> 'JS unescape ()',
	'descr'	=> 'Javascript function <code>unescape()</code> - Converts encoded string to data.<br/>Convertion example:<span class="ex">%u0053%u0061%u0079%u0020%u0048%u0065%u006c%u006c%u006f%u0021</span>will be converted to:<span class="ex">Say Hello!</span><b>Note:</b> this function may return raw binary data, so using of functions from <b>Output</b> after it is recomended.',
	'link'	=> 'http://www.w3schools.com/jsref/jsref_unescape.asp'
);
$f_list[] = array (
	'cat'	=> $cat,
	'name'	=> 'js_escape_bin',
	'callc'	=> 10,
	'title'	=> 'JS escape () (BIN)',
	'descr'	=> 'Javascript function <code>escape()</code> - Converts any data to safe string. Binary variant - does not convert strings encoding.',
	'link'	=> 'http://www.w3schools.com/jsref/jsref_escape.asp'
);
$f_list[] = array (
	'cat'	=> $cat,
	'name'	=> 'js_unescape_bin',
	'callc'	=> 10,
	'title'	=> 'JS unescape () (BIN)',
	'descr'	=> 'Javascript function <code>unescape()</code> - Converts encoded string to data. Binary version - does not convert string encoding.',
	'link'	=> 'http://www.w3schools.com/jsref/jsref_unescape.asp'
);
$f_list[] = array (
	'cat'	=> $cat,
	'name'	=> 'url_encode',
	'callc'	=> 10,
	'title'	=> 'URL encode ()',
	'descr'	=> 'Standart PHP function <code>rawurlencode()</code> - Converts string to URL format.',
	'link'	=> 'http://ru2.php.net/manual/ru/function.rawurlencode.php'
);
$f_list[] = array (
	'cat'	=> $cat,
	'name'	=> 'url_decode',
	'callc'	=> 10,
	'title'	=> 'URL decode ()',
	'descr'	=> 'Standart PHP function <code>rawurlencode()</code> - Converts string from URL format.',
	'link'	=> 'http://ru2.php.net/manual/ru/function.rawurldecode.php'
);

#############################################################################################
# HASHES String functions
$cat++;
$f_cat[] = 'Hashes';
$f_list[] = array (
	'cat'	=> $cat,
	'name'	=> 'md5',
	'title'	=> 'MD5',
	'descr'	=> 'Function <code>md5()</code> - md5 one-side hashing by "<b>The MD5 Message-Digest Algorithm</b>".',
	'link'	=> 'http://www.faqs.org/rfcs/rfc1321'
);
$f_list[] = array (
	'cat'	=> $cat,
	'name'	=> 'sha1',
	'title'	=> 'SHA 1',
	'descr'	=> 'Function <code>sha1()</code> - SHA 1 one-side hashing by "<b>US Secure Hash Algorithm 1</b>".',
	'link'	=> 'http://www.faqs.org/rfcs/rfc3174'
);
$f_list[] = array (
	'cat'	=> $cat,
	'name'	=> 'crc32',
	'title'	=> 'CRC 32',
	'descr'	=> 'Calculates the <code>crc32</code> polynomial of a string (uses as a <code>checksum</code>).',
	'link'	=> 'http://www.php.net/manual/ru/function.crc32.php'
);

#############################################################################################
# IN transform
$cat++;
$f_cat[] = '&rarr; Input';
$f_list[] = array (
	'cat'	=> $cat,
	'name'	=> 'tr_in_hex',
	'callc'	=> 1,
	'title'	=> 'HEX (FF)',
	'descr'	=> 'Converts HEX input like <span class="ex">56FFA345A</span> to binary data. (Like <code>pack("H")</code>)<br/><br/><b>Note:</b> Function reads by-byte (eq. it gets 2 hex numbers like: FF AC 4E etc), and if entrie string length is not %2, 0 (zero) will be added to the begining of the string:<span class="ex">F145A -> 0F145A</span>'
);
$f_list[] = array (
	'cat'	=> $cat,
	'name'	=> 'tr_in_chex_c',
	'callc'	=> 1,
	'title'	=> 'HEX (0xFF, comma)',
	'descr'	=> 'Converts HEX C-Style input string like this:<span class="ex">\\\0x64, \\\0x45, \\\0xFF, \\\0xAD</span> or this: <span class="ex">0x64, 0x45, 0xFF, 0xAD</span>and other formats to binary data.<br/><br/><b>Note:</b> HEX codes is searched by REGEXP like this: <code>/0x[a-f0-9]{2}/i</code>, and string may be very different from the example (A lot of various formats supported).'
);
$f_list[] = array (
	'cat'	=> $cat,
	'name'	=> 'tr_in_chex_s',
	'callc'	=> 1,
	'title'	=> 'HEX (\\\xFF, comma)',
	'descr'	=> 'Converts HEX C-Style input string like this:<span class="ex">\\\x64, \\\x45, \\\xFF, \\\0xAD</span> or this: <span class="ex">\\\x64, \\\x45, \\\xFF, \\\xAD</span>and other formats to binary data.<br/><br/><b>Note:</b> HEX codes is searched by REGEXP like this: <code>/x[a-f0-9]{2}/i</code>, and string may be very different from the example (A lot of various formats supported).'
);
$f_list[] = array (
	'cat'	=> $cat,
	'name'	=> 'tr_in_hex_c',
	'callc'	=> 1,
	'title'	=> 'HEX (FF, comma)',
	'descr'	=> 'Converts HEX input string like this:<span class="ex">64, 45, FF, AD</span> to binary data.<br/><br/><b>Note:</b> Separator-comma is important!'
);
$f_list[] = array (
	'cat'	=> $cat,
	'name'	=> 'tr_in_char_c',
	'callc'	=> 1,
	'title'	=> 'CHAR (055, comma)',
	'descr'	=> 'Converts CHAR C-Style input string like this:<span class="ex">064, 045, 099, 110</span> and other formats to binary data.<br/><br/><b>Note:</b> CHAR codes is searched by REGEXP like this: <code>/[a-f0-9]+/i</code>, and string may be very different from the example (A lot of various formats supported).'
);
#############################################################################################
# OUT transform
$cat++;
$f_cat[] = '&larr; Output';
$f_list[] = array (
	'cat'	=> $cat,
	'name'	=> 'tr_out_hex_c',
	'callc'	=> 1,
	'title'	=> 'HEX (FF, comma)',
	'descr'	=> 'Output will be shown as HEX values like this: <span class="ex">48, 49, 54, 4C, 45, 52, 20, 69, 73, 20,<br/>73, 6F, 20, 63, 6F, 6F, 6C, 2E, 2E, 2E,<br/>...</span>'
);
$f_list[] = array (
	'cat'	=> $cat,
	'name'	=> 'tr_out_chex_c',
	'callc'	=> 1,
	'title'	=> 'HEX (0xFF, comma)',
	'descr'	=> 'Output will be shown as HEX values like this: <span class="ex">0x48, 0x49, 0x54, 0x4C, 0x45, 0x52, 0x20, 0x69, 0x73, 0x20,<br/>0x73, 0x6F, 0x20, 0x63, 0x6F, 0x6F, 0x6C, 0x2E, 0x2E, 0x2E<br/>...</span>'
);
$f_list[] = array (
	'cat'	=> $cat,
	'name'	=> 'tr_out_chex_c2',
	'callc'	=> 1,
	'title'	=> 'HEX (\\\0xFF, comma)',
	'descr'	=> 'Output will be shown as HEX values like this: <span class="ex">\\\0x48, \\\0x49, \\\0x54, \\\0x4C, \\\0x45, \\\0x52, \\\0x20, \\\0x69, \\\0x73, \\\0x20,<br/>\\\0x73, \\\0x6F, \\\0x20, \\\0x63, \\\0x6F, \\\0x6F, \\\0x6C, \\\0x2E, \\\0x2E, \\\0x2E<br/>...</span>'
);
$f_list[] = array (
	'cat'	=> $cat,
	'name'	=> 'tr_out_char_c',
	'callc'	=> 1,
	'title'	=> 'CHAR (055, comma)',
	'descr'	=> 'Output will be shown as CHAR values like this: <span class="ex">072, 073, 084, 076, 069, 082, 032, 105, 115, 032,<br/> 115, 111, 032, 099, 111, 111, 108, 046, 046, 046,<br/>...</span>'
);
$f_list[] = array (
	'cat'	=> $cat,
	'name'	=> 'tr_out_char_carray',
	'callc'	=> 1,
	'title'	=> 'CHAR (055, C-Array)',
	'descr'	=> 'Output will be shown as CHAR values like this: <span class="ex">072, 073, 084, 076, 069, 082, 032, 105, 115, 032,<br/> 115, 111, 032, 099, 111, 111, 108, 046, 046, 046,<br/>...</span>'
);

?>