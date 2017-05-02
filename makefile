
PACKAGES = sunnyyii2

test:
	@export PATH=${PATH}:/usr/local/bin
	echo ${PATH}
	pwd
	ls -la
	ls -l php_demo/tests/codeception/api
	sudo ifconfig -a
	sudo cp -rf ./php_demo/tests/codeception/api/_bootstrap-dev.php ./php_demo/tests/codeception/api/_bootstrap.php
	sudo /home/travis/.phpenv/shims/php /usr/local/bin/codecept run unit models/UnitTest --config=./php_demo/tests/codeception/api/
