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
        $this->middleware(['permission:Update brands'])->only('update');
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
        $brand = $this->brandService->createBrand($request->all());

        return response()->json($brand);
    }
}
