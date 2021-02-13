<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;

class AddNewProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:new';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create new a product';

    /** var ProductRepositoryInterface */
    protected $productRepository;

    /** var CategoryRepositoryInterface */
    protected $categoryRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ProductRepositoryInterface $productRepositoryInterface, CategoryRepositoryInterface $categoryRepositoryInterface)
    {
        parent::__construct();
        $this->productRepository = $productRepositoryInterface;
        $this->categoryRepository = $categoryRepositoryInterface;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $productCategoryId = null;

        // User can create a new category and the category will be assigned to product automatically
        // Otherwise the user must provide the category ID
        if ($this->confirm('Do you want to Create a product category first?')) {
            $productCategoryId = $this->createProductCategory();
        }

        if( $productId = $this->createProduct( $productCategoryId ) ){
            $this->info('Product has been created');
            return 0;
        }

        $this->info('Failed to create the product!');
        return 0;
    }

    private function createProductCategory()
    {
        $categoryName = $this->ask("What's the category name?");

        $validator = Validator::make([
            'name' => $categoryName,
        ], [
            'name' => ['required', 'min:3', 'max:32'],
        ]);
        
        if ($validator->fails()) {
            $this->error('Your input was invalid, Please try again');
        
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            // When there was an Error start over by calling the same method
            return $this->createProductCategory();
        }

        $newCategory = $this->categoryRepository->create(['name' => $categoryName]);

        return $newCategory->id;
    }

    private function createProduct( $productCategory )
    {
        $this->info("All fields are required");
        $name = $this->ask("What's the product name?");
        $description = $this->ask("What's the product description?");
        $price = $this->ask("What's the product price?");
        $imageURL = $this->ask("Product image URL");

        $fields = [];
        $fieldsRules = [];

        if ( ! $productCategory ) {
            $productCategory = $this->ask("Product category ID");
            $fields['category_id'] = $productCategory;
            $fieldsRules['category_id'] = ['required', 'integer', 'exists:categories,id'];
        }
    
        $fields['name'] = $name;
        $fields['price'] = $price;
        $fields['image'] = $imageURL;

        $fieldsRules['name']    = ['required', 'min:2', 'max:32'];
        $fieldsRules['description']    = ['required'];
        $fieldsRules['price']    = ['required', 'integer', 'min:1'];
        $fieldsRules['image']    = ['required'];

        $validator = Validator::make($fields, $fieldsRules);
        
        if ($validator->fails()) {
            $this->error('Your input was invalid, Please try again');
        
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            // When there was an Error start over by calling the same method
            return $this->createProduct( $productCategory );
        }

        $productFields = [
            'name' => $name,
            'description' => $description,

            // Well make it simple and will store the image URL as it is
            // In real app will need to validate and store the image on a storage 
            'image' => $imageURL,

            'price' => $price
        ];

        if( $newProduct = $this->productRepository->create($productFields) ){
            $newProduct->categories()->attach($productCategory);
            return $newProduct->id;
        }

        return false;
    }
}
