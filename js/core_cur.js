$(function(){
	
	/* Variables */
	let usrdata_IsDeclared = true;
	let intdata_IsDeclared = true;
	let demdata_IsDeclared = true;
	let prodata_IsDeclared = true;
	
	let g_hostUrl = null;
	let g_settings = "/assets/data/settings/settings_cur.json";
	let g_errors = "/assets/data/settings/errors_cur.json";
	
	let g_dataDir = null;
	let g_imageDir = null;
	
	
	let g_settingsData = null;
	let g_errorsData = null;
	
	let g_spinnerImage = null;
	
	/* DEBUG */
	let DEBUG = ($message, $context) => 
	{
		
		let date = atp_get_stamp();
		
		if($message && $context && atp_get_params("debug") == $context){
			
			console.log(date+" "+$context+": "+$message);
			
		}else if($message && $context && atp_get_params("debug") == 'all'){
			
			console.log(date+" "+$message);
			
		}
		
	};
	
	/* PROCESS */
	let atp_replace_text = (itext, robject) =>
	{
		if(itext && robject)
		{
			for (let key in robject)
            {
                if (robject.hasOwnProperty(key)) {
                    itext = itext.replace(key,robject[key]);
                }

            }
			
			return itext;
			
		} 
	}
	
	/* GETS */
	let atp_get_stamp = () => 
	{
		let d = new Date();
		let year = d.getUTCFullYear();
		let month = d.getUTCMonth();
		let day = d.getUTCDay();
		let hours = d.getHours()
		let minutes = d.getMinutes();
		let stamp = year.toString()+month.toString()+day.toString()+"["+hours.toString()+":"+minutes.toString()+"]";
		return stamp;
	};
	
	let atp_get_classid = ($name) => 
	{
		
		return $name ? "."+g_settingsData["application"]["classids"][$name] : null;
		
	};
	
	let atp_get_params = (sParam) => 
	{
		let sPageURL = window.location.search.substring(1);
		let sURLVariables = sPageURL.split('&');
		for (let i = 0; i < sURLVariables.length; i++){
			let sParameterName = sURLVariables[i].split('=');
			if (sParameterName[0] == sParam) 
			{
				return sParameterName[1];
			}
		}
	};
	
	/* SETS */
	let atp_set_focus_error = () =>
	{
		DEBUG("FOCUS-ERROR","process");
		$('.js--form').find('.js--input.error').first().focus();
		$('.js--form').find('.js--input.error').first().select();
	};
	
	let atp_set_image = (atext, aurl) =>
	{
		
		return '<img alt="'+atext+'" src="'+aurl+'"/>';
		
	};
	
	let atp_classes = (classlist) => 
	{
		
		DEBUG("CLASSES","submit-form");
		DEBUG("-- List: "+classlist,"submit-form");
		let classes = "";
		let clength = classlist.length;
        let sprefix = g_settingsData["application"]["classpre"] ? g_settingsData["application"]["classpre"] : false;
        let jprefix = g_settingsData["application"]["classpre"] ? g_settingsData["application"]["jspre"] : false;
		DEBUG("-- Length: "+clength+" | ClassPrefix: "+sprefix+" | JSPrefix: "+jprefix,"submit-form");
		

		if(classlist && clength > 0 && sprefix && jprefix)
		{

			for(let i = 0; i < clength; i++)
			{
				
				classes += sprefix+classlist[i];
				classes += " ";
				classes += jprefix+classlist[i];
				
				if(i<(clength-1))
				{
					classes += " ";
				}
				
			}
			DEBUG("-- classes: "+classes);
			return classes;
	
		}

	};
	
	let atp_response = (response, codes) => 
	{
		
		DEBUG("    	  * RESPONSE","submit-form");
		
		if(response)
		{
			
			let r_array;
			let r_type;
			let r_array_length = 0;
			
			if(response.indexOf("|")>-1)
			{
				
				r_array = response.split("|");
				r_type = r_array[0];
				r_array_length = r_array.length;
				
			}
			else
			{
				
				r_type = response;
			
			}
			
			
			DEBUG("    	     -- Type: "+r_type,"submit-form");
			
			if(r_type == "sgn_success")
			{	
				
				let cUrl = location.href;
				let cHost = location.hostname;
				let cProto = "http";
				if(cUrl.indexOf("https")>-1){
					cProto = "https";
				}
				
				let rUrl = cProto+"://"+cHost+"/"+g_settingsData["application"]["session"]["redirects"]["loggedin"];
				DEBUG("    	     -- Redirect: "+rUrl,"submit-form");
				return rUrl;
				
			}
			else if(r_array && r_array_length > 0 && (r_type.indexOf("reg")>-1))
			{
				
				DEBUG("    	     -- Produce Response","submit-form");
				
				let e_styles = g_errorsData["styles"];
				let c_list = codes[r_type]||false;
				DEBUG("    	     -- Styles: "+e_styles+" | List: "+c_list,"submit-form");
				let mymssg = "";
				let r_mssg = "";
				
				r_type = r_type.split("_");
				
				if(c_list)
				{
					DEBUG("    	     -- Build Message","submit-form");
					for(let i = 0; i<c_list.length; i++)
					{
						DEBUG("    	          Insert "+i+"----------------------","submit-form");
						for (let key in c_list[i])
						{
							
							
							DEBUG("    	          Key: "+key,"submit-form");
							if (c_list[i].hasOwnProperty(key)) {
								
								let kValue = c_list[i][key];
								DEBUG("    	          Value: "+key,"submit-form");
								r_mssg += '<'+key+' class="'+atp_classes(e_styles[key])+'">';
								r_mssg += kValue;
								r_mssg += '</'+key+'>';

							}
							DEBUG("    	          ","submit-form");

						}
					}
					
					DEBUG("    	     -- Build Container","submit-form");
					let myclasses = ["response",r_type[0],r_type[1]];

					mymssg = '<div class="'+atp_classes(myclasses)+'">'+r_mssg+'</div>';
					
					DEBUG("    	     -- Return response","submit-form");
					return mymssg;
					
				}
				
			}
			
		}
		
	}
	
	
	/* FORMS */
	let atp_process_form = ($form, $button, name) =>
	{
		
		DEBUG("  - Process Form()","submit-form");
		
		if($form && $button && name)
		{
			
			let form_errors=[];
			let form_config = g_settingsData["application"]["forms"][name];
			DEBUG("    * Config: "+form_config,"submit-form");
			
			let iName;//--FNAME--
			let iEmail;//--EMAIL--
			let aEmail = g_settingsData["administrator"]["contact"]["email"]||false;
			DEBUG("    * Admin Email: "+aEmail,"submit-form");
			
			let form_url = form_config["action"];
			let form_name = $form.attr("name");
			let form_method = form_config["method"];
			DEBUG("    * Form Name: "+form_name+" | Form Url: "+form_url+" | Form Method: "+form_method,"submit-form");
			
			DEBUG("    * Process Form","submit-form");
			$form.find(atp_get_classid('input')).each(function()
			{
				DEBUG("      --------------------------","submit-form");
				let $input = $(this);
				let $field = $input.closest(atp_get_classid('field'));
				let $message = $field.find(atp_get_classid('message'))||false;
				let $example = $field.find(atp_get_classid('example'))||false;
				let field_label = $field.find(atp_get_classid('label')).text().replace(/[*:]/g,"")||false;
				let field_tag = $input.prop('tagName').toLowerCase()||false;
				let field_id = $input.attr('id') || false;
				let field_name = $input.attr('name')||$input.attr('id')||false;
				let field_req = $input.attr('required') ? true : false;
				let field_min = Number($input.attr('min'))||false;
				let field_max = Number($input.attr('max'))||false;
				let field_val = $input.val()||false;
				let field_length = field_val.length||false;
				let field_regex = g_settingsData["application"]["regex"].hasOwnProperty(field_name) ? eval(atob(g_settingsData["application"]["regex"][field_name])) : false;
				let field_error = false;
				let field_message_html = '<p class="error">--MSSG--</p>';
				let field_errors = g_errorsData[form_name]["validation"][field_name];
				let field_message = "";

				DEBUG("      Field Tag: "+field_tag+" | Field Id: "+field_id+" | Field Name: "+field_name+" | Field Value: "+field_val,"submit-form");
				DEBUG("      Field RegEx: "+field_regex, "submit-form");

				if(field_req && field_val=="")
				{

					field_error = true;
					field_message = field_errors["empty"];

				}
				else if(field_req && field_tag=="select" && field_val.indexOf('-- Select a')>-1)
				{

					field_error = true;
					field_message = field_errors["empty"];	

				}
				else if(field_req && field_min && (field_length < field_min))
				{
					field_error = true;
					field_message = field_errors["min"];

				}
				else if(field_req && field_max && (field_length > field_max))
				{

					field_error = true;
					field_message = field_errors["max"];

				}
				else if(field_req && field_name === "usr_eml" && field_regex && !field_val.match(field_regex))
				{

					field_error = true;
					field_message = field_errors["format"];

				}
				else if(field_req && field_name === "email_confirm" && field_val!=iEmail)
				{

					field_error = true;
					field_message = field_errors["nomatch"];

				}
				else if(field_req && field_name === "usr_phn" && field_regex && !field_val.match(field_regex))
				{

					field_error = true;
					if(field_val.indexOf("1")=="0")
					{

						field_message = field_errors["format"+"w1"];

					}
					else
					{

						field_message = field_errors["format"];

					}

				}
				else
				{

					field_error = false;
					$input.removeClass('error');
					$input.addClass('success');
					$message.html("");

				}

				if(field_error)
				{
					
					DEBUG("      ERROR", "submit-form");
					field_message = field_message.replace("--NAME--",field_label);
					field_message = field_message.replace("--MIN--",field_min);
					field_message = field_message.replace("--MAX--",field_max);
					DEBUG("      - Message: "+field_message, "submit-form");
					$input.removeClass('success');
					$input.removeClass('error');
					$input.addClass('error');
					field_message_html = field_message_html.replace("--MSSG--",field_message);
					$message.html(field_message_html);
					form_errors.push("true");

					if($example)
					{

						$example.hide();

					}
					
				}
				else
				{
					
					$input.removeClass('error');
					$input.removeClass('success');
					$input.addClass('success');
					
					DEBUG("      PASS", "submit-form");
					if(field_name === "usr_fnm")
					{
						DEBUG("      - set 'usr_fnm'", "submit-form");
						iName = field_val;

					}

					if(field_name === "usr_eml")
					{
						DEBUG("      - set 'usr_eml'", "submit-form");
						iEmail = field_val;

					}
					if($example){
						DEBUG("      - show example", "submit-form");
						$example.show();

					}
					
				}

			});
			
			DEBUG("    * Errors Check","submit-form");
			if(form_errors.indexOf("true")>-1)
			{
				
				DEBUG("    		-- Focus Error","submit-form");
				atp_set_focus_error();

			}
			else
			{
				DEBUG("    		-- NONE","submit-form");
				let send_data = $form.serialize() || false;
				let button_text = $button.html() || false;
				let return_codes = g_errorsData[form_name]["code"] || false;	
				let $component = $form.closest(atp_get_classid('component')) || false;

				if(send_data)
				{
					DEBUG("    * Ajax","submit-form");
					$.ajax(
					{
						url : form_url,
						type: form_method,
						data: send_data,
						beforeSend: function()
						{
							
							DEBUG("    	- Before","submit-form");
							if($button)
							{

								$button.html("");
								$button.html((g_spinnerImage)+" <span>Processing</span>");
								$button.attr('disabled','true');

							}

						}
					})	
					.done(function(response)
					{
						DEBUG("    	- Done","submit-form");
						if(response)
						{
							
							//DEBUG("    	  * Response","submit-form");
							
							let returned = atp_response(response, return_codes) || false;
							let replaceArray = new Object();
							replaceArray["--FNAME--"] = iName ? iName : false;
							replaceArray["--EMAIL--"] = iEmail ? iEmail : false;
							replaceArray["--ADEMAIL--"] = aEmail ? aEmail : false;
							
							returned = atp_replace_text(returned,replaceArray);

							if($button && button_text)
							{

								$button.html("");
								$button.html(button_text);
								$button.removeAttr('disabled');

							}

							if(name=="registration" && $component && returned)
							{
								
								DEBUG("    	  * Apply to Registration: "+returned,"submit-form");
								$form.hide();
								$component.append('<div class="returned">'+returned+'</div>');

							}
							
							if(name=="signin" && $component && returned)
							{
								
								if(returned.indexOf("://")>-1)
								{
									DEBUG("    	  * Redirect: "+returned,"submit-form");
									location.href = returned;
								}
								else
								{
									DEBUG("    	  * Apply to Signin: "+returned,"submit-form");
									$form.hide();
									$component.append('<div class="returned">'+returned+'</div>');
								}
							}

						}
						else
						{
							
							DEBUG("    	  * No Response","submit-form");
							
						}

					});

				}

			}
			
		}	
		
	};
	
	let atp_form_registration = (formObj, btnObj) => 
	{
		
		DEBUG("REGISTRATION","submit-form");
		
		let $form = formObj || false;
		let $button = btnObj || false;
		
		atp_process_form($form, $button, "registration");

	};
	
	let atp_form_signin = (formObj, btnObj) => 
	{
		DEBUG("SIGNIN","submit-form");
		
		let $form = formObj || false;
		let $button = btnObj || false;
		
		atp_process_form($form, $button, "signin");

	};
	
	let atp_form = (btnclick, btnname, btnform) => 
	{
		
		if(btnclick && btnname && btnform){
			
			DEBUG("DELEGATE FORM"+btnform,"interaction");
			
			let fName = btnform.attr("name");
			
			switch(fName){

				case "form_signin" :

					atp_form_signin(btnform,btnclick);

				break;
				
				case "form_registration" :

					atp_form_registration(btnform,btnclick);

				break;
			
			}
		
		}
		
	};
	
	/* PROFILE */
	let atp_set_profile = () =>
	{
		
		let $pForm = $(atp_get_classid("form")+'[name="form_profile"]');

		$.each(usr_data, function(key,value) {
            
			$pForm.find(atp_get_classid("input")).each(function(){
				let $input  = $(this);
				let $iField = $input.closest(atp_get_classid("field"));
				let _iName = $input.attr('name');
				let _iTag = ($input.prop('tagName')).toLowerCase();
				let _iType = $input.attr('type');
				
				if(_iName == key && value != null){
					
					//DEBUG("key: "+key+" | value: "+value,"process");
					DEBUG("Name: "+_iName+" | Tag: "+_iTag+" | Type: "+_iType,"process");
					if(_iTag === "input" && _iType === "text" || _iType === "phone" || _iType === "date")
					{
						$input.attr("value",value);
						$iField.addClass("prefilled");
						$input.attr("readonly");
						
						if(key.indexOf('eml')>-1 && value)
						{
							let $email_confirm = $pForm.find("#confirm").closest(atp_get_classid("field"));
							$email_confirm.remove();
						}
						
					}
					
				}
			});
			/*
            if($field && value)
            {
				
				DEBUG("Field: "+selector,"process");
                $fTag = $field.prop("tagName");
                $fType = $field.attr("type")||false;
				DEBUG("Tag: "+$fTag+" | type: "+$fType,"process");

            }
			*/

		});
	}
	
	/* INITIALIZE */
	let atp_set_focus = () =>
	{
		DEBUG("FOCUS","process");
		DEBUG("  - Field: "+$(atp_get_classid("form")).find(atp_get_classid("input")).first().attr("name"),"process");
		$(atp_get_classid("form")).find(atp_get_classid("input")).first().focus();
	
	};
	
	let atp_events = () => 
	{
		DEBUG("EVENTS","process");
		
		DEBUG("  - Buttons","process"); 
		$(atp_get_classid("button")).on('click',function(){
			event.preventDefault();
			let $btn = $(this);
			let $btnName = $btn.attr('name');
			let $btnForm = $btn.closest(atp_get_classid("form"));
			atp_form($btn,$btnName,$btnForm);
		});
		
		DEBUG("  - Tooltip","process"); 
		$(atp_get_classid("tooltip")).on('click',function(){
			event.preventDefault();
		});
		
		usrdata_IsDeclared ? atp_set_profile() : atp_set_focus();

	};
	
	let atp_images = () =>
	{
		
		if(g_imageDir){
			
			let url = g_imageDir+g_settingsData["application"]["image"]["spinner"]["url"];
			let alt = g_settingsData["application"]["image"]["spinner"]["alt"];
			g_spinnerImage = atp_set_image(alt,url);
			
			atp_events();
			
		}
		
	};
	
	let atp_get_errors = () => 
	{
		
		DEBUG("GET FILE[Errors]2","process");
		
		if(g_settingsData)
		{
			
			let url = g_hostUrl + g_errors;
			DEBUG("  - url: "+url,"process");
			$.ajax({
				'async': true,
				'url': url,
				'dataType': "json",
				'success': function(data) {
					DEBUG("    - LOADED","process");
					g_errorsData = data;
					atp_images();
				}
			});
			
		}

	};
	
	let atp_get_directories = () =>
	{
		
		DEBUG("GET DIRECTORIES","process");
		
		if(g_hostUrl){

			DEBUG("  - image","process");
			g_imageDir = g_hostUrl + "/" + g_settingsData["application"]["image"]["directory"];

			atp_get_errors();
			
		}	
		
	};
	
	let atp_get_settings = () => 
	{
		
		DEBUG("GET FILE[Settings]","process");
		
		try{ usr_data; }
		catch(e) 
		{
			if(e.name == "ReferenceError")
			{
				usrdata_IsDeclared = false;
			}
		}
		
		if(g_hostUrl && g_settings)
		{
			
			let url = g_hostUrl+g_settings;
			DEBUG("  - url: "+url,"process");
			$.ajax({
				'async': true,
				'url': url,
				'dataType': "json",
				'success': function(data) {
					DEBUG("    - LOADED","process");
					g_settingsData = data;
					atp_get_directories();
				}
			});
			
			
		}

	};
	
	let atp_get_host = () => 
	{
		
		let host = window.location.href;
		
		let path = window.location.pathname;
		let page = path.split("/").pop();
		
		host = host.replace("/"+page,'');
		
		let qIndex = host.indexOf("?");
		if(qIndex > -1)
		{
			host = host.substr(0,qIndex);
		}
		
		g_hostUrl = host;
		
		atp_get_settings();
		
	};
	
	atp_get_host();

});