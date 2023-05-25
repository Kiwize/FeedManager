# Ensure that every command in this Makefile
# will run with bash instead of the default sh
SHELL := /usr/bin/env bash

.DEFAULT_GOAL := help

##@ 🚩  General

# The help target prints out all targets with their descriptions organized
# beneath their categories. The categories are represented by '##@' and the
# target descriptions by '##'. The awk commands is responsible for reading the
# entire set of makefiles included in this invocation, looking for lines of the
# file as xyz: ## something, and then pretty-format the target and help. Then,
# if there's a line with ##@ something, that gets pretty-printed as a category.
# More info on the usage of ANSI control characters for terminal formatting:
# https://en.wikipedia.org/wiki/ANSI_escape_code#SGR_parameters
# More info on the awk command:
# http://linuxcommand.org/lc3_adv_awk.php


.PHONY: help
help: ## Display this help.
	@awk 'BEGIN {FS = ":.*##"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n"} /^[a-zA-Z_0-9-]+:.*?##/ { printf "  \033[36m%-15s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

##@ 🚚  Docker

.PHONY: build
build: ## 🏗️  Build docker image
	@echo "Build docker project"
	@docker-compose build

.PHONY: build-no-cache
build-no-cache: ## 🏗️  Build docker image without cache
	@echo "Build without cache docker project"
	@docker-compose build

.PHONY: up
up: ## 🚀  Start docker containers
	@echo "Start docker containers"
	@docker-compose up -d

.PHONY: stop
stop: ## 🥅  Stop docker containers
	@echo "Stop docker containers"
	@docker-compose stop
	@docker-compose down

.PHONY: ps
ps: ## 🩺  Show docker containers
	@echo "Show docker containers"
	@docker-compose ps

.PHONY: logs
logs: ## 📄  Show docker logs
	@echo "Show docker logs"
	@docker-compose logs -f

.PHONY: prune
prune: ## 💥  Clean docker
	@echo "Clean docker project"
	@docker-compose down --remove-orphans
	@docker-compose down --volumes
	@docker-compose rm -f


##@ ⚗️  news-feed

.PHONY: composer-install
composer-install: ## Composer install
	@docker exec -ti news-feed-php-fpm bash -c 'composer install'

.PHONY: db-init
db-init: ## Initialize database (reset, migrate and seed)
	@docker exec -ti news-feed-php-fpm bash -c 'php artisan migrate:refresh'
	@docker exec -ti news-feed-php-fpm bash -c 'php artisan migrate'
	@docker exec -ti news-feed-php-fpm bash -c 'php artisan migrate:refresh --seed'

##@ 🗃️  Quality

.PHONY: test
test: ## Make tests
	@docker exec -ti news-feed-php-fpm bash -c './vendor/bin/phpunit --coverage-html coverage'

.PHONY: test-coverage
test-coverage: ## Make tests
	@docker exec -ti news-feed-php-fpm bash -c 'composer run-script test:coverage'

.PHONY: test-feeddbseed
feeddbseed: ##DB Seeding for testing
	@docker exec -ti news-feed-php-fpm bash -c 'composer run-script test:feeddbseed'
