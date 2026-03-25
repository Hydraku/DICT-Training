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
        //.env uncomment    database.default.hostname = localhost
                            database.default.database = ci4 //change to task_manager when you are on the database part
                            database.default.username = root
                            database.default.password = 
                            database.default.DBDriver = MySQLi
    
    create database localhost/phpmyadmin
    php spark serve //if apache can't detect becasue of prev system
    $routes
    Controllers // $ php spark make::controller TaskController
    php spark make:migration CreateTaskTable -> php spark migrate //Database Migration
    php spark make:model TaskModel //make models
    php spark make:controller TaskController //make controller
    php spark make:seeder TaskSeeder //make seeder
    php spark db:seed TaskSeeder //Migrate seeder

    main.php //make it inside layout folder in views
    index.php //make it inside tasks
    create.php //inside tasks
    edit.php //inside tasks
    show.php //inside tasks

    php spark make:migration CreateUsersTable //create users table then php spark migrate
    php spark make:model UserModel //make models
    php spark make:controller AuthController //authentication
    //routes
    php spark make:filter AuthFilter //make filter
    filters config class
            'auth' => \App\Filters\AuthFilter::class, //put in aliases

    views\auth\login.php //login form
    register.php //register form