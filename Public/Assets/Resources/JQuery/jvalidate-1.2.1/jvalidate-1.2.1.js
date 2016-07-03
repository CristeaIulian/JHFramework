/*!
 * jQuery UI JValidate @VERSION 1.2.1
 *
 * Copyright 2012-2013, Iulian Cristea
 * Licensed under the Creative Commons.
 * http://www.memobit.ro
 *
 * Depends:
 
 *	jquery.js
 
 * 1.0
   FIRST VERSION
 
 * 1.1.1
   Improvements 
        - can use without options
        - return true if form is valid, false otherwise
    Bug Fixes:
        - fix issue setting as success submit buttons
        
 * 1.1.2
   Improvements 
        - validation for email_list
    Bug Fixes:
        - fix issues for textarea
        
 * 1.1.3
    Improvements
        - scroll to top of the first encountered error
 * 1.1.3.1
    Improvements
        - ignore empty jrules fields

 * 1.2
 	Improvements
 		- added language support (ro/en)
 * 1.2.1
 	Improvements
 		- moved translations inside the main plugin to avoid a secondary request to external language file
 		- bug fix for summary report
 *
 *
 
 */

jQuery.fn.jvalidate = function(options){
	
	var validate = function(obj, options){

        if (options == undefined){

            var options = new function(){
                this.result 	= "bootstrap";
                this.inline 	= true;
                this.summary 	= false;
                this.scroll 	= true;
            }
            
        } else {
            if (options.result == undefined){
                options.result = "bootstrap";
            }
            if (options.inline == undefined){
                options.inline = true;
            }
            if (options.summary == undefined){
                options.summary = false;
            }
            if (options.scroll == undefined){
                options.scroll = false;
            }
        }

   		var errors = [];
		
		if (options != undefined && options.result == 'generateFieldAfter'){
			$('.jerror').remove();
		}
		
		if (options != undefined && options.result == 'bootstrap'){
            $(obj).find('.control-group').each(function(){
                
                $(this).find('input,textarea,select').each(function(){

                    switch ($(this).get(0).tagName){
                        case 'INPUT':
                            switch ($(this).attr('type')){
                                case 'submit':
                                case 'hidden':
                                // do nothing
                                break;
                                case 'text':
                                case 'checkbox':
                                case 'radio':
                                case 'password':
                        			$(this).parent().parent().removeClass('has-error').addClass('has-success');
                        			$(this).parent().parent().find('.help-inline').html('');
                                break;
                                default:
                                // do nothing
                                break;
                            }
                        break;
                        case 'TEXTAREA':
                			$(this).parent().parent().removeClass('has-error').addClass('has-success');
                			$(this).parent().parent().find('.help-inline').html('');
                        break;
                        case 'SELECT':
                			$(this).parent().parent().removeClass('has-error').addClass('has-success');
                			$(this).parent().parent().find('.help-inline').html('');
                        break;
                    }
                })
            })
		}
		
        var topError = 1000000;
        
		if (typeof jvalidateLang != 'object'){
			jvalidateLang = undefined;
		}
        		
		$(obj).find('input,select,textarea').each(function(){
			if ($(this).attr('jrules') != undefined){
				
				objectJRules = ($(this).attr('jrules')).split('|');
				
				errorFound = false;
				
				for (var i=0; i< objectJRules.length; i++){
					
					jvalue = '';
					
					if (objectJRules[i].indexOf(':') != -1){
						jrules = objectJRules[i].split(':');
						jrule = jrules[0];
						jvalue = jrules[1];
						
						if (jrule == 'time' || jrule == 'datetime' || jrule == 'regex'){
							firstSemicolon = (objectJRules[i]).indexOf(':') + 1;
							jvalue = (objectJRules[i]).substr(firstSemicolon, (objectJRules[i]).length - firstSemicolon);
						}
						
					} else {
						jrule = objectJRules[i];
					}
					
					var errorMessage = '';
					
					if ($(this).attr('title') != undefined){
						fieldLabel = $(this).attr('title');
					} else {
						fieldLabel = $(this).attr('name');
					}
					
					switch ($(this).get(0).tagName){
						case 'INPUT':
						case 'TEXTAREA':
							
							switch ($(this).attr('type')){
								case 'text':
								case 'password':
                                default:
                                    if ($(this).get(0).tagName == 'INPUT' && ($(this).attr('type') != 'text' && $(this).attr('type') != 'password')){
                                        console.log('Unknown object type '+$(this).attr('type'));
                                    }
                                
									switch(jrule){
										case 'required':
											if (!errorFound){
												if ($(this).val() == ''){
													errorMessage = ' ' + ((jvalidateLang != undefined) ? jvalidateLang.cannot_be_empty : 'cannot be empty') + '!';
													errors[errors.length] = fieldLabel + errorMessage;
													errorFound = true;
                                                    if ($(this).position().top < topError){
                                                        topError = $(this).position().top;
                                                    }
												}
											}
										break;
										case 'min':
											if (!errorFound && $(this).val()!=''){
												if (($(this).val()).length < jvalue){
													errorMessage = ' ' + ((jvalidateLang != undefined) ? jvalidateLang.cannot_be_smaller_than : 'cannot be smaller than') + ' ' + jvalue + ' ' + ((jvalidateLang != undefined) ? jvalidateLang.characters : 'characters') + '!';
													errors[errors.length] = fieldLabel + errorMessage;
													errorFound = true;
                                                    if ($(this).position().top < topError){
                                                        topError = $(this).position().top;
                                                    }
												}
											}
										break;
										case 'max':
											if (!errorFound && $(this).val()!=''){
												if (($(this).val()).length > jvalue){
													errorMessage = ' ' + ((jvalidateLang != undefined) ? jvalidateLang.cannot_be_higher_than : 'cannot be higher than') + ' ' + jvalue + ' ' + ((jvalidateLang != undefined) ? jvalidateLang.characters : 'characters') + '!';
													errors[errors.length] = fieldLabel + errorMessage;
													errorFound = true;
                                                    if ($(this).position().top < topError){
                                                        topError = $(this).position().top;
                                                    }
												}
											}
										break;
										case 'length':
											if (!errorFound && $(this).val()!=''){
												if (($(this).val()).length != jvalue){
													errorMessage = ' ' + ((jvalidateLang != undefined) ? jvalidateLang.must_have : 'must have') + ' ' + jvalue + ' ' + ((jvalidateLang != undefined) ? jvalidateLang.characters : 'characters') + '!';
													errors[errors.length] = fieldLabel + errorMessage;
													errorFound = true;
                                                    if ($(this).position().top < topError){
                                                        topError = $(this).position().top;
                                                    }
												}
											}
										break;
										case "email":
											if (!errorFound && $(this).val()!=''){
												filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

												if (!filter.test($(this).val())){
													errorMessage = ' ' + ((jvalidateLang != undefined) ? jvalidateLang.is_not_a_valid_email_address : 'is not a valid email address') + '!';
													errors[errors.length] = fieldLabel + errorMessage;
													errorFound = true;
                                                    if ($(this).position().top < topError){
                                                        topError = $(this).position().top;
                                                    }
												}
											}
										break;
                                        case "email_list":
											if (!errorFound && $(this).val()!=''){
												filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                                                
                                                emails = ($(this).val()).split(jvalue);
                                                
                                                var emailsErrorFound = [];
                                                
                                                for (var k = 0; k < emails.length; k++){
    												if (!filter.test($.trim(emails[k]))){
    												    emailsErrorFound[emailsErrorFound.length] = emails[k];
    												}
                                                }
                                                    
                                                if (emailsErrorFound.length > 0){
                                                	errorMessage = ' ' + ((jvalidateLang != undefined) ? jvalidateLang.contains_the_following_invalid_email_addresses : 'contains the following invalid email addresses') + ": <strong>'" + emailsErrorFound.join("', '") + "'</strong>";
													errors[errors.length] = fieldLabel + errorMessage;
													errorFound = true;
                                                    if ($(this).position().top < topError){
                                                        topError = $(this).position().top;
                                                    }
                                                }
											}
                                        break;
										case 'url':
											if (!errorFound && $(this).val()!=''){
												filter = /^(http|ftp|https):\/\/[\w\-_]+(\.[\w\-_]+)+([\w\-\.,@?^=%&amp;:/~\+#]*[\w\-\@?^=%&amp;/~\+#])?$/;

												if (!filter.test($(this).val())){
													errorMessage = ' ' + ((jvalidateLang != undefined) ? jvalidateLang.is_not_a_valid_web_address : 'is not a valid web address') + '!';
													errors[errors.length] = fieldLabel + errorMessage;
													errorFound = true;
                                                    if ($(this).position().top < topError){
                                                        topError = $(this).position().top;
                                                    }
												}
											}
										break;
										case 'cnp':
											if (!errorFound && $(this).val()!=''){
												if (($(this).val()).length != 13 || parseInt($(this).val()) != $(this).val()){
													errorMessage = ' ' + ((jvalidateLang != undefined) ? jvalidateLang.is_not_a_valid_cnp : 'is not a valid CNP') + '!';
													errors[errors.length] = fieldLabel + errorMessage;
													errorFound = true;
                                                    if ($(this).position().top < topError){
                                                        topError = $(this).position().top;
                                                    }
												}
											}
										break;
										case 'numeric':
											if (!errorFound && $(this).val()!=''){
												var pattern = /^-{0,1}\d*\.{0,1}\d+$/;
												if (!pattern.test($(this).val())){
													errorMessage = ' ' + ((jvalidateLang != undefined) ? jvalidateLang.must_be_numeric : 'must be numeric') + '!';
													errors[errors.length] = fieldLabel + errorMessage;
													errorFound = true;
                                                    if ($(this).position().top < topError){
                                                        topError = $(this).position().top;
                                                    }
												}
											}
										break;
										case 'match':
											if (!errorFound && $(this).val()!=''){
												if ($(this).val() != $(jvalue).val()){

													if ($(jvalue).attr('title') != undefined){
														fieldMatchLabel = $(jvalue).attr('title');
													} else {
														fieldMatchLabel = $(jvalue).attr('name');
													}

													errorMessage = ' ' + ((jvalidateLang != undefined) ? jvalidateLang.must_match : 'must match') + ' <strong>' + fieldMatchLabel + '</strong>!';
													errors[errors.length] = fieldLabel + errorMessage;
													errorFound = true;
                                                    if ($(this).position().top < topError){
                                                        topError = $(this).position().top;
                                                    }
												}
											}
										break;
										case 'list':
											if (!errorFound && $(this).val()!=''){

												found = false;
												
												for (var k = 1; k < jrules.length; k++){
													if (jrules[k] == $(this).val()){
														found = true;
													}
												}
												if (!found){
													errorMessage = ' ' + ((jvalidateLang != undefined) ? jvalidateLang.is_not_a_valid_text : 'is not a valid text') + '!';
													errors[errors.length] = fieldLabel + errorMessage;
													errorFound = true;
                                                    if ($(this).position().top < topError){
                                                        topError = $(this).position().top;
                                                    }
												}
											}
										break;
										case 'date':
											if (!errorFound && $(this).val()!=''){
												switch (jvalue){
													case '':
													case 'Y-m-d':
														filter = /^((19[0-9]{2})|(2[0-1]{1}[0-9]{2}))(\-)((0[1-9]{1})|(1[0-2]{1}))(\-)((0[1-9]{1})|([1-2]{1}[0-9]{1})|(3[0-1]{1}))$/;

														if (!filter.test($(this).val())){
															errorMessage = ' ' + ((jvalidateLang != undefined) ? jvalidateLang.is_not_a_valid_date : 'is not a valid date') + '!';
															errors[errors.length] = fieldLabel + errorMessage;
															errorFound = true;
                                                            if ($(this).position().top < topError){
                                                                topError = $(this).position().top;
                                                            }
														}
														
													break;
													default:
														console.log('Date format '+jvalue+' is unknown');
													break;
												}
											}
										break;
										case 'time':
											if (!errorFound && $(this).val()!=''){
												switch (jvalue){
													case '':
													case 'H:i:s':
														filter = /^(([0-1]{1}[0-9]{1})|(2[0-3]{1}))(\:)((0[0-9]{1})|([1-5]{1}[0-9]{1}))(\:)((0[0-9]{1})|([1-5]{1}[0-9]{1}))$/;

														if (!filter.test($(this).val())){
															errorMessage = ' ' + ((jvalidateLang != undefined) ? jvalidateLang.is_not_a_valid_time : 'is not a valid time') + '!';
															errors[errors.length] = fieldLabel + errorMessage;
															errorFound = true;
                                                            if ($(this).position().top < topError){
                                                                topError = $(this).position().top;
                                                            }
														}
													break;
													default:
														console.log('Time format '+jvalue+' is unknown');
													break;
												}
											}
										break;
										case 'datetime':
											if (!errorFound && $(this).val()!=''){
												switch (jvalue){
													case '':
													case 'Y-m-d H:i:s':
														filter = /^((19[0-9]{2})|(2[0-1]{1}[0-9]{2}))(\-)((0[1-9]{1})|(1[0-2]{1}))(\-)((0[1-9]{1})|([1-2]{1}[0-9]{1})|(3[0-1]{1})) (([0-1]{1}[0-9]{1})|(2[0-3]{1}))(\:)((0[0-9]{1})|([1-5]{1}[0-9]{1}))(\:)((0[0-9]{1})|([1-5]{1}[0-9]{1}))$/;

														if (!filter.test($(this).val())){
															errorMessage = ' ' + ((jvalidateLang != undefined) ? jvalidateLang.is_not_a_valid_date : 'is not a valid date') + '!';
															errors[errors.length] = fieldLabel + errorMessage;
															errorFound = true;
                                                            if ($(this).position().top < topError){
                                                                topError = $(this).position().top;
                                                            }
														}
													break;
													default:
														console.log('Datetime format '+jvalue+' is unknown');
													break;
												}
											}
										break;
										case 'regex':
											if (!errorFound && $(this).val()!=''){
												var filter=new RegExp(jvalue);

												if (!filter.test($(this).val())){
													errorMessage = ' ' + ((jvalidateLang != undefined) ? jvalidateLang.is_not_valid : 'is not valid') + '!';
													errors[errors.length] = fieldLabel + errorMessage;
													errorFound = true;
                                                    if ($(this).position().top < topError){
                                                        topError = $(this).position().top;
                                                    }
												}
											}
										break;
										case 'unique':
											console.log('Rule not implemented. This requires a callback function to connect to server.');
										break;
										case '':
											// ignore empty one
										break;
										default:
											console.log('Rule unknwon');
										break;
									}
								break;
								case 'checkbox':
									switch (jrule){
										case 'required':
											if (!errorFound){
												if (!$(this).is(':checked')){
													errorMessage = ' ' + ((jvalidateLang != undefined) ? jvalidateLang.must_be_checked : 'must be checked') + '!';
													errors[errors.length] = fieldLabel + errorMessage;
													errorFound = true;
                                                    if ($(this).position().top < topError){
                                                        topError = $(this).position().top;
                                                    }
												}
											}
										break;
									}
								break;
								case 'radio':
									switch (jrule){
										case 'required':
											if (!errorFound){
												objName = $(this).attr('name');
												
												isChecked = false;
												
												$(obj).find('input[name='+objName+']').each(function(){
													
													if ($(this).is(':checked')){
														isChecked = true;
													}
												});
												
												if (!isChecked){
													errorMessage = ' ' + ((jvalidateLang != undefined) ? jvalidateLang.must_be_checked : 'must be checked') + '!';
													errors[errors.length] = fieldLabel + errorMessage;
													errorFound = true;
                                                    if ($(this).position().top < topError){
                                                        topError = $(this).position().top;
                                                    }
												}
											}
										break;
									}
								break;
							}
						break;
						case 'SELECT':
							switch (jrule){
								case 'required':
									if (!errorFound){
										if ($(this).val() == '' || $(this).val() == '0'){
											errorMessage = ' ' + ((jvalidateLang != undefined) ? jvalidateLang.must_be_selected : 'must be selected') + '!';
											errors[errors.length] = fieldLabel + errorMessage;
											errorFound = true;
                                            if ($(this).position().top < topError){
                                                topError = $(this).position().top;
                                            }
										}
									}
								break;
							}
						break;
					}
					
					if (errorMessage != ''){
						if (options != undefined && options.inline){
							switch (options != undefined && options.result){
								case 'alert':
									alert(fieldLabel + errorMessage);
								break;
								case 'generateFieldAfter':
									if ($(this).next().get(0) != undefined && $(this).next().get(0).tagName == 'LABEL'){
										$(this).next().after('<div class="jerror">' + ((jvalidateLang != undefined) ? jvalidateLang.the_field : 'The field') + ' ' + '<strong>'+fieldLabel + '</strong>' + errorMessage+'</div>');
									} else {
										$(this).after('<div class="jerror">' + ((jvalidateLang != undefined) ? jvalidateLang.the_field : 'The field') + ' ' + '<strong>'+fieldLabel + '</strong>' + errorMessage+'</div>');
									}
								break;
								case 'bootstrap':
									controlClass = $(this).parent().parent().attr('class');
									
									if (controlClass != undefined){
										if ( controlClass.indexOf('control-group') != -1 ){
											$(this).parent().parent().removeClass('has-success').addClass('has-error');
											$(this).parent().find('.help-inline').html(((jvalidateLang != undefined) ? jvalidateLang.the_field : 'The field') + ' <strong>' + fieldLabel + '</strong>' + errorMessage);
										}
									}
								break;
								case 'fieldAfter':
									if ($(this).next().get(0).tagName == 'LABEL'){
										$(this).next().next().html('<div class="jerror">' + ((jvalidateLang != undefined) ? jvalidateLang.the_field : 'The field') + ' <strong>'+fieldLabel + '</strong>' + errorMessage+'</div>');
									} else {
										$(this).next().html('<div class="jerror">' + ((jvalidateLang != undefined) ? jvalidateLang.the_field : 'The field') + '<strong>'+fieldLabel + '</strong>' + errorMessage+'</div>');
									}
								break;
								case 'specifiedField':
									console.log('Display type not implemented. Not quite used and a little bit complicated to implement');
								break;
								case 'modal':
									console.log('Display type not implemented. Usage probability too low.');
								break;
								default:
									console.log('display type unknwon');
								break;
							}
							
						}
					}
				}
			}
		});
		
		if (options != undefined && options.summary && errors.length > 0){
			alert(errors.join('\n'));
		}
        
        if (errors.length > 0){

            if (options.scroll){            
                $('html, body').animate({
                    scrollTop: topError
                }, 500);
            }
            
            return false;
        } else {
            return true;
        }
	};
	
	var init = function(language){
		
		switch (language){
			case 'en':
				this.jvalidateLang = jvalidateLangEN;
			break;
			case 'ro':
				this.jvalidateLang = jvalidateLangRO;
			break;
			default:
				console.log('Unssuported language.');
			break;
		}
	};
	
	var jvalidateLangEN = new function(){
	  this.the_field										= "The field";
	  this.cannot_be_empty 									= "cannot be empty";
	  this.cannot_be_smaller_than 							= "cannot be smaller than";
	  this.cannot_be_higher_than							= "cannot be higher than";
	  this.characters										= "characters";
	  this.must_have										= "must have";
	  this.is_not_a_valid_email_address						= "is not a valid email address";
	  this.contains_the_following_invalid_email_addresses 	= "contains the following invalid email addresses";
	  this.is_not_a_valid_web_address						= "is not a valid web address";
	  this.is_not_a_valid_cnp								= "is not a valid CNP";
	  this.must_be_numeric									= "must be numeric";
	  this.must_match										= "must match";
	  this.is_not_a_valid_text								= "is not a valid text";
	  this.is_not_a_valid_date								= "is not a valid date";
	  this.is_not_a_valid_time								= "is not a valid time";
	  this.is_not_valid										= "is not valid";
	  this.must_be_checked									= "must be checked";
	  this.must_be_selected									= "must be selected";
	};
	
	var jvalidateLangRO = new function(){
	  this.the_field										= "Câmpul";
	  this.cannot_be_empty 									= "nu poate fi gol";
	  this.cannot_be_smaller_than 							= "nu poate fi mai mic de";
	  this.cannot_be_higher_than							= "nu poate fi mai mare de";
	  this.characters										= "caractere";
	  this.must_have										= "trebuie sa aibă";
	  this.is_not_a_valid_email_address						= "nu este o adresă de email validă";
	  this.contains_the_following_invalid_email_addresses 	= "conține următoarele adrese de email invalide";
	  this.is_not_a_valid_web_address						= "nu este o adresă web validă";
	  this.is_not_a_valid_cnp								= "nu este un CNP valid";
	  this.must_be_numeric									= "trebuie să fie numeric";
	  this.must_match										= "trebuie să se potrivească cu";
	  this.is_not_a_valid_text								= "nu este un text valid";
	  this.is_not_a_valid_date								= "nu este o dată validă";
	  this.is_not_a_valid_time								= "nu este o oră validă";
	  this.is_not_valid										= "nu este valid";
	  this.must_be_checked									= "trebuie să fie bifat";
	  this.must_be_selected									= "trebuie să fie selectat";
	};
	
	
	if (options != undefined && options.setLanguage != undefined){
		init(options.setLanguage);
	} else {
		return validate(this, options);
	}
	
};