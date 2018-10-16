[![Build Status](https://travis-ci.org/htmlgraphic/Checkfront-PHP-SDK.svg?branch=master)](https://travis-ci.org/htmlgraphic/Checkfront-PHP-SDK)

Checkfront PHP SDK (v1.3)
==========================

The [Checkfront API 3.0](http://www.checkfront.com/developers/api/) allows you to build integrations and custom applications that interact with a remote Checkfront account.

This repository contains the open source PHP SDK and various example scripts. Except as otherwise noted, the Checkfront PHP SDK is licensed under the Apache Licence, Version 2.0
(http://www.apache.org/licenses/LICENSE-2.0.html)

---

## Features

The Checkfront API SDK (v1.3) provides the following functionality:

* OAuth2 authorization and authentication.
* OAuth2 token refresh.
* Token pair authorization.
* Session handing.
* Access to Checkfront Objects via GET, POST, PUT and DELETE request.
* Notifications via API Hook
* Installation via PHP Composer


## Installation & Usage

This repo is setup to extend off of the library created by Checkfront. To update this library, a Composer.json file has been created. 

If you are not using [Composer](http://getcomposer.org), you should be. It's an excellent way to manage dependencies in your PHP application. 

## Quick Start

Let's install Checkfront-PHP-DK via the following few commands:

>   Type `composer` for more options:

```
$ composer init --require="checkfront/checkfront:1.3" -n 
$ composer install
```

```bash
require 'vendor/autoload.php';
```
Now the needed code should be available within your project. At the top of your PHP script require the autoloader, if you are using a MVC such as CodeIgnitor or Laravel review their autoload guides. 

**API credintials:** [https://{your-company}.checkfront.com/manage/developer/](https://{your-company}.checkfront.com/manage/developer/)


> The repo example files are a good place to start. 

```shell
PHP-SDK                     # → Root of Service
└── examples/
   └── cart
	   ├── Cart.php         # → Main wrapper class, ADD API KEY
	   ├── create.php       # → Process $_POST request, add to cart session
	   ├── Form.php         # → Various PHP functions
	   ├── index.php        # → Default view, list available inventory
	   └── README.md        # → File overview & tips
```

#### OAuth2 Access
```php
<?php
$Checkfront = new Checkfront(
	array(
		'host' => 'your-company.checkfront.com',
		'consumer_key' => '5010076404ec1809470508',
		'consumer_secret' => 'ba0a5c0c509445024c374fcd264d41e816b02d4e',
		'redirect_uri' => 'oob',
	));
?>
```


#### Token Access

```php
<?php
$Checkfront = new Checkfront(
	array(
		'host' => 'your-company.checkfront.com',
		'auth_type' => 'token',
		'api_key' => '5010076404ec1809470508',
		'api_secret' => 'ba0a5c0c509445024c374fcd264d41e816b02d4e',
	));
?>
```

#### PHP Examples
```php
<?php
// Get items rates and availbility
$items = $Checkfront->get('item',array(
			'start_date'=>date('Y-m-d'),
			'end_date'=>date('Y-m-d',strtotime('+3 days'))
		));

print_r( $items );

// Fetch all bookings
public function query_booking() 
{
	$response = $this->Checkfront->get('booking/index');
	return $response;
}

print_r(query_booking() );
?>
```



Notifications via Checkfront API
===
Send reminders to guests as they arrive with details and directions. Send a follow-up thank you message as your guests jet home.

## Overview
Traveling to new areas requires planning for the unexpected and help from trusted travel partners. Have tips and maps sent to your guests a day before they arrive via email or text message.

There might be a need to send out more targeted emails with your reservations and this can be done. By using the event notification service from Checkfront a notification can be sent to a server with information about the reservation. Using Notification Service a custom template can be used to inform guests.

An additional example. Let’s say you have 5 properties and they spread around the city. The guest booked a reservation at 123 ABC Street and after booking a rental car they are on their way. They indicated their approximate arrival time. You could have a text message or email informing the guest of arrival instructions as they indicated their check-in time via the booking.


## Usage
Move the following example file `notifications-example.php` to a place of your choosing and include update the path(s) to the class files needed to process this script. 



### Notification Service Breakdown

```shell
PHP-SDK                                 # → Root of Service
└── scripts/
   └── notifications
	   ├── includes
	   │   ├── db.class.php             # → DB Interface Class 
	   │   └── notifications.class.php  # → Parse of incoming data
	   ├── notifications-example.php    # → Processing Example file
	   └── notifications.sql            # → DB Example File
```


## Contributing

1. Fork it
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Make your changes
4. Run the tests, adding new ones for your own code if necessary (`phpunit`)
5. Commit your changes (`git commit -am 'Added some feature'`)
6. Push to the branch (`git push origin my-new-feature`)
7. Create new Pull Request
