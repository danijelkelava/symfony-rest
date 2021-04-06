Symfony REST
===============

## Docker Setup

Run `docker-compose up -d` to build up the containers (web/db/adminer).

After that, run `docker exec -it sf_web ./setup.sh`, which will install php dependencies and create db schema.

setup.sh needs to be executable

Swagger docs will be available at: `http://localhost:8888/docs`  




