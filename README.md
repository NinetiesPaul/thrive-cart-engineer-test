## ACMEStore
ACMEStore is a web application for browsing a product catalog and building a shopping cart with special offers and shipping rules.

## Requirements
To run this application you need Docker installed so you can build and run the project containers.

This project uses containers with:

- PHP 8.2 with Apache and Composer
- MySQL 5.7
- Node (via nvm) for compiling TypeScript under `src/ts/` into `includes/js/`

When developing, a database client such as MySQL Workbench or DBeaver is recommended.

## Installation and Configuration
With Docker installed, run the following commands to start the application:

1) Build the containers and prepare the images
```
docker-compose build
```

2) Start the containers in the background
```
docker-compose up -d
```

3) Install Composer dependencies
```
docker-compose exec php composer install
```

4) Create local copies of the project environment config files
```
cp .env.dist .env
cp phinx.yml.dist phinx.yml
```

5) Configure the `.env` file with the MySQL container database credentials. For example
```
DB_HOST=mysql
DB_NAME=webschool
DB_USER=root
DB_PASSWORD=root
```

6) Configure the `phinx.yml` file with the MySQL container database credentials. For example
```
    development:
        adapter: mysql
        host: mysql
        name: webschool
        user: root
        pass: 'root'
        port: 3306
        charset: utf8
```

7) Run the migrations to create the tables and seed the initial product data
```
docker-compose exec php vendor/bin/phinx migrate
```

8) Compile the TypeScript front-end (runs automatically when you start the `node` service)
```
docker-compose up node
```
To rebuild after editing files under `src/ts/`:
```
docker-compose run --rm node
```
To watch and rebuild on save:
```
docker-compose run --rm node sh -c "npm install && npm run watch:js"
```

9) You're done! If none of the commands above reported errors, the project is ready. Open `http://localhost:8015` in your browser to use the store.
