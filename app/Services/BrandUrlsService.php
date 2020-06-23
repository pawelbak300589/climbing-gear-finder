<?php

namespace App\Services;

use App\Traits\ConsumeExternalService;

class BrandUrlsService
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
     * Get Images By Brand Id
     * @param $brandId
     * @return string
     */
    public function getUrlsByBrandId($brandId)
    {
        return $this->performRequest('GET', "/api/brands/{$brandId}/urls");
    }

    /**
     * Create Brand Url
     * @param $data
     * @param $brandId
     * @return string
     */
    public function createBrandUrl($data, $brandId)
    {
        return $this->performRequest('POST', "/api/brands/{$brandId}/urls", $data);
    }

    /**
     * Update Brand Url
     * @param $data
     * @param $brandId
     * @param $urlId
     * @return string
     */
    public function updateBrandUrl($data, $brandId, $urlId)
    {
        return $this->performRequest('PATCH', "/api/brands/{$brandId}/urls/{$urlId}", $data);
    }

    /**
     * Delete Brand Url
     * @param $brandId
     * @param $urlId
     * @return string
     */
    public function deleteBrandUrl($brandId, $urlId)
    {
        return $this->performRequest('DELETE', "/api/brands/{$brandId}/urls/{$urlId}");
    }

    /**
     * Set url as main brand url
     * @param $brandId
     * @param $urlId
     * @return string
     */
    public function setAsMainUrl($brandId, $urlId)
    {
        return $this->performRequest('POST', "/api/brands/{$brandId}/urls/{$urlId}/main");
    }
}
