#!/bin/bash

git push $@

# shellcheck disable=SC2164
cd bin
bash fix-php.sh