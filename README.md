# To get started with the app, clone this repository thru
https://github.com/naviarros/product_app.git

# After cloning the repository, install necessary packages
composer install
npm install && npm run dev

# After install the packages, run this command to migrate the migrations
php artisan migrate

# After migrating the migrations, to create seeder for user
php artisan db:seed UserSeeder

# To create seeder for products, run
php artisan db:seed ProductSeeder

# After creating seeder, run now the application
php artisan serve

# After serving the application, go to
/login

# The default password that is set on seeder is
password
