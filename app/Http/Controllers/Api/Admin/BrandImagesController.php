<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\ApiController;
use App\Services\BrandImagesService;
use Illuminate\Http\Request;

class BrandImagesController extends ApiController
{
    /**
     * The service to consume the climbing equipment micro-service
     * @var BrandImagesService
     */
    public $brandImagesService;

    public function __construct()
    {
        $this->brandImagesService = new BrandImagesService();
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
        $result = $this->brandImagesService->getImagesByBrandId($brandId);

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
            'src' => 'required|max:255',
        ];

        $this->validate($request, $rules);

        $brandImage = $this->brandImagesService->createBrandImage([
            'src' => $request->src,
        ], $brandId);

        if ($brandImage)
        {
            return $this->successResponse($brandImage);
        }
    }

    /**
     * @param Request $request
     * @param $brandId
     * @param $imageId
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $brandId, $imageId)
    {
        $rules = [
            'src' => 'required|max:255',
            'alt' => 'required|max:255',
        ];

        $this->validate($request, $rules);

        $brandImage = $this->brandImagesService->updateBrandImage($request->all(), $brandId, $imageId);

        return $this->successResponse($brandImage);
    }

    /**
     * @param $brandId
     * @param $imageId
     * @return mixed
     */
    public function destroy($brandId, $imageId)
    {
        $brandImage = $this->brandImagesService->deleteBrandImage($brandId, $imageId);

        return $this->successResponse($brandImage);
    }

    /**
     * @param $brandId
     * @param $imageId
     * @return mixed
     */
    public function main($brandId, $imageId)
    {
        $brandImage = $this->brandImagesService->setAsMainImage($brandId, $imageId);

        return $this->successResponse($brandImage);
    }
}
