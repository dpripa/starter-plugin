init:
	composer install && nvm use && npm install && npm run build && npm run prepare

init-prod:
	composer run no-dev && nvm use && npm install && npm run build

pre-commit:
	composer run lint && npm run lint-style && npm run lint-script
