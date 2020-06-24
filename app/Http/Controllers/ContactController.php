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
	        'email' => 'required|email:rfc,dns',
		    'tel' => ['required'],
		    'name' => ['required'],
		    'message' => ['required']
		]);

		$email = array(
	        'company' => $request->get('company'),
	        'email' => $request->get('email'),
		    'tel' => $request->get('tel'),
		    'name' => $request->get('name'),
		    'message' => $request->get('message')
		);

		$response = Notification::route('mail', ['album@agencealbum.com', 'maxime.massa@agencealbum.com'])->notify(new NouveauMessage($email));

		return response()->json($response);

	}

}