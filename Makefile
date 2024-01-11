up:
	sudo docker-compose up -d

down:
	sudo docker-compose down

restart:
	sudo docker-compose down
	sudo docker-compose up -d

rebuild: down
	sudo docker-compose build --progress=plain #--no-cache
	sudo docker-compose up -d

composer:
	sudo docker-compose exec -T backend composer install

php:
	sudo docker-compose exec backend bash