.DEFAULT_GOAL := help


PHP = ../../@docker-compose exec php8-sf6 php
SYMFONY = $(PHP) bin/console
COMPOSER = $(PHP) /usr/bin/composer

## Upgrade composer
composer-self-update:
	$(COMPOSER) self-update

## Upgrade composer
composer-update:
	$(COMPOSER) update

## Install PHP dependencies
composer-install:
	$(COMPOSER) install

## Only update the .lock file
composer-update-lock:
	$(COMPOSER) update --lock

open-testing:
	cd project/testing

.PHONY: test
test:
	pwd && docker-compose -f ../../docker-compose.yaml exec php8-sf6 php ./vendor/bin/phpunit --testdox
