init:
	composer install && make nvm-use && npm install && npm run build

start-watch:
	make nvm-use && npm run start

build-src:
	make nvm-use && npm run build

create-release-zip:
	make lint && make build-src && composer run no-dev && npm run create-release-zip && composer install

deploy-to-dev:
	make build-src && composer run no-dev && npm run deploy-to-dev && composer install

fix:
	composer run fix && npm run fix-style && npm run fix-script

lint:
	composer run lint && npm run lint-style && npm run lint-script

prepare-to-release:
	make lint && npm run build && composer run no-dev

nvm-use:
	NVM_DIR="$${HOME}/.nvm" && . "$${NVM_DIR}/nvm.sh" && nvm use
