<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ApiService
{
    private $response;
    private $url;
    private $errors;

    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Gets data from API
     *
     * @return bool
     */
    public function get()
    {
        $this->response = Http::get($this->url);
        if ($this->response->ok()) {
            return true;
        }

        $this->handleErrors();
    }

    /**
     * Gets data in JSON format
     *
     * @return string
     */
    public function getJson()
    {
        $this->get();
        return $this->response->json();
    }
    /**
     * Logs error
     *
     */
    private function handleErrors()
    {
        $this->errors['server'] = $this->response->serverError();
        $this->errors['client'] = $this->response->clientError();
    }

}
