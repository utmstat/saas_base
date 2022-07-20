#!/usr/bin/env bash

codeception="./vendor/bin/codecept run "
tests_path="tests"
tests_dirs="api front"
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
    tests=$(ls -I _bootstrap.php "${tests_path}/${tests_dir}/")
    for test in ${tests}; do
          file="${tests_path}/${tests_dir}/${test}"
          echo -ne "Running ${file}"
          result=$(${codeception} ${file})
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