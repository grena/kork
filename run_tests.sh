#!/bin/bash

bin/console kork:schema:create --force --env=test
vendor/bin/phpspec run -c tests/phpspec.yml.dist tests/spec
bin/phpunit
