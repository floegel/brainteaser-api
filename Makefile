.DEFAULT_GOAL := test

.PHONY: help clean setup setup-db reseed-db test unit-test html-coverage api-doc

dir = `pwd`

help:
	@echo "Please use \`make <target>' where <target> is one of"
	@echo "  help               display this help message"
	@echo "  clean              delete coverage reports"
	@echo "  setup              general project setup"
	@echo "  setup-db           setup database"
	@echo "  reseed-db          cleanup database and populate it with test data"
	@echo "  test               run integration-tests"
	@echo "  test-report        run integration-tests and generate report"
	@echo "  unit-test          run unit-tests"
	@echo "  unit-test-report   run unit-tests and generate coverage report"
	@echo "  api-doc            generate the api documentation"
	@echo ""

clean:
	rm -rf ${dir}/build

setup:
	@sh ${dir}/provision/setup.sh

test:
	${dir}/bin/behat --format=progress

test-ci:
	${dir}/bin/behat --profile=ci --format=progress

test-report:
	${dir}/bin/behat --format=progress --format=html
	@echo "Open build/html/behat/index.html"

unit-test:
	${dir}/bin/phpunit

unit-test-report:
	${dir}/vendor/phpunit/phpunit/phpunit --coverage-html=${dir}/build/html/phpunit
	@echo "Open build/html/phpunit/index.html"

setup-db:
	@sh ${dir}/provision/initDb.sh

reseed-db:
	@sh ${dir}/provision/reseedDb.sh

api-doc:
	@echo "Copy swagger files and config"
	@rm -rf ${dir}/web/api-doc
	@mkdir -p ${dir}/web/api-doc
	@cp -r ${dir}/vendor/swagger-api/swagger-ui/dist/* ${dir}/web/api-doc
	@cp ${dir}/swagger-config/api.yaml ${dir}/web/api-doc
	@sed -i 's/petstore.swagger.io\/v2\/swagger.json/192.168.50.7\/api-doc\/api.yaml/g' ${dir}/web/api-doc/index.html
	@sed -i 's/url: url,/url: url, validatorUrl: null,/g' ${dir}/web/api-doc/index.html
	@echo "Browse to http://192.168.50.7/api-doc/#/default"



