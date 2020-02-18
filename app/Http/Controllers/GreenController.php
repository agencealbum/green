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

	public function getProgess()
	{

		$progress = Session::get('progress') * 100 / 5;
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

		return response()->json([
			'hosting' => $hosting,
			'carbon' => $this->carbon($url),
			'pagespeed' => $this->pagespeed($url),
			'tags' => $this->tags($url),
			'headers' => $this->headers($url),
			'title' => $this->title($url),
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

		Session::put('progress', Session::get('progress') + 1);
		Session::save();

		return json_decode($response->getBody(), true);

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
