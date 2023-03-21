.DEFAULT_GOAL := help


PHP = @docker-compose exec  php8-sf6 php
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


.PHONY: test
test:
	$(PHP) ./bin/phpunit --testdox
