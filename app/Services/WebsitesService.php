<?php

namespace App\Services;

use App\Traits\ConsumeExternalService;

class WebsitesService
{
    use ConsumeExternalService;

    /**
     * The base uri to consume brands service
     * @var string
     */
    public $baseUri;

    /**
     * Authorization secret to pass to brand api
     * @var string
     */
    public $secret;

    public function __construct()
    {
        $this->baseUri = config('services.climbing_equipment.base_uri');
        $this->secret = config('services.climbing_equipment.secret');
    }

    /**
     * Obtain the full list of websites from the cemt service
     * @return string
     */
    public function obtainWebsites()
    {
        return $this->performRequest('GET', '/api/websites');
    }
}
