<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Product\ProductRepositoryInterface;

class ProductController extends Controller
{
    /** var ProductRepositoryInterface */
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $productRepositoryInterface)
    {
        $this->productRepository = $productRepositoryInterface;
    }

    /**
     * List products
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        // Validate the user inputs
        $validator = Validator::make($request->only(['order_type', 'order_direction']), [
            'order_type' => 'sometimes|nullable|in:id,price',
            'order_direction' => 'sometimes|nullable|in:asc,desc',
            'category' => 'sometimes|nullable|integer',
        ], [
            'order_type.in' => 'Order type is invalid',
            'order_direction.in' => 'Order direction type is invalid',
        ]);

        // If inputs are not as expected return errors
        if ($validator->fails()) {
            return [
                'status' => 'fail',
                'errors' => $validator->errors()
            ];
        }

        // We can set this value on config | database, but let's keep it simple
        $limit = 20;

        // Set user order type or default
        $orderType = $request->input('order_type') ? $request->input('order_type') : 'id';

        // Set user order direction or default
        $orderDirection = $request->input('order_direction') ? $request->input('order_direction') : 'desc';

        // Set user category
        $productCategory = $request->input('category');

        // Return list of products if exists
        return [
            'status' => 'ok',
            'products' => $this->productRepository->getPaginate($limit, $orderType, $orderDirection, $productCategory)
        ];
    }
}