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

		foreach ($this->data as $order) {

			$host	 		= $order->{'@attributes'}->host;
			$version	 	= $order->{'@attributes'}->version;
			$status 		= $order->booking->status;
			$code 			= $order->booking->code;
			$email_date		= $this->site->date->format('Y-m-d H:i:s');
			$created_date	= date('Y-m-d H:i:s', $order->booking->created_date);
			$staff_id		= $order->booking->staff_id;
			$source_ip		= sprintf('%u', ip2long($order->booking->source_ip));
			$start_date		= date('Y-m-d H:i:s', $order->booking->start_date);
			$end_date		= date('Y-m-d H:i:s', $order->booking->end_date);
			$name			= $order->booking->customer->name;
			$email			= $order->booking->customer->email;
			$region			= $order->booking->customer->region;
			$address		= $order->booking->customer->address;
			$country		= $order->booking->customer->country[0];
			$postal_zip		= $order->booking->customer->postal_zip;
			

			$this->dataArray[] = array('host'		=> $host,
									'version'		=> $version,
									'status' 		=> $status, 
									'code' 			=> $code,
									'email_date' 	=> $email_date,
									'created_date' 	=> $created_date, 
									'staff_id' 		=> $staff_id, 
									'source_ip' 	=> $source_ip, 
									'start_date' 	=> $start_date,
									'end_date' 		=> $end_date, 
									'name' 			=> $name,
									'email' 		=> $email, 
									'region' 		=> $region,
									'address' 		=> $address, 
									'country' 		=> $country,
									'postal_zip' 	=> $postal_zip,
									'raw_data'		=> serialize($this->raw_data)
									);
		} // END foreach

    }

}

?>