<?php

use App\Models\Product;
use App\Models\User;

test('guest is redirected to login when visiting the dashboard', function () {
    $this->get('/dashboard')->assertRedirect('/login');
});

test('dashboard page is displayed', function () {
    $this->actingAs(User::factory()->create())
        ->get('/dashboard')
        ->assertOk();
});

test('dashboard shows total products and stock', function () {
    Product::factory()->create(['stock' => 5]);
    Product::factory()->create(['stock' => 7]);

    $this->actingAs(User::factory()->create())
        ->get('/dashboard')
        ->assertOk()
        ->assertSee('Productos totales')
        ->assertSee('Stock total')
        ->assertSeeInOrder(['Productos totales', '2', 'Stock total', '12']);
});

test('dashboard shows stock grouped by category', function () {
    Product::factory()->create(['category' => 'Electronics', 'stock' => 5]);
    Product::factory()->create(['category' => 'Electronics', 'stock' => 3]);
    Product::factory()->create(['category' => 'Furniture', 'stock' => 4]);

    $this->actingAs(User::factory()->create())
        ->get('/dashboard')
        ->assertOk()
        ->assertSee('Stock por categoría')
        ->assertSeeInOrder(['Electronics', '8'])
        ->assertSeeInOrder(['Furniture', '4']);
});
