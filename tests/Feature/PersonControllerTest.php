<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Persons;
use Database\Seeders\MenusSeeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PersonControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test the index method of PersonController.
     *
     * How to run : php artisan test --filter testIndex
     * @return void
     */
    public function testIndex()
    {
        $this->withoutExceptionHandling();
        // Start database transaction
        $this->beginDatabaseTransaction();

        // Your test code
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/api/user/list/data');
        $response->assertStatus(200);
    }

    /**
     * Test the allUsers method of PersonController.
     * How to run : php artisan test --filter testGetAllUsers
     * @return void
     */
    public function testGetAllUsers()
    {
        $this->withoutExceptionHandling();
        $this->beginDatabaseTransaction();

        // Your test code
        $user = User::factory()->create();
        $this->actingAs($user);
    
        $response = $this->get('/api/user/list/all-users');
        $response->assertStatus(200);
    }

    /**
     * Test the store method of PersonController.
     *  
     * How to run : php artisan test --filter testStore
     * @return void
     */
    public function testStore()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'nip' => autocode_user_id(),
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'address' => '123 Main St',
            'gender' => 'L',
            'phone' => '081332157133', // Ensure phone number is a string
            'password' => 'password',
            'role' => 'admin',
            'user_id' => $user->id,
        ];

        $response = $this->post('/api/user/list/store', $data);

        $response->assertStatus(200);
        // dd($response->json());
    }

    /**
     * Test the edit method of PersonController.
     *
     * How to run : php artisan test --filter testEdit
     * @return void
     */
    public function testEdit()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get('/api/user/list/edit/1');

        $response->assertStatus(200);
        $response->json();
        
    }

    /**
     * Test the update method of PersonController.
     *
     * How to run : php artisan test --filter testUpdate
     * @return void
     */
    public function testUpdate()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'name' => 'Updated Name',
            'email' => 'emil@gmail.com',
            'address' => '456 New St',
            'gender' => 'P',
            'phone' => '9876543210',
            'password' => 'newpassword',
        ];

        $response = $this->put('/api/user/list/update/' . $user->id, $data);

        $response->assertStatus(200);
        $response->json();
    }

    /**
     * Test the delete method of PersonController.
     *
     * How to run : php artisan test --filter testDelete
     * @return void
     */
    public function testDelete()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->delete('/api/user/list/delete/' . $user->id);

        $response->assertStatus(200);
        $response->json();
    }

    /**
     * Test the multipleDelete method of PersonController.
     *
     * How to run : php artisan test --filter testMultipleDelete
     * @return void
     */
    public function testMultipleDelete()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        
        $users = User::factory(5)->create();
        $ids = $users->pluck('id')->implode(',');

        $response = $this->delete('/api/user/list/selected-delete/' . $ids);

        $response->assertStatus(200);
        $response->json();
    }
}
