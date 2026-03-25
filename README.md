# DICT TRAINING (Intermediate)
March 25-26, 2026

## Full stack web php
Notes:

    php 8.2
        -intl
        -libcurl
        -mysqlnd
        -xml
        -json

    composer 2.9.5

    codeigniter4
        composer create-project codeigniter4/appstarter DICT-Training
        cd .\DICT-Training\ 
        code . \\if typing in cli

        cp env .env
        CI_ENVIRONMENT = development
        //.env uncomment     database.default.hostname = localhost
                            database.default.database = ci4
                            database.default.username = root
                            database.default.password = 
                            database.default.DBDriver = MySQLi
    
    create database localhost/phpmyadmin
    php spark serve //if apache can't detect becasue of prev system
    $routes
    Controllers // $ php spark make::controller TaskController
        use
    