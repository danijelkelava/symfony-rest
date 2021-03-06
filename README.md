Symfony REST
===============

This simple app calculates popularity score for the search term using github api service. 
Calculation 

## Installation

`cd your-app-folder`

Clone repository `git clone https://github.com/danijelkelava/symfony-rest.git`

Checkout `master` branch

## Docker Setup

Run `docker-compose up -d` to build up the containers (sf_web/sf_db/sf_adm).

After that, login to `sf_web` container `docker exec -it sf_web bash`, and run `./setup.sh` which will install php dependencies and create db schema.

setup.sh needs to be executable

Swagger docs will be available at: `http://localhost:8888/docs`  

#### Default database credentials:
- Server:  `symfony_db`
- Username: `user`
- Password: `user`
- Database: `db`

## Sample Requests

    curl

curl -X GET "http://localhost:8888/api/v1/term/{name}" -H  "accept: application/json"

    Request URL

http://localhost:8888/api/v1/term/{name}

## Sample Response

    JSON
{
   "name": "php",
   "score": "6.47",
}

## Run Tests
Login to `sf_web` container `docker exec -it sf_web bash` 

Functional tests:

	`./bin/phpunit tests/Functional`

Unit tests:

	`./bin/phpunit tests/Unit`


## Testing
We are using https://github.com/dmaicher/doctrine-test-bundle when testing, it will return our database to a previous state

