<?php
if(!isset($_POST['fields'])){
	exit;
}
$data = $_POST['fields'];


//webdevelopervishy@gmail.com, timm@dealerwebinstinct.com, justin@dealerwebinstinct.com, markg@zendealer.com, leslie@zendealer.com
ini_set('display_errors', 1);

define('LIBROOT', dirname(dirname(dirname(__FILE__))));


require(LIBROOT . '/dealer_onboarding_form/postmail/autoload.php');

//postmark API
use Postmark\PostmarkClient;

$pmClient = new PostmarkClient("64a5286e-6e7d-4c2e-b452-f3a60f9b1bd9");	

// Getting Dealerships Information
$mainDealershipName =  isset($data['dealershipInfomationName'])? $data['dealershipInfomationName'][0]: '';
$mainDealershipPhone =  isset($data['dealershipInformationContactPhone'])? $data['dealershipInformationContactPhone'][0]: '';
$mainDealershipAddress =  isset($data['dealershipInformationContactAddress'])? $data['dealershipInformationContactAddress'][0]: '';
$mainDealershipWebsiteUrl =  isset($data['dealershipInformationWebsiteURL'])? $data['dealershipInformationWebsiteURL'][0]: '';


$dealership_Name =  isset($data['dealership-Name'])? $data['dealership-Name'][0]: '';
$dealership_contact_phone =  isset($data['dealership-contact-phone'])? $data['dealership-contact-phone'][0]: '';
$dealership_contact_email =  isset($data['dealership-contact-email'])? $data['dealership-contact-email'][0]: '';

$billing_Name =  isset($data['billing-Name'])? $data['billing-Name'][0]: '';
$billing_Contact_Phone =  isset($data['billing-Contact-Phone'])? $data['billing-Contact-Phone'][0]: '';
$billing_Contact_Email =  isset($data['billing-Contact-Email'])? $data['billing-Contact-Email'][0]: '';

$CRM_Email_Address =  isset($data['CRM-Email-Address'])? $data['CRM-Email-Address'][0]: '';
$CRME_User_Name =  isset($data['CRME_User_Name'])? $data['CRME_User_Name'][0]: '';
$additional_Email_Address =  isset($data['additional-Email-Address'])? $data['additional-Email-Address'][0]: '';
$Inventory_Feed_Provider =  isset($data['Inventory-Feed-Provider']) && !empty($data['Inventory-Feed-Provider']) ? $data['Inventory-Feed-Provider'][0]: '';


$Inventory_to_Post =  isset($data['Inventory-to-Post'])? $data['Inventory-to-Post'][0]: '';

$Lead_Admin_Name =  isset($data['Lead Admin-Name'])? $data['Lead Admin-Name'][0]: '';
$Lead_Contact_Email =  isset($data['Lead-Contact-Email'])? $data['Lead-Contact-Email'][0]: '';
$Lead_Contact_Phone =  isset($data['Lead-Contact-Phone'])? $data['Lead-Contact-Phone'][0]: '';

$SalespersonArray =  isset($data['Salesperson'])? $data['Salesperson']: array();
$SalespersonWrap = '';
if(count($SalespersonArray)>0 ){

	for($i=0; $i < count($SalespersonArray); $i++)
	{
	
		$SalespersonWrap.= '<b>Sales Person Name :</b> '.$SalespersonArray[$i]["salesPersonName"].'<br>';
		$SalespersonWrap.= '<b>Email :</b> '.$SalespersonArray[$i]["salesLeadEmail"].'<br>';
		$SalespersonWrap.= '<b>Mobile Number :</b> '.$SalespersonArray[$i]["salesPhoneNumber"].'<br><br>';
	
	}
}

$Contact_Person_Name =  isset($data['Contact-Person-Name'])? $data['Contact-Person-Name'][0]: '';
$craiglist_Ring_for_Leads =  isset($data['craiglist-Ring-for-Leads'])? $data['craiglist-Ring-for-Leads'][0]: '';


$craiglist_Market_NameArray =  isset($data['craiglist-Market-Name'])? $data['craiglist-Market-Name']: array();
$craiglist_Market = '';
if(count($craiglist_Market_NameArray)>0 ){

	for($i=0; $i < count($craiglist_Market_NameArray); $i++)
	{
	
		$craiglist_Market.= '<b>Market Area :</b> '.$craiglist_Market_NameArray[$i]['areaName'].'<br>';
		$craiglist_Market.= '<b>Market Sub Area:</b> '.$craiglist_Market_NameArray[$i]['subAreaName'].'<br>';
	
	}
}

$facebookLink =  isset($data['facebookLink'])? $data['facebookLink'][0]: '';
$does_not_use_CRM =  isset($data['does-not-use-CRM'])? $data['does-not-use-CRM'][0]: '';


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

