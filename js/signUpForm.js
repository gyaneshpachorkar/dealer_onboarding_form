pageElement = {}, pageData = {};
 $(function() {
	
	$('[id^=cragislistAreas_]').select2({width: "100%"});
	$('[id^=cragislistSubAreas_]').select2({width: "100%"});
	
	initSelectors();
    initPageData();
    
    initPageUIBlocker();

    initMaskForPhoneNumberFields();
    initMaskForOnlyNumericValue();
    initMaskForOnlyNumericValueWithoutPrefix();
    //$('.InventorytoPostField').prop('checked', false);
	//$('#does-not-use-CRM').prop('checked', false);
    pageElement.signUpForm.signUpDealershipBttn.click(function(){
        sendRequestForSignUpDealership();
        //window.location.reload;
    });

    pageElement.signUpForm.saveDraftBtn.click(function(){
        sendRequestForSignUpDealership();
        //window.location.reload;
    });
    
    var goLiveDatePicker = pageElement.signUpForm.goLiveDate.pickadate({
         selectMonths: true, // Creates a dropdown to control month
         selectYears: 15, // Creates a dropdown of 15 years to control year,
         clear: 'Clear',
         close: 'Ok',
         min: new Date(),
         closeOnSelect: false, // Close upon selecting a date,
         format: 'mm/dd/yyyy'
    });

    pageElement.signUpForm.priceStrategy.change(function(){
        if($(this).val() == '2'){
            $('.starndardLoanTermElemParentContainer').slideDown();
            return ;
        }
        
        $('.starndardLoanTermElemParentContainer').slideUp();
    });
    
    pageElement.signUpForm.offerUpPackage.change(function(){
        if($(this).val() == '1'){
            $('.showPricesElemParentContainer').slideDown();
            return ;
        }
        
        $('.showPricesElemParentContainer').slideUp();
    });


    pageElement.signUpForm.goLiveDatePickerElem = goLiveDatePicker.pickadate('picker');
    pageElement.popup.popup.modal();


    
    var  specialValidation= document.getElementById("chatHubService");
    if( (specialValidation == null || specialValidation == ''  ) ){
    	specialValidation= document.getElementById("facebookMarketPlaceService");	
    }
    
	var specialClass = "";
	
	if( (specialValidation != '' && specialValidation != null ) && specialValidation.length > 0 ) {
	
		specialClass = specialValidation.className;
		
	}

    if(specialClass == 'checkboxField slideDownListCars'){
    	  pageElement.signUpForm.addAnotherMobileTextingAndChatBtn.click(function(e){
    	        e.preventDefault();
    	        pageData.mobileTextingChatIndex++;
    	        var htmlMarkup = '<div class="addAnotherLink input-field"><input id="mobileTextingAndChat_'+ pageData.mobileTextingChatIndex +'" type="text" class="inputField dataInput formElement mobileTextingAndChats" >'+
    	                            '<label for="mobileTextingAndChat_'+ pageData.mobileTextingChatIndex +'">&nbsp;</label>'+
    	                            '<span style="color:#484848;font-size:13px;>Another Mobile Texing & Chat Operator for ChatHub.</span>'+
    	                            '<span style="color:red;">*</span>'+
    	                            '<a href="#dlt" class="closeBtnForAnotherLink" >x</a>'+
    	                            '<div class="fieldErrorMsg" data-frmid="mobileTextingAndChat_'+ pageData.mobileTextingChatIndex +'"></div>'+
    	                        '</div>';
    	            $('.anotherMobileChatContainer').append(htmlMarkup);
    	            
    	       
    	    });
    	  
    	  pageElement.signUpForm.addAnotherReceivingNumberBtn.click(function(e){
  	        e.preventDefault();
  	        pageData.receivingNumberIndex++;
  	        var htmlMarkup = '<div class="addAnotherLink input-field"><input id="receivingNumber_'+ pageData.receivingNumberIndex +'" type="text" class="inputField dataInput formElement receivingNumbers phoneNumberMask">'+
  	                            '<label for="receivingNumber_'+ pageData.receivingNumberIndex +'" data-msg="Another number to receive phone leads.">&nbsp;</label>'+
  	                            '<a href="#dlt" class="closeBtnForAnotherLink" >x</a>'+
  	                            '<div class="fieldErrorMsg" data-frmid="receivingNumber_'+ pageData.receivingNumberIndex +'"></div>'+
  	                        '</div>';
  	            $('.anotherReceivingNumberContainer').append(htmlMarkup);
  	            initMaskForPhoneNumberFields();
  	    });
  	    
    	
    }else if(specialClass == 'checkboxField slideDownListGha'){
    	 pageElement.signUpForm.addAnotherMobileTextingAndChatBtn.click(function(e){
 	        e.preventDefault();
 	        pageData.mobileTextingChatIndex++;
 	        var htmlMarkup = '<div class="addAnotherLink input-field"><input id="mobileTextingAndChat_'+ pageData.mobileTextingChatIndex +'" type="text" class="inputField dataInput formElement mobileTextingAndChats" >'+
 	                            '<label for="mobileTextingAndChat_'+ pageData.mobileTextingChatIndex +'">&nbsp;</label>'+
 	                            '<span style="color:#484848;font-size:13px;">Another ChatHub Admin Contact & Mobile Number</span>'+
 	                           '<span style="color:red;">*</span>'+
 	                            '<a href="#dlt" class="closeBtnForAnotherLink" >x</a>'+
 	                            '<div class="fieldErrorMsg" data-frmid="mobileTextingAndChat_'+ pageData.mobileTextingChatIndex +'"></div>'+
 	                        '</div>';
 	            $('.anotherMobileChatContainer').append(htmlMarkup);
 	            
 	       
 	    });
    	 
    	 
    	 pageElement.signUpForm.addAnotherMobileTextingAndNormalChatBtn.click(function(e){
  	        e.preventDefault();
  	        pageData.mobileTextingNormalChatIndex++;
  	        var htmlMarkup = '<div class="addAnotherLink input-field"><input id="mobileTextingNormalChat_'+ pageData.mobileTextingNormalChatIndex +'" type="text" class="inputField dataInput formElement mobileTextingNormalChats" >'+
  	                            '<label for="mobileTextingNormalChat_'+ pageData.mobileTextingNormalChatIndex +'">&nbsp;</label>'+
  	                            '<span style="color:#484848;font-size:13px;">Another ChatHub Normal User Name & Mobile Number</span>'+
  	                           '<span style="color:red;">*</span>'+
  	                            '<a href="#dlt" class="closeBtnForAnotherLink" >x</a>'+
  	                            '<div class="fieldErrorMsg" data-frmid="mobileTextingNormalChat_'+ pageData.mobileTextingNormalChatIndex +'"></div>'+
  	                        '</div>';
  	            $('.anotherNormalChatContainer').append(htmlMarkup);
  	            
  	       
  	    });
    	 
    	    pageElement.signUpForm.addAnotherReceivingNumberBtn.click(function(e){
    	        e.preventDefault();
    	        pageData.receivingNumberIndex++;
    	        var htmlMarkup = '<div class="addAnotherLink input-field"><input id="receivingNumber_'+ pageData.receivingNumberIndex +'" type="text" class="inputField dataInput formElement receivingNumbers phoneNumberMask">'+
    	                            '<label for="receivingNumber_'+ pageData.receivingNumberIndex +'">&nbsp;</label>'+
    	                            '<span>Another number to receive phone leads.</span>'+
    	                            '<span style="color:red;">*</span>'+
    	                            '<a href="#dlt" class="closeBtnForAnotherLink" >x</a>'+
    	                            '<div class="fieldErrorMsg" data-frmid="receivingNumber_'+ pageData.receivingNumberIndex +'"></div>'+
    	                        '</div>';
    	            $('.anotherReceivingNumberContainer').append(htmlMarkup);
    	            initMaskForPhoneNumberFields();
    	    });
 	    
    	}else{
    	  pageElement.signUpForm.addAnotherMobileTextingAndChatBtn.click(function(e){
    	        e.preventDefault();
    	        pageData.mobileTextingChatIndex++;
    	        var htmlMarkup = '<div class="addAnotherLink input-field"><input id="mobileTextingAndChat_'+ pageData.mobileTextingChatIndex +'" type="text" class="inputField dataInput formElement mobileTextingAndChats">'+
    	                            '<label for="mobileTextingAndChat_'+ pageData.mobileTextingChatIndex +'"  data-msg="Another Mobile Texing & Chat Operator.">&nbsp;</label>'+
    	                            '<a href="#dlt" class="closeBtnForAnotherLink" >x</a>'+
    	                            '<div class="fieldErrorMsg" data-frmid="mobileTextingAndChat_'+ pageData.mobileTextingChatIndex +'"></div>'+
    	                        '</div>';
    	            $('.anotherMobileChatContainer').append(htmlMarkup);
    	            
    	       
    	    });
    	  
    	    pageElement.signUpForm.addAnotherReceivingNumberBtn.click(function(e){
    	        e.preventDefault();
    	        pageData.receivingNumberIndex++;
    	        var htmlMarkup = '<div class="addAnotherLink input-field"><input id="receivingNumber_'+ pageData.receivingNumberIndex +'" type="text" class="inputField dataInput formElement receivingNumbers phoneNumberMask">'+
    	                            '<label for="receivingNumber_'+ pageData.receivingNumberIndex +'" data-msg="Another number to receive phone leads.">&nbsp;</label>'+
    	                            '<a href="#dlt" class="closeBtnForAnotherLink" >x</a>'+
    	                            '<div class="fieldErrorMsg" data-frmid="receivingNumber_'+ pageData.receivingNumberIndex +'"></div>'+
    	                        '</div>';
    	            $('.anotherReceivingNumberContainer').append(htmlMarkup);
    	            initMaskForPhoneNumberFields();
    	    });
    	    
    	    
    	}
    
    pageElement.signUpForm.addAnotherLeadsEmailBtn.click(function(e){
        e.preventDefault();
        pageData.leadsEmailIndex++;
        var htmlMarkup = '<div class="addAnotherLink input-field"><input id="leadsEmail_'+ pageData.leadsEmailIndex +'" type="text" class="inputField dataInput formElement leadsEmails" data-fid="leadsEmail">'+
                            '<label for="leadsEmail_'+ pageData.leadsEmailIndex +'" data-msg="Another leads email.">&nbsp;</label>'+
                            '<a href="#dlt" class="closeBtnForAnotherLink" >x</a>'+
                            '<div class="fieldErrorMsg" data-frmid="leadsEmail_'+ pageData.leadsEmailIndex +'"></div>'+
                        '</div>';
            $('.anotherLeadsEmailContainer').append(htmlMarkup);
    });
	$('#does-not-use-CRM').change(function(){
        if($('#does-not-use-CRM').is(':checked')){
            $('.conditionalRequire').addClass('hide');
            return;
        }
        $('.conditionalRequire').removeClass('hide');
        
    });

	$('#addAnotherleadeSalesEmailNumBtn').click(function(e){
        e.preventDefault();

        let k = parseInt($('#salesPersonCount').val()) != NaN ? parseInt($('#salesPersonCount').val())+1 : 1;
	
		var htmlMarkup = '';
		htmlMarkup+= '<div class="salespersonDiv"><div class="addAnotherLink input-field" id="SEM_'+k+'"><div class="input-field col width20 offset-s3"><input id="Salesperson_'+ k +'" type="text" class="inputField dataInput formElement Salesperson Salesperson_'+k+'">'+
                            '<label for="Salesperson_'+ k +'" data-msg="Another Salesperson.">&nbsp;</label>'+
                            '<div class="fieldErrorMsg" data-frmid="Salesperson_'+ k +'"></div></div>';
		
		htmlMarkup+= '<div class="input-field cold width20 padding"><input id="LeadEmail_'+ k +'" type="text" class="inputField dataInput formElement leadsEmails leadsEmails_'+k+'" data-fid="leadsEmail">'+
                            '<label for="LeadEmail_'+ k +'" data-msg="Another leads email.">&nbsp;</label>'+
                            '<div class="fieldErrorMsg" data-frmid="LeadEmail_'+ k +'"></div></div>';
		
		htmlMarkup+= '<div class="input-field cold width20 padding"><input id="leadMobileNumber_'+ k +'" type="text" class="inputField dataInput formElement phoneNumberMask leadMobileNumber leadMobileNumber_'+k+'" data-fid="leadMobileNumber">'+
                            '<label for="leadMobileNumber_'+ k +'" data-msg="Another Mobile Number.">&nbsp;</label>'+
                            '<a href="#dlt" class="closeBtnForAnotherLink1" onclick="remove(\'SEM_'+k+'\')">x</a>'+
                            '<div class="fieldErrorMsg" data-frmid="leadMobileNumber_'+ k +'"></div></div></div></div><div style="clear:both"></div>';
	
		$('.leadeSalesEmailNumContainer').append(htmlMarkup);
		$('#salesPersonCount').val(k);
		initMaskForPhoneNumberFields();
    });
	
	$('#addAnotherMarketSubbudgetBtn').click(function(e){
        e.preventDefault();
		
		if( $('#cragislistAreas_'+parseInt($('#marketDetailsCount').val())+' option:selected').val() != 0 ) {
		
			$('.areaErr' ).css("display",  "none");
			
			let count = parseInt($('#marketDetailsCount').val()) != NaN ? parseInt($('#marketDetailsCount').val())+1 : 1;
		
			var htmlMarkup = '';
			htmlMarkup+= '<div id="marketDiv_'+count+'" class="row">\
							<div class="col width30 offset-s3 mntop">\
								<h5>Craigslist Area</h5>\
								<select class="select-wrapper input.select-dropdown" id="cragislistAreas_'+count+'" name="cragislistAreas_'+count+'" rel="'+count+'" >'+areaHtml+'\
								</select>\
								<div class="fieldErrorMsg areaErr area_err_'+count+'">Information required to add more</div>\
							</div>\
							<div class="col width30 padding">\
								<h5>Craigslist Sub-Area</h5>\
								<select class="select-wrapper input.select-dropdown" id="cragislistSubAreas_'+count+'" name="cragislistSubAreas_'+count+'" rel="'+count+'" >\
								</select>\
							</div>\
							<div class="col">\
								<a href="#dlt" onclick="remove(\'marketDiv_'+count+'\')">X</a>\
							</div>\
						</div>';
		
			$('.marketSubbudgetContainer').append(htmlMarkup);
			$('#cragislistAreas_'+count).select2({width: "100%"});
			$('#cragislistSubAreas_'+count).select2({width: "100%"});
			
			$('#marketDetailsCount').val(count);
			
		} else {
			$('.area_err_'+parseInt($('#marketDetailsCount').val()) ).css("display",  "block");
		}
		
    });
	
	
	$('#addAnotherURLBtn').click(function(e){
        e.preventDefault();
		
		count = parseInt($('#websiteHostURLDetailsCount').val()) != NaN ? parseInt($('#websiteHostURLDetailsCount').val())+1 : 1;
	
		var htmlMarkup = '';
		htmlMarkup+= '<div id="websiteHostURL_'+count+'">\
						<div class="input-field col s6 offset-s3" style="margin-bottom: 1px">\
							<input id="dealerWebsiteURL_'+count+'" type="text" class="inputField dataInput formElement fbLink" autocomplete="off" rel="'+count+'" >\
							<label for="dealerWebsiteURL_'+count+'" data-msg="">Dealer Website URL</label>\
							<div class="fieldErrorMsg" data-frmid="dealerWebsiteURL_'+count+'"></div>\
						</div>\
						<div class="col">\
							<a href="#dlt" onclick="remove(\'websiteHostURL_'+count+'\')">X</a>\
						</div>\
					</div>';
	
		$('.websiteHostURLContainer').append(htmlMarkup);
		
		$('#websiteHostURLDetailsCount').val(count);
    });
	
	

	$('#addAnotherSalespersonBtn').click(function(e){
        e.preventDefault();
	
        pageData.SalespersonIndex++;
        var htmlMarkup = '<div class="addAnotherLink input-field"><input id="Salesperson_'+ pageData.SalespersonIndex +'" type="text" class="inputField dataInput formElement Salesperson">'+
                            '<label for="Salesperson_'+ pageData.SalespersonIndex +'" data-msg="Another Salesperson.">&nbsp;</label>'+
                            '<a href="#dlt" class="closeBtnForAnotherLink" >x</a>'+
                            '<div class="fieldErrorMsg" data-frmid="Salesperson_'+ pageData.SalespersonIndex +'"></div>'+
                        '</div>';
            $('.anotherSalespersonContainer').append(htmlMarkup);
    });
	
	$('#addAnotherLeadEmailBtn').click(function(e){
        e.preventDefault();
        pageData.leadsEmailIndex++;
        var htmlMarkup = '<div class="addAnotherLink input-field"><input id="LeadEmail_'+ pageData.leadsEmailIndex +'" type="text" class="inputField dataInput formElement leadsEmails" data-fid="leadsEmail">'+
                            '<label for="LeadEmail_'+ pageData.leadsEmailIndex +'" data-msg="Another leads email.">&nbsp;</label>'+
                            '<a href="#dlt" class="closeBtnForAnotherLink" >x</a>'+
                            '<div class="fieldErrorMsg" data-frmid="LeadEmail_'+ pageData.leadsEmailIndex +'"></div>'+
                        '</div>';
            $('.anotherLeadEmailContainer').append(htmlMarkup);
    });
	
	$('#addAnotherleadMobileNumberBtn').click(function(e){
        e.preventDefault();
        pageData.leadMobileNumber++;
        var htmlMarkup = '<div class="addAnotherLink input-field"><input id="leadMobileNumber_'+ pageData.leadMobileNumber +'" type="text" class="inputField dataInput formElement phoneNumberMask leadMobileNumber" data-fid="leadMobileNumber">'+
                            '<label for="leadMobileNumber_'+ pageData.leadMobileNumber +'" data-msg="Another Mobile Number.">&nbsp;</label>'+
                            '<a href="#dlt" class="closeBtnForAnotherLink" >x</a>'+
                            '<div class="fieldErrorMsg" data-frmid="leadMobileNumber_'+ pageData.leadMobileNumber +'"></div>'+
                        '</div>';
            $('.anotherleadMobileNumberContainer').append(htmlMarkup);
			initMaskForPhoneNumberFields();
    });
	
	$('#addAnothermarketNameBtn').click(function(e){
        e.preventDefault();
        pageData.marketNameIndex++;
        var htmlMarkup = '<div class="addAnotherLink input-field"><input id="marketName_'+ pageData.marketNameIndex +'" type="text" class="inputField dataInput formElement marketName" data-fid="marketName">'+
                            '<label for="marketName_'+ pageData.marketNameIndex +'" data-msg="Another Market name.">&nbsp;</label>'+
                            '<a href="#dlt" class="closeBtnForAnotherLink" >x</a>'+
                            '<div class="fieldErrorMsg" data-frmid="marketName_'+ pageData.marketNameIndex +'"></div>'+
                        '</div>';
            $('.anothermarketNameContainer').append(htmlMarkup);
    });
	
	/* $('#addAnothersubMarketBtn').click(function(e){
        e.preventDefault();
        pageData.subMarketIndex++;
        var htmlMarkup = '<div class="addAnotherLink input-field"><input id="subMarket_'+ pageData.subMarketIndex +'" type="text" class="inputField dataInput formElement subMarket" data-fid="subMarket">'+
                            '<label for="subMarket_'+ pageData.subMarketIndex +'" data-msg="Another sub Market.">&nbsp;</label>'+
                            '<a href="#dlt" class="closeBtnForAnotherLink" >x</a>'+
                            '<div class="fieldErrorMsg" data-frmid="subMarket_'+ pageData.subMarketIndex +'"></div>'+
                        '</div>';
            $('.anothersubMarketContainer').append(htmlMarkup);
    }); */
	
	$('#addAnothermonthlyBudgetBtn').click(function(e){
        e.preventDefault();
        pageData.monthlyBudgetIndex++;
        var htmlMarkup = '<div class="addAnotherLink input-field"><input id="monthlyBudget_'+ pageData.monthlyBudgetIndex +'" type="text" class="inputField dataInput formElement monthlyBudget allowOnlyNumbericValue" data-fid="monthlyBudget">'+
                            '<label for="monthlyBudget_'+ pageData.monthlyBudgetIndex +'" data-msg="Another Monthly Budget.">&nbsp;</label>'+
                            '<a href="#dlt" class="closeBtnForAnotherLink" >x</a>'+
                            '<div class="fieldErrorMsg" data-frmid="monthlyBudget_'+ pageData.monthlyBudgetIndex +'"></div>'+
                        '</div>';
            $('.anothermonthlyBudgetContainer').append(htmlMarkup);
			initMaskForOnlyNumericValue();
    });
    
    pageElement.signUpForm.addAnotherCRMEmailBtn.click(function(e){
        e.preventDefault();
	
        pageData.CRMEmailIndex++;
        var htmlMarkup = '<div class="addAnotherLink input-field"><input id="CRMEmail_'+ pageData.CRMEmailIndex +'" type="text" class="inputField dataInput formElement CRMEmails">'+
                            '<label for="CRMEmail_'+ pageData.CRMEmailIndex +'" data-msg="Another CRM email.">&nbsp;</label>'+
                            '<a href="#dlt" class="closeBtnForAnotherLink" >x</a>'+
                            '<div class="fieldErrorMsg" data-frmid="CRMEmail_'+ pageData.CRMEmailIndex +'"></div>'+
                        '</div>';
            $('.anotherCRMEmailContainer').append(htmlMarkup);
    });
    
    pageElement.signUpForm.addAnotherAdditionalEmailBtn.click(function(e){
        e.preventDefault();
        pageData.additionalEmailIndex++;
        var htmlMarkup = '<div class="addAnotherLink input-field"><input id="additionalEmail_'+ pageData.additionalEmailIndex +'" type="text" class="inputField dataInput formElement additionalEmails">'+
                            '<label for="additionalEmail_'+ pageData.additionalEmailIndex +'" data-msg="Another additional email.">&nbsp;</label>'+
                            '<a href="#dlt" class="closeBtnForAnotherLink" >x</a>'+
                            '<div class="fieldErrorMsg" data-frmid="additionalEmail_'+ pageData.additionalEmailIndex +'"></div>'+
                        '</div>';
            $('.anotherAdditionalEmailContainer').append(htmlMarkup);
    });
    
    
    $('.anotherReceivingNumberContainer,.anotherNormalChatContainer,.anotherMobileChatContainer,.anotherLeadsEmailContainer,.anotherCRMEmailContainer,.anotherAdditionalEmailContainer,.anotherSalespersonContainer,.anotherLeadEmailContainer,.anotherleadMobileNumberContainer,.anothermarketNameContainer,.anothersubMarketContainer,.anothermonthlyBudgetContainer,.leadeSalesEmailNumContainer').on('click','.closeBtnForAnotherLink',function(){
        $(this).parent().remove();
    });
    
    $(".serviceCheckBoxField").change(function(){
        var self = $(this);
        switch(self.attr("id")){
        	case "facebookMarketPlaceService":
            case "facebookCatalogService":
            case "facebookAdsService":
                var isNeedToShowFBLinkContainer = false;
                $("#facebookAdsService,#facebookMarketPlaceService,#facebookCatalogService").each(function(){
                    if($(this).is(':checked')){
                        isNeedToShowFBLinkContainer = true;
                    }
                });

                if(isNeedToShowFBLinkContainer){
                    $('.fbLinksContainer').slideDown();
                }else{
                    $('.fbLinksContainer').slideUp();
                }
                
                if(pageElement.signUpForm.services.facebookAdsService.is(":checked")){
                    pageElement.signUpForm.fbAdsServiceFieldsContainer.slideDown();
                }else{
                    pageElement.signUpForm.fbAdsServiceFieldsContainer.slideUp();
                }
                if(pageElement.signUpForm.services.facebookMarketPlaceService.is(":checked")){
                    pageElement.signUpForm.fbMarketPlaceServiceFieldsContainer.slideDown();
                }else{
                    pageElement.signUpForm.fbMarketPlaceServiceFieldsContainer.slideUp();
                }
                break;
            case "semService":
                if(pageElement.signUpForm.services.semService.is(":checked")){
                    pageElement.signUpForm.semServiceContainer.slideDown();
                }else{
                    pageElement.signUpForm.semServiceContainer.slideUp();
                }
                break;
            case "seoService":
                if(pageElement.signUpForm.services.seoService.is(":checked")){
                    pageElement.signUpForm.seoServiceContainer.slideDown();
                }else{
                    pageElement.signUpForm.seoServiceContainer.slideUp();
                }
                break;
            case "letGoService":
                if(pageElement.signUpForm.services.letGoService.is(":checked")){
                    pageElement.signUpForm.letGoSettingsContainer.slideDown();
                }else{
                    pageElement.signUpForm.letGoSettingsContainer.slideUp();
                }
                break;
                
            case "offerUpService":
                if(pageElement.signUpForm.services.offerUpService.is(":checked")){
                    pageElement.signUpForm.offerUpServiceContainer.slideDown();
                }else{
                    pageElement.signUpForm.offerUpServiceContainer.slideUp();
                }
                break;

        }
    });

    
    $('.InventorytoPostField').on('change', function (){  //when the value of a checkbox will change
        var th = $(this), name = th.prop('name');  //Get the selected checkbox name
        if (th.is(':checked')) //check whether previously another checkbox is checked or not
        {
            //If another checkbox is checked previously then, uncheck it.
            $(':checkbox[name="' + name + '"]').not($(this)).prop('checked', false);
        }
    });
    specialSignupFormServiceSettings();
    
    pageElement.signUpForm.services.craigslistService.change(function(){
        if(pageElement.signUpForm.services.craigslistService.is(':checked')){
            $('.craigsListCampaignSettingsContainer').slideDown();
            return;
        }
        
        $('.craigsListCampaignSettingsContainer').slideUp();
    });
    
     pageElement.signUpForm.services.craigslistService.change(function(){
        if(pageElement.signUpForm.services.craigslistService.is(':checked')){
            $('.postingConditionsContainer').slideDown();
            return;
        }
        
        $('.postingConditionsContainer').slideUp();
    });

      pageElement.signUpForm.services.craigslistService.change(function(){
        if(pageElement.signUpForm.services.craigslistService.is(':checked')){
            $('.spanishCheckBoxContainer').slideDown();
            return;
        }
        
        $('.spanishCheckBoxContainer').slideUp();
    });
      
   specialSignupFormServiceSettings();


   $(document).on('click', '.widgetHead', function() {

        var infoId = '';
        if( $(this).attr('data-id') != undefined && $(this).attr('data-id') != '' ) {
            infoId = $(this).attr('data-id');
        }

        if( infoId != '' && infoId != null ) {

            $('.collapseBody'+infoId).removeClass('hide');
            
            if( $('.collapseIcon'+infoId).hasClass('fa-chevron-down') ) {
                $('.collapseBody'+infoId).addClass('hide');
            }

            if( $('.collapseIcon'+infoId).hasClass('fa-chevron-down') ) {

                $('.collapseIcon'+infoId).removeClass('fa-chevron-down').addClass('fa-chevron-right');
        
            } else {
        
               $('.collapseIcon'+infoId).removeClass('fa-chevron-right').addClass('fa-chevron-down');
        
            }

        }

   });
      
});
 
