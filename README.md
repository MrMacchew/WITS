# WITS (Weber Inventory Tracking System)


| [Dependencies](#dependencies) 	| [Setup Laravel](#setup-laravel) 	| [Start Laravel](#start-laravel) 	|
|-------------------------------	|---------------------------------	|---------------------------------	|
_____________________


## Dependencies


|           | Docker [Docs](https://goo.gl/bJhqjx) |               PHP 7 [Docs](http://php.net/docs.php)               |          Composer [Docs](https://goo.gl/wLWm1T)         |           Node [Downloads](https://nodejs.org/en/download/current/)           |
|:---------:|:------------------------------------:|:-----------------------------------------------------------------:|:-------------------------------------------------------:|:-----------------------------------------------------------------------------:|
|  **Win**  |  [Installer](https://goo.gl/hHCCMT)  |       [WAMP](http://www.wampserver.com/en/#download-wrapper)      | [Installer](https://getcomposer.org/Composer-Setup.exe) |      [Installer (64)](https://nodejs.org/dist/v7.7.2/node-v7.7.2-x64.msi)     |
|  **Mac**  |  [Installer](https://goo.gl/SOVPvM)  |                           Pre-installed                           |      Use [Docs](https://getcomposer.org/download/)      |        [Installer (64)](https://nodejs.org/dist/v7.7.2/node-v7.7.2.pkg)       |
| **Linux** |     [Docs](https://goo.gl/n0rXRg)    | [LAMP Docs](http://howtoubuntu.org/how-to-install-lamp-on-ubuntu) |      Use [Docs](https://getcomposer.org/download/)      | [Installer (64)](https://nodejs.org/dist/v7.7.2/node-v7.7.2-linux-x64.tar.xz) |


## Database Schema

````
https://www.lucidchart.com/documents/edit/6fe7035c-4ede-416a-844d-46168be1a34b
````

## Got everything? Let's do a quick check.

````
docker -v && php -v && composer -V && node -v && npm -v
````


## Clone Project

*Window Users: you might need to put this in **`[User Profile]/sites` directory** because docker & windows are still trying to work with each other* :)

Something like this:
`git clone git@github.com:WSUWITTS/WITS.git %UserProfile%/sites/wits`

`cd %UserProfile%/sites/wits` (Root level of the project)



## Setup Laravel

````
composer install
````

````
npm install
````

**Copy** a new `.env` from `.env.example`. This is where you put any Settings/Passwords/Keys
````
cp .env.example .env
````

````
php artisan app:setup
````


## Start Laravel


````
docker-compose up
````

````
npm run watch
````
