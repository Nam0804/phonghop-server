<?php

namespace App\Http\Controllers\Api\Manager;

use App\Http\Controllers\Controller;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use App\Repository\ManagerRepository\BaseManagerRepository;


class ManagerController extends Controller
{
    use HttpResponses;

    protected $user;
    public function __construct(BaseManagerRepository $user)
    {
        $this->user = $user;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

}
