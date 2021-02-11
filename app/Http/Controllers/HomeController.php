<?php

namespace App\Http\Controllers;

use App\Models\home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

use  App\Http\Lazadas\lazada;
use  App\Http\Lazadas\LazopRequest;
use  App\Http\Lazadas\LazopClient;
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
                    // $request->addApiParam("refresh_token", "50000601c30atpedfgu3LVvik87Ixlsvle3mSoB7701ceb156fPunYZ43GBg");
                    // echo  $lazada->execute($request);
               


             $lazada = new LazopClient($this->api_url, $this->partner_id, $this->partner_key);
            $request = new LazopRequest('/orders/get','GET');
            $request->addApiParam('created_after','2020-02-10T00:00:00+08:00');
            $request->addApiParam('status','pending');
            return $lazada->execute($request, $this->access_token);

                
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
