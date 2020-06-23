<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\ApiController;
use App\Services\BrandsService;
use App\Services\BrandUrlsService;
use Illuminate\Http\Request;

class BrandUrlsController extends ApiController
{
    /**
     * The service to consume the climbing equipment micro-service
     * @var BrandsService
     */
    public $brandUrlsService;

    public function __construct()
    {
        $this->brandUrlsService = new BrandUrlsService();
        $this->middleware(['permission:List brands'])->only(['show']);
        $this->middleware(['permission:Create brands'])->only('store');
        $this->middleware(['permission:Update brands'])->only(['update', 'main']);
        $this->middleware(['permission:Delete brands'])->only('destroy');
    }

    /**
     * @param $brandId
     * @return mixed
     */
    public function show($brandId)
    {
        $result = $this->brandUrlsService->getUrlsByBrandId($brandId);

        return $this->successResponse($result);
    }

    /**
     * @param Request $request
     * @param $brandId
     * @return mixed
     */
    public function store(Request $request, $brandId)
    {
        $rules = [
            'website_id' => 'required',
            'url' => 'required|max:255'
        ];

        $this->validate($request, $rules);

        $brandUrl = $this->brandUrlsService->createBrandUrl($request->all(), $brandId);

        if ($brandUrl)
        {
            return $this->successResponse($brandUrl);
        }
    }

    /**
     * @param Request $request
     * @param $brandId
     * @param $urlId
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $brandId, $urlId)
    {
        $rules = [
            'website_id' => 'required',
            'url' => 'required|max:255'
        ];

        $this->validate($request, $rules);

        $brandUrl = $this->brandUrlsService->updateBrandUrl($request->all(), $brandId, $urlId);

        return $this->successResponse($brandUrl);
    }

    /**
     * @param $brandId
     * @param $urlId
     * @return mixed
     */
    public function destroy($brandId, $urlId)
    {
        $brandUrl = $this->brandUrlsService->deleteBrandUrl($brandId, $urlId);

        return $this->successResponse($brandUrl);
    }

    /**
     * @param $brandId
     * @param $urlId
     * @return mixed
     */
    public function main($brandId, $urlId)
    {
        $brandUrl = $this->brandUrlsService->setAsMainUrl($brandId, $urlId);

        return $this->successResponse($brandUrl);
    }
}
