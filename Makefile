build:
	 phplemon lib/SimpleView/Parser.y
	 php cli.php compile lib/SimpleView/Templates lib/SimpleView/Templates.php -N crodas\\SimpleView\\Templates
phar: build
	 php cli.php phar 
