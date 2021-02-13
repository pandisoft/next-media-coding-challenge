<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'price',
        'description',
        'image'
    ];

    /** @var string */
    protected $currency = "MAD";

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }

    public function getImageAttribute($image){
        if($image) return asset($image);
        return asset('assets/images/product_placeholder.png');
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
            'description' => $this->description,
            'short_description' => str::limit($this->description, 62),
            'price' => sprintf('%s %s', number_format($this->price, 2), $this->currency),
            'image' => $this->image,
            'categories' => $this->categories->map->format(),
        ];
    }
}
