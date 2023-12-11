<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationTemplateDetail extends Model
{
    use HasFactory;

    protected $table = 'quotation_template_details';

    protected $fillable = [
        'quotation_template_id',
        'product_id',
        'qty',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function quotation_template()
    {
        return $this->belongsTo(QuotationTemplate::class);
    }
}