function specialSignupFormServiceSettings(){
  if($( "#craigslistService" ).hasClass( "slideDownListCars" ) || $( "#chatHubService" ).hasClass( "slideDownListGha" ) ){
	  
	
	pageElement.signUpForm.services.craigslistService.prop('checked', true);
  	pageElement.signUpForm.services.letGoService.prop('checked', true);
  	$('.fbLinksContainer').slideDown();
	 $('.craigsListCampaignSettingsContainer').slideDown(); 
	 $('.postingConditionsContainer').slideDown();
	 $('.spanishCheckBoxContainer').slideDown();
	 if($( "#facebookMarketPlaceService" ).hasClass( "slideDownList" )){
	 $('.fbLinksContainer').slideDown();
	 $('.fbMarketPlaceServiceFieldsContainer').slideDown();
	 pageElement.signUpForm.services.facebookMarketPlaceService.prop('checked', true);
	 pageElement.signUpForm.services.chatHubService.prop('checked',true);
	 pageElement.signUpForm.services.carboService.prop('checked',true);
	 
	 }
	 $('.letGoSettingsContainer').slideDown();
	 	 
	   	 $(document).on('change','#specialTierSelection',function(e){
	         e.preventDefault();
	         $this = $(this);
	         $( "#addClass" ).addClass( "active" );  
	         $('#letGoTierSelection').val($this.val());
	         $('#monthlyPostingBudget').val($this.val());
	         $('#removeClass').each(function() {
	        	 if (this.selected){
	        		 $( "#addClass" ).removeClass( "active" ); 
	        	 }
	        	 });
	     });
	    }
} 

