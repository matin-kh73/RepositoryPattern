<p align="center">
<a href="https://travis-ci.org/matin-kh73/RepositoryPattern.svg?branch=master"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/mtkh73/repo-handler"><img src="https://poser.pugx.org/mtkh73/repo-handler/downloads" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/mtkh73/repo-handler"><img src="https://poser.pugx.org/mtkh73/repo-handler/v/stable" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://scrutinizer-ci.com/g/matin-kh73/RepositoryPattern/badges/code-intelligence.svg?b=master"></a>
<a href="https://packagist.org/packages/mtkh73/repo-handler"><img src="https://poser.pugx.org/mtkh73/repo-handler/license" alt="License"></a>
</p>

## About RepositoryPattern

The Repository Pattern is one of the most popular patterns to create an enterprise level application. It restricts us to work directly with the data in the application and creates new layers for database operations, business logic, and the application’s UI. using the Repository Pattern has many advantages:

- Your business logic can be unit tested without data access logic;
- The database access code can be reused;
- Your database access code is centrally managed so easy to implement any database access policies, like caching;
- It’s easy to implement domain logic;
- Your domain entities or business entities are strongly typed with annotations; and more.

## How to work with this package
`php artisan make:repository ModelName`

After installing this package, a command will be added on your artisan command with <b> make:repository </b> name. with this command you can create a repository class for your model classes.

## etc
`php artisan make:repository Models\User`

After running this command if the model exists, a directory called Repository creates in your app directory.
in this directory, there are 4 things!
- a BaseRepository class that is the parent of all repositories that you created in your project and includes and contains a number of functions that can be the same in your repository classes.
- a BaseRepositoryInterface class
- a RepositoryServiceProvider for binding your repository classes to the interface that previously made.  
- and finally, a directory with your model name that includes a repository class is created.

## License

The RepositoryPattern-handler is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
