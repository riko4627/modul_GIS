<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StreetfoodModel extends Model
{
    use HasFactory, HasUuids;
    protected $table = 'tb_gis_streetfoods';
    protected $fillable = [
        'id_streetfoods',
        'sub_district',
        'latitude',
        'longitude',
        'created_at',
        'updated_at',
    ];
    public function tailor()
    {
        return $this->belongsTo(StreetfoodModel::class, 'id_streetfoods');
    }
}
