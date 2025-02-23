<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GisstreetfoodModel extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'tb_streetfoods';
    protected $fillable = [
        'id',
        'name_streetfoods',
        'address_streetfoods',
        'phone_streetfoods',
        'image_streetfoods',
        'created_at',
        'updated_at'
    ];

    public function gis()
    {
        return $this->hasOne(GisstreetfoodModel::class, 'id_streetfoods');
    }
}
