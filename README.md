Symfony REST
===============

This simple app calculates popularity score for the search term using github api service

## Installation

`cd your-app-folder`

Clone repository `git clone git@github.com:danijelkelava/symfony-rest.git`

## Docker Setup

Run `docker-compose up -d` to build up the containers (sf_web/sf_db/sf_adm).

After that, run `docker exec -it sf_web ./setup.sh`, which will install php dependencies and create db schema.

setup.sh needs to be executable

Swagger docs will be available at: `http://localhost:8888/docs`  

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

$ bin/phpunit




