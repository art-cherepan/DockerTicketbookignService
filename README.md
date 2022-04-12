# Ticket booking service

1. Скопируйте репозиторий командой `git clone https://github.com/art-cherepan/DockerTicketbookignService.git`
2. Перейдите в директорию `docker` командой `cd docker`
3. Скопируйте файл .env.example в .env командой `cp .env.example .env`
4. Запустите docker контейнеры командой `docker-compose up -d --build`
5. Перейдите в контейнер командой `docker exec -itu1000 resolventa_backend_internship_php-fpm_1 bash`
6. Выполните загрузку необходимых пакетов командой `composer install`
7. Выполните миграцию командой `php bin/console doctrine:migrations:migrate`
8. Загрузите фикстуры командой `php bin/console doctrine:fixtures:load`
9. Перейдите на [страницу бронирования билетов](http://localhost/main)

#Для выполнения тестов:

1. Перейдите в контейнер командой `docker exec -itu1000 resolventa_backend_internship_php-fpm_1 bash`
2. Для выполнения всех тестов выполните команду `vendor/bin/phpunit`
3. Чтобы добавить критерий, по которому будут выполняться определенные тесты, добавьте ключ --filter, например `vendor/bin/phpunit --filter testCommandExecute` 
