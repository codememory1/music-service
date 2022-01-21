stop_php:
	sudo service php8.0-fpm stop
	
stop_apache2:
	sudo service apache2 stop
	
stop_mysql:
	sudo service mysql stop
	
stop_custom_server: stop_php stop_apache2 stop_mysql

build:
	sudo docker-compose --env-file .docker/development/.env build

up_dev:
	docker-compose --env-file .docker/development/.env up

up_prod:
	docker-compose --env-file .docker/production/.env up
