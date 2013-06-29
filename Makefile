build:
	 phplemon lib/SimpleView/Parser.y
	 ./view-compiler compile lib/SimpleView/Templates lib/SimpleView/Templates.php -N crodas\\SimpleView\\Templates
	 php cli.php phar 
