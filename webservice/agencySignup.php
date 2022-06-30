<?php

	// Check fields are coming
	if( !isset($_POST['fields']) || empty($_POST['fields']['dealerId']) ){
		print_r(json_encode(array("status"=>'error', "msg"=>'Something went wrong while submitting form. Please contact customer support.')));
		exit;
	}
	$data = $_POST['fields'];

	ini_set('display_errors', 1);
	define('LIBROOT', dirname(dirname(dirname(__FILE__))));

	require(LIBROOT . '/dealer_onboarding_form/postmail/autoload.php');

	//postmark API
	use Postmark\PostmarkClient;
	$pmClient = new PostmarkClient("64a5286e-6e7d-4c2e-b452-f3a60f9b1bd9");	

	$emailStatus = 'Failed';
	$htmlBody = '';
	$fields = array();

	// For creating the fields
	$fields = createFieldsData( $data );

	// For creating the email html
	$htmlBody = createHtmlForEmail( $fields );

	// Save data
	saveOnboardingInfo( $fields );

	// For sending the email
	$emailResult = sendEmail( $fields['mainDealershipName'], $htmlBody );

	if ($emailResult->message != 'OK') {

		print_r( json_encode(array("status"=>'error', "msg"=>'Something went wrong while submitting form. Please contact customer support.')) );

	}else{
		
		$emailStatus = 'Success';
		print_r(json_encode(array("status"=>'success', "msg"=>'')));
		
	}

	// For creating the log
	createLog( $fields['mainDealershipName'], $emailStatus, $htmlBody );


	/*
		Function for creating the fields
	*/
	function createFieldsData( $data ) {

		// Getting Dealerships Information
		$mainDealershipName =  isset($data['dealershipInfomationName'])? $data['dealershipInfomationName'][0]: '';
		$mainDealershipPhone =  isset($data['dealershipInformationContactPhone'])? $data['dealershipInformationContactPhone'][0]: '';
		$mainDealershipAddress =  isset($data['dealershipInformationContactAddress'])? $data['dealershipInformationContactAddress'][0]: '';
		$mainDealershipWebsiteUrl =  isset($data['dealershipInformationWebsiteURL'])? $data['dealershipInformationWebsiteURL'][0]: '';

		// Contact Info
		$dealership_Name =  isset($data['dealership-Name'])? $data['dealership-Name'][0]: '';
		$dealership_contact_phone =  isset($data['dealership-contact-phone'])? $data['dealership-contact-phone'][0]: '';
		$dealership_contact_email =  isset($data['dealership-contact-email'])? $data['dealership-contact-email'][0]: '';

		// Billing Info
		$billing_Name =  isset($data['billing-Name'])? $data['billing-Name'][0]: '';
		$billing_Contact_Phone =  isset($data['billing-Contact-Phone'])? $data['billing-Contact-Phone'][0]: '';
		$billing_Contact_Email =  isset($data['billing-Contact-Email'])? $data['billing-Contact-Email'][0]: '';

		// CRM Info
		$CRM_Email_Address =  isset($data['CRM-Email-Address'])? $data['CRM-Email-Address'][0]: '';
		$CRM_User_Name =  isset($data['CRM_User_Name'])? $data['CRM_User_Name'][0]: '';
		$additional_Email_Address =  isset($data['additional-Email-Address'])? $data['additional-Email-Address'][0]: '';
		$does_not_use_CRM =  isset($data['does-not-use-CRM'])? $data['does-not-use-CRM'][0]: '';

		// Inventory Info
		$Inventory_Feed_Provider =  isset($data['Inventory-Feed-Provider']) && !empty($data['Inventory-Feed-Provider']) ? $data['Inventory-Feed-Provider'][0]: '';
		$Inventory_to_Post =  isset($data['Inventory-to-Post'])? $data['Inventory-to-Post'][0]: '';

		// Leads Info
		$Lead_Admin_Name =  isset($data['Lead Admin-Name'])? $data['Lead Admin-Name'][0]: '';
		$Lead_Contact_Email =  isset($data['Lead-Contact-Email'])? $data['Lead-Contact-Email'][0]: '';
		$Lead_Contact_Phone =  isset($data['Lead-Contact-Phone'])? $data['Lead-Contact-Phone'][0]: '';

		// Sales Person Info
		$salespersonArray =  isset($data['Salesperson'])? $data['Salesperson']: array();
		$salespersonWrap = '';
		if(count($salespersonArray)>0 ){

			for($i=0; $i < count($salespersonArray); $i++)
			{
			
				$salespersonWrap.= '<b>Sales Person Name :</b> '.$salespersonArray[$i]["salesPersonName"].'<br>';
				$salespersonWrap.= '<b>Email :</b> '.$salespersonArray[$i]["salesLeadEmail"].'<br>';
				$salespersonWrap.= '<b>Mobile Number :</b> '.$salespersonArray[$i]["salesPhoneNumber"].'<br><br>';
			
			}
		}

		// Craigslist Info
		$Contact_Person_Name =  isset($data['Contact-Person-Name'])? $data['Contact-Person-Name'][0]: '';
		$craigslist_Ring_for_Leads =  isset($data['craigslist-Ring-for-Leads'])? $data['craigslist-Ring-for-Leads'][0]: '';
		$craigslist_Market_NameArray =  isset($data['craigslist-Market-Name'])? $data['craigslist-Market-Name']: array();
		$craigslist_Market = '';
		if(count($craigslist_Market_NameArray)>0 ){

			for($i=0; $i < count($craigslist_Market_NameArray); $i++)
			{
			
				$craigslist_Market.= '<b>Market Area :</b> '.$craigslist_Market_NameArray[$i]['areaName'].'<br>';
				$craigslist_Market.= '<b>Market Sub Area:</b> '.$craigslist_Market_NameArray[$i]['subAreaName'].'<br>';
			
			}
		}

		// Facebook Info
		$facebookLink =  isset($data['facebookLink'])? $data['facebookLink'][0]: '';

		// Website Info
		$Support_Provider_Name =  isset($data['Support-Provider-Name'])? $data['Support-Provider-Name'][0]: '';
		$Support_Provider_Email =  isset($data['Support-Provider-Email'])? $data['Support-Provider-Email'][0]: '';
		$Support_Provider_Phone =  isset($data['Support-Provider-Phone'])? $data['Support-Provider-Phone'][0]: '';
		$hostWebsite =  isset($data['hostWebsite'])? $data['hostWebsite'][0]: '';

		$hostProviderWebsiteURLArray =  isset($data['hostProviderWebsiteURL'])? $data['hostProviderWebsiteURL']: array();
		$websiteUrlDetails = '';
		if(count($hostProviderWebsiteURLArray)>0 ){

			for($i=0; $i < count($hostProviderWebsiteURLArray); $i++)
			{
			
				$websiteUrlDetails.= '<b>Dealer website :</b> '.$hostProviderWebsiteURLArray[$i]['dealerWebsite'].'<br>';
			
			}
		}

		return array(
			"dealerId" => $data['dealerId'],
			"mainDealershipName" => $mainDealershipName,
			"mainDealershipPhone"=> $mainDealershipPhone,
			"mainDealershipAddress"=> $mainDealershipAddress,
			"mainDealershipWebsiteUrl"=> $mainDealershipWebsiteUrl,
			"dealership_Name"=> $dealership_Name,
			"dealership_contact_phone"=> $dealership_contact_phone,
			"dealership_contact_email"=> $dealership_contact_email,
			"billing_Name"=> $billing_Name,
			"billing_Contact_Phone"=> $billing_Contact_Phone,
			"billing_Contact_Email"=> $billing_Contact_Email,
			"CRM_Email_Address"=> $CRM_Email_Address,
			"CRM_User_Name"=> $CRM_User_Name,
			"additional_Email_Address"=> $additional_Email_Address,
			"does_not_use_CRM"=> $does_not_use_CRM,
			"Inventory_Feed_Provider"=> $Inventory_Feed_Provider,
			"Inventory_to_Post"=> $Inventory_to_Post,
			"Lead_Admin_Name"=> $Lead_Admin_Name,
			"Lead_Contact_Email"=> $Lead_Contact_Email,
			"Lead_Contact_Phone"=> $Lead_Contact_Phone,
			"salespersonWrap"=> $salespersonWrap,
			"Contact_Person_Name"=> $Contact_Person_Name,
			"craigslist_Ring_for_Leads"=> $craigslist_Ring_for_Leads,
			"craigslist_Market"=> $craigslist_Market,
			"facebookLink"=> $facebookLink,
			"Support_Provider_Name"=> $Support_Provider_Name,
			"Support_Provider_Email"=> $Support_Provider_Email,
			"Support_Provider_Phone"=> $Support_Provider_Phone,
			"hostWebsite"=> $hostWebsite,
			"websiteUrlDetails"=> $websiteUrlDetails,
			"hostProviderWebsiteURLArray"=> $hostProviderWebsiteURLArray,
			"craigslist_Market_NameArray"=> $craigslist_Market_NameArray,
			"salespersonArray"=> $salespersonArray

		);

	}

	/*
		Function for creating the log
	*/
	function createLog( $mainDealershipName, $emailStatus, $htmlBody ) {

		// Api call for saving logs
		$access_key = "YVl3K7RYkd6jhTY";
		$secret_key = "OA5SfoARzEyMcLXhoYVu2NTgLXK5NU";
		$service_url = '';

		if( isset($_SERVER['SERVER_NAME']) && 
			( 
				$_SERVER['SERVER_NAME'] == 'www.zendealer.com' || $_SERVER['SERVER_NAME'] == 'zendealer.com' 
			) 
		) {

			// Base url LIVE
			$service_url = "https://api.systempostings.com/services/createLog";

		} else {

			// Base url local
			$service_url = "http://localhost/dwigtpl/webservices/services/createLog";
		}

		// Add API params
		$params['key'] = $access_key;
		$params['timeStamp'] = gmdate("Y-m-d\TH:i:s\Z");

		// Add custom params
		$params['item']=$mainDealershipName;
		$params['status']=$emailStatus;
		$params['htmlText']=addslashes($htmlBody);

		ksort($params);

		// Encode params and values
		foreach($params as $parameter => $value){
			
			if( $parameter != 'htmlText' ) {
				$parameter = str_replace("%7E", "~", rawurlencode($parameter));
				$value = str_replace("%7E", "~", rawurlencode($value));
				$requestArray[] = $parameter . '=' . $value;
			}
		}

		$signatureString = implode('&', $requestArray);
		//echo $signature_string."\n";
		// Make it happen
		$params['signature'] = urlencode(base64_encode(hash_hmac('sha256', $signatureString, $secret_key, true)));

		$curl_handle = curl_init();
		curl_setopt($curl_handle, CURLOPT_URL, $service_url);
		curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $params); 

		$buffer = curl_exec($curl_handle);
		curl_close($curl_handle);

	}

	/*
		Function for creating the html
	*/
	function createHtmlForEmail( $fields ) {

		// Creating the email html
		$htmlBody = '';

		$htmlBody.='<h1>Dealership Information</h1>';

		$htmlBody.='<h3>Dealerships Contact Information:</h3>';
		$htmlBody.='<b>Name of Dealership :</b> '.$fields['mainDealershipName'].'<br>';
		$htmlBody.='<b>Dealership Phone Number :</b> '.$fields['mainDealershipPhone'].'<br>';
		$htmlBody.='<b>Dealership Address :</b> '.$fields['mainDealershipAddress'].'<br>';
		$htmlBody.='<b>Dealership Website URL :</b> '.$fields['mainDealershipWebsiteUrl'].'<br>';

		$htmlBody.='<h3>Dealer Contact Information:</h3>';
		$htmlBody.='<b>Full Name :</b> '.$fields['dealership_Name'].'<br>';
		$htmlBody.='<b>Phone Number :</b> '.$fields['dealership_contact_phone'].'<br>';
		$htmlBody.='<b>Email Address :</b> '.$fields['dealership_contact_email'].'<br>';

		$htmlBody.='<h3>Billing Contact Information:</h3>';
		$htmlBody.='<b>Full Name :</b> '.$fields['billing_Name'].'<br>';
		$htmlBody.='<b>Phone Number :</b> '.$fields['billing_Contact_Phone'].'<br>';
		$htmlBody.='<b>Email Address :</b> '.$fields['billing_Contact_Email'].'<br>';

		$htmlBody.='<h1>Lead routing: </h1>';
		$htmlBody.='<b>Does not use CRM</b> : '.$fields['does_not_use_CRM'].'<br>';
		$htmlBody.='<b>CRM Email Address for ADF/XML Delivery (Lead Manager Address) :</b> '.$fields['CRM_Email_Address'].'<br>';
		$htmlBody.='<b>User Name :</b> '.$fields['CRM_User_Name'].'<br>';
		$htmlBody.='<b>Additional email address to send Lead Notifications to :</b> '.$fields['additional_Email_Address'].'<br>';

		$htmlBody.='<h1>Inventory Information: </h1>';
		$htmlBody.='<b>Inventory Feed Provider: (i.e. Homenet, Dealer Specialties, Vauto, Vinsolutions etc...)</b> : '.$fields['Inventory_Feed_Provider'].'<br>';
		$htmlBody.='<b>Please Check Inventory to Post</b> : '.$fields['Inventory_to_Post'].'<br>';

		$htmlBody.='<h1>Dashboard/Admin. User for (Calls, Texts, & Email Leads)</h1>';
		$htmlBody.='<b>Admin Name</b> : '.$fields['Lead_Admin_Name'].'<br>';
		$htmlBody.='<b>Email</b> : '.$fields['Lead_Contact_Email'].'<br>';
		$htmlBody.='<b>Mobile number</b> : '.$fields['Lead_Contact_Phone'].'<br><br>';

		$htmlBody.=$fields['salespersonWrap'];

		$htmlBody.='<h1>Craigslist Setup: </h1>';
		$htmlBody.='<b>Contact Person Name to Appear in Ads</b> : '.$fields['Contact_Person_Name'].'<br>';
		$htmlBody.='<b>Ring to # for Leads : (If not wanting leads to go to Dashboard User\'s/Ring to main line at store)</b> : '.$fields['craigslist_Ring_for_Leads'].'<br><br>';

		$htmlBody.= $fields['craigslist_Market'];

		$htmlBody.='<h1>Facebook Market Place Setup</h1>';
		$htmlBody.='<b>Facebook Business page Dealership URL :</b> '.$fields['facebookLink'].'<br>';

		$htmlBody.='<h1>Website Host Support Provider</h1>';
		$htmlBody.='<b>Contact Name</b> : '.$fields['Support_Provider_Name'].'<br>';
		$htmlBody.='<b>Phone Number</b> : '.$fields['Support_Provider_Phone'].'<br>';
		$htmlBody.='<b>Email</b> : '.$fields['Support_Provider_Email'].'<br><br>';
		$htmlBody.='<b>Hosting Provider Website</b> : '.$fields['hostWebsite'].'<br><br>';


		$htmlBody.= $fields['websiteUrlDetails'];

		return $htmlBody;
	}

	/*
		Function for sending the email
	*/
	function sendEmail( $mainDealershipName, $htmlBody ) {

		global $pmClient;

		$to = '';
		if( isset($_SERVER['SERVER_NAME']) && 
			( 
				$_SERVER['SERVER_NAME'] == 'www.zendealer.com' || $_SERVER['SERVER_NAME'] == 'zendealer.com' 
			) 
		) {
			
			//$to = "webdevelopervishy@gmail.com, tim@zendealer.com,justin@zendealer.com, craig@zendealer.com,bill@zendealer.com,sales@zendealer.com,terry@zendealer.com";
			
		} else {
			
			$to = "vishvanathsingh.1@gmail.com";
		}

		$subject = "Dealer Onboarding Form (".$mainDealershipName.")";
		$from = "timm@dealerwebinstinct.com";

		$result = $pmClient->sendEmail($from, $to, $subject, $htmlBody , NULL, true, null, null,null,null,null);

		return $result;

	}

	/*
		Function for creating the log
	*/
	function saveOnboardingInfo( $fields ) {

		// Api call for saving logs
		$access_key = "YVl3K7RYkd6jhTY";
		$secret_key = "OA5SfoARzEyMcLXhoYVu2NTgLXK5NU";
		$service_url = '';

		if( isset($_SERVER['SERVER_NAME']) && 
			( 
				$_SERVER['SERVER_NAME'] == 'www.zendealer.com' || $_SERVER['SERVER_NAME'] == 'zendealer.com' 
			) 
		) {

			// Base url LIVE
			$service_url = "https://api.systempostings.com/services/saveOnboardingInfo";

		} else {

			// Base url local
			$service_url = "http://localhost/dwigtpl/webservices/services/saveOnboardingInfo";
		}

		// Add API params
		$params['key'] = $access_key;
		$params['timeStamp'] = gmdate("Y-m-d\TH:i:s\Z");

		// Add custom params
		$params['fields']=json_encode($fields);

		ksort($params);

		// Encode params and values
		foreach($params as $parameter => $value){
			
			if( $parameter != 'htmlText' ) {
				$parameter = str_replace("%7E", "~", rawurlencode($parameter));
				$value = str_replace("%7E", "~", rawurlencode($value));
				$requestArray[] = $parameter . '=' . $value;
			}
		}

		$signatureString = implode('&', $requestArray);
		//echo $signature_string."\n";
		// Make it happen
		$params['signature'] = urlencode(base64_encode(hash_hmac('sha256', $signatureString, $secret_key, true)));

		$curl_handle = curl_init();
		curl_setopt($curl_handle, CURLOPT_URL, $service_url);
		curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 2);
		curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $params); 

		$buffer = curl_exec($curl_handle);
		curl_close($curl_handle);

	}
?>