#!/bin/bash

docker-compose exec app bin/console app:jwt-generate-keys JWT_ACCESS --env-file=.env.local && bin/console app:jwt-generate-keys JWT_REFRESH --env-file=.env.local && bin/console app:jwt-generate-keys JWT_PASSWORD_RESET --env-file=.env.local && bin/console app:jwt-generate-keys JWT_ACCOUNT_ACTIVATION --env-file=.env.local