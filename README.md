https://hoanguyenit.com/create-a-application-laravel-8-docker.html

```
$ docker-compose exec app composer install
$ docker-compose exec app php artisan key:generate
$ docker-compose exec app php artisan migrate
```