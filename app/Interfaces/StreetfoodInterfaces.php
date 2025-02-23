<?php

namespace App\Interfaces;

use App\Http\Requests\StreetfoodRequest;

interface  StreetfoodInterfaces
{
    public function getAllData();
    public function createData(StreetfoodRequest $request);
    public function getDataById($id);
    public function updateDataById(StreetfoodRequest $request, $id);
    public function deleteDataById($id);
}
