<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class GreenController extends Controller
{

	private $pagespeed;

	public function index()
	{
		return view('welcome');
	}

	public function scan(Request $request)
	{
		
		$url = $request->url;

		return response()->json([
			'hosting' => $this->hosting($this->remove_http($url)),
			'carbon' => $this->carbon($url),
			'pagespeed' => $this->pagespeed($url),
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

		return response()->json([
			'speedScore' => $result->getSpeedScore(),
			'usabilityScore' => $result->getUsabilityScore(),
			'thumbnail' => $result->screenshot->getData()
		]);

	}

    public function hosting($url)
    {

		$endpoint = "https://api.thegreenwebfoundation.org/greencheck/" . $url;
		$client = new Client();

		$response = $client->request('GET', $endpoint);

		// url will be: http://my.domain.com/test.php?key1=5&key2=ABC;

		$statusCode = $response->getStatusCode();
		return json_decode($response->getBody()->getContents());

    }

    public function carbon($url)
    {

		$endpoint = "https://api.websitecarbon.com/b";
		$client = new Client();

		$response = $client->request('GET', $endpoint, ['query' => [
		    'url' => $url, 
		]]);

		// url will be: http://my.domain.com/test.php?key1=5&key2=ABC;

		$statusCode = $response->getStatusCode();
		return json_decode($response->getBody(), true);

    }
}
