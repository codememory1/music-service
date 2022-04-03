#!/bin/bash

docker-compose exec app bin/console doctrine:schema:drop && bin/console doctrine:migrations:migrate