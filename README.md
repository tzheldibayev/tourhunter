# TourHunter

# Technologies
  - Yii2
  - MySQL
  - Nginx
  - Composer
  - Docker

## Install
```sh
$ git clone git@github.com:talgat065/tourhunter.git
$ cd tourhunter
$ php composer install
$ cp .env.example .env
$ docker-composer up -d
$ php yii migrate
```
## Test task

The user can only use a unique nickname without a password for authorization / registration. If there is no such user, then create it automatically and authorize. There is no separate registration. A public page should be made with a list of all users and their current balance, accessible without authorization.

For authorized users available:

The user can transfer any positive amount to another user (identification by nickname). In this case, the user's balance is reduced by the specified amount. The balance may be negative. Balance can not be less than -1000. The balance of all new users is by default 0. You can transfer any amount (with two decimal places for cents) only to an existing nickname. The user can not do the translation itself. Users in the database in the user table must have separate fields for balance. For transfers, be sure to use transactions.

Use yii2 (latest stable version, basic project template). Installing database from migrations, installing external plugins from composer with minimal stable stability. Code design in accordance with the coding style and directory structure in yii2. The code should not have bugs, security holes, violations of the planned logic. For development speed, use crud to create / edit / delete objects, as well as other features of yii2. The code must be professional, supported, and understandable.