function initPageData(){
    pageData.receivingNumberIndex = pageData.mobileTextingChatIndex = pageData.mobileTextingNormalChatIndex  = pageData.leadsEmailIndex = pageData.CRMEmailIndex = pageData.additionalEmailIndex = pageData.starndardLoanTermIndex = pageData.leadMobileNumber =  pageData.SalespersonIndex = pageData.marketNameIndex = pageData.monthlyBudgetIndex = pageData.subMarketIndex =  1;
}

function initSelectors(){
    pageElement.signUpForm = {};
    pageElement.popup = {};
    pageElement.popup.popup = $('#popup');
    pageElement.popup.modelContent = $('#modelContent');
        
    pageElement.signUpForm.form = $('#signUpForm');
    

        
    pageElement.signUpForm.saveDraftBtn = $('#saveDraftBtn');
    pageElement.signUpForm.signUpDealershipBttn = $('#signUpDealershipBttn');
    pageElement.signUpForm.letGoSettingsContainer = $('.letGoSettingsContainer');
    pageElement.signUpForm.fbMarketPlaceServiceFieldsContainer = $('.fbMarketPlaceServiceFieldsContainer');
    pageElement.signUpForm.fbAdsServiceFieldsContainer = $('.fbAdsServiceFieldsContainer');
    pageElement.signUpForm.semServiceContainer = $('.semServiceContainer');
    pageElement.signUpForm.seoServiceContainer = $('.seoServiceContainer');
    pageElement.signUpForm.offerUpServiceContainer = $('.offerUpServiceContainer');
    
    pageElement.signUpForm.hideForSpecialSignup = $('.hideForSpecialSignup');
    pageElement.signUpForm.title = $('#dealershipName');
    pageElement.signUpForm.dealershipWebsite = $('#dealershipWebsite');
    pageElement.signUpForm.dealershipContactName = $('#dealershipContactName');
    pageElement.signUpForm.accountsNotes = $('#accountsNotes');
    pageElement.signUpForm.inventoryFilters = $('#inventoryFilters');
    pageElement.signUpForm.postingPriority = $('#postingPriority');
    pageElement.signUpForm.dealershipContactPhone = $('#dealershipContactPhone');    
    pageElement.signUpForm.dealershipContactEmail = $('#dealershipContactEmail');
    pageElement.signUpForm.inventoryFeedVendor = $('#inventoryFeedVendor');

    pageElement.signUpForm.services = {};
    pageElement.signUpForm.services.craigslistService = $('#craigslistService');
    pageElement.signUpForm.services.facebookCatalogService = $('#facebookCatalogService');
    pageElement.signUpForm.services.facebookMarketPlaceService = $('#facebookMarketPlaceService');
    pageElement.signUpForm.services.letGoService = $('#letGoService');
    pageElement.signUpForm.services.offerUpService = $('#offerUpService');
    pageElement.signUpForm.services.ampMicrositeService = $('#ampMicrositeService');
    pageElement.signUpForm.services.chatHubService = $('#chatHubService');
    pageElement.signUpForm.services.carboService = $('#carboService');
    pageElement.signUpForm.services.leadsPortalService = $('#leadsPortalService');
    pageElement.signUpForm.services.spanishService = $('#spanishService');    
    pageElement.signUpForm.services.facebookAdsService = $('#facebookAdsService');
    pageElement.signUpForm.services.semService = $('#semService');
    pageElement.signUpForm.services.seoService = $('#seoService');
    
    pageElement.signUpForm.fbMediaSpendField = $("#fbMediaSpendField");
    pageElement.signUpForm.semMediaSpendField = $("#semMediaSpendField");
    pageElement.signUpForm.fbmktServiceCheckBoxField = $('.fbmktServiceCheckBoxField');
    pageElement.signUpForm.seoKeywordField = $("#seoKeywordField");
    pageElement.signUpForm.fbBudgetInstructionField = $("#fbBudgetInstructionField");
    pageElement.signUpForm.semBudgetInstructionFeild = $("#semBudgetInstructionFeild");
    
    pageElement.signUpForm.facebookURL = $('#facebookURL');
    pageElement.signUpForm.monthlyPostingBudget = $('#monthlyPostingBudget');
    pageElement.signUpForm.accountManagerName = $('#accountManagerName');
    pageElement.signUpForm.accountManagerEmail = $('#accountManagerEmail');
    pageElement.signUpForm.desiredPostingRegion = $('#desiredPostingRegion');
    pageElement.signUpForm.postingConditions = $('#postingConditions');
    pageElement.signUpForm.priceStrategy = $('#priceStrategy');
    pageElement.signUpForm.offerUpPackage = $('#offerUpPackage');
    pageElement.signUpForm.letGoTierSelection = $('#letGoTierSelection');
    pageElement.signUpForm.specialTierSelection = $('#specialTierSelection');
    pageElement.signUpForm.starndardLoanTerm = $('#starndardLoanTerm');
    pageElement.signUpForm.showOfferupTierPrices = $('#showOfferupTierPrices');
    
    pageElement.signUpForm.goLiveDate = $('#goLiveDate');
    pageElement.signUpForm.serviceLevel = $('#serviceLevel');
    pageElement.signUpForm.receivingNumber = $('#receivingNumber');
    pageElement.signUpForm.mobileTextingAndChat = $('#mobileTextingAndChat');
    pageElement.signUpForm.mobileTextingNormalChat = $('#mobileTextingNormalChat');
    pageElement.signUpForm.leadsEmail = $('#leadsEmail');    
    pageElement.signUpForm.CRMEmail = $('#CRMEmail');
    pageElement.signUpForm.CRMVendor = $('#CRMVendor');
    pageElement.signUpForm.deleteSoldUnits = $('#deleteSoldUnits');
    
    pageElement.signUpForm.agencyName = $('#agencyName');
    pageElement.signUpForm.salesRep = $('#salesRep');
    pageElement.signUpForm.salesRepPhone = $('#salesRepPhone');
    pageElement.signUpForm.salesRepEmail = $('#salesRepEmail');
    pageElement.signUpForm.additionalEmail = $('#additionalEmail');
    pageElement.signUpForm.publication = $('#publication');
    
    pageElement.signUpForm.addAnotherReceivingNumberBtn = $('#addAnotherReceivingNumberBtn');
    pageElement.signUpForm.addAnotherLeadsEmailBtn = $('#addAnotherLeadsEmailBtn');
    pageElement.signUpForm.addAnotherMobileTextingAndChatBtn = $('#addAnotherMobileTextingAndChatBtn');
    pageElement.signUpForm.addAnotherMobileTextingAndNormalChatBtn = $('#addAnotherMobileTextingAndNormalChatBtn');
    pageElement.signUpForm.addAnotherCRMEmailBtn = $('#addAnotherCRMEmailBtn');
    pageElement.signUpForm.addAnotherAdditionalEmailBtn = $('#addAnotherAdditionalEmailBtn');
}

