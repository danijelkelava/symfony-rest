Symfony REST
===============

## Docker Setup

Run `docker-compose up -d` to build up the containers (web/db/adminer).

After that, run `docker exec -it sf_web ./setup.sh`, which will run necessary fixtures in web container and import questions data into database.

setup.sh needs to be executable

Swagger docs will be available at: `http://localhost:8888/docs`  

Useful notes:

Create controller inside subdirectory php bin/console make:controller Subdirectory\\Controller

nelmio 4.1 version error  The annotation "@Swagger\Annotations\Post" in method App\Controller\Api\V1\User\CreateController::__invoke() was never imported.
