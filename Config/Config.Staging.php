<?php

return [
	'application.name' 				=> 'jH Framework',
	'application.version' 			=> '1.0.0',
	'application.date' 				=> '2016',
	
	'debug'							=> true,
	'debug.log.path'				=> 'Temp/app.log',
	
	'path.web'						=> 'http://framework/',
	'path.web.prefix'				=> '/',
	'path.local'					=> 'C:/_MYDRIVE/WEB/www/framework/public/',
	'path.protocol'					=> 'http',

	'db.type.default'				=> 'master',
	'db.types.master.hostname' 		=> '127.0.0.1',
	'db.types.master.username' 		=> 'root',
	'db.types.master.password' 		=> 'defcon30',
	'db.types.master.database' 		=> 'fw',
	'db.types.slave.hostname' 		=> '127.0.0.1',
	'db.types.slave.username' 		=> 'root',
	'db.types.slave.password' 		=> 'defcon30',
	'db.types.slave.database' 		=> 'fw',
	'db.charset'					=> 'utf8',
	'db.safe_changes' 				=> true, // protects against mass update/delete in queries
	
	'mail.host' 					=> 'mail.domain.com',
	'mail.username' 				=> 'address_name@domain.com',
	'mail.password' 				=> 'pass',
	'mail.port' 					=> 465,
	'mail.from' 					=> 'address_name@domain.com',
	
	'pager.recordsPerPageDefault' 	=> 50,
	'pager.recordsPerPage' 			=> [50, 100, 500, 1000],
	
	'modules' 						=> [
		'AccessRight' 	=> true,
		'Auth' 			=> true,
		'Benchmark' 	=> true,
		'Breadcrumb' 	=> true,
		'Cookie' 		=> true,
		'Dashboard' 	=> true,
		'Date' 			=> true,
		'Debug' 		=> true,
		'Error' 		=> true,
		'Filter' 		=> true,
		'Http' 			=> true,
		'Integrity' 	=> true,
		'Log' 			=> true,
		'Mail' 			=> true,
		'Pager' 		=> true,
		'Security' 		=> true,
		'Session' 		=> true,
		'String' 		=> true,
		'User' 			=> true,
		'WhiteListIP' 	=> true,
	],
	'integrityCheck' => true, // enable it to ensure all files integrity. For performance keep it disable if you know there are all the files
];