#run init in tools
cd tools & ./init
#install confide (cd ..)
php artisan confide:migration  --env=local
php artisan migrate --env=local

php artisan confide:controller --env=local
php artisan confide:routes --env=local

composer dump-autoload
