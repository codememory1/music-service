#!/bin/bash

docker-compose exec api php vendor/bin/php-cs-fixer fix --allow-risky=yes