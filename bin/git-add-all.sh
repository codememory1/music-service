#!/bin/bash

# shellcheck disable=SC2164
cd bin
bash fix-php.sh

cd ../

git add .