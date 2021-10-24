<?php

namespace App\Http\Controllers;

use App\Service\TreeService;
use App\Models\Node;

class TreeController extends Controller
{
    protected $service;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->service = new TreeService;
    }

    public function getNodeExists(){
        $keys = [6,7,8,9,10,14];

        return response()->json(
            $this->service->getNode($keys)
        );
    }

    //
}
