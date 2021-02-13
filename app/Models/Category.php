<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_category');
    }

    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /** 
    * Return a formatted data
    * 
    * @return array 
    */
    public function format()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'parent_category' => $this->parentCategory ? $this->parentCategory->format() : null,
        ];
    }

}
