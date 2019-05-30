# Instant MVC micro-framework

The MVC micro-framework plus Instant

## Getting Started


### Prerequisites

```
Apache 2.0+ with mod_rewrite and "AllowOverride All" set.
PHP >= 7.1 The latest version of PHP is recommended.
Package manager composer
```

### Installing

A step by step series 

1. Clone GitHub repo for this project locally
```
git clone https://github.com/kenlog/instant-mvc.git
```
2. cd into your project  
You will need to be inside that project file to enter all of the rest of the commands  
3. Install Composer Dependencies  
Because these packages are constantly changing, the source code is generally not submitted to github, but instead we let composer handle these updates.
Updating composer 
If you already have composer installed you can update it by running:
```
composer self-update
composer install
```
After adding a new class, you need to run dump-autoload again to regenerate the vendor/autoload.php file.
```
composer dump-autoload
```
## Wrapping Up
That is all you need to get started on a project.  
There are some examples to get you started. Boom! 

For the database no dependencies are included to give full freedom, in this case we recommend [Spot DataMapper ORM v2.0](https://github.com/spotorm/spot2)

## Dependency

* [nezamy/route](http://nezamy.com/route)
* [symfony/serializer](https://symfony.com/doc/current/components/serializer.html)
* [symfony/property-access](https://symfony.com/doc/current/components/property_access/index.html)
* [bocharsky-bw/arrayzy](https://github.com/bocharsky-bw/Arrayzy)

## Contributing
Clone the repository: 
```console 
git clone https://github.com/kenlog/instant-mvc.git
```
:bug: Reporting Issues
------------
Please [create an issue](https://github.com/kenlog/instant-mvc/issues) for any bugs you've found.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/kenlog/instant-mvc/tags). 

## Authors

* **Valentino Pesce** - *Initial work* - [Kenlog](https://github.com/kenlog)

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE) file for details