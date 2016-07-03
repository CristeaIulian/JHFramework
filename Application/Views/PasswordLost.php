<?php if (Core\Config::get('modules')['Http']) { Application\Services\HttpService::checkViewDirectAccess(); } ?>

<form action="<?php echo Core\Config::get('path.web'); ?>Index/PasswordLostExec" id="PasswordLostForm" method="post" onsubmit="return check_password_lost_form();">
	<div class="boxFields">
		<div class="row">
			<div class="col-md-4"><h6>Login &raquo; Password Lost</h6></div>
		</div>
		<div class="row">
			<div class="row">
				<div class="col-md-4">Email:</div>
				<div class="col-md-8"><input type="text" name="password_lost_email" id="password_lost_email" class="form-control" value="" jrules="required|email" title="Email" /></div>
			</div>
			<div class="row">
				<div class="col-md-4">&nbsp;</div>
				<div class="col-md-8"><a href="<?php echo Core\Config::get('path.web'); ?>">Back to Login</a></div>
			</div>
			<div class="row">
				<div class="col-md-4">&nbsp;</div>
				<div class="col-md-8"><button type="submit" class="btn btn-success"><span class="fa fa-key"></span> Request new password</button></div>
			</div>
		</div>
	</div>
</form>