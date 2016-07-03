<?php

	namespace Core;

	if (file_exists(dirname(__FILE__) . '/ErrorHandlerService.php')) {
		require(dirname(__FILE__) . '/ErrorHandlerService.php');
	}

	require(dirname(__FILE__) . '/AutoLoad.php');

	switch (Application::environment()) {
		case 'development':
			ini_set('display_errors', 1);
			error_reporting(E_ALL);
		break;
		case 'staging':
			ini_set('display_errors', 1);
			error_reporting(E_ALL);
		break;
		case 'master':
		case 'production':
			ini_set('display_errors', 1);
			error_reporting(E_ALL);
		break;
	}

	if (Config::get('integrityCheck') && Config::get('modules')['Integrity']) {
		\Application\Services\IntegrityService::check();
	}

	if (Config::get('modules')['Benchmark']) {
		\Application\Services\BenchmarkService::start();
	}

	if (Config::get('modules')['WhiteListIP']) {
		\Application\Services\WhiteListIPService::checkIpIsWhiteListed();
	}

	require(dirname(__FILE__) . '/Route.php');