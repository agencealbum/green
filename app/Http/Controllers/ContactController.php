<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NouveauMessage;

class ContactController extends Controller
{

	public function send(Request $request)
	{

		$validatedData = $request->validate([
	        'url' => 'required|url',
	        'email' => 'required|email:rfc,dns',
		    'tel' => ['required'],
		    'name' => ['required'],
		    'message' => ['required']
		]);

		$email = array(
	        'url' => $request->get('url'),
	        'email' => $request->get('email'),
		    'tel' => $request->get('tel'),
		    'name' => $request->get('name'),
		    'message' => $request->get('message')
		);

		try{
			Notification::route('mail', 'album@agencealbum.com')->notify(new NouveauMessage($email));
		}
		catch(\Exception $e){
		    //dd($e);
		    abort(422, 'Une erreur a eu lieu lors de l\'envoi du mail.');
		}
	}

}