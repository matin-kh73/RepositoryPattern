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

After running this command if the model exists, a directory called Repository creates in your app directory.to use your repository class you can inject it in any controller that you want.
after that you can easily use all of the features in your repository class.
## etc
`php artisan make:repository Models\User`

<p align="left">
<img src="https://user-images.githubusercontent.com/38176879/77259649-947cde80-6ca0-11ea-82ad-004d28aab6de.png"  width="500">

In this example, you can see a method with setFilters name!
<p>
you can apply your any eloquent filters on your query.but where is these filters?? 
</p> 
You can create your filters with this command:  

`php artisan make:filter With'`

After creating the filter, the structure of this class like this :

<img src="https://user-images.githubusercontent.com/38176879/77259667-bf673280-6ca0-11ea-9b47-8e6a2e655c8e.png" width="400">

The implementation of your filter must be in the handle method! the args variable includes the value that you set on the setFilters method!

**Be careful after creating the filters, you have to set filters on the repository config file.**

In the repositories directory, there are 4 things!
- a BaseRepository class that is the parent of all repositories that you created in your project and includes and contains a number of functions that can be the same in your repository classes.
- a BaseRepositoryInterface class
- a RepositoryServiceProvider for binding your repository classes to the interface that previously made.  
- and finally, a directory with your model name that includes a repository class is created and a directory with contracts name.

**Be careful If you want using your repository class with their contracts you have to bind them together on the RepositoryServiceProvider class!**

<img src="https://user-images.githubusercontent.com/38176879/77549316-50225600-6ecd-11ea-803f-0ac896bc4cc3.png" width="600">

## License

The RepositoryPattern-handler is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
