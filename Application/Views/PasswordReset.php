<?php if (Core\Config::get('modules')['Http']) { Application\Services\HttpService::checkViewDirectAccess(); } ?>

<form action="<?php echo Core\Config::get('path.web'); ?>Index/PasswordResetExec/<?php echo $code; ?>" id="PasswordResetForm" method="post" onsubmit="return check_password_reset_form();">
	<div class="boxFields">
		<div class="row">
			<div class="col-md-4"><h6>Login &raquo; Password Reset</h6></div>
		</div>
		<div class="row">
			<div class="row">
				<div class="col-md-5">New Password:</div>
				<div class="col-md-7"><input type="password" name="password_reset" id="password_reset" class="form-control" value="" jrules="required|min:5|match:input[name=password_reset_repeat]" title="New Password" /></div>
			</div>
			<div class="row">
				<div class="col-md-5">Retype New Password:</div>
				<div class="col-md-7"><input type="password" name="password_reset_repeat" id="password_reset_repeat" class="form-control" value="" jrules="required|min:5|match:input[name=password_reset]" title="Retype New Password" /></div>
			</div>
			<div class="row">
				<div class="col-md-5">&nbsp;</div>
				<div class="col-md-7"><a href="<?php echo Core\Config::get('path.web'); ?>">Back to Login</a></div>
			</div>
			<div class="row">
				<div class="col-md-5">&nbsp;</div>
				<div class="col-md-7"><button type="submit" class="btn btn-success"><span class="fa fa-key"></span> Reset password</button></div>
			</div>
		</div>
	</div>
</form>