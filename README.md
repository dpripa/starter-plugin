# WordPress Development Environment
Welcome to the structured and efficient environment of WordPress development. The environment provides:
- the collection of PHP classes that cover many basic tasks;
- ready to use `webpack.config.js`;
- GitHub Actions for deployment and releases;
- Git pre-commit automation for linting;
- ;
- .
-
### Requirements
- PHP ^7.2.0
- NVM

### Special Conditions and Rules
- .
- .


## Use the following commands to...
```sh
# initialize the development environment
make init
```
```sh
# start a proxy server with a file (php, js, scss) watcher
make start-watch
# NOTE: the .env file must to be defined and contain the required parameters (use the .env.example file as reference)
```
```sh
# build the source files
make build-src
```
```sh
# create the release-ready zip archive
make create-release-zip
```
```sh
# deploy to the personal development server
make deploy-to-dev
# NOTE: the .env file must to be defined and contain the required parameters (use the .env.example file as reference)
```
```sh
# execute all code style fixers
make fix
```
```sh
# execute all code style linters
make lint
```

## Project Management

### Deployment

### Creating a new Release

### Initializing a new Project

