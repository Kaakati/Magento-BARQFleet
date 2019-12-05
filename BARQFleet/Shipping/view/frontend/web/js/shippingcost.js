require(['mage/url', 'jquery','domReady!' ,'jquery/ui'],function(url,$) {
	
	jQuery("#cashondelivery").prop('disabled', true);

	var country = 0;
	var city =0;
	var value =0;
	var i=0;
	var ch=0;

	jQuery(document).ready(function() {

	setTimeout(function() {   //calls click event after a certain time

		value = jQuery("[name='country_id']").val();
		console.log(value);
		if(value =='SA'){
			var city_id;
			jQuery('div[name="shippingAddress.custom_cities"]').show();
			jQuery('div[name="shippingAddress.city"]').hide();
			
			city_id=jQuery("[name='custom_cities']").val();
			console.log(city_id);			
			jQuery('input[name="city"]').val(city_id).change();			
			var linkUrl = url.build('barq/index/index');
			console.log(linkUrl);
			
			$.ajax({
				url: linkUrl,
				type: 'POST',
				dataType: 'json',
				data: {
					responsecity: city_id
				},
				complete: function(response) {             
					console.log('completed');
					console.log(response);
					if (response.responseJSON == null)
					{
						jQuery('#label_method_barq_barq').closest('.row').hide();
						

						jQuery('.radio').prop('checked', false);
						jQuery("input:radio[value=barq_barq]").attr('checked',false);
						jQuery("input:radio[value=barq_barq]").attr('disabled',true);
						jQuery("input:radio:first").prop("checked", true).trigger("click");


						if(jQuery("input:radio:first").val() == "barq_barq"){
							jQuery("#shipping-method-buttons-container").find(".button").hide();
						}
						else if(jQuery("input:radio:first").val() != "barq_barq"){
							jQuery("#shipping-method-buttons-container").find(".button").show();
						}	

						if(jQuery("#a").length == 0)
						{
							jQuery("#shipping-method-buttons-container").append("<p id=a></p>");
							jQuery("#a").text("BARQ doesn't operate here").show();
							jQuery("#a").css("color","red");
							// jQuery("#a").show();
							// jQuery("#a").hide();
						}else{
							jQuery("#a").text("BARQ doesn't operate here");
							jQuery("#a").css("color","red");
							jQuery("#a").show();
						}			
					}
					else if(response.responseJSON == 0)
					{
						if(jQuery("#a").length == 0)
						{
							jQuery("#shipping-method-buttons-container").append("<p id=a></p>");
							jQuery("#a").text("Module is currently disabled");
							jQuery("#a").css("color","red");
							jQuery("#a").show();
						}else{
							jQuery("#a").text("Module is currently disabled");
							jQuery("#a").css("color","red");
							jQuery("#a").show();
						}
					}
					else if (response.responseJSON != null && response.responseJSON != 0){
						jQuery('#label_method_barq_barq').closest('.row').show();
						jQuery("input:radio[value=barq_barq]").attr('disabled',false);
						jQuery("#shipping-method-buttons-container").find(".button").show();
						jQuery("#a").hide();
					}
					
				},
				error: function (xhr, status, errorThrown) {
					if(jQuery('#error').length == 0){
						jQuery("#checkout-shipping-method-load").append("<h5 id=error> BARQ Method is not available</h5>");
						jQuery("#error").css("color","red");
						jQuery("#error").show().delay(5000).fadeOut();
						jQuery("#error").hide();
					}
					else{
						jQuery("#error").show().delay(5000).fadeOut();
					}					
				}
			});
		}
		else{
			jQuery('div[name="shippingAddress.custom_cities"]').hide();
			jQuery('div[name="shippingAddress.city"]').show();
			jQuery('input[name="city"]').val('').change();
		}	
	}, 5000);
});

	jQuery(window).on('hashchange', function() {

		console.log(window.location.hash);
		if (window.location.hash == "#shipping")
		{
  			// console.log(document.URL.indexOf("#shipping"));
  			window.location.reload(true);
  		}
  		
  	});

	function hide(){
		setTimeout(function() {
			jQuery('#label_method_barq_barq').closest('.row').hide();
			jQuery('.radio').prop('checked', false);
			jQuery("input:radio[value=barq_barq]").attr('checked',false);
			jQuery("input:radio[value=barq_barq]").attr('disabled',true);
			jQuery("input:radio:first").prop("checked", true).trigger("click");	
		}, 3000);}

		jQuery(document).on('change',"[name='country_id']",function(){
			var country_id=jQuery(this).val();
			var value=jQuery(this).val();
			console.log(country_id);				
			jQuery("#a").hide();

			if(country_id=='SA'){
				var city_id;
				jQuery('div[name="shippingAddress.custom_cities"]').show();
				jQuery('div[name="shippingAddress.city"]').hide();

				city_id=jQuery("[name='custom_cities']").val();
				console.log(city_id);
				jQuery('input[name="city"]').val(city_id).change();

				var linkUrl = url.build('barq/index/index');
				console.log(linkUrl);
				$.ajax({
					url: linkUrl,
					type: 'POST',
					dataType: 'json',
					data: {
						responsecity: city_id
					},
					complete: function(response) {             
				// country = response.responseJSON.default_country;
				// var states = response.message;

				console.log('completed');
				// console.log(response);
				if (response.responseJSON == null)
				{
					hide();				

					if(jQuery("input:radio:first").val() == "barq_barq"){
						jQuery("#shipping-method-buttons-container").find(".button").hide();
					}
					else if(jQuery("input:radio:first").val() != "barq_barq"){
						jQuery("#shipping-method-buttons-container").find(".button").show();
					}	
					console.log(response.responseJSON);
					if(jQuery("#a").length == 0)
					{
						jQuery('#label_method_barq_barq').closest('.row').hide();
						jQuery("#shipping-method-buttons-container").append("<p id=a></p>");
						jQuery("#a").text("BARQ doesn't operate here").show();
						jQuery("#a").css("color","red");
						
						// jQuery("#a").hide();
					}else{
						jQuery('#label_method_barq_barq').closest('.row').hide();
						jQuery("#a").show();
					}

				}else if(response.responseJSON == 0)
				{
					if(jQuery("#a").length == 0)
					{
						jQuery("#shipping-method-buttons-container").append("<p id=a></p>");
						jQuery("#a").text("Module is currently disabled");
						jQuery("#a").css("color","red");
						jQuery("#a").show();
					}else{
						jQuery("#a").text("Module is currently disabled");
						jQuery("#a").css("color","red");
						jQuery("#a").show();
					}

				}
				else if (response.responseJSON != null && response.responseJSON != 0){
					jQuery('#label_method_barq_barq').closest('.row').show();
					jQuery("input:radio[value=barq_barq]").attr('disabled',false);
					jQuery("#shipping-method-buttons-container").find(".button").show();
					jQuery("#a").hide();
				}
				
			},
			error: function (xhr, status, errorThrown) {
				if(jQuery('#error').length == 0){
					jQuery("#checkout-shipping-method-load").append("<h5 id=error>BARQ Method is not available</h5>");
					jQuery("#error").css("color","red");
					jQuery("#error").show().delay(5000).fadeOut();
					jQuery("#error").hide();

				}
				else{
					jQuery("#error").show().delay(5000).fadeOut();
				}
			}
		});

			}
			else{
				jQuery('div[name="shippingAddress.custom_cities"]').hide();
				jQuery('div[name="shippingAddress.city"]').show();
				jQuery('input[name="city"]').val('').change();
			}


	// jQuery('#checkout-step-shipping_method').hide();
});

		jQuery(document).on('change',"[name='custom_cities']",function(){
			if (value == "SA"){
				city_id=jQuery("[name='custom_cities']").val();
				console.log(city_id);
				
				jQuery('input[name="city"]').val(city_id).change();

				
				var linkUrl = url.build('barq/index/index');
				console.log(linkUrl);

				
				$.ajax({
					url: linkUrl,
					type: 'POST',
					dataType: 'json',
					data: {
						responsecity: city_id
					},
					complete: function(response) {             
					// country = response.responseJSON.default_country;
					// var states = response.message;         
					console.log('completed');
					console.log(response);
					if (response.responseJSON == null)
					{
						jQuery('#label_method_barq_barq').closest('.row').hide();
						jQuery('.radio').prop('checked', false);
						jQuery("input:radio[value=barq_barq]").attr('checked',false);
						jQuery("input:radio[value=barq_barq]").attr('disabled',true);
						jQuery("input:radio:first").prop("checked", true).trigger("click");

						if(jQuery("input:radio:first").val() == "barq_barq"){
							jQuery("#shipping-method-buttons-container").find(".button").hide();
						}
						else if(jQuery("input:radio:first").val() != "barq_barq"){
							jQuery("#shipping-method-buttons-container").find(".button").show();
						}	

						if(jQuery("#a").length == 0)
						{
							jQuery("#shipping-method-buttons-container").append("<p id=a></p>");
							jQuery("#a").text("BARQ doesn't operate here").show();
							jQuery("#a").css("color","red");

							// jQuery("#a").show().delay(5000).fadeOut();
							// jQuery("#a").hide();
						}else{
							jQuery("#a").text("BARQ doesn't operate here").show();
						}
					}
					else if(response.responseJSON == 0)
					{
						if(jQuery("#a").length == 0)
						{
							jQuery("#shipping-method-buttons-container").append("<p id=a></p>");
							jQuery("#a").text("Module is currently disabled");
							jQuery("#a").css("color","red");
							jQuery("#a").show();
						}else{
							jQuery("#a").text("Module is currently disabled");
							jQuery("#a").css("color","red");
							jQuery("#a").show();
						}

					}
					else if (response.responseJSON != null && response.responseJSON != 0){
						jQuery('#label_method_barq_barq').closest('.row').show();
						jQuery("input:radio[value=barq_barq]").attr('disabled',false);
						jQuery("#shipping-method-buttons-container").find(".button").show();
						jQuery("#a").hide();
					}					 
				},
				error: function (xhr, status, errorThrown) {
					if(jQuery('#error').length == 0){
						jQuery("#checkout-shipping-method-load").append("<h5 id=error> BARQ Method is not available</h5>");
						jQuery("#error").css("color","red");
						jQuery("#error").show().delay(5000).fadeOut();
						jQuery("#error").hide();

					}
					else{
						jQuery("#error").show().delay(5000).fadeOut();
					}
				}
			});

			}});

		jQuery(document).on('click',"[name='city']",function(){

			value = jQuery("[name='country_id']").val();
			console.log(value);
			if(value =='SA'){
				var city_id;
				jQuery('div[name="shippingAddress.custom_cities"]').show();
				jQuery('div[name="shippingAddress.city"]').hide();
				jQuery(document).ready(function()
				{
					city_id=jQuery("[name='custom_cities']").val();
					console.log(city_id);			
					jQuery('input[name="city"]').val(city_id).change();			
					var linkUrl = url.build('barq/index/index');
					console.log(linkUrl);
					
					$.ajax({
						url: linkUrl,
						type: 'POST',
						dataType: 'json',
						data: {
							responsecity: city_id
						},
						complete: function(response) {             
							console.log('completed');
							console.log(response);
							if (response.responseJSON == null)
							{
								jQuery('#label_method_barq_barq').closest('.row').hide();
								jQuery('.radio').prop('checked', false);
								jQuery("input:radio[value=barq_barq]").attr('checked',false);
								jQuery("input:radio[value=barq_barq]").attr('disabled',true);
								jQuery("input:radio:first").prop("checked", true).trigger("click");

								if(jQuery("input:radio:first").val() == "barq_barq"){
									jQuery("#shipping-method-buttons-container").find(".button").hide();
								}
								else if(jQuery("input:radio:first").val() != "barq_barq"){
									jQuery("#shipping-method-buttons-container").find(".button").show();
								}	

								if(jQuery("#a").length == 0)
								{
									jQuery("#shipping-method-buttons-container").append("<p id=a></p>");
									jQuery("#a").text("BARQ doesn't operate here").show();
									jQuery("#a").css("color","red");
							// jQuery("#a").show().delay(5000).fadeOut();
							// jQuery("#a").hide();
						}else{
							jQuery("#a").text("BARQ doesn't operate here").show();
						}
						
					}
					else if(response.responseJSON == 0)
					{
						if(jQuery("#a").length == 0)
						{
							jQuery("#shipping-method-buttons-container").append("<p id=a></p>");
							jQuery("#a").text("Module is currently disabled");
							jQuery("#a").css("color","red");
							jQuery("#a").show();
						}else{
							jQuery("#a").text("Module is currently disabled");
							jQuery("#a").css("color","red");
							jQuery("#a").show();
						}
					}
					else if (response.responseJSON != null && response.responseJSON != 0){
						jQuery('#label_method_barq_barq').closest('.row').show();
						jQuery("input:radio[value=barq_barq]").attr('disabled',false);
						jQuery("#shipping-method-buttons-container").find(".button").show();
						jQuery("#a").hide();
					}
					
				},
				error: function (xhr, status, errorThrown) {
					if(jQuery('#error').length == 0){
						jQuery("#checkout-shipping-method-load").append("<h5 id=error>BARQ Method is not available</h5>");
						jQuery("#error").css("color","red");
						jQuery("#error").show().delay(5000).fadeOut();
						jQuery("#error").hide();
					}
					else{
						jQuery("#error").show().delay(5000).fadeOut();
					}
				}
			});
				});	
			}
			else{
				jQuery('div[name="shippingAddress.custom_cities"]').hide();
				jQuery('div[name="shippingAddress.city"]').show();
				jQuery('input[name="city"]').val('').change();
			}	
		});


	});