function sendRequestForSignUpDealership(){

    pageElement.signUpForm.form.find('.fieldErrorMsg').html('').hide();

    if(!validateFormData()){
        return false;
    }

    if( $('#dealerId').val() == '' || $('#dealerId').val() <= 0 ) {

        pageElement.popup.modelContent.html('Something went wrong while submitting form. Please contact customer support.');
        pageElement.popup.popup.modal('open');
        return false;
	    
    }

	dealershipName = $('#dealershipName').val();
	dealershipContactPhone = $('#dealershipContactPhone').val();
    dealershipContactEmail = $('#dealershipContactEmail').val();
	
	// Dealerships Information 
	dealershipInfomationName = $('#dealershipInfomationName').val();
	dealershipInformationContactPhone = $('#dealershipInformationContactPhone').val();
    dealershipInformationContactAddress = $('#dealershipInformationContactAddress').val();
    dealershipInformationWebsiteURL = $('#dealershipInformationWebsiteURL').val();


	var param = {
        'title' : 'Dealer Onboarding Form'
    };

    //dealerId
    param['dealerId'] = $('#dealerId').val();
	
	//-----------------Dealership Contact Information---------------------------
	if(dealershipInfomationName != null){
	    if(dealershipInfomationName.length > 0){
	        param['dealershipInfomationName'] = [dealershipInfomationName];
	    }
    }
	
    if(dealershipInformationContactPhone != null){
	    if(dealershipInformationContactPhone.length > 0){
	        param['dealershipInformationContactPhone'] = [dealershipInformationContactPhone];
	    }
    }
    if(dealershipInformationContactAddress != null){
	    if(dealershipInformationContactAddress.length > 0){
	        param['dealershipInformationContactAddress'] = [dealershipInformationContactAddress];
	    }
    }
	
	if(dealershipInformationWebsiteURL != null){
	    if(dealershipInformationWebsiteURL.length > 0){
	        param['dealershipInformationWebsiteURL'] = [dealershipInformationWebsiteURL];
	    }
    }
	
	//-----------------Dealer Contact Information---------------------------
	if(dealershipName != null){
	    if(dealershipName.length > 0){
	        param['dealership-Name'] = [dealershipName];
	    }
    }
	
    if(dealershipContactPhone != null){
	    if(dealershipContactPhone.length > 0){
	        param['dealership-contact-phone'] = [dealershipContactPhone];
	    }
    }
    if(dealershipContactEmail != null){
	    if(dealershipContactEmail.length > 0){
	        param['dealership-contact-email'] = [dealershipContactEmail];
	    }
    }
	//-------------------Billing Contact Information-------------------------
	billingName = $('#billingName').val();
    billingContactPhone = $('#billingContactPhone').val();
    billingContactEmail = $('#billingContactEmail').val();
	
	if(billingName != null){
	    if(billingName.length > 0){
	        param['billing-Name'] = [billingName];
	    }
    }
	
	if(billingContactPhone != null){
	    if(billingContactPhone.length > 0){
	        param['billing-Contact-Phone'] = [billingContactPhone];
	    }
    }
	
	if(billingContactEmail != null){
	    if(billingContactEmail.length > 0){
	        param['billing-Contact-Email'] = [billingContactEmail];
	    }
    }
	//----------------Lead Routing----------------------------
	CRMEmail = $('#CRMEmail').val();
    additionalEmailAddress = $('#additionalEmailAddress').val();
    CRM_User_Name = $('#CRM_User_Name').val();
	
	if(CRMEmail != null){
	    if(CRMEmail.length > 0){
	        param['CRM-Email-Address'] = [CRMEmail];
	    }
    }
	
	if(additionalEmailAddress != null){
	    if(additionalEmailAddress.length > 0){
	        param['additional-Email-Address'] = [additionalEmailAddress];
	    }
    }
	
	if(CRM_User_Name != null){
	    if(CRM_User_Name.length > 0){
	        param['CRM_User_Name'] = [CRM_User_Name];
	    }
    }
	var dontuse = "Yes,does not use.";
	if($('#does-not-use-CRM').is(':checked')){
        param['does-not-use-CRM'] = [dontuse];
	}
	
	
    //------------------Inventory Information--------------------------
	
	InventoryFeedProvider = $('#InventoryFeedProvider').val();
	
	if(InventoryFeedProvider != null){
	    if(InventoryFeedProvider.length > 0){
	        param['Inventory-Feed-Provider'] = [InventoryFeedProvider];
	    }
    }
	
	var InventorytoPostFieldVal = "";      
    $.each($(".InventorytoPostField:checked"), function()
    {
    	InventorytoPostFieldVal =$(this).val();   //Store the selected checkbox value in a variable.
    });	
	param['Inventory-to-Post'] = [InventorytoPostFieldVal];
	
	//-------------------------Lead App User----------------------------------------
	
	adminLeadName = $('#adminLeadName').val();
    LeadContactEmail = $('#LeadContactEmail').val();
    LeadContactPhone = $('#LeadContactPhone').val();
	
	if(adminLeadName != null){
	    if(adminLeadName.length > 0){
	        param['Lead Admin-Name'] = [adminLeadName];
	    }
    }
	
	if(LeadContactEmail != null){
	    if(LeadContactEmail.length > 0){
	        param['Lead-Contact-Email'] = [LeadContactEmail];
	    }
    }
	
	if(LeadContactPhone != null){
	    if(LeadContactPhone.length > 0){
	        param['Lead-Contact-Phone'] = [LeadContactPhone];
	    }
    }
	
	//-------------------------Lead App User----------------------------------------
	

    var salesPersonContainer = [];
	var nextSales = 1;
    $('.salespersonDiv').each(function(){
        var Salesperson = $('.Salesperson_'+nextSales).val();
        var leadsEmails = $('.leadsEmails_'+nextSales).val();
        var leadMobileNumber = $('.leadMobileNumber_'+nextSales).val();
		var salesArray = {"salesPersonName" : $.trim(Salesperson), "salesLeadEmail": $.trim(leadsEmails), "salesPhoneNumber": $.trim(leadMobileNumber)};
        //if(self.val() == '') return true;

        //salesPersonContainer.push({'type': 'work'});
        salesPersonContainer.push(salesArray);
		nextSales++;
    });
    
    if(salesPersonContainer.length > 0){
        param['Salesperson'] = salesPersonContainer;   
    }

	//-------------------------Craigslist Setup----------------------------------------
	
	craigslistName = $('#craigslistName').val();
    craigName = $('#craigName').val();
  
	
	if(craigslistName != null){
	    if(craigslistName.length > 0){
	        param['Contact-Person-Name'] = [craigslistName];
	    }
    }
	
	if(craigName != null){
	    if(craigName.length > 0){
	        param['craigslist-Ring-for-Leads'] = [craigName];
	    }
    }
	
	/* var  param['craigslistAreaAndSubArea'] = [];
	var nextMarket = 1; */
    /* $('.marketDiv').each(function(){
		var marketName = $('.marketName_'+nextMarket).val();
        var subMarket = $('.subMarket_'+nextMarket).val();
        var monthlyBudget = $('.monthlyBudget_'+nextMarket).val();
		var marketArray = [ $.trim(marketName), $.trim(subMarket), $.trim(monthlyBudget)];
        //if(self.val() == '') return true;

        //marketNameContainer.push({'type': 'work'});
        marketNameContainer.push(marketArray);
		nextMarket++;
    }); */
	
	/* if(marketNameContainer.length > 0){
        param['craigslist-Market-Name'] = marketNameContainer;   
    } */
	
	var areaDetails = [];
	if( $('#areaSubAreDiv').length > 0 ) {
		
		$('[id^=cragislistAreas_]').each(function(){
			
			var rel = $(this).attr('rel');
            var areaId = $('#cragislistAreas_'+rel+' option:selected').val();

            if( areaId != 0 ) {

                var marketName = ($('#cragislistAreas_'+rel+' option:selected').text() == "Select Area" ? "" : $('#cragislistAreas_'+rel+' option:selected').text() );
                var subMarket = $('#cragislistSubAreas_'+rel+' option:selected').text();
                var subMarketId = $('#cragislistSubAreas_'+rel+' option:selected').val() !== undefined ? $('#cragislistSubAreas_'+rel+' option:selected').val() : 0;
                
                areaDetails.push({"areaId" : areaId , "areaName" : marketName, "subAreaId" : subMarketId, "subAreaName" : subMarket});
            }
			
		});
		
	}
	
	param['craigslist-Market-Name'] = areaDetails;
	
	//----------------------facebook---------------------
	if($('#facebookURL').val() != undefined && $('#facebookURL').val() != ''){
		facebookLink = appendHttpIfURLDoesNotHaveIt($('#facebookURL').val());
		
		if(facebookLink != null){
			if(facebookLink.length > 0){
				param['facebookLink'] = [facebookLink];
			}
		}
	}
	
	//-------------------------Website support provider-------------
	
	supportProviderName = $('#supportProviderName').val();
    supportProviderTelephone = $('#supportProviderTelephone').val();
    supportProviderEmail = $('#supportProviderEmail').val();
	
	if(supportProviderName != null){
	    if(supportProviderName.length > 0){
	        param['Support-Provider-Name'] = [supportProviderName];
	    }
    }
	
	if(supportProviderEmail != null){
	    if(supportProviderEmail.length > 0){
	        param['Support-Provider-Email'] = [supportProviderEmail];
	    }
    }
	
	if(supportProviderTelephone != null){
	    if(supportProviderTelephone.length > 0){
	        param['Support-Provider-Phone'] = [supportProviderTelephone];
	    }
    }
	
	if( $('#websiteUrlContainer').length > 0 ) {
		
		param['hostProviderWebsiteURL'] = [];
		
		$('[id^=dealerWebsiteURL_]').each(function(){
			
			var rel = $(this).attr('rel');
			param['hostProviderWebsiteURL'].push({"dealerWebsite" : $('#dealerWebsiteURL_'+rel).val()});
			
		});
		
	}
	
	if ( $('#hostingProviderWebsiteURL_1').length > 0 ) {
		
		param['hostWebsite'] = [$('#hostingProviderWebsiteURL_1').val()];
	}
	
	//-------------------------Website support provider-------------


    data = {};
    data.fields = param;

    $.post(wsUrl, data, function(res) {
      var response = $.parseJSON(res);
	   
        if(response.hasOwnProperty('status')){
			
            var msgContent;
            
            if(response.status == 'error'){
                msgContent = '<div class="errMsg">' + response.msg + '</div>';
            }
            
            if(response.status == 'success'){
                msgContent = 'Thankyou. Onboarding Form Submitted Successfully. <br>Stay Tuned. We will get back to you shortly';
                //resetForm();
            }
            
            pageElement.popup.modelContent.html(msgContent);
            pageElement.popup.popup.modal('open');
        } 
    });
}

