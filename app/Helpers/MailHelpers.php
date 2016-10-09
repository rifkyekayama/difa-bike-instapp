<?php

namespace App\Helpers;

use App\Libs\PhpImap\Mailbox as ImapMailbox;
use App\Libs\PhpImap\IncomingMail;
use App\Libs\PhpImap\IncomingMailAttachment;

use App\Models\Mails\Mail;
use App\Models\Setting\App;

class MailHelpers{

	private $mailbox;
	private $mailsIds;

	public function __construct(){
		$this->mailbox = new ImapMailbox('{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX', config('imap.username'), config('imap.password'), app_path('Mails/Attachments/'));
	}

	public function readAllMails(){
		// Read all messaged into an array:
		$this->mailsIds = $this->mailbox->searchMailbox('ALL');
		if(!$this->mailsIds) {
		    die('Mailbox is empty');
		}
	}

	public function getMessages(){
		$result = [];
		$item = [];
		$setting = App::find(1);
		$isApps = false;

		for($i=0;$i<sizeof($this->mailsIds);$i++){
			$mail = $this->mailbox->getMail($this->mailsIds[$i]);
			foreach ($mail->getAttachments() as $attach) {
				if(strpos($mail->subject, "[".$setting->name."]") !== false){
					# code...
					$ext = pathinfo($attach->filePath, PATHINFO_EXTENSION);
					if($ext == "html"){
						$myfile = fopen($attach->filePath, "r") or die("Unable to open file!");
						$mailContent = fread($myfile,filesize($attach->filePath));

						$mailContent = strip_tags($mailContent);

						$mailContent = explode(PHP_EOL, $mailContent);
						
						for($j=0;$j<sizeof($mailContent);$j++){
							$mailContent[$j] = trim($mailContent[$j]);
						}

						$mailContent =  array_values(array_filter($mailContent, function($value) { return $value !== ''; }));

						$mailContent = $this->getGPSData($mailContent);

						for($j=0; $j<sizeof($mailContent); $j++){
							$mailContent[$j] = str_replace(':', '', $mailContent[$j]);
						}

						if($this->checkMail($mail->subject, "") == "order"){
							array_splice($mailContent, 0, 2);
							$item = $this->getDetailOrder($mailContent);
						}
					}
					$isApps = true;
				}
			}
			if($this->checkMail($mail->subject, "") == "order"){
					if($isApps){
						array_push($result, $this->getDataOrder($mail, $mailContent, $item));
					}
				}else{
					if($isApps){
						array_push($result, $this->getDataFormEditor($mail, $mailContent));
					}
				}
		}
		return $result;
	}

	public function getMessagesUnRead(){
		$result = [];
		$switch = true;
		$index = sizeof($this->mailsIds)-1;
		$setting = App::find(1);
		$isApps = false;

		$lastIndex = Mail::orderBy('mail_index', 'desc')->first();
		while($switch){

			$mail = $this->mailbox->getMail($this->mailsIds[$index]);
			$id = $mail->id;

			if($id > $lastIndex->mail_index){

				foreach ($mail->getAttachments() as $attach) {
				# code...
					if(strpos($mail->subject, "[".$setting->name."]") !== false){
						$ext = pathinfo($attach->filePath, PATHINFO_EXTENSION);
						if($ext == "html"){
							$myfile = fopen($attach->filePath, "r") or die("Unable to open file!");
							dd($myfile);
							$mailContent = fread($myfile,filesize($attach->filePath));

							$mailContent = strip_tags($mailContent);

							$mailContent = explode(PHP_EOL, $mailContent);
							
							for($j=0;$j<sizeof($mailContent);$j++){
								$mailContent[$j] = trim($mailContent[$j]);
							}

							$mailContent =  array_values(array_filter($mailContent, function($value) { return $value !== ''; }));

							$mailContent = $this->getGPSData($mailContent);
						
							for($j=0; $j<sizeof($mailContent); $j++){
								$mailContent[$j] = str_replace(':', '', $mailContent[$j]);
							}

							if($this->checkMail($mail->subject, "") == "order"){
								array_splice($mailContent, 0, 2);
								$item = $this->getDetailOrder($mailContent);
							}
						}
						$isApps = true;
					}
				}

				if($this->checkMail($mail->subject, "") == "order"){
					if($isApps){
						array_push($result, $this->getDataOrder($mail, $mailContent, $item));
					}
				}else{
					if($isApps){
						array_push($result, $this->getDataFormEditor($mail, $mailContent));
					}
				}
			}else{
				$switch = false;
			}
			$index--;
		}

		return array_reverse($result);
	}

	public function checkMail($subject, $title){
		$mail = "";
		if(strpos($subject, "New order is placed") !== false){
			$mail = "order";
		}else{
			$mail = "formEditor";
		}
		return $mail;
	}

