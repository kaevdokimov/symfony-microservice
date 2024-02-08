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

migrate:
	docker-compose exec php php artisan migrate
	docker-compose exec php php artisan doctrine:migrations:migrate --no-interaction

rollback:
	docker-compose exec php php artisan doctrine:migrations:migrate prev --no-interaction

diff:
	docker-compose exec php php artisan doctrine:migrations:diff

validate-schema:
	docker-compose exec php php artisan doctrine:schema:validate

composer-install:
	docker-compose exec php composer install
	docker-compose exec php composer dump-autoload

composer-update:
	docker-compose exec php composer update --apcu-autoloader -o
	docker-compose exec php composer dump-autoload


