<?php

namespace App\Http\Controllers;

use App\Models\home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use  App\Http\Lazadas\lazada;
use  App\Http\Lazadas\LazopRequest;
use  App\Http\Lazadas\LazopClient;
use Carbon\Carbon;
use DateTime;
use DatePeriod;
use DateIntercal;
class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public $lazada;
    public $partner_id;
    public $partner_key;
    public $access_token='50000500830dXmfr8KFvYnRBebhWclQbyxC6GAs6ty1f49fcffYcKkRGZTBATFO';
    public $auth_url = 'https://auth.lazada.com/rest';
    public $api_url = 'https://api.lazada.com.ph/rest';

    public function __construct($access_token = '50000500830dXmfr8KFvYnRBebhWclQbyxC6GAs6ty1f49fcffYcKkRGZTBATFO') {
        $this->partner_id = '125715';
        $this->partner_key = 'PgHH3iKxhpf8AljMWgqsNnR3Jr0xSHe5';
        $this->access_token = $access_token;
        $this->lazada = new LazopClient($this->api_url, $this->partner_id, $this->partner_key);
    }

    public function index()
    {

        //
//         app key = 125715
// app secret = PgHH3iKxhpf8AljMWgqsNnR3Jr0xSHe5
// accessstoken = 50000500625qH2rLfTCpmoXOvCabfxDjwiROH10c23fdf6edyAPrYjnDxWGvAVb

 //// this is for lazada get autorazation //
            // try {
            //     $response = Http::get('https://auth.lazada.com/oauth/authorize?response_type=code&force_auth=true&uri=http://127.0.0.1:8000/'."&client_id=125715");
            //     return $response;
            // } catch(\Exception $e) {
            //     return false;
            // }


 //// get access token//

                //     $lazada = new LazopClient($this->auth_url, $this->partner_id, $this->partner_key);
                //     $request = new LazopRequest('/auth/token/create');
                //    $request->addApiParam('code', '0_125715_kwtK3DsmrVCroSrAR99rMF3m8484');
                //     return $lazada->execute($request);

                    // $lazada = new LazopClient($this->auth_url, $this->partner_id, $this->partner_key);
                    // $request = new LazopRequest("/auth/token/refresh");
                    // $request->addApiParam("refresh_token", "50001501e30rKydbrgqzWdHFPJxGqwke3HOOFtryys1003aa6cRvaBwBuQ0B2tM");
                    // echo  $lazada->execute($request);

                    $carbon = new Carbon();
                    $dt = Carbon::today()->toDateString();

             $lazada = new LazopClient($this->api_url, $this->partner_id, $this->partner_key);
            $request = new LazopRequest('/orders/get','GET');
            $request->addApiParam('created_after',$dt.'T00:00:00+08:00');
            $request->addApiParam('status','pending');
             return $lazada->execute($request, $this->access_token);




    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function zaloras()
    {

// Pay no attention to this statement.
// It's only needed if timezone in php.ini is not set correctly.
date_default_timezone_set("UTC");
$yesterday = Carbon::yesterday();
// The current time. Needed to create the Timestamp parameter below.
$now = new DateTime();


// The parameters for our GET request. These will get signed.
$parameters = array(
    // The user ID for which we are making the call.
    'UserID' => 'umcc.mdb.online@gmail.com',

    // The API version. Currently must be 1.0
    'Version' => '1.0',

    // The API method to call.
    'Action' => 'GetOrders',
    'Filter' => 'pending',

    //
    'CreatedAfter'=>$yesterday->format(DateTime::ISO8601),
    'CreatedBefore'=>$now->format(DateTime::ISO8601),

    // The format of the result.
    'Format' => 'JSON',

    // The current time formatted as ISO8601
    'Timestamp' => $now->format(DateTime::ISO8601)
);

// Sort parameters by name.
ksort($parameters);

// URL encode the parameters.
$encoded = array();
foreach ($parameters as $name => $value) {
    $encoded[] = rawurlencode($name) . '=' . rawurlencode($value);
}

// Concatenate the sorted and URL encoded parameters into a string.
$concatenated = implode('&', $encoded);

// The API key for the user as generated in the Seller Center GUI.
// Must be an API key associated with the UserID parameter.
$api_key = '24c1ae2b4f5c5cce2b3ee3a2426918993c90b04d';

// Compute signature and add it to the parameters.
$parameters['Signature'] =rawurlencode(hash_hmac('sha256', $concatenated, $api_key, false));
 $parameters['Signature'];


// ...continued from above

// Replace with the URL of your API host.
$url = "https://sellertest.herokuapp.com/zalora";

// Build Query String
$queryString = http_build_query($parameters, '', '&', PHP_QUERY_RFC3986);

// Open cURL connection
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url."?".$queryString);

// Save response to the variable $data
curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
$data = curl_exec($ch);


curl_close($ch);
$response = Http::get('https://sellercenter-api.zalora.com.ph', $queryString);

return $response;


    }

    public function create()
    {
        //

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\home  $home
     * @return \Illuminate\Http\Response
     */
    public function show(home $home)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\home  $home
     * @return \Illuminate\Http\Response
     */
    public function edit(home $home)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\home  $home
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, home $home)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\home  $home
     * @return \Illuminate\Http\Response
     */
    public function destroy(home $home)
    {
        //
    }
}
