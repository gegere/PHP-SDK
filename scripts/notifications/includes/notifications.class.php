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

		if (is_array($this->data)) {

			foreach ($this->data as $order) {

				// key used should also be a column in the database
				$d['host']	 		= $order->{'@attributes'}->host;
				$d['version']	 	= $order->{'@attributes'}->version;
				$d['status'] 		= $order->booking->status;
				$d['code'] 			= $order->booking->code;
				$d['email_date']	= $this->site->date->format('Y-m-d H:i:s');
				$d['created_date']	= date('Y-m-d H:i:s', $order->booking->created_date);
				$d['staff_id']		= $order->booking->staff_id;
				$d['source_ip']		= sprintf('%u', ip2long($order->booking->source_ip));
				$d['start_date']	= date('Y-m-d H:i:s', $order->booking->start_date);
				$d['end_date']		= date('Y-m-d H:i:s', $order->booking->end_date);
				$d['name']			= $order->booking->customer->name;
				$d['email']			= $order->booking->customer->email;
				$d['region']		= $order->booking->customer->region;
				$d['address']		= $order->booking->customer->address;
				$d['country']		= $order->booking->customer->country;
				$d['postal_zip']	= $order->booking->customer->postal_zip;
				$d['raw_data'] 		= serialize($this->raw_data);

				$a = array_filter( $d, 'strlen' );
				$this->dataArray[] = $a;

			} // END foreach
		} else {
			error_log("Array Missing", 0);
		}
    }

}

?>