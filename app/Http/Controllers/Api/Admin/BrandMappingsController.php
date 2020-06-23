<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\ApiController;
use App\Services\BrandMappingsService;
use Illuminate\Http\Request;

class BrandMappingsController extends ApiController
{
    /**
     * The service to consume the climbing equipment micro-service
     * @var BrandMappingsService
     */
    public $brandMappingsService;

    public function __construct()
    {
        $this->brandMappingsService = new BrandMappingsService();
        $this->middleware(['permission:List brands'])->only(['show']);
        $this->middleware(['permission:Create brands'])->only('store');
        $this->middleware(['permission:Update brands'])->only(['update']);
        $this->middleware(['permission:Delete brands'])->only('destroy');
    }

    /**
     * @param $brandId
     * @return mixed
     */
    public function show($brandId)
    {
        $result = $this->brandMappingsService->getMappingsByBrandId($brandId);

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
            'name' => 'required|max:255',
        ];

        $this->validate($request, $rules);

        $brandMapping = $this->brandMappingsService->createBrandMapping([
            'brand_id' => $brandId,
            'name' => $request->name,
        ], $brandId);

        return $this->successResponse($brandMapping);
    }

    /**
     * @param Request $request
     * @param $brandId
     * @param $mappingId
     * @return mixed
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $brandId, $mappingId)
    {
        $rules = [
            'name' => 'required|max:255',
        ];

        $this->validate($request, $rules);

        $brand = $this->brandMappingsService->updateBrandMapping([
            'brand_id' => $brandId,
            'name' => $request->name,
        ], $brandId, $mappingId);

        return $this->successResponse($brand);
    }

    /**
     * @param $brandId
     * @param $mappingId
     * @return mixed
     */
    public function destroy($brandId, $mappingId)
    {
        $brand = $this->brandMappingsService->deleteBrandMapping($brandId, $mappingId);

        return $this->successResponse($brand);
    }
}
