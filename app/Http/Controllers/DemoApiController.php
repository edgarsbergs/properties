<?php

namespace App\Http\Controllers;

use App\Services\ApiService;
use Facade\FlareClient\Api;
use Illuminate\Http\Request;

class DemoApiController extends Controller
{
    private $url;
    private $key;
    private $request_url;
    private $response;

    public function __construct()
    {
        $this->url = config('services.demo_api.url');
        $this->key = config('services.demo_api.key');
    }


    /**
     * main logic
     *
     * @param int $count
     */
    public function index($count = 1)
    {
        self::__construct();
        $this->buildRequestUrl([
            'page[size]' => $count,
        ]);
        $api = new ApiService($this->request_url);
        $this->response = $api->getJson();
        $properties = $this->extractProperties();

        $property_controller = new PropertyController;
        $property_controller->save($properties);
    }

    /**
     * Makes api request
     *
     * @param
     * @return string
     */
    public function get()
    {
        $this->buildRequestUrl();
        $api = new ApiService($this->request_url);

        return $api->getJson();
    }

    /**
     * Creates request url
     *
     * @param bool $params
     */
    private function buildRequestUrl($params = false)
    {
        $this->request_url = $this->url . '?api_key=' . $this->key;

        // add additional parameters
        if ($params) {
            $url_params = '';
            foreach ($params as $key => $value) {
                $url_params .= "&{$key}={$value}";
            }
            $this->request_url .= $url_params;
        }
    }


    /**
     * Extract properties data from API's response
     *
     * @return mixed
     */
    public function extractProperties()
    {
        return $this->response['data'];
    }
}
