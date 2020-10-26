build:
	docker-compose build

rebuild:
	docker-compose build --no-cache --force-rm

run:
	docker-compose up -d
