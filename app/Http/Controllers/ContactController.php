<?php

namespace App\Http\Controllers;

use App\Mail\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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

		$response = Notification::route('mail', 'album@agencealbum.com')->notify(new NouveauMessage($email));

		return response()->json($response);

	}

}