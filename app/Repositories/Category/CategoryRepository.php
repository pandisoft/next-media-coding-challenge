<?php

namespace App\Repositories\Category;

use App\Models\Category;
use Illuminate\Support\Collection;
use App\Repositories\BaseRepository;
use App\Repositories\Category\CategoryRepositoryInterface;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{

   /**
    * CategoryRepository constructor.
    *
    * @param Category $model
    */
   public function __construct(Category $model)
   {
       parent::__construct($model);
   }

   /**
    * Get and order product Categories
    *
    * @return Illuminate\Support\Collection
    */
    public function get()
    {   
        // return list of product Categories
        return $this->model->select('id', 'name', 'parent_id')->get()->map->format();
    }

}
