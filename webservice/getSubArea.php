<?php
	
	$subAreaHtml = "";
	
	$access_key = "YVl3K7RYkd6jhTY";
	$secret_key = "OA5SfoARzEyMcLXhoYVu2NTgLXK5NU";
	
	// Base url local
	//$service_url = "http://localhost/dwigtpl/webservices/services/getCraigslistSubArea"; //getCraigslistArea
	
	// Base url LIVE
	$service_url = "https://api.systempostings.com/services/getCraigslistSubArea";

	// Add API params
	$parameters['key'] = $access_key;
	$parameters['timeStamp'] = gmdate("Y-m-d\TH:i:s\Z");
	
	// Add custom params
	$parameters['areaId']= $_REQUEST['areaId'];
	
	ksort($parameters);
	
	// Encode params and values
	foreach($parameters as $parameter => $value){
		$parameter = str_replace("%7E", "~", rawurlencode($parameter));
		$value = str_replace("%7E", "~", rawurlencode($value));
		$request_array[] = $parameter . '=' . $value;
	}
	
	$signature_string = implode('&', $request_array);
	//echo $signature_string."\n";
	// Make it happen
	$parameters['signature'] = urlencode(base64_encode(hash_hmac('sha256', $signature_string, $secret_key, true)));
	
	$curl_handle = curl_init();
	curl_setopt($curl_handle, CURLOPT_URL, $service_url);
	curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
	curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $parameters); 

	$buffer = curl_exec($curl_handle);
	curl_close($curl_handle);
  
	if (empty($buffer)){
		print_r(($buffer) );
	} else {
		print_r(($buffer) );
	}
	
	
?>