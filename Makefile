.PHONY: build up down restart php npm artisan composer app app_root

include .env

docker_app=docker exec -it ${PROJECT_PREFIX}_app
docker_app_root=docker exec -it -u root ${PROJECT_PREFIX}_app
docker_npm=docker exec -it sf_npm
docker_artisan=docker exec -it sf_artisan
docker_composer=docker exec -it sf_composer
docker_app_no_deps=docker-compose run --rm --no-deps app
docker_compose=docker-compose -f docker-compose.local.yaml

build:
	@$(docker_compose) --env-file .env up -d --build

up:
	@$(docker_compose) --env-file .env up -d

down:
	@$(docker_compose) down

restart:
	@make down
	@make up

app:
	@$(docker_app) bash

app_root:
	@$(docker_app_root) bash

npm:
	@$(docker_npm) bash

artisan:
	@$(docker_artisan) bash

composer:
	@$(docker_composer) bash