test:
	php -d "memory_limit=-1" vendor/bin/phpcbf --report=full --report-file=./report.txt -p ./src
