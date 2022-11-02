#!/usr/bin/env bash

composer update
vendor/bin/codecept run tests/api
vendor/bin/codecept run tests/front
vendor/phpunit/phpunit/phpunit --configuration=tests/phpunit/phpunit.xml tests/phpunit/functional/
