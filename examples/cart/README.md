## Reservations Booking Demo

In this directory you will find examples and a working bare bones reservation booking system. Not intended for *production* use, and should act as an example to create an even better system. It is missing important validation and error checking. 

##### QUICK GUIDE
Change `HOST`, `CONSUMER_KEY` and `CONSUMER_SECRET` within `Cart.php` file, this information can be obtained via your Checkfront account.


### index.php

Default page fetches available inventory based on the selected date (defaults to today) and allows you to add multiple items.

**API calls:**

```
booking/session
item
```

### create.php

Booking form fields are requested from Checkfront via API and rendered on the page. 

Once a successful `booking/create` call has been completed, a url will be returned in the response. The url can differ depending on the booking and your configuration.

**API calls:**
```
booking/session
booking/create
booking/form
```


### Form.php
The form class is an optional helper class that renders the form fields into html.  


### Cart.php
Main wrapper class that encapsulates the Checkfront API and extends some custom calls. 
