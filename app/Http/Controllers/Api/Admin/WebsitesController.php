<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\ApiController;
use App\Services\WebsitesService;
use Illuminate\Http\Request;

class WebsitesController extends ApiController
{
    /**
     * The service to consume the climbing equipment micro-service
     * @var WebsitesService
     */
    public $websiteService;

    public function __construct()
    {
        $this->websiteService = new WebsitesService();
        $this->middleware(['permission:List websites'])->only(['index']);
    }

    /**
     * @return mixed
     */
    public function index()
    {
        $websites = $this->websiteService->obtainWebsites();

        return $this->successResponse($websites);
    }
}
