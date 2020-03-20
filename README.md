# README

1. Go to the project folder
2. Provide the right permissions for the `storage` folder.
    Reference: https://stackoverflow.com/questions/30639174/how-to-set-up-file-permissions-for-laravel
    For test purposes, you can use 775 or 777.
2. Assign the right owner and group for `public/uploads` and `public/download`.
    In apache is `www-data:www-data`.
3. Create your `.env` file
4. Add the database and url configuration
    ````
    APP_URL=http://images.local
   
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=images
    DB_USERNAME=root
    DB_PASSWORD=12345678
    ````
5. In the terminal run the command:
    ````
    php artisan migrate
    ````
   
# Notes
You must to create your own `virtualhost`, set the DocumentRoot (example)

````
DocumentRoot /var/www/html/jokes/public/
````

and provide the following permissions

````
<Directory PROJECT_LOCATION>
    Options Indexes FollowSymLinks MultiViews
    AllowOverride All
    Require all granted
</Directory>
````

The `mod_rewrite` should be enabled.

Here un example:
````
<VirtualHost *:80>
        ServerAdmin pcoyoy8@gmail.com
        ServerName images.local
        ServerAlias www.images.local
        DocumentRoot /var/www/html/imagesApi/public/

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined

        ErrorLog ${APACHE_LOG_DIR}/error.log
        CustomLog ${APACHE_LOG_DIR}/access.log combined

        <Directory /var/www/html/imagesApi/>
                Options Indexes FollowSymLinks MultiViews
                AllowOverride All
                Require all granted
        </Directory>
</VirtualHost>

````

Reference: https://www.digitalocean.com/community/tutorials/how-to-rewrite-urls-with-mod_rewrite-for-apache-on-ubuntu-18-04

# Client

For testing the API you can use Postman and import the file that is located in `public/resources/ImagesAPI.postman_collection.json`

There are 3 methods:
- getAll: retrieve all the records
    - HTTP Method: GET
- getById: retrieve one record by Id
    - HTTP Method: GET
    - Parameters:
        - id: integer
- store: insert and/or update the records
    - HTTP Method: POST
    - Parameters:
        - file: csv
        
    
