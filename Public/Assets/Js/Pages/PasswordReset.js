var check_password_reset_form = function(){
	return $("#PasswordResetForm").jvalidate({result:'generateFieldAfter', scroll:true});
}

$('#password_reset').CheckPasswordStrength();