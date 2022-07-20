#!/usr/bin/env bash

phpunit="./vendor/phpunit/phpunit/phpunit --configuration=tests/phpunit/phpunit.xml"
tests_path="./tests/phpunit/functional"
tests_dirs=$(ls "${tests_path}")
errors=""

#colors
RED=`tput setaf 1`
GREEN=`tput setaf 2`
NC=`tput sgr0`

function ok() {
    echo -e "${GREEN}$1${NC}"
}

function fail() {
    echo -e "${RED}$1${NC}"
}

for tests_dir in ${tests_dirs}; do
    ok "Entering ${tests_dir}"
    tests=$(ls "${tests_path}/${tests_dir}/")
    for test in ${tests}; do
          file="${tests_path}/${tests_dir}/${test}"
          echo -ne "Running ${file}"
          result=$(${phpunit} ${file})
          if [[ $? -ne 0 ]]; then
               fail " Failed"
               errors+="${result}"
          else
               ok " OK"
          fi
    done
done

if [[ -z "${errors}" ]]
then
    ok "All tests passed"
    exit 0
else
    fail "Errors found"
    echo "${errors}"
    exit 1
fi