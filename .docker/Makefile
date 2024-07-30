.PHONY: app-install

app-install:
	docker cp .env.example .env
	docker compose build
	docker compose up -d
	docker exec laravel-11-app /bin/sh -c "composer install"
# stop:
#     docker-compose stop
# start:
#     docker-compose up --detach
# destroy:
#     docker-compose down --volumes
# build:
#     docker-compose up --detach --build
# seed:
#     docker-compose exec laravel-app php artisan db:seed
# migrate:
#     docker-compose exec laravel-app php artisan migrate:fresh