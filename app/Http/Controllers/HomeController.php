<?php
namespace App\Http\Controllers;

use App\Models\home;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use GuzzleHttp\Client;


use App\Http\Lazadas\lazada;
use App\Http\Lazadas\LazopRequest;
use App\Http\Lazadas\LazopClient;
use Illuminate\Support\Facades\Storage;
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
    public $access_token;
    public $auth_url = 'https://auth.lazada.com/rest';
    public $api_url = 'https://api.lazada.com.ph/rest';

    public function __construct($access_token = '50000500c42to9BoxPvhBzHViKrCrsDYijPdPRwfokygakySnSHQ8R1c3cbd642')
    {
        $this->partner_id = '125715';
        $this->partner_key = 'PgHH3iKxhpf8AljMWgqsNnR3Jr0xSHe5';
        $this->access_token = $access_token;
        $this->lazada = new LazopClient($this->api_url, $this->partner_id, $this->partner_key);
    }

    public function index()
    {

        return 'multiseller data url/lazada  url/zalora';

    }
    public function lazadas()
    {
        $carbon = new Carbon();
        $dt = Carbon::today()->toDateString();
        $lazada = new LazopClient($this->api_url, $this->partner_id, $this->partner_key);
        $request = new LazopRequest('/orders/get', 'GET');
        $request->addApiParam('created_after', $dt . 'T00:00:00+08:00');
        $request->addApiParam('status', 'pending');
        $jsongetLazadaNewOrder = $lazada->execute($request, $this->access_token);

          $lazadajson = json_decode($jsongetLazadaNewOrder, true);
          $laz = $lazadajson['data']['orders'];

   
         foreach($lazadajson['data']['orders'] as $i => $v)
         {
           $lazadaOrderNumber[] = $v['order_number'];
               $datas = ['order_number' => $lazadaOrderNumber];
         }

         foreach($lazadajson['data']['orders'] as $i => $v)
         {
           $lazadaOrderName[] = $v['address_billing']['first_name'];
           $data = (['first_name' => $lazadaOrderName, 'order_number' => $lazadaOrderNumber]);
         }
         //$varss = response()->json($data)->getContent();
     
        //  $var = response()->json($datas)->getContent();
        //  $lazadawithItems = $lazada->execute($request, $this->access_token);
         //  $collection = collect([$varss, $var,$lazadawithItems]);
        //  return response()->json($collection);
       
        $lazOrderNum = response()->json($lazadaOrderNumber)->getContent();
        $request = new LazopRequest('/orders/items/get','GET');
        $request->addApiParam('order_ids',$lazOrderNum);
         $lazadawithItems = $lazada->execute($request, $this->access_token);
          return $lazada->execute($request, $this->access_token);
       
//          $collection = collect( $jsongetLazadaNewOrder );

// $merged = $collection->merge([ $data]);

// return $merged->all();
 
   
    }
    public function lazgetorderitems()
    {
        $lazada = new LazopClient($this->api_url, $this->partner_id, $this->partner_key);
        $request = new LazopRequest('/order/get/new','GET');
        $request->addApiParam('order_id','355584238548124');
        $getOrderLaz = $lazada->execute($request, $this->access_token);
        $jsondecodegetOrderLaz = json_decode($getOrderLaz, true);
        $lazOrder = $jsondecodegetOrderLaz['data']['order_number'];
        $lazOrderNowOrderNumbers = response()->json($lazOrder)->getContent();

        $lazada = new LazopClient($this->api_url, $this->partner_id, $this->partner_key);
        $request = new LazopRequest('/order/items/get/new','GET');
        $request->addApiParam('order_id','355584238548124');
         $dataGetOrder =$lazada->execute($request, $this->access_token);

        $orderItemDecode = json_decode($dataGetOrder, true);

        $collection = collect( ['data1'=>$jsondecodegetOrderLaz] );
        $merged = $collection->merge([ 'data2'=>$orderItemDecode]);
        $mixeOrderOrderitem = $merged->all();

      
        $order_reference = $mixeOrderOrderitem['data1']['data']['order_number'];
        $customer_name = $mixeOrderOrderitem['data1']['data']['customer_first_name'];
        $customer_mobileno = $mixeOrderOrderitem['data1']['data']['address_billing']['phone'];
        $shipping_address = $mixeOrderOrderitem['data1']['data']['address_shipping']['address5'];
        $shipping_city = $mixeOrderOrderitem['data1']['data']['address_shipping']['address1'];
        $shipping_region = $mixeOrderOrderitem['data1']['data']['address_shipping']['address3'];
        $shipping_country = $mixeOrderOrderitem['data1']['data']['address_shipping']['country'];
        $total_cost = $mixeOrderOrderitem['data1']['data']['price'];
        $total_shipping = $mixeOrderOrderitem['data1']['data']['shipping_fee'];
        $notes = $mixeOrderOrderitem['data1']['data']['remarks'];
        $payment_method = $mixeOrderOrderitem['data1']['data']['payment_method'];
        $qty_to_invoice = $mixeOrderOrderitem['data1']['data']['items_count'];
        $ordered_date = $mixeOrderOrderitem['data1']['data']['created_at'];
        
        

        $customer_id = $mixeOrderOrderitem['data2']['data'][0]['order_id'];
        $merchant_name = $mixeOrderOrderitem['data2']['data'][0]['shop_id'];
        $total_net = $mixeOrderOrderitem['data2']['data'][0]['paid_price'];
        $total_vat = $mixeOrderOrderitem['data2']['data'][0]['tax_amount'];
        $product_id = $mixeOrderOrderitem['data2']['data'][0]['order_item_id'];
        $sku = $mixeOrderOrderitem['data2']['data'][0]['sku'];
        $product_name = $mixeOrderOrderitem['data2']['data'][0]['name'];
        $product_image_url = $mixeOrderOrderitem['data2']['data'][0]['product_main_image'];
        
        
      
   
     
       // dd($sku );
     
 

        $testjson =[
            "order_reference" => $order_reference  ,
             "merchant_id" => "11111111",
             "merchant_name" => $merchant_name,
             "agent_id" => null,
             "agent_name" => null,
             "customer_id" =>  $customer_id,
             "customer_name" => $customer_name,
             "customer_mobileno" => $customer_mobileno,
             "is_manually_shipped" => false,
             "pickup_location_id" => "1770",
             "pickup_location_name" => "JP RIZAL 3",
             "pickup_group_name" => "ROUTE63",
             "shipping_address" => $shipping_address,
             "shipping_city" => $shipping_city,
             "shipping_region" => $shipping_region,
             "shipping_country" => $shipping_country,
             "total_cost" => $total_cost,
             "total_commission" => 0,
             "total_gross" => $total_cost,
             "total_discount" => 0,
             "total_shipping" => $total_shipping,
             "total_net" => $total_net,
             "total_vatable" => 0,
             "total_non_vatable" => 0,
             "total_vat" =>$total_vat,
             "currency" => "PHP",
             "ordered_date" =>  '2021-02-07T04:22:19.000Z',
             "notes" => $notes,
             "payment_method" =>  $payment_method,
             "items" => [ [
              "product_id" =>  $product_id,
              "product_name" => $product_name,
              "product_image_url" => $product_image_url ,
              "sku" => $sku,
              "category_id" => "12345",
              "category_name" => "No Category",
              "brand_id" => "12345",
              "brand_name" => $merchant_name,
              "qty_to_invoice" => $qty_to_invoice,
              "product_qty_multiplier" => 1,
              "uom" => "EA",
              "unit_price" => 200,
              "unit_cost" => 190,
              "unit_commission" => 0,
              "unit_discount" => "0.00",
              "total_cost" => 190,
              "total_commission" => 0,
              "total_gross" => 200,
              "total_discount" => 0,
              "total_net" => 200,
              "total_vatable" => 0,
              "total_non_vatable" => 0,
              "total_vat" => $total_vat,
              "currency" => "PHP",
             ]],
             "payments" => [
                [
              "payment_type" => "COD",
              "currency" => "PHP",
              "amount" => 50,
              "peso_conversion" => 1,
             ]],
             "rewards" => [[
              "reward_name" => "Pickup Bonus",
              "currency" => "CLQPT",
              "amount" => 20,
              "reward_reference_code" => null,
              ]],
             "discounts" => [[
              "discount_name" => "First Time Promo",
              "currency" => null,
              "amount" => null,
              "discount_reference_code" => "FIRST_TIME",
             ]],
        ];

        
        $response =  Http::post('https://orders-api-dev.iconnect.com.ph/api/v1/orders',$testjson );
        return $response ;
       
        // *get order
        // $carbon = new Carbon();
        // $dt = Carbon::today()->toDateString();
        // $lazada = new LazopClient($this->api_url, $this->partner_id, $this->partner_key);
        // $request = new LazopRequest('/orders/items/get','GET');
        // $request->addApiParam('order_ids','[ 356769709495301,356757543044743]');
        // return $lazada->execute($request, $this->access_token);

    }


    public function lazadaauthorization()
    {
        try
        {
            $response = Http::get('https://auth.lazada.com/oauth/authorize?response_type=code&force_auth=true&uri=http://127.0.0.1:8000/' . "&client_id=125715");

            $getCode = Storage::disk('public')->put('lazada_code.json', response()
                ->json(['lazada_code' => $response]));
            return $response;
        }
        catch(\Exception $e)
        {
            return false;
        }
    }
    public function lazadagetToken()
    {
        $lazada = new LazopClient($this->auth_url, $this->partner_id, $this->partner_key);
        $request = new LazopRequest('/auth/token/create');
        $request->addApiParam('code', '0_125715_u1Fk0H1JF1oyEX6C141MMiKv10941');
        $getLazToken = $lazada->execute($request);
        $laztoken = Storage::disk('public')->put('lazada_token.json', response()
            ->json(['lazada_token' => $getLazToken]));
    }

    public function lazadasrefreshToken()
    {
        $lazada = new LazopClient($this->auth_url, $this->partner_id, $this->partner_key);
        $request = new LazopRequest("/auth/token/refresh");
        $request->addApiParam("refresh_token", "50001501542bg7vdjSfzRd8DgS5NrxDhkSGVIQvCl3noThROZf64FY1ca90d74W");
        $Reftoken = $lazada->execute($request);
        $laz_refreshToken = Storage::disk('public')->put('lazada_refresh_token.json', response()
            ->json(['lazada_refresh' => $Reftoken]));

    }
    public function testStorage()
    {
        // $tokens = "red:red";
        // $dar = Storage::disk('public')->put('lazada.json', response()->json($tokens)); 
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
            'CreatedAfter' => $yesterday->format(DateTime::ISO8601) ,
            'CreatedBefore' => $now->format(DateTime::ISO8601) ,

            // The format of the result.
            'Format' => 'JSON',

            // The current time formatted as ISO8601
            'Timestamp' => $now->format(DateTime::ISO8601)
        );

        // Sort parameters by name.
        ksort($parameters);

        // URL encode the parameters.
        $encoded = array();
        foreach ($parameters as $name => $value)
        {
            $encoded[] = rawurlencode($name) . '=' . rawurlencode($value);
        }

        // Concatenate the sorted and URL encoded parameters into a string.
        $concatenated = implode('&', $encoded);

        // The API key for the user as generated in the Seller Center GUI.
        // Must be an API key associated with the UserID parameter.
        $api_key = '24c1ae2b4f5c5cce2b3ee3a2426918993c90b04d';

        // Compute signature and add it to the parameters.
        $parameters['Signature'] = rawurlencode(hash_hmac('sha256', $concatenated, $api_key, false));
        $parameters['Signature'];

        // ...continued from above
        // Replace with the URL of your API host.
        $url = "https://sellercenter-api.zalora.com.ph";

        // Build Query String
        $queryString = http_build_query($parameters, '', '&', PHP_QUERY_RFC3986);

        // Open cURL connection
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url . "?" . $queryString);

        // Save response to the variable $data
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($ch);

        curl_close($ch);
        // $response = Http::get('https://sellercenter-api.zalora.com.ph', $queryString);
        return $data;

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

