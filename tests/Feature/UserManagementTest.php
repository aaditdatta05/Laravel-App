<?php

use App\Models\Role;
use App\Models\User;

function authenticatedManager(): User
{
    $role = Role::create(['name' => 'Admin']);

    return User::factory()->create([
        'role_id' => $role->id,
        'first_name' => 'Admin',
        'last_name' => 'User',
        'employee_code' => 'EMP-000',
        'email' => 'admin@example.com',
        'status' => 'active',
    ]);
}

test('guests are redirected away from user management pages', function () {
    $this->get(route('users.index'))->assertRedirect(route('login'));
});

test('authenticated users can view the users list', function () {
    $user = authenticatedManager();

    $this->actingAs($user)
        ->get(route('users.index'))
        ->assertOk()
        ->assertSee('User Management');
});

test('users can be searched by employee code email or name', function () {
    $user = authenticatedManager();
    $role = Role::create(['name' => 'Employee']);

    $alpha = User::factory()->create([
        'role_id' => $role->id,
        'first_name' => 'Alpha',
        'last_name' => 'Tester',
        'employee_code' => 'EMP-101',
        'email' => 'alpha@example.com',
        'status' => 'active',
    ]);

    $beta = User::factory()->create([
        'role_id' => $role->id,
        'first_name' => 'Beta',
        'last_name' => 'Person',
        'employee_code' => 'EMP-202',
        'email' => 'beta@example.com',
        'status' => 'inactive',
    ]);

    $this->actingAs($user)
        ->get(route('users.index', ['search' => 'EMP-101']))
        ->assertOk()
        ->assertSee($alpha->employee_code)
        ->assertDontSee($beta->employee_code);

    $this->actingAs($user)
        ->get(route('users.index', ['search' => 'beta@example.com']))
        ->assertOk()
        ->assertSee($beta->email)
        ->assertDontSee($alpha->email);
});

test('users can be created with validation and role assignment', function () {
    $user = authenticatedManager();
    $role = Role::create(['name' => 'HR']);

    $response = $this->actingAs($user)->post(route('users.store'), [
        'first_name' => 'New',
        'last_name' => 'Hire',
        'employee_code' => 'EMP-303',
        'email' => 'new.hire@example.com',
        'phone' => '555-1234',
        'role_id' => $role->id,
        'status' => 'active',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);

    $response->assertRedirect(route('users.index'));

    $this->assertDatabaseHas('users', [
        'employee_code' => 'EMP-303',
        'email' => 'new.hire@example.com',
        'first_name' => 'New',
        'last_name' => 'Hire',
        'role_id' => $role->id,
        'status' => 'active',
    ]);
});

test('users cannot be created with duplicate email or employee code', function () {
    $user = authenticatedManager();
    $role = Role::create(['name' => 'Lead']);

    User::factory()->create([
        'role_id' => $role->id,
        'first_name' => 'Existing',
        'last_name' => 'User',
        'employee_code' => 'EMP-404',
        'email' => 'existing@example.com',
        'status' => 'active',
    ]);

    $this->actingAs($user)
        ->from(route('users.create'))
        ->post(route('users.store'), [
            'first_name' => 'Duplicate',
            'last_name' => 'User',
            'employee_code' => 'EMP-404',
            'email' => 'existing@example.com',
            'phone' => '555-9999',
            'role_id' => $role->id,
            'status' => 'active',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ])
        ->assertSessionHasErrors(['employee_code', 'email'])
        ->assertRedirect(route('users.create'));
});

test('users can be updated and deleted', function () {
    $user = authenticatedManager();
    $role = Role::create(['name' => 'Employee']);
    $userToManage = User::factory()->create([
        'role_id' => $role->id,
        'first_name' => 'Before',
        'last_name' => 'Update',
        'employee_code' => 'EMP-505',
        'email' => 'before@example.com',
        'status' => 'active',
    ]);

    $this->actingAs($user)
        ->put(route('users.update', $userToManage), [
            'first_name' => 'After',
            'last_name' => 'Update',
            'employee_code' => 'EMP-505',
            'email' => 'after@example.com',
            'phone' => '555-0001',
            'role_id' => $role->id,
            'status' => 'inactive',
            'password' => '',
            'password_confirmation' => '',
        ])
        ->assertRedirect(route('users.index'));

    $userToManage->refresh();

    expect($userToManage->first_name)->toBe('After')
        ->and($userToManage->email)->toBe('after@example.com')
        ->and($userToManage->status)->toBe('inactive');

    $this->actingAs($user)
        ->delete(route('users.destroy', $userToManage))
        ->assertRedirect(route('users.index'));

    $this->assertModelMissing($userToManage);
});