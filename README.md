# PiDeploy
========

[dead] Pi Php Deploy - deploy system php based

## build.json

```php
{
	"project" : {
		"config" : {
			"config.php" : "/src/inc/"
		},
		"css" : {
			"style.css" : "/src/css/"
		}
	}
}
```

## project tree

```bash
/ 					# <- pideploy root
/project/				# <- your project root
/project/src/ 				# <- your code here
/project/src/inc/ 			# <- config files
/project/src/inc/demo.config.php 	# <- demo config file
/project/src/inc/config.php 		# <- real config file
/project/src/css/ 			# <- sass files
```

## build

http://yourplace/BUILD/project

## responsive view

http://yourplace/VIEW/www.yourwebsite-subplace-

this call http://www.yourwebsite/subplace/ 
