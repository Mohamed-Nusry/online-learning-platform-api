# Installation Guide For The Repo

## Pre-Requisites
- PHP version 8.1 or higher required
- Composer required

## Please follow below steps to initiate the app:

- Clone the repo using `git clone {repo}`
- Copy `.env.example` to `.env` and edit database credentials there
- Create an empty database according to the name given in the .env
- Run `composer install` to install required dependencies
- Run `php artisan key:generate` to generate app key
- Run `php artisan migrate:fresh --seed` to create database tables and seed data
- Run `php artisan serve` to serve the app
- Run `php artisan test` to run the tests

# Other Information

Postman API Documentation provided in root folder named `Online Learning Platform.postman_collection.json`


### Example Testing the API with Postman:

##### Postman Settings
###### POST:
	http://localhost:8000/api/login

###### Headers:
	Accept:	application/json