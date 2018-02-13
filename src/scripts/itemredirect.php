<?php

// TF2 item redirect by WindPower

$config = array(
	'api_key' => getenv('STEAM_API_KEY'),
	'cache_duration' => 900,
	'wiki_default' => getenv('SERVER_URL') . '/wiki/%ARTICLE%', // Default article URL format
	'wiki_lang' => getenv('SERVER_URL') . '/wiki/%ARTICLE%',    // Localised article URL format
	'article_format' => '%ARTICLE%/%LANGUAGE%', 				// Format of article name in another language
	'default_language' => 'en', 							    // Default language of articles
	'wiki_api' => 'http://localhost/w/api.php', 				// URL to MediaWiki API
	'memcached_host' => getenv('MEMCACHED_HOST'),
	'memcached_port' => '11211'
);

define( 'NAMEMAP_CACHE_KEY', 'wikiredirect_namemap2' );

$item_filters = array(      // Filters applied to item names, in the form '/regex/' => 'replacement'
	'/^The\\s+/i' => '',    // Remove "the"
	'/[#<>[\]|{}]+/' => '', // Strip characters not allowed in Wiki page titles
	'/^\\s+|\\s+$/' => ''   // Trim item name
);
$language_mapping = array(
	'en_US' => 'en',
	'de_DE' => 'de',
	'fr_FR' => 'fr',
	'it_IT' => 'it',
	'ko_KR' => 'ko',
	'es_ES' => 'es',
	'zh_CN' => 'zh-hans',
	'zh_TW' => 'zh-hant',
	'ru_RU' => 'ru',
	'th_TH' => 'th',
	'ja_JP' => 'ja',
	'pt_PT' => 'pt',
	'pl_PL' => 'pl',
	'da_DK' => 'da',
	'nl_NL' => 'nl',
	'fi_FI' => 'fi',
	'no_NO' => 'no',
	'sv_SE' => 'sv',
	'hu_HU' => 'hu',
	'cs_CZ' => 'cs',
	'ro_RO' => 'ro',
	'tr_TR' => 'tr',
	'pt_BR' => 'pt-br',
	'bg_BG' => 'bg'
);
function error($error)
{
	die('Error: <strong>' . htmlentities($error) . '</strong>.');
}
function url_param($param)
{
	// Replace spaces with underscores
	// Ignore newlines
	return rawurlencode(str_replace("\n", '', str_replace(' ', '_', trim($param))));
}
function language_map($lang) {
	global $language_mapping;
	if(in_array($lang, array_keys($language_mapping))) {
		$lang = $language_mapping[$lang];
	}
	return $lang;
}
function build_article($page, $lang=null)
{
	global $config;
	if($lang == null || $lang == $config['default_language']) {
		return url_param($page);
	}
	return str_replace('%ARTICLE%', url_param($page), str_replace('%LANGUAGE%', url_param($lang), $config['article_format']));
}
function build_url($page, $lang=null)
{
	global $config;
	if($lang == null) {
		return str_replace('%ARTICLE%', build_article($page, $lang), $config['wiki_default']);
	}
	return str_replace('%ARTICLE%', build_article($page, $lang), str_replace('%LANGUAGE%', url_param($lang), $config['wiki_lang']));
}
function apply_item_filters($name)
{
	global $item_filters;
	foreach($item_filters as $regex => $replacement) {
		$name = preg_replace($regex, $replacement, $name);
	}
	return $name;
}
function get_item_list($json)
{
	if(!isset($json['result'])) return false;
	if(!isset($json['result']['items'])) return false;
	$jsonitems = $json['result']['items'];
	if(!is_array($jsonitems)) return false;
	$items = array();
	$numitems = count($jsonitems);
	for($i = 0; $i < $numitems; $i++) {
		if(isset($jsonitems[$i]['defindex']) and isset($jsonitems[$i]['item_name'])) {
			$items[$jsonitems[$i]['defindex']] = trim($jsonitems[$i]['item_name']);
		}
	}
	return $items;
}
function curl_fetch( $url )
{
	global $config;
	$hcurl = curl_init( $url );
	curl_setopt( $hcurl, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt( $hcurl, CURLOPT_TIMEOUT, 5 );
	curl_setopt( $hcurl, CURLOPT_CONNECTTIMEOUT, 5 );
	if ( !empty( $config['http_proxy_addr'] ) && !empty( $config['http_proxy_port'] ) )
	{
		curl_setopt( $hcurl, CURLOPT_PROXY, $config['http_proxy_addr'].':'.$config['http_proxy_port'] );
	}
	$data = curl_exec( $hcurl );
	curl_close( $hcurl );
	return $data;
}
function is_valid_page($page, $lang=null)
{
	global $config;
	$apidata=@json_decode(curl_fetch($config['wiki_api'].'?action=query&titles='.build_article($page,$lang).'&format=json'),true);
	if(!$apidata) return false;
	if(!isset($apidata['query'])) return false;
	if(!isset($apidata['query']['pages'])) return false;
	return !in_array('-1', array_keys($apidata['query']['pages']));
}
function get_memcache()
{
	static $memcache;
	if ( !isset( $memcache ) )
	{
		global $config;
		$memcache = new Memcached;
		$memcache->addServer( $config['memcached_host'], $config['memcached_port'] );
	}
	return $memcache;
}
function load_cache()
{
	global $config;
	$memcache = get_memcache();
	$cache = $memcache->get( NAMEMAP_CACHE_KEY );
	if( empty( $cache ) ) return false;
	return $cache;
}
function write_cache($cache)
{
	global $config;
	$memcache = get_memcache();
	$memcache->set( NAMEMAP_CACHE_KEY, $cache, $config['cache_duration'] );
}
function load_data()
{
	global $config;
	$cache=load_cache();
	if($cache && !array_key_exists('rj_busta_cache', $_GET))
	{
		return $cache;
	}
	// Otherwise, gotta refresh the cache
	$data = curl_fetch( 'https://api.steampowered.com/IEconItems_440/GetSchema/v0001/?key='.rawurlencode($config['api_key']).'&language=english&format=json' );
	$json = @json_decode( $data, true );
	if(!$json) {
		error('Received invalid data from Steam API');
	}
	$items = get_item_list($json);
	if(!$items) {
		error('Received invalid item list from Steam API');
	}
	$cache = array(
		'items' => $items
	);
	write_cache($cache);
	return $cache;
}
function redirect($url)
{
	header('Location: ' . $url);
	die();
}
function redirect_to_page($page, $lang=null)
{
	if($lang != null) {
		if(is_valid_page($page, $lang)) {
			redirect(build_url($page, $lang));
		}
	}
	redirect(build_url($page));
}
if(!isset($_GET['id'])) {
	http_response_code(400);
	error('Missing ID parameter');
}
$language = isset($_GET['lang']) ? language_map($_GET['lang']) : null;
if(!intval($_GET['id'])) {
	http_response_code(400);
	error('Malformed ID');
}
$cached_data = load_data();
$items = $cached_data['items'];
if(!isset($items[$_GET['id']])) {
	http_response_code(404);
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Sun, 25 Mar 2012 13:00:00 GMT"); // Date in the past
	error('Invalid item ID: '.$_GET['id']);
}
redirect_to_page(apply_item_filters($items[$_GET['id']]), $language);
?>
