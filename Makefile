install:
	docker-compose up -d --build
	docker-compose run --rm php-fpm composer install