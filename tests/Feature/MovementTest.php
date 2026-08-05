<?php

use App\Models\Movement;
use App\Models\Product;
use App\Models\User;

test('guest is redirected to login when visiting movements', function () {
    $this->get('/movements')->assertRedirect('/login');
});

test('movements page is displayed', function () {
    $product = Product::factory()->create(['name' => 'Laptop']);
    Movement::factory()->entry()->create(['product_id' => $product->id, 'quantity' => 5]);

    $this->actingAs(User::factory()->create())
        ->get('/movements')
        ->assertOk()
        ->assertSee('Laptop')
        ->assertSee(5);
});

test('movements page filters by type', function () {
    $entryProduct = Product::factory()->create(['name' => 'Entry Product']);
    $exitProduct = Product::factory()->create(['name' => 'Exit Product']);
    Movement::factory()->entry()->create(['product_id' => $entryProduct->id]);
    Movement::factory()->exit()->create(['product_id' => $exitProduct->id]);

    $this->actingAs(User::factory()->create())
        ->get('/movements?type=entry')
        ->assertOk()
        ->assertSee('Entry Product')
        ->assertDontSee('Exit Product');
});

test('movement create page is displayed', function () {
    Product::factory()->create(['name' => 'Laptop']);

    $this->actingAs(User::factory()->create())
        ->get('/movements/create')
        ->assertOk()
        ->assertSee('Laptop');
});

test('movement store requires type, quantity, product and date', function () {
    $this->actingAs(User::factory()->create())
        ->from('/movements/create')
        ->post('/movements', [])
        ->assertSessionHasErrors(['type', 'quantity', 'product_id', 'date'])
        ->assertRedirect('/movements/create');

    $this->assertDatabaseCount('movements', 0);
});

test('an entry movement increases the product stock', function () {
    $product = Product::factory()->create(['stock' => 10]);

    $this->actingAs(User::factory()->create())
        ->post('/movements', [
            'type' => 'entry',
            'quantity' => 5,
            'product_id' => $product->id,
            'supplier' => 'Acme Corp',
            'reason' => 'ignored',
            'date' => now()->toDateString(),
        ])
        ->assertRedirect('/movements')
        ->assertSessionHas('success', 'Movement Register');

    expect($product->fresh()->stock)->toBe(15);

    $this->assertDatabaseHas('movements', [
        'product_id' => $product->id,
        'type' => 'entry',
        'quantity' => 5,
        'supplier' => 'Acme Corp',
        'reason' => null,
    ]);
});

test('an exit movement decreases the product stock', function () {
    $product = Product::factory()->create(['stock' => 10]);

    $this->actingAs(User::factory()->create())
        ->post('/movements', [
            'type' => 'exit',
            'quantity' => 4,
            'product_id' => $product->id,
            'supplier' => 'ignored',
            'reason' => 'Sale',
            'date' => now()->toDateString(),
        ])
        ->assertRedirect('/movements')
        ->assertSessionHas('success', 'Movement Register');

    expect($product->fresh()->stock)->toBe(6);

    $this->assertDatabaseHas('movements', [
        'product_id' => $product->id,
        'type' => 'exit',
        'quantity' => 4,
        'supplier' => null,
        'reason' => 'Sale',
    ]);
});

test('an exit movement is rejected when stock is insufficient', function () {
    $product = Product::factory()->create(['stock' => 2]);

    $this->actingAs(User::factory()->create())
        ->from('/movements/create')
        ->post('/movements', [
            'type' => 'exit',
            'quantity' => 5,
            'product_id' => $product->id,
            'date' => now()->toDateString(),
        ])
        ->assertSessionHasErrors('quantity')
        ->assertRedirect('/movements/create');

    expect($product->fresh()->stock)->toBe(2);
    $this->assertDatabaseCount('movements', 0);
});

test('an entry movement nulls the reason', function () {
    $product = Product::factory()->create();

    $this->actingAs(User::factory()->create())
        ->post('/movements', [
            'type' => 'entry',
            'quantity' => 3,
            'product_id' => $product->id,
            'supplier' => 'Acme Corp',
            'date' => now()->toDateString(),
        ])
        ->assertRedirect('/movements');

    $this->assertDatabaseHas('movements', [
        'product_id' => $product->id,
        'type' => 'entry',
        'supplier' => 'Acme Corp',
        'reason' => null,
    ]);
});

test('movement belongs to a product', function () {
    $product = Product::factory()->create();
    $movement = Movement::factory()->create(['product_id' => $product->id]);

    expect($movement->product->is($product))->toBeTrue();
});

test('product has many movements', function () {
    $product = Product::factory()->create();
    Movement::factory()->count(3)->create(['product_id' => $product->id]);

    expect($product->movements)->toHaveCount(3);
});
