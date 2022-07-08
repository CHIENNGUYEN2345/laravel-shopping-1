<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Product extends Model
{
    use SoftDeletes;
    protected $guarded = [];
    //1 product co nhieu hinh anh chi tiet -> Product - ProductImage  (1-n)
    //-->moi quan he 1 nhieu (has many)
    public function images(){
        return $this->hasMany(ProductImage::class, 'product_id');
    }

    // product - tag (n-n)
    public function tags(){
        return $this->belongsToMany(Tag::class,'product_tags','product_id','tag_id')
                    ->withTimestamps();
    }

    //product - category (1-n inverse)
    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }

    //product - image (1-n)
    public function productImages(){
        return $this->hasMany(ProductImage::class,'product_id');
    }
}
