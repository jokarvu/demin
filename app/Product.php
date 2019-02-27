<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use softDeletes;
    protected $fillable = ['name', 'slug', 'description', 'category_id', 'price', 'instock', 'total'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = str_slug($value);
    }
}
