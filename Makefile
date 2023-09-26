init:
	composer install && make nvm-use && npm install && npm run build

init-prod:
	composer run no-dev && make nvm-use && npm install && npm run build

start-watch:
	make nvm-use && npm run start

build-src:
	make nvm-use && npm run build

lint:
	composer run lint && npm run lint-style && npm run lint-script

fix:
	composer run fix && npm run fix-style && npm run fix-script

nvm-use:
	NVM_DIR="$${HOME}/.nvm" && . "$${NVM_DIR}/nvm.sh" && nvm use
