<?php

namespace App\Http\Controllers;

use Session;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class GreenController extends Controller
{

	public function index()
	{
		return view('welcome');
	}

	public function store(Request $request) 
	{
		
	}

	public function getProgess()
	{

		$progress = Session::get('progress') * 100 / 6;
	    return response()->json($progress);
	}

	public function scan(Request $request)
	{
		
		$url = $request->url;

		Session::put('progress', 0);
		Session::save();

		if( $hosting = $this->hosting($this->remove_http($url)) ) {
			Session::put('progress', Session::get('progress') + 1);
			Session::save();
		}

		if( $pagespeed = $this->pagespeed($url) ) {

			$performance = $pagespeed->getSpeedScore();
			$usability = $pagespeed->getUsabilityScore();

			Session::put('progress', Session::get('progress') + 1);
			Session::save();
		}

		if( $carbon = $this->carbon($url) ) {
			Session::put('progress', Session::get('progress') + 1);
			Session::save();
		}

		return response()->json([
			'hosting' => $hosting,
			'performance' => $performance,
			'usability' => $usability,
			'carbon' => $carbon,
			'tags' => $this->tags($url),
			'headers' => $this->headers($url),
			'title' => $this->title($url),
			'url' => $url,
		]);
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

	public function pagespeed($url)
	{

		$key = env("GOOGLE_PAGESPEED_APP_KEY");
		$caller = new \PhpInsights\InsightsCaller($key, 'fr');
		$response = $caller->getResponse($url, \PhpInsights\InsightsCaller::STRATEGY_MOBILE);
		$result = $response->getMappedResult();
		return $result;

	}

    public function hosting($url)
    {

		$endpoint = "https://api.thegreenwebfoundation.org/greencheck/" . $url;
		$client = new Client();

		$response = $client->request('GET', $endpoint);

		// url will be: http://my.domain.com/test.php?key1=5&key2=ABC;

		$statusCode = $response->getStatusCode();

		$hosting = json_decode($response->getBody()->getContents());
		$hosting = ($hosting->green) ? 100 : 25;

		return $hosting;

    }

    public function carbon($url)
    {

		$endpoint = "https://api.websitecarbon.com/b";
		$client = new Client();

		$response = $client->request('GET', $endpoint, ['query' => [
		    'url' => $url, 
		]]);

		$statusCode = $response->getStatusCode();
		$carbon = json_decode($response->getBody(), true); // Carbon (gramme)
		$carbon = intval(round( ($carbon['c'] > 1) ? 0 : (100 - ($carbon['c'] * 100)), 0 )); // Convert to percent

		return $carbon;

    }

    public function tags($url)
    {

    	$tags = get_meta_tags($url);

		Session::put('progress', Session::get('progress') + 1);
		Session::save();


    	return $tags;

    }

    public function headers($url)
    {

    	$headers = get_headers($url);

		Session::put('progress', Session::get('progress') + 1);
		Session::save();


    	return $headers;

    }

    public function title($url)
    {

		$data = file_get_contents($url);
    	$title = preg_match('/<title[^>]*>(.*?)<\/title>/ims', $data, $matches) ? $matches[1] : null;

		Session::put('progress', Session::get('progress') + 1);
		Session::save();

    	return $title;

    }

}
