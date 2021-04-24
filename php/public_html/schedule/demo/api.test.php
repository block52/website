<?php
# +------------------------------------------------------------------------+
# | Artlantis CMS Solutions                                                |
# +------------------------------------------------------------------------+
# | Caledonian PHP Event Calendar                                          |
# | Copyright (c) Artlantis Design Studio 2014. All rights reserved.       |
# | File Version  2.0                                                      |
# | Last modified 14.07.15                                                 |
# | Email         developer@artlantis.net                                  |
# | Developer     http://www.artlantis.net                                 |
# +------------------------------------------------------------------------+
require_once('lib/functions.php');
$pos = ((!isset($_GET['pos']) || empty($_GET['pos'])) ? 'list':$_GET['pos']);

# Call API
class callApi{
	
	public $url = '';
	public $end_point = '';
	public $mccp_result = false;
	public $api_key = '';
	public $fields = null;
	
	public function getData(){
			
		$post_data = ((!is_array($this->fields)) ? array():$this->fields);
		$post_data['apiKey'] = $this->api_key;
		foreach($post_data as $key=>$value) { $fields_string .= $sep.$key.'='.urlencode($value); $sep='&'; }
		//$preJSON = json_encode($post_data);
		
		$options = array(
			CURLOPT_URL => $this->url.$this->end_point,
			//CURLOPT_RETURNTRANSFER => true,     // return web page
			CURLOPT_HEADER         => false,    // don't return headers
			//CURLOPT_FOLLOWLOCATION => true,     // follow redirects
			CURLOPT_ENCODING       => "",       // handle all encodings
			CURLOPT_USERAGENT      => "Caledonian", // who am i
			//CURLOPT_AUTOREFERER    => true,     // set referer on redirect
			CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
			CURLOPT_TIMEOUT        => 120,      // timeout on response
			CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
			CURLOPT_POST           => true,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_POSTFIELDS     => $fields_string,
			CURLOPT_FRESH_CONNECT  => 1,
			CURLOPT_HTTPHEADER     => array(
											'Cache-Control: no-cache',
											'Content-length: '.strlen($fields_string)
                                            )
		);
		$ch      = curl_init();
		curl_setopt_array( $ch, $options );
		$content = curl_exec( $ch );
		$err     = curl_errno( $ch );
		$errmsg  = curl_error( $ch );
		$header  = curl_getinfo( $ch );
		curl_close( $ch );

		$header['errno']   = $err;
		$header['errmsg']  = $errmsg;
		$header['content'] = $content;
		
		return $header;
		
	}
	
}



# Testing For Lister
if($pos=='list'){
	
	# Define Variables	
	//$_POST['oneday'] = '2015-07-15';
	$_POST['from'] = '2015-07-10';
	$_POST['to'] = '2015-07-11';
	$_POST['offset'] = 0;
	$_POST['count'] = 1;
	//$_POST['user'] = '083535632f263bc92ff8044e6aad58c7';
	
	# Call Hook
	$hook = new callApi();
	$hook->url = 'https://localhost/api/v1';
	$hook->end_point = '/lists/';
	$hook->api_key = '301c4bece849e2176e9ce55ff02759a6';
	$hook->fields = $_POST;
	$data = $hook->getData();
	$data = json_decode($data['content'],true);
	print_r($data['content']);
	
}

# Testing For Add
if($pos=='add'){
	
	# Define Variables	
	$_POST['title'] = 'Test From API'; # Event Title
	$_POST['event'] = 'Test From API Details';  # Event Detail
	$_POST['event_date'] = '2015-07-11';  # Event Date
	$_POST['user'] = '083535632f263bc92ff8044e6aad58c7'; # User Public Key
	$_POST['ip'] = $_SERVER['REMOTE_ADDR']; # IP Address
	$_POST['icon'] = 'fa fa-users'; # Optional
	$_POST['color'] = 'magenta'; # Optional
	
	# Call Hook
	$hook = new callApi();
	$hook->url = 'https://localhost/api/v1';
	$hook->end_point = '/add/';
	$hook->api_key = '301c4bece849e2176e9ce55ff02759a6';
	$hook->fields = $_POST;
	$data = $hook->getData();
	$data = json_decode($data['content'],true);
	print_r($data['content']);
	
}

# Testing For Delete
if($pos=='delete'){
	
	# Define Variables	
	$_POST['id'] = 3; # Event ID
	$_POST['user'] = '083535632f263bc92ff8044e6aad58c7'; # User Public Key
	
	# Call Hook
	$hook = new callApi();
	$hook->url = 'https://localhost/api/v1';
	$hook->end_point = '/delete/';
	$hook->api_key = '301c4bece849e2176e9ce55ff02759a6';
	$hook->fields = $_POST;
	$data = $hook->getData();
	$data = json_decode($data['content'],true);
	print_r($data['content']);
	
}
?>