// Creating the email html
$htmlbody = '';

$htmlbody.='<h1>Dealership Information</h1>';

$htmlbody.='<h3>Dealerships Contact Information:</h3>';
$htmlbody.='<b>Name of Dealership :</b> '.$mainDealershipName.'<br>';
$htmlbody.='<b>Dealership Phone Number :</b> '.$mainDealershipPhone.'<br>';
$htmlbody.='<b>Dealership Address :</b> '.$mainDealershipAddress.'<br>';
$htmlbody.='<b>Dealership Website URL :</b> '.$mainDealershipWebsiteUrl.'<br>';

$htmlbody.='<h3>Dealer Contact Information:</h3>';
$htmlbody.='<b>Full Name :</b> '.$dealership_Name.'<br>';
$htmlbody.='<b>Phone Number :</b> '.$dealership_contact_phone.'<br>';
$htmlbody.='<b>Email Address :</b> '.$dealership_contact_email.'<br>';

$htmlbody.='<h3>Billing Contact Information:</h3>';
$htmlbody.='<b>Full Name :</b> '.$billing_Name.'<br>';
$htmlbody.='<b>Phone Number :</b> '.$billing_Contact_Phone.'<br>';
$htmlbody.='<b>Email Address :</b> '.$billing_Contact_Email.'<br>';

$htmlbody.='<h1>Lead routing: </h1>';
$htmlbody.='<b>Does not use CRM</b> : '.$does_not_use_CRM.'<br>';
$htmlbody.='<b>CRM Email Address for ADF/XML Delivery (Lead Manager Address) :</b> '.$CRM_Email_Address.'<br>';
$htmlbody.='<b>User Name :</b> '.$CRME_User_Name.'<br>';
$htmlbody.='<b>Additional email address to send Lead Notifications to :</b> '.$additional_Email_Address.'<br>';

$htmlbody.='<h1>Inventory Information: </h1>';
$htmlbody.='<b>Inventory Feed Provider: (i.e. Homenet, Dealer Specialties, Vauto, Vinsolutions etc...)</b> : '.$Inventory_Feed_Provider.'<br>';
$htmlbody.='<b>Please Check Inventory to Post</b> : '.$Inventory_to_Post.'<br>';

$htmlbody.='<h1>Dashboard/Admin. User for (Calls, Texts, & Email Leads)</h1>';
$htmlbody.='<b>Admin Name</b> : '.$Lead_Admin_Name.'<br>';
$htmlbody.='<b>Email</b> : '.$Lead_Contact_Email.'<br>';
$htmlbody.='<b>Mobile number</b> : '.$Lead_Contact_Phone.'<br><br>';


$htmlbody.=$SalespersonWrap;


$htmlbody.='<h1>Craigslist Setup: </h1>';
$htmlbody.='<b>Contact Person Name to Appear in Ads</b> : '.$Contact_Person_Name.'<br>';
$htmlbody.='<b>Ring to # for Leads : (If not wanting leads to go to Dashboard User\'s/Ring to main line at store)</b> : '.$craiglist_Ring_for_Leads.'<br><br>';

$htmlbody.= $craiglist_Market;



$htmlbody.='<h1>Facebook Market Place Setup</h1>';
$htmlbody.='<b>Facebook Business page Dealership URL :</b> '.$facebookLink.'<br>';

$htmlbody.='<h1>Website Host Support Provider</h1>';
$htmlbody.='<b>Contact Name</b> : '.$Support_Provider_Name.'<br>';
$htmlbody.='<b>Phone Number</b> : '.$Support_Provider_Phone.'<br>';
$htmlbody.='<b>Email</b> : '.$Support_Provider_Email.'<br><br>';
$htmlbody.='<b>Hosting Provider Website</b> : '.$hostWebsite.'<br><br>';

$htmlbody.= $websiteUrlDetails;
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

//$result = $pmClient->sendEmail($from, $to, $subject, $htmlbody , NULL, true, null, null,null,null,null);

$emailStatus = 'Failed';


if ($result->message != 'OK') {
	$data = array("status"=>'error', "msg"=>'Something went wrong while submitting form. Please contact customer support.');
	$json_array = array_merge($data);
	$data['json_data'] = json_encode($json_array);
	print_r($data['json_data']);
	
    //$errorMessage = error_get_last()['message'];
}else{
	
	$data = array("status"=>'success', "msg"=>'');
	$emailStatus = 'Success';
	$json_array = array_merge($data);
	$data['json_data'] = json_encode($json_array);
	print_r($data['json_data']);
	
	
}

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
	$params['htmlText']=addslashes($htmlbody);

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

?>