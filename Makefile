init:
	composer install && \
	sh -l ./.script/install-wp-tests.sh && \
	NVM_DIR="$${HOME}/.nvm" && . "$${NVM_DIR}/nvm.sh" && nvm use && \
	npm install && npm run build

composer-update:
	composer update

start-watch:
	NVM_DIR="$${HOME}/.nvm" && . "$${NVM_DIR}/nvm.sh" && nvm use && \
 	npm run start

build-src:
	NVM_DIR="$${HOME}/.nvm" && . "$${NVM_DIR}/nvm.sh" && nvm use && \
 	npm run build

create-release-zip:
	make lint && make build-src && composer run no-dev && \
	npm run create-release-zip && composer install

deploy-to-dev:
	make build-src && composer run no-dev && \
	npm run deploy-to-dev && composer install

tests:
	composer run tests

fix:
	composer run fix && npm run fix-style && npm run fix-script

lint:
	composer run lint && npm run lint-style && npm run lint-script

prepare-to-release:
	make lint && npm run build && \
	composer run no-dev