function resetForm(){
    initPageData();
    
    var elems = ['dealershipInfomationName','dealershipInformationContactPhone','dealershipInformationContactAddress','dealershipInformationWebsiteURL','dealershipName','dealershipContactPhone','billingName','billingContactPhone','billingContactEmail','CRMEmail','CRM_User_Name','additionalEmailAddress','InventoryFeedProvider','adminLeadName','LeadContactEmail','LeadContactPhone','Salesperson','LeadEmail','leadMobileNumber','craigslistName','craigName','marketName','subMarket','monthlyBudget','facebookURL','supportProviderName','supportProviderTelephone','supportProviderEmail','hostingProviderWebsiteURL_1','dealerWebsiteURL_1','dealershipContactEmail'];
 
    for(var elem in elems){
        clearFormField($('#' + elems[elem]));
    }

    pageElement.signUpForm.form.find('.addAnotherLink').remove();
    $('.websiteHostURLContainer').empty();
	$('.marketSubbudgetContainer').empty();
    

    $('#InventorytoPostField').prop('checked', false);
	$('#does-not-use-CRM').prop('checked', false);
	$('#craigslistService').prop('checked', false);
	$('#letGoService').prop('checked', false);
	$('#facebookMarketPlaceService').prop('checked', false);
	
	//$("#cragislistAreas_0").select2("val", "0");
	//$("#cragislistAreas_0").trigger('change');

    specialSignupFormServiceSettings();
    
    /* setTimeout(function() {
        window.location.reload();
    }, 2000);	 */

}


