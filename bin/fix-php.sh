#!/bin/bash

docker-compose exec app php vendor/bin/php-cs-fixer fix --allow-risky=yes