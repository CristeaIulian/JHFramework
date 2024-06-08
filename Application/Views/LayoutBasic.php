<?php if (Core\Config::get('modules')['Http']) { Application\Services\HttpService::checkViewDirectAccess(); } ?>

<!DOCTYPE html>
<html lang="en-us">	
	<head>
		<title><?php echo Core\Config::get('application.name'); ?></title>

		<meta charset="utf-8">
		<meta name="description" content="">
		<meta name="author" content="">

		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo Core\Config::get('path.web'); ?>Assets/Resources/Bootstrap/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo Core\Config::get('path.web'); ?>Assets/Resources/Font-Awesome/4.6.3/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo Core\Config::get('path.web'); ?>Assets/Resources/JQuery/jvalidate-1.2.1/jvalidate-1.2.1.css"> 

		<?php echo $pageCss; ?>

		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo Core\Config::get('path.web'); ?>Assets/Css/material.min.css" /> 

		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo Core\Config::get('path.web'); ?>Assets/Css/styles.css" /> 

		<link rel="shortcut icon" href="<?php echo Core\Config::get('path.web'); ?>favicon.ico" type="image/x-icon">
		<link rel="icon" href="<?php echo Core\Config::get('path.web'); ?>favicon.ico" type="image/x-icon">

	</head>
	<body>
		<header id="header">
			<div id="logo-group">
				<span id="logo"> 
					<img src="<?php echo Core\Config::get('path.web'); ?>Assets/img/logo.png" />
				</span>
			</div>
		</header>
		<div id="main" role="main" style="margin:160px 220px 0px 220px;">
			<div id="content"><?php echo $pageContent; ?></div>

			<?php if (!empty($flashMessage)) { ?>
				<script type="text/javascript">
				var _message 		= '<?php echo $flashMessage; ?>';
				var _message_type 	= '<?php echo ($flashSuccess) ? 'success' : 'danger'; ?>';
				</script>
			<?php } ?>
		</div>
		<div class="page-footer">
			<div class="row">
				<div class="col-xs-12 col-sm-6">
					<span class="txt-color-white"><?php echo Core\Config::get('application.name') . ' ' . Core\Config::get('application.version') . ' &copy; ' . Core\Config::get('application.date'); ?></span>
				</div>
			</div>
		</div>

		<script type="text/javascript" src="<?php echo Core\Config::get('path.web'); ?>Assets/Resources/JQuery/jquery-3.7.1.min.js"></script>
		<script type="text/javascript" src="<?php echo Core\Config::get('path.web'); ?>Assets/Resources/JQuery/jquery-ui-1.13.3.custom/jquery-ui.min.js"></script>
		<script type="text/javascript" src="<?php echo Core\Config::get('path.web'); ?>Assets/Resources/Bootstrap/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo Core\Config::get('path.web'); ?>Assets/Resources/JQuery/CheckPasswordStrength.js"></script>
		<script type="text/javascript" src="<?php echo Core\Config::get('path.web'); ?>Assets/Resources/JQuery/jvalidate-1.2.1/jvalidate-1.2.1.js"></script>
		<script type="text/javascript" src="<?php echo Core\Config::get('path.web'); ?>Assets/Js/functions.js"></script>

		<?php echo $pageJs; ?>
	</body>
</html>