<?php

/*

Logging the notifications sent from Checkfront, from this process we can customize and build additional features

*/

class Notification 
{
	public $data;
	public $dataArray;

	function __construct(){  
		$this->raw_data = (file_get_contents('php://input'));
		$this->data = json_decode($this->raw_data);

        // Set an array with the correct timezone to unsure proper timestamp
        $this->site = new StdClass;
        $this->site->date = new DateTime();
        $this->site->date->setTimezone(new DateTimeZone('GMT'));

    }

    // Use this function when parsing and storing data sent via a Checkfront notification
	public function ParseNotificationData() {

		if (is_object($this->data)) {
			// Single JSON object
			$order = $this->data;
		} else {
			// Array form from Checkfront, order version
			$order = $this->data[0];
		}

		$this->dataArray[] = $order;
    }

}

?>