#!/bin/bash

docker-compose exec app bin/console doctrine:migrations:migrate