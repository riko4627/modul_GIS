<?php

namespace App\Repositories;

use App\Http\Requests\StreetfoodRequest;
use App\Interfaces\StreetfoodInterfaces;

use App\Models\StreetfoodModel;
use App\Traits\HttpResponseTraits;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;


class StreetfoodRepositories implements StreetfoodInterfaces
{
    use HttpResponseTraits;
    protected $StreetfoodModel;

    public function __construct(StreetfoodModel $StreetfoodModel)
    {
        $this->StreetfoodModel = $StreetfoodModel;
    }
    public function getAllData()
    {
        $data = $this->StreetfoodModel::all();
        if ($data->isEmpty()) {
            return $this->dataNotFound();
        } else {
            return $this->success($data);
        }
    }

    public function createData(StreetfoodRequest $request)
    {
        try {
            $data = new $this->StreetfoodModel;
            $data->name_streetfoods = $request->input('name_streetfoods');
            $data->address_streetfoods = $request->input('address_streetfoods');

            $data->phone_streetfoods = $request->input('phone_streetfoods');
            if ($request->hasFile('image_streetfoods')) {
                $file = $request->file('image_streetfoods');
                $extension = $file->getClientOriginalExtension();
                $filename = 'IMG-streetfoods-' . Str::random(15) . '.' . $extension;
                Storage::makeDirectory('uploads/img-streetfoods');
                $file->move(public_path('uploads/img-streetfoods'), $filename);
                $data->image_streetfoods = $filename;
            }
            $data->save();
            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }


    public function getDataById($id)
    {
        $data = $this->StreetfoodModel::where('id', $id)->first();
        if ($data) {
            return $this->success($data);
        } else {
            return $this->dataNotFound();
        }
    }
    public function updateDataById(StreetfoodRequest $request, $id)
    {
        try {
            $data = $this->StreetfoodModel::find($id);
            if (!$data) {
                return $this->dataNotFound();
            }

            $data->name_streetfoods = $request->input('name_streetfoods');
            $data->address_streetfoods = $request->input('address_streetfoods');
            $data->phone_streetfoods = $request->input('phone_streetfoods');

            if ($request->hasFile('image_streetfoods')) {
                // Delete the old image
                if ($data->image_streetfoods && File::exists(public_path('uploads/img-streetfoods/' . $data->image_streetfoods))) {
                    File::delete(public_path('uploads/img-streetfoods/' . $data->image_streetfoods));
                }

                // Upload the new image
                $file = $request->file('image_streetfoods');
                $extension = $file->getClientOriginalExtension();
                $filename = 'IMG-streetfoods-' . Str::random(15) . '.' . $extension;
                $file->move(public_path('uploads/img-streetfoods'), $filename);
                $data->image_streetfoods = $filename;
            }

            $data->save();
            return $this->success($data);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }

    public function deleteDataById($id)
    {
        try {
            $data = $this->StreetfoodModel::find($id);
            if (!$data) {
                return $this->dataNotFound();
            }

            // Delete the image file
            if ($data->image_tailor && File::exists(public_path('uploads/img-streetfoods/' . $data->image_streetfoods))) {
                File::delete(public_path('uploads/img-streetfoods/' . $data->image_streetfoods));
            }

            $data->delete();
            return $this->delete();
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 400, $th, class_basename($this), __FUNCTION__);
        }
    }
}
