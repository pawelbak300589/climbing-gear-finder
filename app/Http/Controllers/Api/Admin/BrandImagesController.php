<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\ApiController;
use App\Services\BrandsService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BrandImagesController extends ApiController
{
    /**
     * The service to consume the climbing equipment micro-service
     * @var BrandsService
     */
    public $brandService;

    public function __construct()
    {
        $this->brandService = new BrandsService();
        $this->middleware(['permission:List brands'])->only(['index', 'show']);
        $this->middleware(['permission:Create brands'])->only('store');
        $this->middleware(['permission:Update brands'])->only(['update', 'main']);
        $this->middleware(['permission:Delete brands'])->only('destroy');
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $brands = $this->brandService->obtainBrands();

        return $this->successResponse($brands);
    }

    /**
     * @param $brandId
     * @return mixed
     */
    public function show($brandId)
    {
        $result = $this->brandService->getImagesByBrandId($brandId);

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

        $brandImage = $this->brandService->createBrandImage([
            'src' => $request->src,
        ], $brandId);

        if($brandImage)
        {
            return $this->successResponse($brandImage);
        }
        return $this->errorResponse('test', Response::HTTP_CONFLICT);
    }

    /**
     * @param Request $request
     * @param $brandId
     * @param $mappingId
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

        $brandImage = $this->brandService->updateBrandImage($request->all(), $brandId, $imageId);

        return $this->successResponse($brandImage);
    }

    /**
     * @param $brandId
     * @param $mappingId
     * @return mixed
     */
    public function destroy($brandId, $imageId)
    {
        $brandImage = $this->brandService->deleteBrandImage($brandId, $imageId);

        return $this->successResponse($brandImage);
    }

    /**
     * @param $brandId
     * @param $mappingId
     * @return mixed
     */
    public function main($brandId, $imageId)
    {
        $brandImage = $this->brandService->setAsMainImage($brandId, $imageId);

        return $this->successResponse($brandImage);
    }
}
