<?php
require_once 'includes/db.class.php';
require_once 'includes/notifications.class.php';


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
				$db->insert('notifications', $data);
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