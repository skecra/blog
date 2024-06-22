<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriPost extends Model
{
    use HasFactory;
    protected $fillable = ['category_id, post_id'];
    protected $table = 'category_post';
    public $timestamps = true; // osigurava da timestamps budu automatski popunjeni


}
