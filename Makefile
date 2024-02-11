#!make

init: docker-clear docker-build docker-up composer-install
up: docker-up
down: docker-down
restart: docker-down docker-up
#check: validate-schema lint

app:
	docker-compose exec php bash
docker-up:
	docker-compose up -d

docker-down:
	docker-compose down

docker-clear:
	docker-compose down -v --remove-orphans

docker-build:
	docker-compose build --pull

wait-db:
	docker-compose exec php wait-for-it mariadb:3306 -t 60

migration:
	docker-compose exec php symfony console make:migration

migrate:
	docker-compose exec php symfony console doctrine:migrations:migrate

composer-install:
	docker-compose exec php composer install
	docker-compose exec php composer dump-autoload

composer-update:
	docker-compose exec php composer update --apcu-autoloader -o
	docker-compose exec php composer dump-autoload


