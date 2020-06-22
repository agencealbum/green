<?php

namespace App\Http\Controllers;

use Session;
use App\Scan;
use GuzzleHttp\Client;
use Goutte\Client as Goutte;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NouveauTest;

class GreenController extends Controller
{

	protected $url;


	public function index()
	{
		return view('welcome');
	}

	public function verification(Request $request)
	{
	    $validator = Validator::make($request->all(), [
	        'url' => 'required|url',
	        'email' => 'required|email:rfc,dns'
	    ]);

 		if ($validator->fails()) {

 			return response()->json(['url' => false, 'email' => false]);

 		} else {

			$file_headers = @get_headers($request->url);
			$urlexists = (!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') ? false : true;

			$verified = VerifyEmail::where('email', $request->email)->andWhere('verified', true)->exists();

			if ($urlexists) {

				if ($verified) {

					return response()->json(['url' => true, 'email' => true]);

				} else {

			        $verify = new Verifyemail;
			        $verify->email = $request->get('email');
			        $verify->code = mt_rand(10000, 99999);
			        $scan->save();

			        return response()->json(['url' => true, 'email' => false]);

				}

			} else {

				return response()->json(['url' => false, 'email' => false]);

			}

		}

	}

	// Check if the requested url exists
	public function url_exists(Request $request)
	{

	    $validator = Validator::make($request->all(), [
	        'url' => 'required|url',
	        'email' => 'required|email:rfc,dns'
	    ]);

 		if ($validator->fails()) {
 			return response()->json(false);
 		}

		$file_headers = @get_headers($request->url);
		$exists = (!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') ? false : true;
	    return response()->json($exists);
	}

	// Increment the current progress session
	public function incrementProgess()
	{
		Session::put('progress', Session::get('progress') + 1);
		Session::save();
	}

	// Return the progress session status
	public function getProgess()
	{
		$progress = Session::get('progress') * 100 / 3.4;
	    return response()->json($progress);
	}

	// Launch the url scan
	public function scan(Request $request)
	{
		
		$this->url = $request->url;

		Session::put('progress', 0);
		Session::save();

		// HOSTING
		try {
			$hosting = $this->hosting();
			$this->incrementProgess();
		} catch (Exception $e) {
			return response()->json(['error' => true]);
		}

		// PAGESPEED
		try {
			$pagespeed = $this->pagespeed();
			$performance = $pagespeed['performance'];
			$usability = $pagespeed['usability'];
			$this->incrementProgess();
		} catch (Exception $e) {
			return response()->json(['error' => true]);
		}

		// CARBON
		try {
			$carbon = $this->carbon();
			$this->incrementProgess();
		} catch (Exception $e) {
			return response()->json(['error' => true]);
		}

		// INFOS
		try {
			$infos = $this->infos();
			$infos['url'] = $this->url;
			$infos['email'] = $request->email;
			$infos['ip'] = $request->ip();
			$this->incrementProgess();
		} catch (Exception $e) {
			return response()->json(['error' => true]);
		}

		$total = round( ($hosting + $performance + $usability + intval($carbon['percent']) ) / 4);

		$result = [
			'hosting' => $hosting,
			'performance' => $performance,
			'usability' => $usability,
			'carbon' => $carbon,
			'infos' => $infos,
			'total' => $total,
		];

		if ($result) $this->store($result);

		return response()->json($result);

	}

	public function store($result)
	{
        $scan = new Scan;

        $scan->ip = $result['infos']['ip'];
        $scan->email = $result['infos']['email'];
        $scan->url = $result['infos']['url'];
        $scan->hosting_score = $result['hosting'];
        $scan->performance_score = $result['performance'];
        $scan->responsive_score = $result['usability'];
        $scan->carbon_score = $result['carbon']['percent'];
        $scan->total_score = $result['total'];

        $scan->save();

		Notification::route('mail', ['album@agencealbum.com', 'maxime.massa@agencealbum.com'])
					->notify(new NouveauTest($scan));

	}


	public function remove_http($url) {
	   $disallowed = array('http://', 'https://');
	   foreach($disallowed as $d) {
	      if(strpos($url, $d) === 0) {
	         return str_replace($d, '', $url);
	      }
	   }
	   return $url;
	}

	public function pagespeed()
	{
/*
		$key = env("GOOGLE_PAGESPEED_APP_KEY");
		$caller = new \PhpInsights\InsightsCaller($key, 'fr');
		$response = $caller->getResponse($this->url, \PhpInsights\InsightsCaller::STRATEGY_MOBILE);
		$result = $response->getMappedResult();
		return $result;
*/


        $key = env('GOOGLE_PAGESPEED_APP_KEY');
        $website = $this->url;

        $client = new \GuzzleHttp\Client();

        $result = $client->request('GET', 'https://www.googleapis.com/pagespeedonline/v5/runPagespeed?category=PERFORMANCE&category=ACCESSIBILITY&url=' .$website. '&key=' . $key);
		$result = json_decode($result->getBody());

		$performance = $result->lighthouseResult->categories->performance->score * 100;
		$usability = $result->lighthouseResult->categories->accessibility->score * 100;

		return array(
			'performance' => $performance,
			'usability' => $usability
		);

	}

    public function hosting()
    {

    	$url = $this->remove_http($this->url);

		$endpoint = "https://api.thegreenwebfoundation.org/greencheck/" . $url;
		$client = new Client();

		$response = $client->request('GET', $endpoint);

		// url will be: http://my.domain.com/test.php?key1=5&key2=ABC;

		$statusCode = $response->getStatusCode();

		$hosting = json_decode($response->getBody()->getContents());
		$hosting = ($hosting->green) ? 100 : 25;

		return $hosting;

    }

    public function carbon()
    {

		$endpoint = "https://api.websitecarbon.com/b";
		$client = new Client();

		$response = $client->request('GET', $endpoint, ['query' => [
		    'url' => $this->remove_http($this->url)
		]]);

		$statusCode = $response->getStatusCode();
		$carbon = json_decode($response->getBody(), true); // Carbon (gramme)

		$percent = intval(round( ($carbon['c'] > 2) ? 0 : (100 - ($carbon['c']/2 * 100)), 0 )); // Convert to percent

		return array(
			'g' => $carbon['c'],
			'percent' => $percent
		);

    }

    public function infos() {

		$client = new Goutte();

		$crawler = $client->request('GET', $this->url);

		try {
			$title = ($crawler->filter('title')->count()) ? $crawler->filter('title')->text() : 'Aucun titre';
		} catch(Exception $e) {
			$title = 'Aucun titre';
		}

		try {
			$description = ($crawler->filterXpath('//meta[@name="description"]')->count()) ? $crawler->filterXpath('//meta[@name="description"]')->eq(0)->attr('content') : '';

		} catch(Exception $e) {
			$description = "Aucune description";
		}


		return array(
			'title' => $title,
			'description' => $description
		);

    }

}
