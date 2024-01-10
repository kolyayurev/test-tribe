up:
	sudo docker-compose up -d

down:
	sudo docker-compose down

rebuild: down
	sudo docker-compose build
	sudo docker-compose up -d

composer:
	sudo docker-compose exec -T backend composer install

php:
	sudo docker-compose exec backend bash