<?php

use App\Models\Product;
use App\Models\User;

test('guest is redirected to login when visiting products', function () {
    $this->get('/products')->assertRedirect('/login');
});

test('products page is displayed', function () {
    $product = Product::factory()->create(['name' => 'Laptop', 'sku' => 'SKU-001']);

    $this->actingAs(User::factory()->create())
        ->get('/products')
        ->assertOk()
        ->assertSee('Laptop')
        ->assertSee('SKU-001');
});

test('products page filters by category', function () {
    Product::factory()->create(['name' => 'Laptop', 'category' => 'Electronics']);
    Product::factory()->create(['name' => 'Desk', 'category' => 'Furniture']);

    $this->actingAs(User::factory()->create())
        ->get('/products?category=Electronics')
        ->assertOk()
        ->assertSee('Laptop')
        ->assertDontSee('Desk');
});

test('products page filters by search', function () {
    Product::factory()->create(['name' => 'Wireless Mouse']);
    Product::factory()->create(['name' => 'Keyboard']);

    $this->actingAs(User::factory()->create())
        ->get('/products?search=Mouse')
        ->assertOk()
        ->assertSee('Wireless Mouse')
        ->assertDontSee('Keyboard');
});

test('admin sees the create product button', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->get('/products')
        ->assertOk()
        ->assertSee('Nuevo producto');
});

test('operator does not see the create product button', function () {
    $operator = User::factory()->create(['role' => 'operator']);

    $this->actingAs($operator)
        ->get('/products')
        ->assertOk()
        ->assertDontSee('Nuevo producto');
});

test('operator cannot access the product create page', function () {
    $operator = User::factory()->create(['role' => 'operator']);

    $this->actingAs($operator)
        ->get('/products/create')
        ->assertForbidden();
});

test('admin can access the product create page', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->get('/products/create')
        ->assertOk();
});

test('product store requires name, sku and category', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->from('/products/create')
        ->post('/products', [])
        ->assertSessionHasErrors(['name', 'sku', 'category'])
        ->assertRedirect('/products/create');

    $this->assertDatabaseCount('products', 0);
});

test('product store validates that sku is unique', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    Product::factory()->create(['sku' => 'SKU-001']);

    $this->actingAs($admin)
        ->post('/products', [
            'name' => 'Laptop',
            'sku' => 'SKU-001',
            'category' => 'Electronics',
        ])
        ->assertSessionHasErrors('sku');

    $this->assertDatabaseCount('products', 1);
});

test('admin can create a product', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->post('/products', [
            'name' => 'Laptop',
            'description' => 'A powerful laptop',
            'sku' => 'SKU-100',
            'category' => 'Electronics',
        ])
        ->assertRedirect('/products')
        ->assertSessionHas('success', 'Product Create');

    $this->assertDatabaseHas('products', [
        'name' => 'Laptop',
        'sku' => 'SKU-100',
        'category' => 'Electronics',
        'stock' => 0,
    ]);
});

test('operator cannot create a product', function () {
    $operator = User::factory()->create(['role' => 'operator']);

    $this->actingAs($operator)
        ->post('/products', [
            'name' => 'Laptop',
            'sku' => 'SKU-100',
            'category' => 'Electronics',
        ])
        ->assertForbidden();

    $this->assertDatabaseCount('products', 0);
});

test('admin can view the product edit page', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $product = Product::factory()->create(['name' => 'Laptop']);

    $this->actingAs($admin)
        ->get("/products/{$product->id}/edit")
        ->assertOk()
        ->assertSee('Laptop');
});

test('operator cannot access the product edit page', function () {
    $operator = User::factory()->create(['role' => 'operator']);
    $product = Product::factory()->create();

    $this->actingAs($operator)
        ->get("/products/{$product->id}/edit")
        ->assertForbidden();
});

test('admin can update a product', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $product = Product::factory()->create(['name' => 'Old name']);

    $this->actingAs($admin)
        ->put("/products/{$product->id}", [
            'name' => 'New name',
            'sku' => $product->sku,
            'category' => 'Electronics',
        ])
        ->assertRedirect('/products')
        ->assertSessionHas('success', 'Product Update');

    expect($product->fresh()->name)->toBe('New name');
});

test('product update ignores the current sku for uniqueness', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $product = Product::factory()->create(['sku' => 'SKU-001']);

    $this->actingAs($admin)
        ->put("/products/{$product->id}", [
            'name' => $product->name,
            'sku' => 'SKU-001',
            'category' => $product->category,
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect('/products');
});

test('operator cannot update a product', function () {
    $operator = User::factory()->create(['role' => 'operator']);
    $product = Product::factory()->create();

    $this->actingAs($operator)
        ->put("/products/{$product->id}", [
            'name' => 'New name',
            'sku' => $product->sku,
            'category' => $product->category,
        ])
        ->assertForbidden();
});

test('admin can delete a product', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $product = Product::factory()->create();

    $this->actingAs($admin)
        ->from('/products')
        ->delete("/products/{$product->id}")
        ->assertRedirect('/products')
        ->assertSessionHas('success', 'Product Delete');

    $this->assertDatabaseMissing('products', ['id' => $product->id]);
});

test('operator cannot delete a product', function () {
    $operator = User::factory()->create(['role' => 'operator']);
    $product = Product::factory()->create();

    $this->actingAs($operator)
        ->delete("/products/{$product->id}")
        ->assertForbidden();

    $this->assertDatabaseHas('products', ['id' => $product->id]);
});
