<?php

namespace App\Repositories\Product;

use App\Models\Product;
use Illuminate\Support\Collection;
use App\Repositories\BaseRepository;
use App\Repositories\Product\ProductRepositoryInterface;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{

   /**
    * ProductRepository constructor.
    *
    * @param Product $model
    */
   public function __construct(Product $model)
   {
       parent::__construct($model);
   }

   /**
    * Get and order products
    * @param int $limit
    * @param string $orderField
    * @param string $orderDirection
    * @param mixed $category
    * @return Illuminate\Pagination\LengthAwarePaginator
    */
    public function getPaginate(int $limit = 20, $orderField = 'id', $orderDirection = "desc", $category = 'all')
    {   
        // Get list of products
        $products = $this->model->select('id', 'name', 'price', 'image')
            ->orderBy($orderField, $orderDirection);

            if( $category != 'all'){
                $products->whereHas('categories', function($q) use ($category){
                    $q->where('categories.id', (int)$category);
                });
            }

        $products = $products->paginate($limit);

        // Reformat our product details
        $products->transform(function($item){
            return $item->format();
        });

        // return the results
        return $products;
    }

}
