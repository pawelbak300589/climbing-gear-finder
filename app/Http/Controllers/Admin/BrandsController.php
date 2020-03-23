<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\BrandsService;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class BrandsController extends Controller
{
    /**
     * The service to consume the authors micro-service
     * @var BrandsService
     */
    public $brandService;

    public function __construct()
    {
        $this->brandService = new BrandsService();
    }

    /**
     * Show the brands panel list
     *
     * @return Renderable
     */
    public function index()
    {
        $brands = $this->brandService->obtainBrands();

        return view('admin.brands.index', compact('brands'));
    }
}
