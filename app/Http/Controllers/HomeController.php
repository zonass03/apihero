<?php

namespace App\Http\Controllers;

use App\Models\home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\LazopClient;
use App\Models\LazopRequest;

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
    public $access_token;
    public $auth_url = 'https://auth.lazada.com/rest';
    public $api_url = 'https://api.lazada.vn/rest';
    public function __construct($access_token = '') {
        $this->partner_id = '125715';
        $this->partner_key = 'PgHH3iKxhpf8AljMWgqsNnR3Jr0xSHe5';
        $this->access_token = $access_token;
        $this->lazada = new LazopClient($this->api_url, $this->partner_id, $this->partner_key);
       
    }

    public function request($path, $params = [], $method = 'GET') {
        $request = new LazopRequest($path, $method);
        if(!empty($params)) {
            foreach($params as $key => $value) {
                $request->addApiParam($key, $value);
            }
        }
        return $this->lazada->execute($request, $this->access_token);
    }

    public function authorization($return_url) {
        try {
            $auth_url = 'https://auth.lazada.com/oauth/authorize?response_type=code&force_auth=true&redirect_uri='.$return_url."&client_id=".$this->partner_id;
           dd( $auth_url);
            return $auth_url;
        } catch(\Exception $e) {
            return false;
        }
    }
    
    public function get_access_token($code) {
        try {
            $lazada = new LazopClient($this->auth_url, $this->partner_id, $this->partner_key);
            $request = new LazopRequest('/auth/token/create');
            $request->addApiParam('code', $code);
            return $lazada->execute($request);
        } catch(\Exception $e) {
            return false;
        }
    }

    public function index()
    {
        //
//         app key = 125715
// app secret = PgHH3iKxhpf8AljMWgqsNnR3Jr0xSHe5
// accessstoken = 50000500625qH2rLfTCpmoXOvCabfxDjwiROH10c23fdf6edyAPrYjnDxWGvAVb

       // $response = Http::get('https://api.lazada.com.ph/rest/orders/get?sort_direction=DESC&offset=0&created_after=2021-02-10T00%3A00%3A00%2B08%3A00&sort_by=updated_at&app_key=125715&sign_method=sha256&timestamp=1612940288606&access_token=50000500119cd0xTpCgxxeSinmpYmtA11d68a91a5oTCMPcuxjBbFwBKVjxxxw8&sign=F7737C14FBAD201F975E26AF74D7FD9E7D8365E1CBAF8B34C48A3522C8FF4804');
 echo url()->full();
//                 try {
//                     $lazada = new LazopClient($this->auth_url, $this->partner_id, $this->partner_key);
//                     $request = new LazopRequest('/auth/token/create');
//                    $request->addApiParam('code', '0_125715_3Q64fkpBvwMGbT8NPy2TWdYd8572');
//                     return $lazada->execute($request);
//                 } catch(\Exception $e) {
//                     return false;
//                 }

       // return $response;
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
