<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationTemplate extends Model
{
    use HasFactory;

    protected $table = 'quotation_templates';

    protected $fillable = [
        'title',
        'expired',
    ];

    public function template_details()
    {
        return $this->hasMany(QuotationTemplateDetail::class);
    }
}
