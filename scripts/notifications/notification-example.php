<?php
require_once 'vendor/checkfront/checkfront/scripts/notifications/includes/db.class.php';
require_once 'vendor/checkfront/checkfront/scripts/notifications/includes/notifications.class.php';


## COMMENTED CODE IS USED TO WRITE TO A FILE, GOOD FOR DEBUGGING

#$fh = fopen('json_parse.log', 'a+') or die("Error opening output file");

#if ( $fh ) {

	// Check if the post is coming from Checkfront servers
	if (strstr($_SERVER['HTTP_USER_AGENT'], 'Checkfront') || $_SERVER['SERVER_ADDR'] == '127.0.0.1') {

		$notifications = new Notification();
		$notifications->ParseNotificationData();

		$db = new MysqliDb('localhost', 'username', 'P@$sw0rD', 'domain_com');

		if (is_array($notifications->dataArray))
		{
			foreach ( $notifications->dataArray as $data ) 
			{
				// key used should also be a column in the database
				// need additional data simply add it
				$d['host']	 		= $data->{'@attributes'}->host;
				$d['version']	 	= $data->{'@attributes'}->version;
				$d['status'] 		= $data->booking->status;
				$d['code'] 			= $data->booking->code;
				$d['email_date']	= $notifications->site->date->format('Y-m-d H:i:s');
				$d['created_date']	= date('Y-m-d H:i:s', $data->booking->created_date);
				$d['staff_id']		= $data->booking->staff_id;
				$d['source_ip']		= sprintf('%u', ip2long($data->booking->source_ip));
				$d['start_date']	= date('Y-m-d H:i:s', $data->booking->start_date);
				$d['end_date']		= date('Y-m-d H:i:s', $data->booking->end_date);
				$d['name']			= $data->booking->customer->name;
				$d['email']			= $data->booking->customer->email;
				$d['region']		= $data->booking->customer->region;
				$d['address']		= $data->booking->customer->address;
				$d['country']		= $data->booking->customer->country;
				$d['postal_zip']	= $data->booking->customer->postal_zip;
				$d['raw_data'] 		= serialize($notifications->raw_data);

				$a = array_filter( $d, 'strlen' ); // this will remove emtpy object from causing database insertion issues
				$db->insert('notifications', $a);
			}
			
			echo "Ok";

		} else {

			// Any errors? Let's review in the logs
			error_log("Invalid Array: " . print_r($notifications->dataArray, TRUE), 0);

		}


#	    fwrite($fh, serialize($notifications->dataArray));
#	    fclose($fh);
		
	} else {
		error_log("Invalid Host", 0);
	}
#}

?>