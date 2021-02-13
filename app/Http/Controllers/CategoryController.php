<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Category\CategoryRepositoryInterface;

class CategoryController extends Controller
{
        /** var RepositoryInterface */
        protected $CategoryRepository;

        public function __construct(CategoryRepositoryInterface $CategoryRepositoryInterface)
        {
            $this->CategoryRepository = $CategoryRepositoryInterface;
        }
    
        /**
         * List categories
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\Response
         */
        public function list(Request $request)
        {
            // Return list of product categories
            return [
                'status' => 'ok',
                'categories' => $this->CategoryRepository->get()
            ];
        }
}
