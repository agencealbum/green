<?php

namespace App\Http\Controllers;

use Session;
use App\Scan;
use GuzzleHttp\Client;
use Goutte\Client as Goutte;
use Illuminate\Http\Request;

class GreenController extends Controller
{

	protected $url;


	public function index()
	{
		return view('welcome');
	}


	// Check if the requested url exists
	public function url_exists(Request $request)
	{
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

		if( $hosting = $this->hosting() ) {

			$this->incrementProgess();

			if( $pagespeed = $this->pagespeed() ) {

				$this->incrementProgess();

				$performance = $pagespeed->getSpeedScore();
				$usability = $pagespeed->getUsabilityScore();
				

				if( $carbon = $this->carbon() ) {

					$this->incrementProgess();

					if( $infos = $this->infos() ) {
						$infos['url'] = $this->url;
						$infos['email'] = $request->email;
						$infos['ip'] = $request->ip();
						$this->incrementProgess();
					}

				}

			}

		}

		$total = round( ($hosting + $performance + $usability + $carbon) / 4);

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
        $scan->carbon_score = $result['carbon'];
        $scan->total_score = $result['total'];

        $scan->save();
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

		$key = env("GOOGLE_PAGESPEED_APP_KEY");
		$caller = new \PhpInsights\InsightsCaller($key, 'fr');
		$response = $caller->getResponse($this->url, \PhpInsights\InsightsCaller::STRATEGY_MOBILE);
		$result = $response->getMappedResult();
		return $result;

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
		    'url' => $this->url, 
		]]);

		$statusCode = $response->getStatusCode();
		$carbon = json_decode($response->getBody(), true); // Carbon (gramme)
		$carbon = intval(round( ($carbon['c'] > 1) ? 0 : (100 - ($carbon['c'] * 100)), 0 )); // Convert to percent

		return $carbon;

    }

    public function infos() {

		$client = new Goutte();

		$crawler = $client->request('GET', $this->url);

		$title = $crawler->filter('title')->text();
		$description = $crawler->filterXpath('//meta[@name="description"]')->eq(0)->attr('content');

		return array(
			'title' => $title,
			'description' => $description
		);

    }

}
