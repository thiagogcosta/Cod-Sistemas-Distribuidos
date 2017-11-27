<?php
namespace App\Models;

class Product extends BaseModel
{
    protected $fillable = ['name', 'description', 'sku', 'bars_code', 'price'];
}

