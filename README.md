# curd-laravel-kepegawaian

## 1
```sh
cd src
```
## 2. env
setup .env.example to .env
## 3. composer
```sh
sudo composer install
```
## 4. up with docker
if up with docker
```sh
sudo docker-compose up -d
```
manual with xampp or else
```sh
copy all inside src folder to xampp or else project
```
## 5. Permission
```sh
chmod -R 775 src/storage
```
```sh
chmod -R 775 src/bootstrap/cache
```

## 6. Migrations
Open .env
comment DB_HOST=mysql and uncomment # DB_HOST=127.0.0.1
```sh
DB_HOST=127.0.0.1
#DB_HOST=mysql
```
Open new terminal
```sh
cd src
sudo php artisan migrate:fresh --seed
```

## 7. Run with docker
Open .env
uncomment #DB_HOST=mysql and comment DB_HOST=127.0.0.1
```sh
#DB_HOST=127.0.0.1
DB_HOST=mysql
```
Add hosts
```sh
# ubuntu
sudo nano /etc/hosts
127.0.0.1 medic.docker
```
```sh
# Windows
open notepad with run as administrator
c:\Windows\System32\Drivers\etc\hosts
127.0.0.1 medic.docker
```
run with browser
```sh
http://medic.docker
```

## 8. Run with laravel
```sh
php artisan serve --port=8080
```