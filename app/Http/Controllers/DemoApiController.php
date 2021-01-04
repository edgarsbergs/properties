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
    private $params; // api params,  e.g. next_page_url

    public function __construct()
    {
        $this->url = config('services.demo_api.url');
        $this->key = config('services.demo_api.key');
        $this->params = [
            'to' => 0,
            'next_page_url' => $this->buildRequestUrl(),
        ];
    }


    /**
     * main logic
     *
     * @param int $count
     * @return bool
     */
    public function index($count = 90)
    {
        try {
            $api = new ApiService();
        } catch (ApiException $exception) {
            report($exception);
            return false;
        }
        $property_controller = new PropertyController;

        $this->buildRequestUrl();
        $api->setUrl($this->request_url);

        $this->response = $api->getJson();
        $properties = $this->extractProperties();
        $this->extractApiParams();

        $property_controller->save($properties);
    }

    /**
     * Creates request url
     *
     * @param string $url
     * @param bool $params
     * @return bool
     */
    private function buildRequestUrl($url = '', $params = false)
    {
        if ($url) {
            $this->request_url = $url;
            return true;
        }
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

    /**
     * Extract parameters from API's response
     *
     * @return mixed
     */
    public function extractApiParams()
    {
        $this->params = [
            'next_page_url' => $this->response['next_page_url'],
            'last_page' => $this->response['last_page'],
            'to' => $this->response['to'],
            'total' => $this->response['total'],
        ];
    }
}
