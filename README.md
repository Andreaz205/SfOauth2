composer create-project symfony/skeleton:"7.2.x" my_project_directory

./bin/console make:user

./bin/console make:migration
./bin/console doctrine:migrations:migrate

./vendor/bin/phpunit

sudo chown  andrei:andrei -R src

php bin/console security:hash-password

composer require --dev symfony/profiler-pack
composer require symfony/orm-pack //Doctrine
composer require --dev phpunit/phpunit
composer require lexik/jwt-authentication-bundle

php bin/console lexik:jwt:generate-keypair

HWIOAuthBundle - бандл для oauth2 полностью кастомизируемый

https://github.com/hwi/HWIOAuthBundle/issues/1824
https://dev.to/jszutkowski/securing-api-with-jwt-in-symfony-36dk


