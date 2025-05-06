init:
	composer install && sh ./.script/install-wp-tests.sh && make nvm-use && npm install && npm run build

start-watch:
	make nvm-use && npm run start

build-src:
	make nvm-use && npm run build

create-release-zip:
	make test && make lint && make build-src && composer run no-dev && npm run create-release-zip && composer install

deploy-to-dev:
	make test && make lint && make build-src && composer run no-dev && npm run deploy-to-dev && composer install

test:
	composer run test

lint:
	composer run lint && npm run lint-style && npm run lint-script

fix:
	composer run fix && npm run fix-style && npm run fix-script

# NOTE. The following commands are part of the automation, so you don't need to use them manually:

prepare-to-release:
	make test && make lint && npm run build && composer run no-dev

nvm-use:
	NVM_DIR="$${HOME}/.nvm" && . "$${NVM_DIR}/nvm.sh" && nvm use
