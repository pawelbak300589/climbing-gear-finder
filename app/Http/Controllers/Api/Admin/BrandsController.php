<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Services\BrandsService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class BrandsController extends Controller
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
        $this->middleware(['permission:Update brands'])->only(['update', 'blacklist', 'moveToMapping']);
        $this->middleware(['permission:Delete brands'])->only('destroy');
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $brands = $this->brandService->obtainBrands();

        return response()->json($brands);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        $brand = $this->brandService->obtainBrand($id);

        return response()->json($brand);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'url' => 'required|max:255',
            'img' => 'required|max:255'
        ]);

        $brand = $this->brandService->createBrand($request->all());

        return response()->json($brand);
    }

    /**
     * @param Request $request
     * @param $id
     * @return mixed
     */
    public function update(Request $request, $id)
    {
        $brand = $this->brandService->updateBrand($request->all(), $id);

        return response()->json($brand);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id)
    {
        $brand = $this->brandService->deleteBrand($id);

        return response()->json($brand);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function blacklist($id)
    {
        $result = $this->brandService->blacklistBrand($id);

        return response()->json($result);
    }

    /**
     * @param $id
     * @param $parentId
     * @return mixed
     */
    public function moveToMapping($id, $parentId)
    {
        $result = $this->brandService->convertBrandToMap($id, $parentId);

        return response()->json($result);
    }
}
