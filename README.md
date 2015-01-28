[![Build Status](https://travis-ci.org/htmlgraphic/PHP-SDK.svg?branch=feature/travis-ci)](https://travis-ci.org/htmlgraphic/PHP-SDK)

# Checkfront PHP SDK (v3.0)

The [Checkfront API](http://api.checkfront.com/en/latest/) allows you 
to build integrations and custom applications that interact with the Checkfront service. 

##Features

The Checkfront API SDK provides the following functionality:

* OAuth 2.0 authorization and authentication.
* OAuth 2.0 token refresh.
* Token pair authorization.
* Session handing.
* Access to Checkfront Objects via GET, POST, PUT and DELETE request.


## Installation

This repo is setup to extend off of the library created by Checkfront. To easily add or **update** this library, a Composer.json file has been created. 

If you are not using [Composer](http://getcomposer.org), you should be. It's an excellent way to manage dependencies in your PHP application. Offically Checkfront does not have a registered Composer library, no problem it can be setup via the following code:

Setup composer with the needed code:

```
$ composer init --require=checkfront/checkfront:dev-master -n 
$ composer install
```
Now the needed code should be available within your project.


Next, at the top of your PHP script require the autoloader:

```bash
require 'vendor/autoload.php';
```


## Usage

The examples are a good place to start, there are several in the `examples` folder. The minimal you'll need to have is:

```php
<?php
$Checkfront = new Checkfront(
    array(
        'host'=>'your-company.checkfront.com',
        'auth_type' => 'token',
        'consumer_key'  => 'CHANGE_ME',
        'consumer_secret' => 'CHANGE_ME',
        'account_id' => 'off',
    )
);
?>
```

```php
<?php
    // fetch all bookings
    public function query_booking($booking_id) {
        $response = $this->Checkfront->get('booking/index');
        return $response;
    }
?>
```

