# JHFramework
Just another MVC framework.

# Requirements
	php >= 5.6
	Jasmine Unit Testing (optional in case you use it)
	SASS (optional in case you use it)

# Instalation
	Copy project to your working folder.

	Set writing permission to folders:

		/Temp
		/Public/UserData/*

	Set home directory to: "/Public" folder

	Setup configuration files in "/Config" for each environment.

	Setup routes in "/Config/Routes.php"

	Do not commit "Config/Config.php". Each server should have its own copy.

# Deploy
	Do not deploy the following:
		- /docs/*
		- /Public/JasmineUnitTest/*
		
# Documentation
See project documentation in "/docs/index.html"