#!/bin/bash

docker-compose exec app composer dump-autoload && bin/console cache:clear