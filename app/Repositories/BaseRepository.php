<?php   

namespace App\Repositories;   

use Illuminate\Database\Eloquent\Model;   
use Illuminate\Database\Eloquent\Collection;
use App\Repository\EloquentRepositoryInterface; 

class BaseRepository
{     
    /**      
     * @var Model      
     */     
     protected $model;       

    /**      
     * BaseRepository constructor.      
     *      
     * @param Model $model      
     */     
    public function __construct(Model $model)     
    {         
        $this->model = $model;
    }
 
    /**
    * @param array $attributes
    *
    * @return Model
    */
    public function create(array $attributes): Model
    {
        return $this->model->create($attributes)->fresh();
    }

}