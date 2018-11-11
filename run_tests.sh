#!/bin/bash

bin/console kork:schema:create --force --env=test
vendor/bin/phpspec run -c tests/phpspec.yml.dist tests/spec
vendor/bin/simple-phpunit -c phpunit-sql.xml
vendor/bin/simple-phpunit -c phpunit-in-memory.xml
