<<<<<<< Updated upstream
# test API's

### first level

we must run docker compose file

`docker-compose up -d`

### second level

we must execute docker container

`docker exec -it -u 1000 php_fpm_test bash`

after that we must run seeder

`php artisan db:seed`

after all we import model into elastic

`php artisan scout:import "App\Models\Position"`

so we can search

__notic__: all _API's_ requests with example into the postman_collection in project root path! please import that into postman

and __done__
=======

#iran talent test API's
``
>>>>>>> Stashed changes
