[![GitHub](https://img.shields.io/github/license/docpht/docpht?style=flat-square)](https://github.com/docpht/docpht/blob/master/LICENSE)
[![Maintenance](https://img.shields.io/maintenance/yes/2020?style=flat-square)](https://github.com/docpht/docpht/graphs/contributors)
[![PHP from Packagist](https://img.shields.io/packagist/php-v/kenlog/docpht?style=flat-square)](https://packagist.org/packages/kenlog/docpht)
[![GitHub release](https://img.shields.io/github/release/docpht/docpht?style=flat-square)](https://github.com/docpht/docpht/releases/latest)
[![GitHub All Releases](https://img.shields.io/github/downloads/docpht/docpht/total?style=flat-square)](https://github.com/docpht/docpht/releases)
[![GitHub repo size](https://img.shields.io/github/repo-size/docpht/docpht?style=flat-square)](https://github.com/docpht/docpht/releases)
[![Packagist](https://img.shields.io/packagist/dt/kenlog/docpht?label=composer%20create-project&style=flat-square)](https://packagist.org/packages/kenlog/docpht)
[![Docker Pulls](https://img.shields.io/docker/pulls/docpht/docpht?style=flat-square)](https://hub.docker.com/r/docpht/docpht)
[![GitHub last commit](https://img.shields.io/github/last-commit/docpht/docpht?style=flat-square)](https://github.com/docpht/docpht/commits/master)

# DocPHT :bookmark_tabs:

With DocPHT you can take notes and quickly document anything! You can also manage users, save versions of your pages and run and restore backups. Complete with interface that can be customized, all with maximum portability and without
the use of any database. You won't believe it, until you try it! :gem:

[![Demo](https://img.shields.io/static/v1?style=flat-square&label=Demo&message=TRY%20DEMO%20VERSION&color=4caf50)](https://demo.docpht.org)

![create-new-page](https://user-images.githubusercontent.com/11728231/61236340-0ecf8900-a738-11e9-8b2a-81b0752fb384.gif)
![edit-version-published](https://user-images.githubusercontent.com/11728231/61236343-10994c80-a738-11e9-88a5-424e72b5fd9f.gif)
![switch-theme](https://user-images.githubusercontent.com/11728231/61236350-12631000-a738-11e9-8259-eb7539d6ca6f.gif)

## Getting Started

[Download](https://github.com/docpht/docpht/releases/latest) the latest version of the package and upload it to the server, unzip it to the location you prefer. Open the browser and enter the address to start the installation wizard, it will take less than a minute. :rocket:

## Prerequisites :electric_plug:

```
Apache 2.2+ with mod_rewrite and "AllowOverride All" set.
Enable mod headers module
PHP >= 7.4
```

## Composer 

This project can be installed as a [Composer](https://getcomposer.org/) dependency.

```bash
composer create-project kenlog/docpht
```

## Docker

**Basic Usage:**
```
docker pull docpht/docpht:v1.3.2
docker run -d --name docpht -p 80:80 -t docpht/docpht:v1.3.2
```

**Advanced Usage (Persistence data):**
```
docker pull docpht/docpht:v1.3.2
docker run -d --name docpht -p 80:80 -p 443:443 -t 
-v /var/www/app/src/config:/var/www/app/src/config
-v /var/www/app/data:/var/www/app/data
-v /var/www/app/pages:/var/www/app/pages
-v /etc/nginx/ssl:/etc/nginx/ssl
docpht/docpht:v1.3.2
```

## Wrapping Up
That is all you need to get started. Boom! 

## Welcome to the new collaborators :boy: :information_desk_person: :older_man: :angel: :dancer: :alien:
Clone the repository: 
```console 
git clone https://github.com/kenlog/docpht.git
```
We look forward to seeing your pull requests!

## Contributor Covenant Code of Conduct :scroll:
## Our Pledge

In the interest of fostering an open and welcoming environment, we as
contributors and maintainers pledge to making participation in our project and
our community a harassment-free experience for everyone, regardless of age, body
size, disability, ethnicity, gender identity and expression, level of experience,
nationality, personal appearance, race, religion, or sexual identity and
orientation. :earth_africa: Always strive to collaborate with mutual respect.

Project maintainers are responsible for clarifying the standards of acceptable behavior and are expected to take appropriate and fair corrective action in response to any instances of unacceptable behavior.

:grey_exclamation: Reporting Issues or feature requests :grey_question: 
------------
Please [create an issue](https://github.com/kenlog/docpht/issues)

## :bug: Where should I report security issues?
In order to give the community time to respond and upgrade we strongly urge you report all security issues privately. Email us directly at `securitybugreport@docpht.org` with details and repro steps. Security issues always take precedence over bug fixes and feature work. We can and do mark releases as "urgent" if they contain serious security fixes.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://github.com/kenlog/docpht/tags). 

## Authors

* **Valentino Pesce** - [Kenlog](https://github.com/kenlog) :it:
* **Craig Crosby** - [Creecros](https://github.com/creecros) :us:

## License

Copyright © 2019 - This project is licensed under the MIT License - see the [LICENSE.md](LICENSE) file for details 

## Dedicated to everyone :heartpulse:
![hearts](https://user-images.githubusercontent.com/11728231/60382009-241c9600-9a5d-11e9-8bd5-c3396e57e5cf.gif)
