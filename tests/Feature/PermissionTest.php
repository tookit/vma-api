<?php

namespace Tests\Feature;

use App\Models\Permission as Model;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PermissionTest extends TestCase
{
    const ENDPOINT = '/api/acl/permission/';

    public function testViewItem() 
    {
        $item = $this->createUniqueItem();
        $response = $this->actingAs($this->makeAdmin(), 'api')->getJson(self::ENDPOINT.$item->id);
        $response->assertJson([
            'data' => $item->toArray()
        ]);
        $response->assertStatus(200);
    }

    public function testCreateItem()
    {
        $item = Model::factory()->make()->getAttributes();
        $response = $this->actingAs($this->makeAdmin(), 'api')->postJson(self::ENDPOINT, $item);
        $response->assertStatus(201);
    }


    public function testCreateFailed()
    {
        $item = Model::factory()->make(['name'=> ''])->toArray();
        $response = $this->actingAs($this->makeAdmin(), 'api')->postJson(self::ENDPOINT, $item);
        $response->assertStatus(422);

    }





    public function testUpdateItem()
    {
        $item = $this->createUniqueItem();
        $data = $item->toArray();
        $data['name'] = 'test_unique_name';
        $response = $this->actingAs($this->makeAdmin(), 'api')->putJson(self::ENDPOINT.$item->id, $data);
        $response->assertSee(['name'=>'test']);
        $response->assertStatus(200);

    }


    public function testDeleteItem()
    {
        $item = $this->createUniqueItem();
        $response = $this->actingAs($this->makeAdmin(), 'api')->delete(self::ENDPOINT.$item->id);
        $response->assertStatus(200);

    }



    protected function createUniqueItem()
    {
        return Model::factory()->create(
            [
                'name' => 'test_permissioin',
                'guard_name' => 'api', // make name unique
            ]
        );
    }
}
