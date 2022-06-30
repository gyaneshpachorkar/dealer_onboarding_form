<?php

	$areaHtml = "";
	$access_key = "YVl3K7RYkd6jhTY";
	$secret_key = "OA5SfoARzEyMcLXhoYVu2NTgLXK5NU";
	
	$agreementResponse = '';
	$dealerContactFullName = '';
	$billingContactFullName = '';
	$dealerFullAddress = '';
	$dealershipPhone = '';
	$dealershipWebsiteUrl = '';
	$dealershipContactPhone = '';
	$dealershipContactEmail = '';
	$dealershipBillingPhone = '';
	$dealershipBillingEmail = '';
	$dealershipFullName = '';
	$areaArr = array();
	$subAreaArr = array();
	$craigslistAreas = array();
	$salesPersonArr = array();
	$dealerMultiWebSiteUrlsArr = array();
	$dealerId = 0;
	
	if( isset($_GET['cls']) ) {

		$service_url ='';
		
		if( isset($_SERVER['SERVER_NAME']) && 
			( 
				$_SERVER['SERVER_NAME'] == 'www.zendealer.com' || $_SERVER['SERVER_NAME'] == 'zendealer.com' 
			) 
		) {

			// Base url LIVE
			$service_url = "https://api.systempostings.com/services/getCraigslistArea";

		} else {
	
			// Base url local
			$service_url = "http://localhost/dwigtpl/webservices/services/getCraigslistArea";
		}

		// Add API params
		$parameters['key'] = $access_key;
		$parameters['timeStamp'] = gmdate("Y-m-d\TH:i:s\Z");
		
		// Add custom params
		//$parameters['areaId']=27;
		
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
			
		} else {

			$data = json_decode($buffer,true);
			
			if( $data['result']['response'] == "Success" ) {
				
				$response = $data['result']['responseData']['area'];

				$areaArr = $response;
				$subAreaArr =  $data['result']['responseData']['subArea'];

				$areaHtml .= "<option value='0' selected>Select Area</option>";
				
				for( $ind = 0; $ind < count($response); $ind++ ) {
					
					$areaHtml .= "<option value='".$response[$ind]['id']."'>".$response[$ind]['state'].' - '.$response[$ind]['url'].' - '.$response[$ind]['cl_area']."</option>";
					
				}
			}
			
		}
	}
	
	if( isset($_REQUEST['envId']) ) {

		$service_url = '';
		
		if( isset($_SERVER['SERVER_NAME']) && 
			( 
				$_SERVER['SERVER_NAME'] == 'www.zendealer.com' || $_SERVER['SERVER_NAME'] == 'zendealer.com' 
			) 
		) {

			// Base url LIVE
			$service_url = "https://api.systempostings.com/services/getAgreementDetail";

		} else {
	
			// Base url local
			$service_url = "http://localhost/dwigtpl/webservices/services/getAgreementDetail";
		}
				
		
		// Add API params
		$params['key'] = $access_key;
		$params['timeStamp'] = gmdate("Y-m-d\TH:i:s\Z");
		
		// Add custom params
		$params['envId']=$_REQUEST['envId'];
		
		ksort($params);
		
		// Encode params and values
		foreach($params as $parameter => $value){
			$parameter = str_replace("%7E", "~", rawurlencode($parameter));
			$value = str_replace("%7E", "~", rawurlencode($value));
			$requestArray[] = $parameter . '=' . $value;
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
	  
		if (empty($buffer)){
			
		} else {

			$data = json_decode($buffer,true);
			
			if( $data['result']['response'] == "Success" ) {
				
				$agreementResponse = $data['result']['responseData'];

				if( isset($agreementResponse['dealer_id']) && !empty($agreementResponse['dealer_id']) ) {
					$dealerId = $agreementResponse['dealer_id'];
				}

				// Contact Name
				if( isset($agreementResponse['dealership_contact_name']) && !empty($agreementResponse['dealership_contact_name']) ) {

					$dealerContactFullName = $agreementResponse['dealership_contact_name'];

				} else {

					if( isset($agreementResponse['dealer_contact_first']) ) {
						$dealerContactFullName .= $agreementResponse['dealer_contact_first'];
					}
					
					if( isset($agreementResponse['dealer_contact_last']) ) {
						$dealerContactFullName .= ' '.$agreementResponse['dealer_contact_last'];
					}
				}

				// Billing Name
				if( isset($agreementResponse['dealership_billing_name']) && !empty($agreementResponse['dealership_billing_name']) ) {

					$billingContactFullName = $agreementResponse['dealership_billing_name'];

				} else {
				
					if( isset($agreementResponse['dealer_billing_contact_first']) ) {
						$billingContactFullName .= $agreementResponse['dealer_billing_contact_first'];
					}
					
					if( isset($agreementResponse['dealer_billing_contact_last']) ) {
						$billingContactFullName .= ' '.$agreementResponse['dealer_billing_contact_last'];
					}
				}

				// Address 
				if( isset($agreementResponse['onboard_dealership_address']) && !empty($agreementResponse['onboard_dealership_address']) ) {
					
					$dealerFullAddress = $agreementResponse['onboard_dealership_address'];

				} else {
				
					if( isset( $agreementResponse['dealership_address'] ) && !empty( $agreementResponse['dealership_address'] ) ) {
						
						$dealerFullAddress = $agreementResponse['dealership_address'];
						
						if( isset( $agreementResponse['city'] ) && !empty( $agreementResponse['city'] ) ) {
							$dealerFullAddress .= ' '.$agreementResponse['city'];
						}
						
						if( isset( $agreementResponse['state'] ) && !empty( $agreementResponse['state'] ) ) {
							$dealerFullAddress .= ' '.$agreementResponse['state'];
						}
						
						if( isset( $agreementResponse['zip'] ) && !empty( $agreementResponse['zip'] ) ) {
							$dealerFullAddress .= ', '.$agreementResponse['zip'];
						}
						
					}
				}

				// Dealership Name
				if( isset( $agreementResponse['onboard_dealership_name'] ) && !empty($agreementResponse['onboard_dealership_name']) ) {

					$dealershipFullName = $agreementResponse['onboard_dealership_name'];

				} else {

					if( isset( $agreementResponse['dealership_name'] ) ) {

						$dealershipFullName = $agreementResponse['dealership_name'];
					}

				}

				// Dealershi Phone Info
				if( isset( $agreementResponse['dealership_phone'] ) && !empty($agreementResponse['dealership_phone']) ) {

					$dealershipPhone = $agreementResponse['dealership_phone'];

				} else {
					if( isset( $agreementResponse['dealer_contact_phone'] ) ) {

						$dealershipPhone = $agreementResponse['dealer_contact_phone'];
					}
				}


				// Contact Info
				if( isset( $agreementResponse['dealership_contact_phone'] ) && !empty($agreementResponse['dealership_contact_phone']) ) {

					$dealershipContactPhone = $agreementResponse['dealership_contact_phone'];

				} else {
					if( isset( $agreementResponse['dealer_contact_phone'] ) ) {

						$dealershipContactPhone = $agreementResponse['dealer_contact_phone'];
					}
				}

				if( isset( $agreementResponse['dealership_contact_email'] ) && !empty($agreementResponse['dealership_contact_email']) ) {

					$dealershipContactEmail = $agreementResponse['dealership_contact_email'];

				} else {
					if( isset( $agreementResponse['contact_email'] ) ) {

						$dealershipContactEmail = $agreementResponse['contact_email'];
					}
				}

				// Billing Info
				if( isset( $agreementResponse['dealership_billing_phone'] ) && !empty($agreementResponse['dealership_billing_phone']) ) {

					$dealershipBillingPhone = $agreementResponse['dealership_billing_phone'];

				} else {
					if( isset( $agreementResponse['dealer_billing_contact_phone'] ) ) {

						$dealershipBillingPhone = $agreementResponse['dealer_billing_contact_phone'];
					}
				}

				if( isset( $agreementResponse['dealership_billing_email'] ) && !empty($agreementResponse['dealership_billing_email']) ) {

					$dealershipBillingEmail = $agreementResponse['dealership_billing_email'];

				} else {
					if( isset( $agreementResponse['dealer_billing_contact_email'] ) ) {

						$dealershipBillingEmail = $agreementResponse['dealer_billing_contact_email'];
					}
				}

				// Craigslist Areas
				if( isset( $agreementResponse['craigslist_contact_areas'] ) && !empty($agreementResponse['craigslist_contact_areas']) ) {

					$areasCra = json_decode($agreementResponse['craigslist_contact_areas'], true);
					if( is_array($areasCra) ) {
						$craigslistAreas = $areasCra;
					}
					
				}

				// sales person info
				if( isset( $agreementResponse['chat_sales_users'] ) && !empty($agreementResponse['chat_sales_users']) ) {

					$salesPersons = json_decode($agreementResponse['chat_sales_users'], true);
					if( is_array($areasCra) ) {
						$salesPersonArr = $salesPersons;
					}
					
				}

				// dealer website url info
				if( isset( $agreementResponse['dealer_website_url'] ) && !empty($agreementResponse['dealer_website_url']) ) {

					$dealerMultiWebSiteUrls = json_decode($agreementResponse['dealer_website_url'], true);
					if( is_array($areasCra) ) {
						$dealerMultiWebSiteUrlsArr = $dealerMultiWebSiteUrls;
					}
					
				}
				
			}
			
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<!---<meta name="referrer" content="origin">---->
			<!---<meta http-equiv="refresh" content="10; url=https://www.zendealer.com/dealer_onboarding_form/">--->
			<title>Dealer Onboarding Form</title>
			<link type="text/css" rel="stylesheet" href="/dealer_onboarding_form/common/css/material_icons.css">
			<link type="text/css" rel="stylesheet" href="/dealer_onboarding_form/plugins/fontawesome-free-6.1.1-web/css/all.min.css">
			<!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">-->
			<link type="text/css" rel="stylesheet" href="/dealer_onboarding_form/plugins/select2/select2.css" rel="stylesheet"/>
			<link type="text/css" rel="stylesheet" href="/dealer_onboarding_form/plugins/materialize/materialize.min.css" media="screen,projection">
			<link type="text/css" rel="stylesheet" href="/dealer_onboarding_form/common/css/style.css">
			<link type="text/css" rel="stylesheet" href="/dealer_onboarding_form/css/signUpForm.css?v=<?php echo date('Y-m-d H:i:s') ?>">
	</head>
	<style>
		h5{font-size: 17px;color:#000;}
		.crmUNF{margin-left: 20px;width: 27%;float: left;}
		.crmEmailWrap{width: 21%;float: left;margin-left: 25%;}
		.require{color:red;}
		.padding{margin-left: 14px;}
		.width20{width:16%;float:left;margin-bottom: 0px !important;}
		.width30{width:24%;float:left;margin-bottom: 0px !important;}
		.paddingLft0{padding-left:0px;}
		.addmore{padding: 0px !important;margin-top: 5px;}
		.input-field.cold label {width: 100%;}
		.closeBtnForAnotherLink1 {position: absolute;top: 7px;font-size: 22px;right: -12px;}

		@media screen and (max-width: 1100px){
		   .crmEmailWrap{width:50%;}
		   .crmUNF{width:50%;margin-left: 25%;margin-top: 38px !important;}
		   .width20 {width: 50%;float: left;}
		   .padding {margin-left: 25%;}
		   .mntop{margin-top: 20px !important;}
		   .crmemailempty{margin-top: 22px !important;} 
		}
	</style>
    <body>
		<input type="hidden" value="<?php echo $dealerId; ?>" id="dealerId" />
        <div class="container" id="signUpForm">
			<div class="row">
                <div class="col s6 offset-s3 pageHeadingContainer">
					<h1 class="pageNavSectionHeading">Dealer Onboarding Form</h1>
					<div class="smallHr"></div>
                </div>
            </div>
            <div class="row">
                <div class="col s6 offset-s3 noPadding widgetHead" data-id="DealerInfo">
					<h1 class="signUpSectionHeading">
						Dealership Information
					</h1>
					<span class="collapseIcon" >
						<i class="collapseIconDealerInfo fa-solid fa-chevron-down"></i>
					</span>
                </div>
            </div>
			
			<!-- Dealership Information section start-->
			<div class="row collapseBodyDealerInfo">
				<div class="col s6 offset-s3 noPadding">
					<h5 class="signUpSectionHeading">Dealership Contact Information:</h5>
				</div>
			</div>
			
			<div class="row collapseBodyDealerInfo">               
                <div class="input-field col s6 offset-s3">
                    <input id="dealershipInfomationName" type="text" class="inputField dataInput formElement" data-fid="dealershipInfomationName" autocomplete="off" value="<?php echo $dealershipFullName; ?>">
                    <label for="dealershipInfomationName" class="">Name of Dealership<span class="require">*</span> </label>
                    <div class="fieldErrorMsg" data-frmid="dealershipInfomationName"></div>
                </div>
            </div>
			
			<?php if( isset( $_GET['dis'] ) ){ ?>
			
				<div class="row collapseBodyDealerInfo">
					<div class="input-field col s6 offset-s3">
						<input id="dealershipInformationContactPhone" type="text" class="inputField dataInput formElement phoneNumberMask " data-fid="dealershipInformationContactPhone" maxlength="15" autocomplete="off" value="<?php echo $dealershipPhone;?>">
						<label for="dealershipInformationContactPhone">Dealership Phone Number<span class="require">*</span></label>
						<div class="fieldErrorMsg" data-frmid="dealershipInformationContactPhone"></div>
					</div>
				</div>
				
				<div class="row collapseBodyDealerInfo">
					<div class="input-field col s6 offset-s3">
						<input id="dealershipInformationContactAddress" type="text" class="inputField dataInput formElement" data-fid="dealershipInformationContactAddress" autocomplete="off" value="<?php echo $dealerFullAddress;?>">
						<label for="dealershipInformationContactAddress" class="active">Dealership Address<span class="require">*</span></label>
						<div class="fieldErrorMsg" data-frmid="dealershipInformationContactAddress"></div>
					</div>
				</div>
				
				<div class="row collapseBodyDealerInfo">
					<div class="input-field col s6 offset-s3">
						<input id="dealershipInformationWebsiteURL" type="text" class="inputField dataInput formElement fbLink" autocomplete="off" value="<?php echo isset( $agreementResponse['dealership_website_url'] ) ? $agreementResponse['dealership_website_url'] : '';?>">
						<label for="dealershipInformationWebsiteURL" data-msg="Dealership Website URL, Website URL format should be https://www.example.com, http://www.example.com">Dealership Website URL</label>
						<div class="fieldErrorMsg" data-frmid="dealershipInformationWebsiteURL"></div>
					   
					</div>
				</div>

				
				<!-- Dealerships Information section end-->

				<div class="row collapseBodyDealerInfo">
					<div class="col s6 offset-s3 noPadding">
						<h5 class="signUpSectionHeading">Dealer Contact Information: <span style="color:red;">(Note: this person will be setup as the Admin for reporting)</span></h5>
					</div>
				</div>

				<div class="row collapseBodyDealerInfo">               
					<div class="input-field col s6 offset-s3">
						<input id="dealershipName" type="text" class="inputField dataInput formElement" data-fid="dealershipName" autocomplete="off" value="<?php echo $dealerContactFullName;?>">
						<label for="dealershipName" class="">Full Name<span class="require">*</span> </label>
						<div class="fieldErrorMsg" data-frmid="dealershipName"></div>
					</div>
				</div>


				<div class="row collapseBodyDealerInfo">
					<div class="input-field col s6 offset-s3">
						<input id="dealershipContactPhone" type="text" class="inputField dataInput formElement phoneNumberMask " data-fid="dealershipContactPhone" maxlength="15" autocomplete="off" value="<?php echo $dealershipContactPhone;?>">
						<label for="dealershipContactPhone">Phone Number<span class="require">*</span></label>
						<div class="fieldErrorMsg" data-frmid="dealershipContactPhone"></div>
					</div>
				</div>
				<div class="row collapseBodyDealerInfo">
					<div class="input-field col s6 offset-s3">
						<input id="dealershipContactEmail" type="text" class="inputField dataInput formElement" data-fid="dealershipContactEmail" autocomplete="off" value="<?php echo $dealershipContactEmail;?>">
						<label for="dealershipContactEmail" class="active">Email<span class="require">*</span></label>
						<div class="fieldErrorMsg" data-frmid="dealershipContactEmail"></div>
					</div>
				</div>

				<!------------------Billing Section------------------------------------------------>			
				<div class="row collapseBodyDealerInfo">
					<div class="col s6 offset-s3 noPadding">
						<h5 class="signUpSectionHeading">Billing Contact Information: <span style="color:red;">(Note: this person will receive monthly statement)</span></h5>
					</div>
				</div>
				<div class="row collapseBodyDealerInfo">               
					<div class="input-field col s6 offset-s3">
						<input id="billingName" type="text" class="inputField dataInput formElement" data-fid="dealershipName" autocomplete="off" value="<?php echo $billingContactFullName;?>">
						<label for="billingName" class="">Full Name<span class="require">*</span> </label>
						<div class="fieldErrorMsg" data-frmid="billing-fullName"></div>
					</div>
				</div>
				<div class="row collapseBodyDealerInfo">
					<div class="input-field col s6 offset-s3">
						<input id="billingContactPhone" type="text" class="inputField dataInput formElement phoneNumberMask " data-fid="billingContactPhone" maxlength="15" autocomplete="off" value="<?php echo $dealershipBillingPhone;?>">
						<label for="billingContactPhone">Phone Number<span class="require">*</span></label>
						<div class="fieldErrorMsg" data-frmid="billing-phoneNumber"></div>
					</div>
				</div>
				<div class="row collapseBodyDealerInfo">
					<div class="input-field col s6 offset-s3">
						<input id="billingContactEmail" type="text" class="inputField dataInput formElement" data-fid="dealershipContactEmail" autocomplete="off" value="<?php echo $dealershipBillingEmail;?>">
						<label for="billingContactEmail" class="active">Email<span class="require">*</span></label>
						<div class="fieldErrorMsg" data-frmid="billingContactEmail"></div>
					</div>
				  </div>
			<?php } ?>

            <?php if( isset($_GET['lrs']) ) { ?>
				<!-------------Lead Routing---------------------------------->			
				<div class="row">
					<div class="col s6 offset-s3 noPadding widgetHead" data-id="LeadsInfo">
						<h1 class="signUpSectionHeading">Lead Routing</h1>
						<span class="collapseIcon" >
							<i class="collapseIconLeadsInfo fa-solid fa-chevron-down"></i>
						</span>
					</div>
				</div>
				
				<div class="row collapseBodyLeadsInfo">
					<div class="input-field col s6 offset-s3">
						<input type="checkbox" value="does-not-use-CRM" id="does-not-use-CRM" class="checkboxField does-not-use-CRM" <?php echo ( isset( $agreementResponse['is_crm_not_used'] ) && $agreementResponse['is_crm_not_used'] == 1 ? "checked" : "" );?> >
						<label for="does-not-use-CRM">Does not use CRM</label>
					</div>
					<div class="input-field col  offset-s3 crmEmailWrap">
						
						<input id="CRMEmail" type="text" class="inputField dataInput formElement CRMEmails" autocomplete="off"  value="<?php echo isset( $agreementResponse['crm_email'] ) ? $agreementResponse['crm_email'] : '';?>">
						<label for="CRMEmail" data-msg="for ADF/XML Delivery (Lead Manager Address)">CRM Email Address <span class="require conditionalRequire <?php echo ( isset( $agreementResponse['is_crm_not_used'] ) && $agreementResponse['is_crm_not_used'] == 1 ? "hide" : "" );?>">*</span></label>
						<div class="fieldErrorMsg crmemailempty" data-frmid="CRM-email-address"></div>	
					</div>
					<div class="input-field col  crmUNF">
						
						<input id="CRM_User_Name" type="text" class="inputField dataInput formElement CRM_User_Name" autocomplete="off" value="<?php echo isset( $agreementResponse['crm_user_name'] ) ? $agreementResponse['crm_user_name'] : '';?>" >
						  <label for="CRM_User_Name" data-msg="">User Name<span class="require conditionalRequire <?php echo ( isset( $agreementResponse['is_crm_not_used'] ) && $agreementResponse['is_crm_not_used'] == 1 ? "hide" : "" );?>">*</span> </label>
						<div class="fieldErrorMsg" data-frmid="CRM_User_Name"></div>	
					</div>
				
				</div>
				<div class="row collapseBodyLeadsInfo">
					<div class="input-field col s6 offset-s3">
						<input id="additionalEmailAddress" type="text" class="inputField dataInput formElement additionalEmailAddress" autocomplete="off" value="<?php echo isset( $agreementResponse['additional_email'] ) ? $agreementResponse['additional_email'] : '';?>" >
						  <label for="additionalEmailAddress" data-msg="Additional Email address to send Lead Notifications to">Email address </label>
						<div class="fieldErrorMsg" data-frmid="additionalEmailAddress"></div>	
					</div>
				</div>
				<!----------------------------Lead Routing End----------------------------------> 
			<?php } ?>
			
			<?php if( isset($_GET['ifs']) ) { ?>
				<!----------------------------Inventory Information:---------------------------------->                        
			   <div class="row">
					<div class="col s6 offset-s3 noPadding widgetHead" data-id="InventoryInfo" >
						<h1 class="signUpSectionHeading">Inventory Information:</h1>
						<span class="collapseIcon" >
							<i class="collapseIconInventoryInfo fa-solid fa-chevron-down"></i>
						</span>
					</div>
				</div> 

				<div class="row collapseBodyInventoryInfo">
					<div class="input-field col s6 offset-s3">
						<input id="InventoryFeedProvider" type="text" class="inputField dataInput formElement" data-fid="InventoryFeedProvider" autocomplete="off" value="<?php echo isset( $agreementResponse['inventory_provider'] ) ? $agreementResponse['inventory_provider'] : '';?>" >
						<label for="InventoryFeedProvider" class="" data-msg="(i.e. Homenet, Dealer Specialties, Vauto, Vinsolutions etc...)">Inventory Feed Provider </label>
					</div>
				</div>
				<div class="row collapseBodyInventoryInfo">
					<div class="input-field col s6 offset-s3">
						<span class="elemHeading">Please Check Inventory to Post:</span>
						<span class="elemSubHeading">Choose one or more services to sign up for.</span>
						<input 
							type="checkbox" 
							value="Used" 
							id="craigslistService" 
							class="checkboxField InventorytoPostField" 
							name="InventorytoPost"
							<?php echo isset( $agreementResponse['inventory_type'] ) && $agreementResponse['inventory_type'] == "used" ? 'checked' : '';?>
						/>
						<label for="craigslistService">Used</label>
								
						<input 
							type="checkbox" 
							value="New" 
							id="facebookMarketPlaceService" 
							class="checkboxField serviceCheckBoxField InventorytoPostField" 
							name="InventorytoPost"
							<?php echo isset( $agreementResponse['inventory_type'] ) && $agreementResponse['inventory_type'] == "new" ? 'checked' : '';?>
						/>
						<label for="facebookMarketPlaceService">New</label>

						<input
							type="checkbox" 
							value="Both" 
							id="letGoService" 
							class="checkboxField serviceCheckBoxField InventorytoPostField" 
							name="InventorytoPost"
							<?php echo isset( $agreementResponse['inventory_type'] ) && $agreementResponse['inventory_type'] == "both" ? 'checked' : '';?>
						/>
						<label for="letGoService">Both</label>                   
					</div>
				</div>
			<?php } ?>

			<?php if( isset($_GET['aus']) ) { ?>
				<!------Lead App User----->          
				<div class="row">
					<div class="col s6 offset-s3 noPadding widgetHead"  data-id="ChatInfo">
						<h1 class="signUpSectionHeading">Dashboard-Admin/User for (Calls, Texts &amp; Email Leads)</h1>
						<span class="collapseIcon" >
							<i class="collapseIconChatInfo fa-solid fa-chevron-down"></i>
						</span>
					</div>
				</div>
				<div class="row collapseBodyChatInfo">               
					<div class="input-field col s6 offset-s3">
						<input id="adminLeadName" type="text" class="inputField dataInput formElement" data-fid="adminLeadName" autocomplete="off"
						value="<?php echo isset( $agreementResponse['chat_admin_name'] ) ? $agreementResponse['chat_admin_name'] : '';?>"
						>
						<label for="adminLeadName" class="">Admin Name </label>
						<div class="fieldErrorMsg" data-frmid="adminLeadName"></div>
					</div>
				</div>
				<div class="row collapseBodyChatInfo">
					<div class="input-field col s6 offset-s3">
						<input id="LeadContactEmail" type="text" class="inputField dataInput formElement" data-fid="LeadContactEmail" autocomplete="off" value="<?php echo isset( $agreementResponse['chat_email'] ) ? $agreementResponse['chat_email'] : '';?>">
						<label for="LeadContactEmail" class="active">Email</label>
						<div class="fieldErrorMsg" data-frmid="leadContactEmail"></div>
					</div>
				  </div>
				<div class="row collapseBodyChatInfo">
					<div class="input-field col s6 offset-s3">
						<input id="LeadContactPhone" type="text" class="inputField dataInput formElement phoneNumberMask " data-fid="leadContactPhone" maxlength="15" autocomplete="off" value="<?php echo isset( $agreementResponse['chat_phone'] ) ? $agreementResponse['chat_phone'] : '';?>">
						<label for="LeadContactPhone">Phone Number</label>
						<div class="fieldErrorMsg" data-frmid="leadContactPhone"></div>
					</div>
				</div>
				<!------Lead App User End-----> 		
			
				<div class="row collapseBodyChatInfo">
					
						<input type="hidden" value="<?php echo count($salesPersonArr); ?>" id="salesPersonCount" />
						<?php 
							if( count($salesPersonArr) > 0 ) {

								foreach( $salesPersonArr as $key => $value ) {
						?>
									<div class="salespersonDiv">
										<div class="input-field col width20 offset-s3">
											<input id="Salesperson" type="text" class="inputField dataInput formElement Salesperson Salesperson_<?php echo $key+1; ?>" autocomplete="off" value="<?php echo $value['salesPersonName']; ?>" >
											<label for="Salesperson" data-msg="">Salesperson</label>
											<div class="fieldErrorMsg" data-frmid=""></div>

											<!--<div class="anotherSalespersonContainer">
											</div>-->
											<!--<a class="addAnotherBtn" id="addAnotherSalespersonBtn">Add another</a>-->
										</div>
										<div class="input-field cold width20 padding">
											<input id="LeadEmail" type="text" class="inputField dataInput formElement leadsEmails leadsEmails_<?php echo $key+1; ?>" data-fid="dealershipLeadEmail" autocomplete="off" value="<?php echo $value['salesLeadEmail']; ?>">
											<label for="LeadEmail" class="active">Email</label>
											<div class="fieldErrorMsg" data-frmid="LeadEmail"></div>

										<!-- <div class="anotherLeadEmailContainer">
											</div>
											<a class="addAnotherBtn" id="addAnotherLeadEmailBtn">Add another</a>-->
										</div>
										<div class="input-field cold width20 padding">
											<input id="leadMobileNumber" type="text" class="inputField dataInput formElement phoneNumberMask leadMobileNumber leadMobileNumber_<?php echo $key+1; ?>" autocomplete="off" value="<?php echo $value['salesPhoneNumber']; ?>">
											<label for="leadMobileNumber" data-msg="">Mobile number  </label>
											<div class="fieldErrorMsg" data-frmid="leadMobileNumber"></div>

										<!--  <div class="anotherleadMobileNumberContainer">
											</div>
										<a class="addAnotherBtn" id="addAnotherleadMobileNumberBtn">Add another</a>-->
										</div> 
									</div>

						<?php
								}

							} else {
						?>

								<div class="input-field col width20 offset-s3">
									<input id="Salesperson" type="text" class="inputField dataInput formElement Salesperson Salesperson_0" autocomplete="off">
									<label for="Salesperson" data-msg="">Salesperson</label>
									<div class="fieldErrorMsg" data-frmid=""></div>

									<!--<div class="anotherSalespersonContainer">
									</div>-->
									<!--<a class="addAnotherBtn" id="addAnotherSalespersonBtn">Add another</a>-->
								</div>
								<div class="input-field cold width20 padding">
									<input id="LeadEmail" type="text" class="inputField dataInput formElement leadsEmails leadsEmails_0" data-fid="dealershipLeadEmail" autocomplete="off">
									<label for="LeadEmail" class="active">Email</label>
									<div class="fieldErrorMsg" data-frmid="LeadEmail"></div>

								<!-- <div class="anotherLeadEmailContainer">
									</div>
									<a class="addAnotherBtn" id="addAnotherLeadEmailBtn">Add another</a>-->
								</div>
								<div class="input-field cold width20 padding">
									<input id="leadMobileNumber" type="text" class="inputField dataInput formElement phoneNumberMask leadMobileNumber leadMobileNumber_0" autocomplete="off">
									<label for="leadMobileNumber" data-msg="">Mobile number  </label>
									<div class="fieldErrorMsg" data-frmid="leadMobileNumber"></div>

								<!--  <div class="anotherleadMobileNumberContainer">
									</div>
								<a class="addAnotherBtn" id="addAnotherleadMobileNumberBtn">Add another</a>-->
								</div> 
						<?php

							}
						
						?>
						
					<div style="clear:both;"></div>
					<div class="leadeSalesEmailNumContainer">
					</div>
					<div style="clear:both;"></div>
					<div class="col s6 offset-s3 addmore">
						<a class="addAnotherBtn offset-s3 paddingLft0" id="addAnotherleadeSalesEmailNumBtn">Add another</a>
					</div>
				</div >
			<?php } ?>
			
			<?php if( isset($_GET['cls']) ) { ?>
				<!----------------craigslist Setup----------------------------------->
				<div class="row">
					<div class="col s6 offset-s3 noPadding widgetHead" data-id="CraigslistInfo">
						<h1 class="signUpSectionHeading">Craigslist Setup:</h1>
						<span class="collapseIcon" >
							<i class="collapseIconCraigslistInfo fa-solid fa-chevron-down"></i>
						</span>
					</div>
				</div>
				<div class="row collapseBodyCraigslistInfo">               
					<div class="input-field col s6 offset-s3">
						<input id="craigslistName" type="text" class="inputField dataInput formElement" data-fid="dealershipName" autocomplete="off" value="<?php echo isset( $agreementResponse['craigslist_contact_name'] ) ? $agreementResponse['craigslist_contact_name'] : '';?>" >
						<label for="craigslistName" class="" data-msg="to Appear in Ads">Contact Person Name</label>
						<div class="fieldErrorMsg" data-frmid="craigslistName"></div>
					</div>
				</div>
				<div class="row collapseBodyCraigslistInfo">               
					<div class="input-field col s6 offset-s3">
						<input id="craigName" type="text" class="inputField dataInput formElement phoneNumberMask" data-fid="craigName" autocomplete="off" value="<?php echo isset( $agreementResponse['craigslist_contact_phone'] ) ? $agreementResponse['craigslist_contact_phone'] : '';?>" >
						<label for="craigName" class="" data-msg="(If not wanting leads to go to Dashboard User's/Ring to main line at store)">Ring to # for Leads: </label>
						<div class="fieldErrorMsg" data-frmid="craigName"></div>
					</div>
				</div>

				<div class="row collapseBodyCraigslistInfo" id="areaSubAreDiv" >

					<input id="marketDetailsCount" type="hidden" value="<?php echo count($craigslistAreas) ?>" />

						<?php 
						
							if( count($craigslistAreas) > 0 ) { 

								foreach( $craigslistAreas as $key => $value ) {
						?>
								<div id="marketDiv_<?php echo $key+1;?>" class="row">
									<div class="col width30 offset-s3 mntop">
										<h5>Craigslist Area</h5>
										<select class="select-wrapper input.select-dropdown form-control-chosen" id="cragislistAreas_<?php echo $key+1;?>" name="cragislistAreas_<?php echo $key+1;?>" rel="<?php echo $key+1;?>" >
											<option value="0">Select Area</option>
											<?php 
												
												for( $ind = 0; $ind < count($areaArr); $ind++ ) {
							
													echo "<option value='".$areaArr[$ind]['id']."' ".($value['areaId'] == $areaArr[$ind]['id'] ? "selected" : "")." >".$areaArr[$ind]['state'].' - '.$areaArr[$ind]['url'].' - '.$areaArr[$ind]['cl_area']."</option>";
													
												}
											
											?>
										</select>
										<div class="fieldErrorMsg areaErr area_err_<?php echo $key+1;?>">Information required to add more</div>
									</div>

									<div class="col width30 padding">
										<h5>Craigslist Sub-Area</h5>
										<select class="select-wrapper input.select-dropdown" id="cragislistSubAreas_<?php echo $key+1;?>" name="cragislistSubAreas_<?php echo $key+1;?>" rel="<?php echo $key+1;?>" >

											<?php 
												
												for( $ind = 0; $ind < count($subAreaArr); $ind++ ) {
							
													if( $value['areaId'] == $subAreaArr[$ind]['area_id'] ) {

														echo "<option value='".$subAreaArr[$ind]['id']."' ".($value['subAreaId'] == $subAreaArr[$ind]['id'] ? "selected" : "")." >".$subAreaArr[$ind]['description'].' - '.$subAreaArr[$ind]['cl_sub_area']."</option>";
													}
													
												}
											
											?>

										</select>
									</div>
								</div>

						<?php
								}
							} else {
						
						?>
						
							<div id="marketDiv_0" class="row">
								<div class="col width30 offset-s3 mntop">
									<h5>Craigslist Area</h5>
									<select class="select-wrapper input.select-dropdown form-control-chosen" id="cragislistAreas_0" name="cragislistAreas_0" rel="0" >
										<?php echo $areaHtml; ?>
									</select>
									<div class="fieldErrorMsg areaErr area_err_0">Information required to add more</div>
								</div>

								<div class="col width30 padding">
									<h5>Craigslist Sub-Area</h5>
									<select class="select-wrapper input.select-dropdown" id="cragislistSubAreas_0" name="cragislistSubAreas_0" rel="0" >
									</select>
								</div>
							</div>
						<?php

							}
						
						?>
					
					<div class="marketSubbudgetContainer">
					</div>
					<div style="clear:both;"></div>
					<div class="col s6 offset-s3 addmore">
						<a class="addAnotherBtn offset-s3 paddingLft0" id="addAnotherMarketSubbudgetBtn">Add More</a>
					</div>
				</div>
			<?php } ?>
			
			<?php if( isset($_GET['fbs']) ) { ?>
				<!-------Facebook Market----------------->
				<div class="row">
					<div class="col s6 offset-s3 noPadding widgetHead" data-id="FacebookInfo">
						<h1 class="signUpSectionHeading">Facebook Market Place Setup:</h1>
						<span class="collapseIcon" >
							<i class="collapseIconFacebookInfo fa-solid fa-chevron-down"></i>
						</span>
					</div>
				</div>
				<div class="row collapseBodyFacebookInfo">
					<div class="input-field col s6 offset-s3">
						<input id="facebookURL" type="text" class="inputField dataInput formElement fbLink" autocomplete="off" value="<?php echo isset( $agreementResponse['facebook_page_link'] ) ? $agreementResponse['facebook_page_link'] : '';?>" >
						<label for="facebookURL" data-msg="Business page Dealership URL">Facebook Link</label>
						<div class="fieldErrorMsg" data-frmid="facebookURL"></div>
					   
					</div>
				</div>
			<?php } ?>
			
		   <?php if( isset($_GET['fps']) ) { ?>
			   <!------Website Host Support Provider----->          
				<div class="row">
					<div class="col s6 offset-s3 noPadding widgetHead" data-id="WebsiteInfo">
						<h1 class="signUpSectionHeading">Website Host Support Provider</h1>
						<span class="collapseIcon" >
							<i class="collapseIconWebsiteInfo fa-solid fa-chevron-down"></i>
						</span>
					</div>
				</div>
				<div class="row collapseBodyWebsiteInfo">               
					<div class="input-field col s6 offset-s3">
						<input id="supportProviderName" type="text" class="inputField dataInput formElement" data-fid="supportProviderName" autocomplete="off" value="<?php echo isset( $agreementResponse['website_contact_name'] ) ? $agreementResponse['website_contact_name'] : '';?>" >
						<label for="supportProviderName" class="">Contact Name </label>
						<div class="fieldErrorMsg" data-frmid="supportProviderName"></div>
					</div>
				</div>
				<div class="row collapseBodyWebsiteInfo">
					<div class="input-field col s6 offset-s3">
						<input id="supportProviderTelephone" type="text" class="inputField dataInput formElement phoneNumberMask" data-fid="supportProviderTelephone" maxlength="15" autocomplete="off" value="<?php echo isset( $agreementResponse['website_contact_number'] ) ? $agreementResponse['website_contact_number'] : '';?>" >
						<label for="supportProviderTelephone">Phone Number</label>
						<div class="fieldErrorMsg" data-frmid="supportProviderTelephone"></div>
					</div>
				</div>
				<div class="row collapseBodyWebsiteInfo">
					<div class="input-field col s6 offset-s3">
						<input id="supportProviderEmail" type="text" class="inputField dataInput formElement" data-fid="supportProviderEmail" autocomplete="off" value="<?php echo isset( $agreementResponse['website_contact_email'] ) ? $agreementResponse['website_contact_email'] : '';?>" >
						<label for="supportProviderEmail" class="active">Email</label>
						<div class="fieldErrorMsg" data-frmid="supportProviderEmail"></div>
					</div>
				 </div>
				<div class="row collapseBodyWebsiteInfo">
				
					<div class="input-field col s6 offset-s3">
						<input id="hostingProviderWebsiteURL_1" type="text" class="inputField dataInput formElement fbLink" autocomplete="off" rel="1" value="<?php echo isset( $agreementResponse['website_host_provider'] ) ? $agreementResponse['website_host_provider'] : '';?>" >
						<label for="hostingProviderWebsiteURL_1" data-msg="">Hosting Provider Website URL</label>
						<div class="fieldErrorMsg" data-frmid="hostingProviderWebsiteURL_1"></div>
					   
					</div>	
				</div>
				<div class="row collapseBodyWebsiteInfo" id="websiteUrlContainer">

					<input id="websiteHostURLDetailsCount" type="hidden" value="<?php echo count($dealerMultiWebSiteUrlsArr); ?>" />
					<?php 

						if( count($dealerMultiWebSiteUrlsArr) > 0 ) {

							foreach( $dealerMultiWebSiteUrlsArr as $key => $value ) {

					?>
								<div id="websiteHostURL_<?php echo $key+1; ?>" class="">

									<div class="input-field col s6 offset-s3" style="margin-bottom: 1px">
										<input id="dealerWebsiteURL_<?php echo $key+1; ?>" type="text" class="inputField dataInput formElement fbLink" autocomplete="off" rel="<?php echo $key+1; ?>" value="<?php echo $value['dealerWebsite'] ?>" >
										<label for="dealerWebsiteURL_<?php echo $key+1; ?>" data-msg="">Dealer Website URL</label>
										<div class="fieldErrorMsg" data-frmid="dealerWebsiteURL_<?php echo $key+1; ?>"></div>
									
									</div>				

								</div>
					<?php
							}

						} else {

					?>
							<div id="websiteHostURL_1" class="">

								<div class="input-field col s6 offset-s3" style="margin-bottom: 1px">
									<input id="dealerWebsiteURL_1" type="text" class="inputField dataInput formElement fbLink" autocomplete="off" rel="1" >
									<label for="dealerWebsiteURL_1" data-msg="">Dealer Website URL</label>
									<div class="fieldErrorMsg" data-frmid="dealerWebsiteURL_1"></div>
								
								</div>				

							</div>

					<?php
						}
					
					?>
					
					<div class="websiteHostURLContainer">
					</div>
					<div class="col s6 offset-s3 addmore">
						<a class="addAnotherBtn offset-s3 paddingLft0" id="addAnotherURLBtn">Add More</a>
					</div>
				</div>
				<!------Website Host Support Provider End-----> 
		   <?php } ?>


            <div class="row">  
				<div class="col s4 offset-s4 bottomBtnContainer">  
					<!--<p style="text-align: center;">Please complete all required fields (Highlighted above) to continue.</p>-->
					<button id="saveDraftBtn" class="waves-effect waves-light btn">Save Draft</button>
					<button id="signUpDealershipBttn" class="waves-effect waves-light btn green accent-3">Submit</button>
		   		</div>
            </div>

						
            <!-- Modal Structure -->
            <div id="popup" class="modal">
                <div class="modal-content">
                    <p id="modelContent">A bunch of text</p>
                </div>
                <div class="modal-footer">
                    <a href="#" class="modal-action modal-close waves-effect waves-green btn-flat">close</a>
                </div>
            </div>

            <div class="row"><div class="col s12">&nbsp;</div></div>
			<script>
				wsUrl = "webservice/agencySignup.php";
				areaHtml = <?php print_r( json_encode($areaHtml) ); ?>
			</script>
            <script type="text/javascript" src="plugins/jquery/jquery.js"></script>
            <script type="text/javascript" src="plugins/blockUI/jquery.blockUI.js"></script>

	    	<script type="text/javascript" src="/dealer_onboarding_form/plugins/select2/select2.js"></script>
            <script type="text/javascript" src="/dealer_onboarding_form/plugins/materialize/materialize.min.js"></script>
            <script type="text/javascript" src="/dealer_onboarding_form/plugins/materialize/datepickerfix.js"></script>
            <script type="text/javascript" src="/dealer_onboarding_form/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
            <script type="text/javascript" src="/dealer_onboarding_form/plugins/Inputmask-5/dist/inputmask-old.js"></script>
            <script type="text/javascript" src="/dealer_onboarding_form/js/signUpForm.js?date=<?php echo date('Y-m-d H:i:s') ?>"></script>
			
    

		</div>
		<div class="hiddendiv common"></div>
	</body>
</html>