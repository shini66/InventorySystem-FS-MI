<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('guest is redirected to login when visiting users', function () {
    $this->get('/users')->assertRedirect('/login');
});

test('operator cannot access the users page', function () {
    $operator = User::factory()->create(['role' => 'operator']);

    $this->actingAs($operator)
        ->get('/users')
        ->assertForbidden();
});

test('admin can access the users page', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    User::factory()->create(['name' => 'Operario Uno', 'role' => 'operator']);

    $this->actingAs($admin)
        ->get('/users')
        ->assertOk()
        ->assertSee('Operario Uno')
        ->assertSee('admin')
        ->assertSee('operator');
});

test('users page filters by search', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    User::factory()->create(['name' => 'Juan Pérez', 'role' => 'operator']);
    User::factory()->create(['name' => 'María López', 'role' => 'operator']);

    $this->actingAs($admin)
        ->get('/users?search=Juan')
        ->assertOk()
        ->assertSee('Juan Pérez')
        ->assertDontSee('María López');
});

test('admin can change another user role', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $operator = User::factory()->create(['role' => 'operator']);

    $this->actingAs($admin)
        ->patch("/users/{$operator->id}", ['role' => 'admin']);

    $this->assertDatabaseHas('users', ['id' => $operator->id, 'role' => 'admin']);
});

test('admin cannot change their own role', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($admin)
        ->patch("/users/{$admin->id}", ['role' => 'operator']);

    $this->assertDatabaseHas('users', ['id' => $admin->id, 'role' => 'admin']);
});

test('admin can edit another user name, email and password', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $operator = User::factory()->create(['role' => 'operator', 'name' => 'Viejo']);

    $this->actingAs($admin)
        ->patch("/users/{$operator->id}", [
            'name' => 'Nuevo Nombre',
            'email' => 'nuevo@example.com',
            'password' => 'nueva-password-123',
            'password_confirmation' => 'nueva-password-123',
            'role' => 'operator',
        ]);

    $this->assertDatabaseHas('users', [
        'id' => $operator->id,
        'name' => 'Nuevo Nombre',
        'email' => 'nuevo@example.com',
    ]);

    $this->assertTrue(Hash::check('nueva-password-123', $operator->fresh()->password));
});

test('admin can leave password unchanged when editing', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $operator = User::factory()->create(['role' => 'operator', 'name' => 'Viejo']);
    $originalPassword = $operator->password;

    $this->actingAs($admin)
        ->patch("/users/{$operator->id}", [
            'name' => 'Nuevo Nombre',
            'email' => $operator->email,
            'password' => '',
            'password_confirmation' => '',
            'role' => 'operator',
        ]);

    $this->assertSame($originalPassword, $operator->fresh()->password);
});

test('admin cannot set a duplicate email', function () {
    $admin = User::factory()->create(['role' => 'admin', 'email' => 'admin@example.com']);
    $other = User::factory()->create(['role' => 'operator', 'email' => 'other@example.com']);

    $this->actingAs($admin)
        ->patch("/users/{$admin->id}", ['email' => 'other@example.com'])
        ->assertSessionHasErrors('email');
});

test('invalid role is rejected', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $operator = User::factory()->create(['role' => 'operator']);

    $this->actingAs($admin)
        ->patch("/users/{$operator->id}", ['role' => 'superadmin'])
        ->assertSessionHasErrors('role');

    $this->assertDatabaseHas('users', ['id' => $operator->id, 'role' => 'operator']);
});
