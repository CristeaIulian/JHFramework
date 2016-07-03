var check_password_lost_form = function(){
	return $("#PasswordLostForm").jvalidate({result:'generateFieldAfter', scroll:true});
}