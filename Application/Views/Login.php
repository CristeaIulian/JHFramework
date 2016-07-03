<?php if (Core\Config::get('modules')['Http']) { Application\Services\HttpService::checkViewDirectAccess(); } ?>

<form action="<?php echo Core\Config::get('path.web'); ?>Login/Login" method="post">
	<input type="hidden" name="token" value="<?php echo $token; ?>" />
	<div class="boxFields">
		<div class="row">
			<div class="col-md-4"><h6>Login</h6></div>
		</div>
		<div class="row">
			<div class="row">
				<div class="col-md-4">Email</div>
				<div class="col-md-8"><input type="text" name="login_email" class="form-control" value="" /></div>
			</div>
			<div class="row">
				<div class="col-md-4">Password</div>
				<div class="col-md-8"><input type="password" name="login_password" class="form-control" value="" /></div>
			</div>
			<div class="row">
				<div class="col-md-4">&nbsp;</div>
				<div class="col-md-8"><input type="checkbox" name="keep_me_logged" id="keep_me_logged" /> <label for="keep_me_logged">keep me logged</label></div>
			</div>
			<div class="row">
				<div class="col-md-4">&nbsp;</div>
				<div class="col-md-8"><a href="<?php echo Core\Config::get('path.web'); ?>Index/PasswordLost">Password Lost</a></div>
			</div>
			<div class="row">
				<div class="col-md-4">&nbsp;</div>
				<div class="col-md-8"><input type="submit" value="Login" class="btn btn-success" /></div>
			</div>
		</div>
	</div>
</form>