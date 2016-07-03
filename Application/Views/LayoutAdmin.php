<?php if (Core\Config::get('modules')['Http']) { Application\Services\HttpService::checkViewDirectAccess(); } ?>

<!DOCTYPE html>
<html lang="en-us">	
	<head>
		<title><?php echo Core\Config::get('application.name'); ?></title>

		<meta charset="utf-8" />
		<meta name="description" content="" />
		<meta name="author" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo Core\Config::get('path.web'); ?>Assets/Resources/Bootstrap/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo Core\Config::get('path.web'); ?>Assets/Resources/Bootstrap/Toggle/bootstrap-toggle.min.css" />
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo Core\Config::get('path.web'); ?>Assets/Resources/Font-Awesome/4.6.3/css/font-awesome.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo Core\Config::get('path.web'); ?>Assets/Resources/jquery/datetimepicker-master/jquery.datetimepicker.css"/ >
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo Core\Config::get('path.web'); ?>Assets/Resources/JQuery/jvalidate-1.2.1/jvalidate-1.2.1.css" /> 

		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" type="text/css" />
		<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" />
		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo Core\Config::get('path.web'); ?>Assets/Css/material.min.css" /> 

		<link rel="stylesheet" type="text/css" media="screen" href="<?php echo Core\Config::get('path.web'); ?>Assets/Css/styles.css" /> 

		<link rel="shortcut icon" href="<?php echo Core\Config::get('path.web'); ?>favicon.ico" type="image/x-icon" />
		<link rel="icon" href="<?php echo Core\Config::get('path.web'); ?>favicon.ico" type="image/x-icon" />

		<?php echo $pageCss; ?>

		<script type="text/javascript">
			var config = {
				env: 				'<?php echo Core\Application::environment(); ?>',
				basepath: 			'<?php echo Core\Config::get('path.local'); ?>',
				webpath: 			'<?php echo Core\Config::get('path.web'); ?>',
				webpath_prefix: 	'<?php echo Core\Config::get('path.web.prefix'); ?>',
				debug: 				<?php echo (Core\Config::get('debug')) ? 'true' : 'false'; ?>,
			};
		</script>
	</head>
	<body>
		<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
			<header class="mdl-layout__header">
				<div class="mdl-layout__header-row">
					<span class="mdl-layout-title"><?php echo $pageTitle; ?></span>
					<div class="mdl-layout-spacer"></div>
					<nav class="mdl-navigation mdl-layout--large-screen-only">
						<button id="user-menu-top-right" class="mdl-button mdl-js-button mdl-button--icon">
							<i class="material-icons">more_vert</i>
						</button>
						<ul class="mdl-menu mdl-menu--bottom-right mdl-js-menu mdl-js-ripple-effect" for="user-menu-top-right">
							<li class="mdl-menu__item">
								<?php echo $loggedUser['name']; ?> 
								<?php if (Core\Config::get('modules')['User']) { ?>
									(<?php echo Application\Services\UsersService::getUserTypes()[$loggedUser['user_type']]; ?>)
								<?php } ?>
							</li>
							<li class="mdl-menu__item" data-modal-opener="myProfile">
								<i class="material-icons">account_circle</i> Profile
							</li>
							<li class="mdl-menu__item" onclick="document.location='<?php echo Core\Config::get('path.web'); ?>Login/Logout';">
								<i class="material-icons">exit_to_app</i> Logout</a>
							</li>
						</ul>
					</nav>
				</div>
			</header>
			<div class="mdl-layout__drawer">
			<span class="mdl-layout-title"><?php echo $pageTitle; ?></span>
				<nav class="mdl-navigation">
					<a class="mdl-navigation__link" href="<?php echo Core\Config::get('path.web'); ?>Dashboard" title="Dashboard">
						<i class="material-icons <?php echo ($controllerName == 'Dashboard' && $actionName == 'Index') ? 'mdl-button--primary' : ''; ?>">home</i>
						Dashboard
					</a>

					<?php if (\Core\Config::get('modules')['AccessRight'] && \Application\Services\AccessRightsService::checkRights('Users', 'Index', true)) { ?>
						<a class="mdl-navigation__link" href="<?php echo Core\Config::get('path.web'); ?>Users">
							<i class="material-icons <?php echo ($controllerName == 'Users' && $actionName == 'Index') ? 'mdl-button--primary' : ''; ?>">group</i>
							Users
						</a>
					<?php } ?>

					<?php if (\Core\Config::get('modules')['AccessRight'] && \Application\Services\AccessRightsService::checkRights('Logs', 'Index', true)) { ?>
						<a class="mdl-navigation__link" href="<?php echo Core\Config::get('path.web'); ?>Logs">
							<i class="material-icons <?php echo ($controllerName == 'Logs' && $actionName == 'Index') ? 'mdl-button--primary' : ''; ?>">assignment</i>
							Logs
						</a>
					<?php } ?>
				
					<?php if (\Core\Config::get('modules')['AccessRight'] && \Application\Services\AccessRightsService::checkRights('WhiteListIPs', 'Index', true)) { ?>
						<a class="mdl-navigation__link" href="<?php echo Core\Config::get('path.web'); ?>WhiteListIPs"> 
							<i class="material-icons <?php echo ($controllerName == 'WhiteListIPs' && $actionName == 'Index') ? 'mdl-button--primary' : ''; ?>">device_hub</i>
							WhiteList Ips
						</a>
					<?php } ?>

					<?php if (\Core\Config::get('modules')['AccessRight'] && \Application\Services\AccessRightsService::checkRights('AccessRights', 'Index', true)) { ?>
						<a class="mdl-navigation__link" href="<?php echo Core\Config::get('path.web'); ?>AccessRights">
							<i class="material-icons <?php echo ($controllerName == 'AccessRights' && $actionName == 'Index') ? 'mdl-button--primary' : ''; ?>">security</i>
							Access Rights
						</a>
					<?php } ?>

					<?php if (\Core\Config::get('modules')['AccessRight'] && \Application\Services\AccessRightsService::checkRights('Articles', 'Index', true)) { ?>
						<a class="mdl-navigation__link" href="<?php echo Core\Config::get('path.web'); ?>Articles">
							<i class="material-icons <?php echo ($controllerName == 'Articles' && $actionName == 'Index') ? 'mdl-button--primary' : ''; ?>">subtitles</i>
							Articles
						</a>
					<?php } ?>
				</nav>
			</div>
			<main class="mdl-layout__content">
				<div class="page-content">

					<div class="mdl-grid">
						<div class="mdl-cell mdl-cell--1-col"></div>
						<div class="mdl-cell mdl-cell--10-col" id="content">
							<?php echo $pageContent; ?>
						</div>
						<div class="mdl-cell mdl-cell--1-col"></div>
					</div>
				</div>
			</main>
		</div>


		<?php if (!empty($flashMessage)) { ?>
			<script type="text/javascript">
			var _message 		= '<?php echo $flashMessage; ?>';
			var _message_type 	= '<?php echo ($flashSuccess) ? 'success' : 'danger'; ?>';
			</script>
		<?php } ?>




		<script type="text/javascript" src="<?php echo Core\Config::get('path.web'); ?>Assets/Resources/JQuery/jquery-2.1.1.min.js"></script>
		<script type="text/javascript" src="<?php echo Core\Config::get('path.web'); ?>Assets/Resources/JQuery/jquery-ui-1.10.3.min.js"></script>
		<script type="text/javascript" src="<?php echo Core\Config::get('path.web'); ?>Assets/Resources/Bootstrap/bootstrap.min.js"></script>
		<script type="text/javascript" src="<?php echo Core\Config::get('path.web'); ?>Assets/Resources/Bootstrap/Toggle/bootstrap-toggle.min.js"></script>
		<script type="text/javascript" src="<?php echo Core\Config::get('path.web'); ?>Assets/Resources/JQuery/datetimepicker-master/build/jquery.datetimepicker.full.min.js"></script>
		<script type="text/javascript" src="<?php echo Core\Config::get('path.web'); ?>Assets/Resources/JQuery/CheckPasswordStrength.js"></script>
		<script type="text/javascript" src="<?php echo Core\Config::get('path.web'); ?>Assets/Resources/JQuery/jvalidate-1.2.1/jvalidate-1.2.1.js"></script>
		<script type="text/javascript" src="<?php echo Core\Config::get('path.web'); ?>Assets/Resources/tinymce/tinymce.min.js"></script>

		<script type="text/javascript" src="<?php echo Core\Config::get('path.web'); ?>Assets/Js/Services/ValidationService.js"></script>
		<script type="text/javascript" src="<?php echo Core\Config::get('path.web'); ?>Assets/Js/Services/AjaxService.js"></script>

		<script type="text/javascript" src="<?php echo Core\Config::get('path.web'); ?>Assets/Js/Components/NotifierComponent.js"></script>
		<script type="text/javascript" src="<?php echo Core\Config::get('path.web'); ?>Assets/Js/Components/PreloadComponent.js"></script>
		<script type="text/javascript" src="<?php echo Core\Config::get('path.web'); ?>Assets/Js/Components/ButtonOnOffComponent.js"></script>
		<script type="text/javascript" src="<?php echo Core\Config::get('path.web'); ?>Assets/Js/Components/ButtonDeleteComponent.js"></script>
		<script type="text/javascript" src="<?php echo Core\Config::get('path.web'); ?>Assets/Js/Components/TextboxEditorComponent.js"></script>
		<script type="text/javascript" src="<?php echo Core\Config::get('path.web'); ?>Assets/Js/Components/SelectComponent.js"></script>

		<script type="text/javascript" src="<?php echo Core\Config::get('path.web'); ?>Assets/Js/Controllers/BaseController.js"></script>
		<script type="text/javascript" src="<?php echo Core\Config::get('path.web'); ?>Assets/Js/Controllers/AccessRightsController.js"></script>
		<script type="text/javascript" src="<?php echo Core\Config::get('path.web'); ?>Assets/Js/Controllers/WhiteListIpsController.js"></script>
		<script type="text/javascript" src="<?php echo Core\Config::get('path.web'); ?>Assets/Js/Controllers/ArticlesController.js"></script>
		<script type="text/javascript" src="<?php echo Core\Config::get('path.web'); ?>Assets/Js/Controllers/DashboardController.js"></script>
		<script type="text/javascript" src="<?php echo Core\Config::get('path.web'); ?>Assets/Js/Controllers/LogsController.js"></script>
		<script type="text/javascript" src="<?php echo Core\Config::get('path.web'); ?>Assets/Js/Controllers/UsersController.js"></script>

		<script type="text/javascript" defer src="https://code.getmdl.io/1.1.3/material.min.js"></script>

		<script type="text/javascript" src="<?php echo Core\Config::get('path.web'); ?>Assets/Js/functions.js"></script>

		<?php echo $pageJs; ?>

		<dialog class="mdl-dialog" style="width:350px;" id="profileDialog">
			<h4 class="mdl-dialog__title">My Profile</h4>
			<div class="mdl-dialog__content">
				<p>
					<form action="" method="post">
						<div class="row">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<input class="mdl-textfield__input form-control" type="password" id="window_user_password" />
								<label class="mdl-textfield__label" for="window_user_password">Password</label>
							</div>
						</div>
						<div style="height:10px;"></div>
						<div class="row">
							<div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
								<input class="mdl-textfield__input form-control" type="password" id="window_user_password_repeat" />
								<label class="mdl-textfield__label" for="window_user_password_repeat">Repeat Password</label>
							</div>
						</div>
					</form>
				</p>
			</div>
			<div class="mdl-dialog__actions">
				<button type="button" class="mdl-button update">Update</button>
				<button type="button" class="mdl-button discard">Discard</button>
			</div>
		</dialog>

	</body>
</html>
<!-- <?php if (Core\Config::get('modules')['Benchmark']) { ?>Loading Time: <?php echo \Application\Services\BenchmarkService::test(); ?> seconds<?php } ?> -->