	public function getGPSData($mailContent){
		for($j=0; $j<sizeof($mailContent); $j++){
			if($j+3 <= sizeof($mailContent)){
				if((strpos($mailContent[$j], 'Title') !== false) && (strpos($mailContent[$j+1], 'Address') !== false) && (strpos($mailContent[$j+2], 'Latitude') !== false) && (strpos($mailContent[$j+3], 'Longitude') !== false)){
					$gps['title'] = explode(':', $mailContent[$j])[1];
					$tmp = $j;
					$j++;
					$gps['address'] = explode(':', $mailContent[$j])[1];
					unset($mailContent[$j]);
					$j++;
					$gps['latitude'] = explode(':', $mailContent[$j])[1];
					unset($mailContent[$j]);
					$j++;
					$gps['longitude'] = explode(':', $mailContent[$j])[1];
					unset($mailContent[$j]);
					$j++;
					$mailContent[$tmp] = $gps;
				}
			}
		}

		return array_values($mailContent);
	}

	public function getDetailOrder($mailContent){
		$item = [];

		for($i=0;$i<sizeof($mailContent);$i++){
			if(strpos($mailContent[$i], "Details:") !== false){
				$j=$i+1;
				$isCustomer=true;
				$x=1;
				while($isCustomer){
					if(strpos($mailContent[$j], "Customer ID:") !== false){
						$isCustomer=false;
					}else{
						if($x==1){
							array_push($item, [$mailContent[$j], $mailContent[$j+1], $mailContent[$j+2]]);
						}
						$j++;
						$x++;
						if($x == 4){
							$x=1;
						}
					}
				}
				$i=$j;
			}
		}
		return $item;
	}

	public function getDataOrder($mail, $mailContent, $item){
		$order = [];
		$result = [];

		$order['id'] = trim(explode(":", $mailContent[0])[1]);
		for($i=1;$i<sizeof($mailContent);$i++){
			if(strpos($mailContent[$i], "Delivery type:") !== false){
				$order['delivery_type'] = trim(explode(":", $mailContent[$i])[1]);
			}
			if(strpos($mailContent[$i], "Delivery price:") !== false){
				$order['delivery_price'] = trim(explode(":", $mailContent[$i])[1]);
			}
			if(strpos($mailContent[$i], "Amount to charge:") !== false){
				$order['amount_to_charge'] = trim(explode(":", $mailContent[$i])[1]);
			}
			if(strpos($mailContent[$i], "Payment solution:") !== false){
				$order['payment_solution'] = trim(explode(":", $mailContent[$i])[1]);
			}
			if(strpos($mailContent[$i], "Special Request:") !== false){
				$order['special_request'] = trim(explode(":", $mailContent[$i])[1]);
			}
			if(strpos($mailContent[$i], "Details:") !== false){
				$order['details'] = json_encode($item);
			}
			if(strpos($mailContent[$i], "Customer ID:") !== false){
				$order['customer_id'] = trim(explode(":", $mailContent[$i])[1]);
			}
			if(strpos($mailContent[$i], "Login:") !== false){
				$order['login'] = trim(explode(":", $mailContent[$i])[1]);
			}
			if(strpos($mailContent[$i], "Name:") !== false){
				$order['name'] = trim(explode(":", $mailContent[$i])[1]);
			}
			if(strpos($mailContent[$i], "Address:") !== false){
				$order['address'] = trim(explode(":", $mailContent[$i])[1]);
			}
			if(strpos($mailContent[$i], "Zip:") !== false){
				$order['zip'] = trim(explode(":", $mailContent[$i])[1]);
			}
			if(strpos($mailContent[$i], "City:") !== false){
				$order['city'] = trim(explode(":", $mailContent[$i])[1]);
			}
			if(strpos($mailContent[$i], "Country:") !== false){
				$order['country'] = trim(explode(":", $mailContent[$i])[1]);
			}
			if(strpos($mailContent[$i], "Phone:") !== false){
				$order['phone'] = trim(explode(":", $mailContent[$i])[1]);
			}
			if(strpos($mailContent[$i], "Email:") !== false){
				$order['email'] = trim(explode(":", $mailContent[$i])[1]);
			}
			if(strpos($mailContent[$i], "Birthdate:") !== false){
				$order['birthdate'] = trim(explode(":", $mailContent[$i])[1]);
			}
			if(strpos($mailContent[$i], "Gender:") !== false){
				$order['gender'] = trim(explode(":", $mailContent[$i])[1]);
			}
			if(strpos($mailContent[$i], "Contact email:") !== false){
				$order['contact_email'] = trim(explode(":", $mailContent[$i])[1]);
			}
			if(strpos($mailContent[$i], "Link to customer:") !== false){
				$order['link_to_customer'] = trim(explode(":", $mailContent[$i])[1]);
			}
		}
		$result['mail_index'] = $mail->id;
		$result['date'] = $mail->date;
		$result['from'] = $mail->headers->fromaddress;
		$result['subject'] = $mail->subject;
		$result['content'] = json_encode($order);
		return $result;
	}

	public function getDataFormEditor($mail, $mailContent){
		$result["mail_index"] = $mail->id;
		$result["date"] = $mail->date;
		$result["from"] = $mail->headers->fromaddress;
		$result["subject"] = $mail->subject;
		$result["content"] = json_encode($mailContent);
		return $result;
	}
}