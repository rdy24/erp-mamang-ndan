<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $table ='materials';
    protected $guarded = ['id'];

    public static function setKodeMaterial()
    {
        $lastMaterial = Material::orderBy('id', 'desc')->first();
        if (! $lastMaterial) {
            return 'B0001';
        }

        $lastMaterialNumber = substr($lastMaterial->kode_bahan, 1);
        $newMaterialNumber = $lastMaterialNumber + 1;

        return 'B' . sprintf('%04s', $newMaterialNumber);
    }
}
