<?php

namespace App\Http\Controllers\Mails;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Helpers\MailHelpers;

use App\Models\Mails\Mail;
use App\Models\Orders\Order;
use App\Models\Setting\App;

use App\Events\NewOrder;

class MailController extends Controller
{
	
	public function __construct()
    {
        $this->middleware('auth');
    }

	//
	public function message()
	{
		$mail = new MailHelpers();
		$mail->readAllMails();
		if(Mail::count() == 0){
			$message = $mail->getMessages();
		}else{
			$message = $mail->getMessagesUnRead();
		}

		$setting = App::find(1);

		foreach($message as $val){
			if((strpos($val['subject'], "[".$setting->name."]") !== false) && (strpos($val['subject'], "Form results") !== false)){
				$mails = new Mail;
				$mails->mail_index = $val['mail_index'];
				$mails->mailTypes = "form_editor";
				$mails->date = $val['date'];
				$mails->from = $val['from'];
				$mails->subject = $val['subject'];
				$mails->content = $val['content'];
				$mails->isread = 'false';
				$mails->save();

				$mailcontent = json_decode($mails->content);

				$order = new Order;
				if($mailcontent[0] == "Nama"){
					$order->nama = $mailcontent[1];
				}

				$key = array_search('Nomor HP', $mailcontent);
				if($key != null){
					$order->hp = $mailcontent[$key+1];
				}

				$key = array_search('Tanggal Pemesanan', $mailcontent);
				if($key != null){
					$order->tgl_pemesanan = date("Y-m-d", strtotime($mailcontent[$key+1]));
				}

				$key = array_search('Keterangan Lokasi Penjemputan', $mailcontent);
				if($key != null){
					$order->ket_lokasi_penjemputan = $mailcontent[$key+1];
				}

				$key = array_search('Lokasi Tujuan', $mailcontent);
				if($key != null){
					$order->tujuan = $mailcontent[$key+1];
				}

				$order->save();

				$key = array_search('Lokasi Penjemputan', $mailcontent);
				if($key != null){
					$order->newLokasi()
					  	  ->withTitle($mailcontent[$key+1]->title)
					  	  ->withAddress($mailcontent[$key+1]->address)
					  	  ->withLatitude($mailcontent[$key+1]->latitude)
					  	  ->withLongitude($mailcontent[$key+1]->longitude)
					  	  ->saveLokasi();
				}

				event(new NewOrder($order->nama));
			}
		}

	}
}
