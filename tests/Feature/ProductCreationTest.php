<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class ProductCreationTest extends TestCase
{
    // After the test is completed rollback database transactions
    use DatabaseTransactions;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_console_create_new_product()
    {
        $this->artisan('product:new')
         ->expectsConfirmation('Do you want to Create a product category first?', 'yes')
         ->expectsOutput('All fields are required')
         ->expectsQuestion('What\'s the category name?', 'Test Category name')
         ->expectsQuestion('What\'s the product name?', 'Test product name')
         ->expectsQuestion('What\'s the product description?', 'Test product description')
         ->expectsQuestion('What\'s the product price?', '120')
         ->expectsQuestion('Product image URL', 'https://via.placeholder.com/150')
         ->expectsOutput('Product has been created')
         ->assertExitCode(0);
    }
}
