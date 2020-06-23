<?php

namespace App\Services;

use App\Traits\ConsumeExternalService;

class BrandImagesService
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
    public function getImagesByBrandId($brandId)
    {
        return $this->performRequest('GET', "/api/brands/{$brandId}/images");
    }

    /**
     * Create Brand Image
     * @param $data
     * @param $brandId
     * @return string
     */
    public function createBrandImage($data, $brandId)
    {
        return $this->performRequest('POST', "/api/brands/{$brandId}/images", $data);
    }

    /**
     * Update Brand Image
     * @param $data
     * @param $brandId
     * @param $imageId
     * @return string
     */
    public function updateBrandImage($data, $brandId, $imageId)
    {
        return $this->performRequest('PATCH', "/api/brands/{$brandId}/images/{$imageId}", $data);
    }

    /**
     * Delete Brand Image
     * @param $brandId
     * @param $imageId
     * @return string
     */
    public function deleteBrandImage($brandId, $imageId)
    {
        return $this->performRequest('DELETE', "/api/brands/{$brandId}/images/{$imageId}");
    }

    /**
     * Set image as main brand img
     * @param $brandId
     * @param $imageId
     * @return string
     */
    public function setAsMainImage($brandId, $imageId)
    {
        return $this->performRequest('POST', "/api/brands/{$brandId}/images/{$imageId}/main");
    }
}
