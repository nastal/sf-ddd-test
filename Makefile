install:
	docker-compose up -d --build
	docker-compose run --rm php-fpm composer install

migrate:
	docker-compose run --rm php-fpm symfony console doctrine:migrations:migrate

refresh-queue:
	docker-compose run --rm php-fpm symfony console messenger:stop-workers