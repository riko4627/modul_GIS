<?php

namespace App\Http\Controllers\CMS;

use App\Http\Controllers\Controller;
use App\Http\Requests\StreetfoodRequest;
use App\Repositories\StreetfoodRepositories;
use Illuminate\Http\Request;

class StreetfoodController extends Controller
{
    protected $StreetfoodRepo;
    public function __construct(StreetfoodRepositories $StreetfoodRepo)
    {
        $this->StreetfoodRepo = $StreetfoodRepo;
    }
    public function getAllData()
    {
        return $this->StreetfoodRepo->getAllData();
    }
    public function createData(StreetfoodRequest $request)
    {
        return $this->StreetfoodRepo->createData($request);
    }
    public function getDataById($id)
    {
        return $this->StreetfoodRepo->getDataById($id);
    }
    public function updateDataById(StreetfoodRequest $request, $id)
    {
        return $this->StreetfoodRepo->updateDataById($request, $id);
    }
    public function deleteDatabyId($id)
    {
        return $this->StreetfoodRepo->deleteDataById($id);
    }
}