function validateFormData(){
    var isValFailed = false,
	errField = pageElement.signUpForm.form.find('.fieldErrorMsg'), isScrollPointFound = false;
    

    if($('#dealershipInfomationName').val().length == 0){
        errField.filter('[data-frmid="dealershipInfomationName"]').show().html('Information required to continue');
        isValFailed = true;
    }
	
	if( $('#dealershipInformationContactPhone').length > 0 && $('#dealershipInformationContactPhone').val().length == 0){
        errField.filter('[data-frmid="dealershipInformationContactPhone"]').show().html('Information required to continue');
        isValFailed = true;
    }
	
	if( $('#dealershipInformationContactAddress').length > 0 && $('#dealershipInformationContactAddress').val().length == 0 ) {
		
		errField.filter('[data-frmid="dealershipInformationContactAddress"]').show().html('Information required to continue');
        isValFailed = true;
		
	}
	
	/*$('#dealershipInformationWebsiteURL').each(function(){
        var self = $(this);
        //if(self.val() == '') return false;
        
        var url = $.trim(self.val());
        if(!isUrlValid(url)){
            isValFailed = true;
            errField.filter('[data-frmid="'+ self.attr('id') +'"]').show().html('Invalid Website URL format, Website URL format should be https://www.example.com, http://www.example.com');
        }
    });*/
   
   if( $('#dealershipName').length > 0 &&  $('#dealershipName').val().length == 0){
        errField.filter('[data-frmid="dealershipName"]').show().html('Information required to continue');
        isValFailed = true;
    }
	
	if( $('#does-not-use-CRM').length > 0 ) {
		
		if( $('#does-not-use-CRM').is(':checked')){
				//$('.conditionalRequire').addClass('hide');
				isValFailed = false; 
		}else{
			if($('#CRMEmail').val().length > 0){
				if(!validateEmail($('#CRMEmail').val())){
					errField.filter('[data-frmid="CRM-email-address"]').show().html('Invalid email format, email format should be simple@example.com');
					isValFailed = true;
				}
			}
			
			if($('#CRMEmail').val().length == 0){
				errField.filter('[data-frmid="CRM-email-address"]').show().html('Information required to continue');
			isValFailed = true;
			}
			
			if($('#CRM_User_Name').val().length == 0){
				errField.filter('[data-frmid="CRM_User_Name"]').show().html('Information required to continue');
			isValFailed = true;
			}
		}
	}
	
    if( pageElement.signUpForm.dealershipContactPhone.length && pageElement.signUpForm.dealershipContactPhone.val() != null){
	    if(pageElement.signUpForm.dealershipContactPhone.val().length > 0){
	        if(!validatePhoneNumber(pageElement.signUpForm.dealershipContactPhone.val())){
	            errField.filter('[data-frmid="dealershipContactPhone"]').show().html('Invalid phone number');
	            isValFailed = true;            
	        }
	    }
    }
	if( $('#dealershipContactPhone').length > 0 && $('#dealershipContactPhone').val().length == 0){
        errField.filter('[data-frmid="dealershipContactPhone"]').show().html('Information required to continue');
        isValFailed = true;
    }
	if( $('#billingContactPhone').length > 0 && $('#billingContactPhone').val() != null){
	    if($('#billingContactPhone').val().length > 0){
	        if(!validatePhoneNumber($('#billingContactPhone').val())){
	            errField.filter('[data-frmid="billing-phoneNumber"]').show().html('Invalid phone number');
	            isValFailed = true;            
	        }
	    }
    }
    if( $('#billingContactPhone').length > 0 && $('#billingContactPhone').val().length == 0){
        errField.filter('[data-frmid="billing-phoneNumber"]').show().html('Information required to continue');
        isValFailed = true;
    }
	if( $('#dealershipContactEmail').length > 0 && $('#dealershipContactEmail').val().length == 0){
        errField.filter('[data-frmid="dealershipContactEmail"]').show().html('Information required to continue');
        isValFailed = true;
    }
	
	if( $('#dealershipContactEmail').length > 0 ) {
		
		$('#dealershipContactEmail').each(function(){
			var self = $(this);
			if(self.val() == '') return false;
			
			var email = $.trim(self.val());
			if(!validateEmail(email)){
				isValFailed = true;
				errField.filter('[data-frmid="'+ self.attr('id') +'"]').show().html('Invalid email format, email format should be simple@example.com');
			}
		});
	}
	
	if( $('#billingName').length > 0 && $('#billingName').val().length == 0){
        errField.filter('[data-frmid="billing-fullName"]').show().html('Information required to continue');
        isValFailed = true;
    }
	
	if( $('#billingContactPhone').length > 0 && $('#billingContactPhone').val().length == 0){
        errField.filter('[data-frmid="billing-phoneNumber"]').show().html('Information required to continue');
        isValFailed = true;
    }
	
	if( $('#billingContactPhone').length > 0){	
	
		$('#billingContactEmail').each(function(){
			var self = $(this);
			if(self.val() == '') return false;
			
			var email = $.trim(self.val());
			if(!validateEmail(email)){
				isValFailed = true;
				errField.filter('[data-frmid="'+ self.attr('id') +'"]').show().html('Invalid email format, email format should be simple@example.com');
			}
		});
	}
	
	if( $('#billingContactEmail').length > 0 && $('#billingContactEmail').val().length == 0){
        errField.filter('[data-frmid="billingContactEmail"]').show().html('Information required to continue');
        isValFailed = true;
    }
	
	
	
	if( $('#additionalEmailAddress').length && $('#additionalEmailAddress').val().length > 0){
        if(!validateEmail($('#additionalEmailAddress').val())){
            errField.filter('[data-frmid="additionalEmailAddress"]').show().html('Invalid email format, email format should be simple@example.com');
            isValFailed = true;
        }
    }
	
	if( $('#LeadContactEmail').length > 0 && $('#LeadContactEmail').val().length > 0){
        if(!validateEmail($('#LeadContactEmail').val())){
            errField.filter('[data-frmid="leadContactEmail"]').show().html('Invalid email format, email format should be simple@example.com');
            isValFailed = true;
        }
    }
	
	
	if( $('#supportProviderEmail').length && $('#supportProviderEmail').val().length > 0){
        if(!validateEmail($('#supportProviderEmail').val())){
            errField.filter('[data-frmid="supportProviderEmail"]').show().html('Invalid email format, email format should be simple@example.com');
            isValFailed = true;
        }
    }
	
	if( $('#supportProviderTelephone').length && $('#supportProviderTelephone').val().length > 0){
        if(!validatePhoneNumber($.trim($('#supportProviderTelephone').val()))){
            errField.filter('[data-frmid="supportProviderTelephone"]').show().html('Invalid phone number');
            isValFailed = true;
        }
    }
	
	if( $('#LeadContactPhone').length > 0 && $('#LeadContactPhone').val().length > 0){
        if(!validatePhoneNumber($.trim($('#LeadContactPhone').val()))){
            errField.filter('[data-frmid="leadContactPhone"]').show().html('Invalid phone number');
            isValFailed = true;
        }
    }
	
	if( $('.leadsEmails').length > 0) {
		
		$('.leadsEmails').each(function(){
			var self = $(this);
			if(self.val() == '') return false;
			
			var email = $.trim(self.val());
			errField.filter('[data-frmid="'+ self.attr('id') +'"]').hide();
			if(!validateEmail(email)){
				isValFailed = true;
				errField.filter('[data-frmid="'+ self.attr('id') +'"]').show().html('Invalid email format, email format should be simple@example.com');
			}
		});
	}
	
	/* if($('#LeadEmail').val().length > 0){

        var email = $.trim($('#LeadEmail').val());
        if(!validateEmail(email)){
            isValFailed = true;
            errField.filter('[data-frmid="LeadEmail"]').show().html('Invalid email format, email format should be simple@example.com');
        }
    } */
	
    if( $('.leadMobileNumber').length > 0) {
		
		$('.leadMobileNumber').each(function(){
			var self = $(this);
			if(self.val() == '') return false;
			
			var leadMobileNumber = self.val();
			errField.filter('[data-frmid="'+ self.attr('id') +'"]').hide();
			 if(!validatePhoneNumber($.trim(self.val()))){
				errField.filter('[data-frmid="'+ self.attr('id') +'"]').show().html('Invalid phone number');
				isValFailed = true;
			}
		});
	}

    /* if($('#leadMobileNumber').val().length > 0){
        if(!validatePhoneNumber($.trim($('#leadMobileNumber').val()))){
            errField.filter('[data-frmid="leadMobileNumber"]').show().html('Invalid phone number');
            isValFailed = true;
        }
    } */
	if($('#craigName').length && $('#craigName').val() != null){
	    if($('#craigName').val().length > 0){
	        if(!validatePhoneNumber($('#craigName').val())){
	            errField.filter('[data-frmid="craigName"]').show().html('Invalid phone number');
	            isValFailed = true;            
	        }
	    }
    }
	

	
	if( $('#salespersonDiv').length > 0  ) {
		for(var i = 2; i < 7 ;i++){
			var receivingNumberAdditionalButton = document.getElementById('leadMobileNumber_'+[i]);
			if(receivingNumberAdditionalButton){
				var receivingNumberAdditionalButtonValue = document.getElementById('leadMobileNumber_'+[i]).value.length;	
				if(receivingNumberAdditionalButtonValue == 0 ){
					errField.filter('[data-frmid="leadMobileNumber_'+[i]+'"]').show().html('Information required to continue');
					isValFailed = true;
				}
			}
		}
	}
    
 
    
    errField.each(function(){
        if(!isScrollPointFound){
            if($(this).text() != ''){
                $('html, body').animate({
                    scrollTop: $(this).offset().top - 100
                }, 2000);
                isScrollPointFound = true;
            } 
        }
    });
    
    return  isValFailed == false;
}

