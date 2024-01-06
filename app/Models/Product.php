<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "products";

    protected $fillable = [
        "name",
        "category",
        "description",
        "images"
    ];

    protected $dates = ["date_time", "created_at", "updated_at"];

    public $timestamp = false;
}
