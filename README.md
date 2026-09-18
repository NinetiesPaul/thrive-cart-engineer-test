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


### Explaining the archictecture

The infrastructure for this application is based on a containerized microservices architecture using Docker Compose. It brings together a PHP backend, a MySQL database, and a TypeScript-powered frontend—each running in dedicated containers—for a smooth, portable, and replicable developer experience.

- **Backend**: Handles business logic, product catalog management, and the application of special offers when users interact with their shopping cart. It uses Phinx migrations for database schema and initial data management.
- **Frontend**: Written in TypeScript, the client allows users to browse products and interact with their shopping cart interactively. Build scripts watch for changes and auto-compile code, ensuring a seamless development workflow.
- **Database**: A MySQL service holds products, offers, and cart data, all initialized by versioned migrations for consistency.

---

### How the Special Offers Feature Works

This application features special offers that automatically provide discounts when certain conditions are met in the cart. For example, a "Buy One Get One 50% Off" deal might be set for a specific product, providing a discount every time a user adds multiple qualifying items.

- **Add To Cart Button**:  
  When a user clicks the "Add To Cart" button on a product, that product is immediately added to the shopping cart. If the product qualifies for a special offer (e.g., buy 2 to get a discount on the second), and the threshold is met by this action, the offer is immediately applied—users will see the price of the affected item(s) reflect the discount in the cart summary.

- **Increase (+) Button in Cart**:  
  Inside the cart, each product line has an "Increase" (plus) button, letting the user increment the quantity of that item. Increasing the quantity through this button works the same as "Add To Cart" from the main view: as the quantity passes the qualifying threshold for an active special offer (e.g., goes from 1 to 2 for a "buy 2" deal), the discounted pricing is dynamically and instantly updated in the cart overview.  
  If a user continues to increase quantities (for example, from 2 to 4), the discount logic applies repeatedly (e.g., for every eligible pair).

**User Experience:**  
Users do not need to enter codes or take additional actions for offers—the cart automatically and transparently calculates discounts as soon as the requirements are met, no matter if the products are added from the catalogue page or by adjusting quantities in the cart. Visual indicators or price breakdowns make it clear when items are discounted, ensuring users always see the most advantageous price possible as they shop.