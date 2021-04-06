#!/bin/bash

composer install
php bin/console do:sc:dr --force
php bin/console do:sc:cr
php bin/console assets:install