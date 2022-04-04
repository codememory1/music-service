#!/bin/bash

docker-compose exec api bin/console doctrine:schema:drop && bin/console doctrine:migrations:migrate