function validatePhoneNumber(number){
    var phone_pattern = /^\s*(?:\+?(\d{1,3}))?[-. (]*(\d{3})[-. )]*(\d{3})[-. ]*(\d{4})(?: *x(\d+))?\s*$/; 
    return phone_pattern.test(number);
}

function isUrlValid(url) {
	
    var url = $.trim(url); 
	var filter =/^(https?|s?ftp):\/\/(((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:)*@)?(((\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5])\.(\d|[1-9]\d|1\d\d|2[0-4]\d|25[0-5]))|((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?)(:\d*)?)(\/((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)+(\/(([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)*)*)?)?(\?((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|[\uE000-\uF8FF]|\/|\?)*)?(#((([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(%[\da-f]{2})|[!\$&'\(\)\*\+,;=]|:|@)|\/|\?)*)?$/i;
	
	if (url != '') {
		if (!filter.test(url)) {
			return false;
		} else {
			return true;
		}
	} else {
		return true;
	}
}

function validateEmail(email) {
    email = $.trim(email);
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}

function removeKeyIfValueIsNullOrEmpty(obj){
    for(var elem in obj){
        if(obj[elem] == '' || typeof obj[elem] == 'undefined' || obj[elem] == null){
            delete obj[elem];
        }
    }
    
    return obj;
}

function appendHttpIfURLDoesNotHaveIt(url){
	
    url = $.trim(url);
    var reg = /http:\/\/|https:\/\//;
    var pos = url.search(reg);
    if(pos == -1){
        url = 'http://' + url;
    }
    
    return url;
}

function initMaskForPhoneNumberFields() {
    var fieldList = $(document).find('.phoneNumberMask');
    var options = [{"mask": "(###) ###-####"}, {"mask": "(###) ###-####"}];
    fieldList.each(function () {
        $(this).inputmask({
            mask: options,
            greedy: false,
            definitions: {
                '#': {
                    validator: "[0-9]",
                    cardinality: 1
                }
            },
            showMaskOnHover: false
        });
    });
}

function initMaskForOnlyNumericValue(){
    var fieldList = $(document).find('.allowOnlyNumbericValue');

    fieldList.each(function () {
        $(this).inputmask("numeric", {
            radixPoint: ".",
            groupSeparator: ",",
            digits: 2,
            autoGroup: true,
            prefix: '$', //No Space, this will truncate the first character
            rightAlign: false,
            oncleared: function () { self.Value(''); }
        });
    });
}

function initMaskForOnlyNumericValueWithoutPrefix(){
    var fieldList = $(document).find('.allowOnlyNumbericValueWithoutPrefix');

    fieldList.each(function () {
        $(this).inputmask("numeric", {
            radixPoint: ".",
            groupSeparator: ",",
            digits: 2,
            autoGroup: true,
            rightAlign: false,
            oncleared: function () { self.Value(''); }
        });
    });
}

function initPageUIBlocker() {
    $(document).ajaxStart(function () {
        isAsyncProcessRunning = true;
        if (typeof showAsyncLoadingUI !== 'boolean' || showAsyncLoadingUI) {
            blockPage();
        }
    }).ajaxStop(function () {
        unblockPage();
        showAsyncLoadingUI = true;
        isAsyncProcessRunning = false;
    });
}

function blockPage() {
    $.blockUI(getBlockUIStyleObject());
}

function unblockPage() {
    $.unblockUI();
	
}
function remove(divId) {
	
   // console.log(divId);
	$('#'+divId).remove();
}

function getBlockUIStyleObject() {
    return {
        message: '<div class="preloader-wrapper big active"><div class="spinner-layer spinner-blue-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>',
        css: {
            border: 'none',
            padding: '15px',
            backgroundColor: 'transparent',
            '-webkit-border-radius': '10px',
            '-moz-border-radius': '10px',
            'border-radius': '10px',
            opacity: 1,
            color: '#fff'
        },
        baseZ: 20000
    };
}

function replaceJunkDataFromAmount(amount){
    amount = amount.replace (/,|\$/g, "");;
    
    return amount;
}

 function clearFormField(elem) {
    if(typeof elem !== 'undefined') {
        if(elem.hasClass('inputField')) {
            elem.val('');
            var label = elem.parent().find('label');
            if(label.length == 1) {
                setTimeout(function() {
                    label.removeClass('active');
                }, 50);
            }
        } else if(elem.hasClass('textareaField')) {
            if(elem.hasClass('editorTextBox')) {
                elem.html('');
            } else {
                elem.val('');
                var label = elem.parent().find('label');
                if(label.length == 1) {
                    setTimeout(function() {
                        label.removeClass('active');
                    }, 50);
                }
            }
        } else if(elem.hasClass('selectField')) {
            if(elem.hasClass('select2-offscreen')) {
                elem.select2('val', '');
            } else {
                elem.val('');
            }
        } else if(elem.hasClass('radioField') || elem.hasClass('checkboxField')) {
            elem.prop('checked', false);
        }
    }
}

$(document).on('change', "[id^=cragislistAreas_]", function() {
	
	var areaId = $(this).val();
	var rel = $(this).attr('rel');
	var subAreaHtml = "";
	
	$('.areaErr' ).css("display",  "none");
	
	$.post('webservice/getSubArea.php', {"areaId" : areaId}, function(res) {
		
      var response = $.parseJSON(res);
	   
        if( response['result']['response']  == "Success" ){
			
            var msgContent;
			
			if( response['result']['responseData'] != null && response['result']['responseData'] != '' ) {
				
				responseData =  response['result']['responseData'];
				
				for( var ind = 0; ind < responseData.length; ind++ ) {
					
					subAreaHtml += "<option value='"+responseData[ind]['id']+"'>"+responseData[ind]['description']+' - '+responseData[ind]['cl_sub_area']+"</option>";
					
				}
				
				$('#cragislistSubAreas_'+rel).html( subAreaHtml );
				$('#cragislistSubAreas_'+rel).trigger( 'change');
				
			} else {
				$('#cragislistSubAreas_'+rel).html( '' );
				$('#cragislistSubAreas_'+rel).trigger( 'change');
			}

        }else {
			$('#cragislistSubAreas_'+rel).html( '' );
		}
    });
	
});