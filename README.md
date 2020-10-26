# wordpress-docker-compose
This is a complete blank WordPress installation based on docker containers and managed by docker-compose
for everyone who wants to test WordPress or do some plugin development (like me) and so on. Feel free to use it.

## Requirements:
You need to install `docker` and `docker-compose` on your computer.

## Simple installation
```
git clone https://github.com/ssilaev/wordpress-docker-compose.git
cd wordpress-docker-compose
docker-compose up -d
```
WordPress: `https://127.0.0.1/`

PhpMyAdmin `http://127.0.0.1:8081`

## Configuration
All necessary configuration is stored in configs/ folder:

    configs/
    ├── Dockerfile.mysql
    ├── Dockerfile.nginx
    ├── Dockerfile.redis
    ├── Dockerfile.wordpress
    ├── mysql/
    │   ├── 50-server.cnf
    │   └── mariadb.cnf
    ├── nginx/
    │   ├── default.conf
    │   ├── dhparam.pem
    │   ├── nginx.conf
    │   ├── nginx-selfsigned.crt
    │   ├── nginx-selfsigned.key
    │   └── ssl-params.conf
    └── php/
        ├── php-fpm.conf
        ├── php.ini
        └── www.conf

You don't need to touch anything, everything works out of the box, but if you use Linux like me you need to change
user and group of processes in configs/php/www.conf to be able to create and modify files from under your user:

    # configs/php/www.conf file (lines 23 and 24):

    user = 1000 <-- specify your user's UID
    group = 998 <-- specify your user's GID

That's all. Happy coding 😉!
