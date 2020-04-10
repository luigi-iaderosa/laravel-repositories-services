##Introduction
This project is a mean to study the largest possible code separation. 

In the perspective of good OOP/D , and the use of TDD made via PHPUNIT, 
an effort has been made to bring the largest possible separation of concerns. 

The following code has been developed under laravel 6, using TDD via UNIT and FEATURE TEST
facilities provided by PHPUNIT framework. 
The use cases are all fairly easy. I wanted no-brainer functional problems so to 
focus on code maintenance and separation of concerns. 

### Main tech requirements.
php >= 7.0
laravel 6.0
phpunit

### General recommendation
Make sure you have a basic understanding of laravel and phpunit. 

### Laravel facilities
All non-trivial test classes have been created via ``` php artisan make:test TestName``` command. 

All non-trivial controller classes have been created via ``` php artisan make:controller ControllerName``` command

All non-trivial model classes have been created via  ```php artisan make:model ModelName -m``` command

All non-trivial factories have been created via ``` php artisan make:factory ModelNameFactory -m ModelName``` command

All tests have been executed via ``` phpunit --filter TestClass``` or ``` phpunit --filter test_class_method``` command
 

### Project Description
Assume you have a db with with 2 tables:
1.Users
2.Articles

Suppose also, for the moment, you have one route, '/', that displays the articles. 
The table articles has two special columns:
1. ```user_reserved``` : boolean  
2. ```discount_user_visible``` :  numeric


```user_reserved``` states that this article is user-only   
```discount_user_visible``` is visible ONLY to users

So, the route can be called either having a user, or being a "passer-by". 

Let's impose a simple two-point rule:
1. Authenticated users access all articles and all columns
2. Passer-bys access only the non-dedicated articles, and do not access the discount column. 


The effort to be made is to let go of in-controller logic. 
We will be familiar with two classes:
1. Repository, that will contain the set of query 
2. Service, that will reuse raw data of Repository and hand them to controller. 

 
The architecture will be as follows:
1. There is only ONE CONTROLLER, ArticleController. 
2. On controller route-method, according to user availability, will be allocated a Repo that
contains query for the user or the passer-by

Another route that proves the correct dependency injection  is
```'/article/{id}'``` , that returns fields and articles according to user availability in route. 

Finally, a protected route ```'/purchase/{id}'``` has been provided for proving the correct 
user detection from the creation through dependency injection up to Service Business Logic. 
(Route has been protected with the popular ```auth``` middleware). 


### Logic behind the architecture.
We don't want the controller clobbed with logic.
We want to put the business rules (and code) somewhere else. 

Also, we want to make full use of Repository pattern, in order to :
1. Isolate the query level from the business rules level
2. Create a "Query Warehouse" where we can find all queries (and possibly, reuse them)
Furthermore, the poor business rule we have mandates that queries will be different if 
the route is queried by an authenticated user or a passer-by. 

The depedency injection is a mechanism that works such as , according to user availability,
an instance of an object will be instantiated instea of another one. 

### Where to focus on code
```AppServiceProvider``` contains the bindings to create the objects. 
Make sure to understand that a ```Repo``` is a dependency of ```Service```, and the former is created earlier and injected
thus into the latter (IoC - Inversion of Control). 

Folders ```tests/Unit``` and ```tests/Feature``` provide a clean way to look at all pieces of code. 
1. ```tests/Unit``` makes you acquainted with the building bricks of the application, and doesn't respect any code convention.
2. ```tests/Feature``` is a small collection of calls to routes, that proves that the pieces tested at step 1 are injected in the
right way. 

### Further help:
In the ```drawing``` folder, I've provided some basic UML diagrams. Created with (and I encourage you to use it) "Violet Uml Editor" (http://alexdp.free.fr/violetumleditor/page.php
)

Might be a good idea to have the diagrams at hand while you read the project and , anyway, make sure to hit at least
```class-diagram.class.violet.html```

### Database level
I've use Sqlite db. Easy and comfortable. Make sure in your .env file to populate as follows:
```DB_CONNECTION = sqlite```
```DB_DATABASE=absolute_path_of_database_sqlite_file```

For instance, since I work with homestead, the file will be in:  

```
DB_DATABASE=/home/vagrant/code/OwnProjects/user-driven-services-repos/database/database.sqlite
```

Feel free to put this file wherever you see fit. It's very easy to create you laravel project and then, 
from the project root directory, write (in a terminal shell):

```touch database/database.sqlite```

### Where to go from here -"Built on Shoulders of Giants"
Youtube is your best friend and, specifically, nothing's better that "Coder's Tape" channel (search it and enjoy!!).   
I owe a lot of the principles of this project to those "Coder's Tape" tutorials, and I just needed to experiment further. 

When in doubt for phpunit, take a look at phpunit api docs: http://apigen.juzna.cz/doc/sebastianbergmann/phpunit/

Don't forget Laravel, specifically https://laravel.com/docs/6.x
 

