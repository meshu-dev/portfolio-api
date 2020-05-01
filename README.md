# Portfolio API

As I wanted to expand my experience with NodeJS and building this app was a great opportunity to build an API to manage data for my portfolio website. This app use's the Express.js framework and stores all data in MongoDB.

## Install software
### NodeJS
- Install in ubuntu
```
curl -sL https://deb.nodesource.com/setup_13.x | sudo -E bash -
sudo apt-get install -y nodejs
```
- Install in MacOS via brew 
```
brew install node
```
### MongoDB
- Install ins MacOS via brew 
```
brew tap mongodb/brew
brew install mongodb-community
```

## Setup 
- Install npm packages
```
npm install
```
- Copy the .env.example file to a new file named .env
```
cp .env.example .env
```
- Fill in .env variables in new file
    - MONGO_DB parameters are used for MongoDB details
    - JWT_PRIVATE_KEY should be used for a secure JWT Key 
    - An AWS S3 account is required for the AWS parameters 
```
APP_ENV=dev
APP_PORT=3000
APP_FRONTEND_SITE=http://localhost:3001
APP_ADMIN_SITE=http://localhost:8080

MONGO_DB_HOST=localhost
MONGO_DB_PORT=27017
MONGO_DB_AUTH_SOURCE=
MONGO_DB_NAME=portfolio-dev
MONGO_DB_USERNAME=
MONGO_DB_PASSWORD=

JWT_PRIVATE_KEY=secret

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_S3_BUCKET=
```
## Commands
- Run app locally
```
npm run nodemon
```
- Run app on production
```
node server.js
```
