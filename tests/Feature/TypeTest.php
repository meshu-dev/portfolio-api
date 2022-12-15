<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Models\Type;

class TypeTest extends TestCase
{
    use RefreshDatabase;

    protected $url = '/api/types';

    protected $structure = [
        'id',
        'name'
    ];

    public function test_getting_type_by_id()
    {
        $this->setupAuth();

        $type = $this->addType();

        $this->json('GET', "{$this->url}/{$type->id}")
            ->assertOk()
            ->assertJsonStructure([
                'data' => $this->structure
            ]);
    }

    public function test_stop_getting_type_by_id_with_no_token()
    {
        $type = $this->addType();

        $this->testUnauthorised('GET', "{$this->url}/{$type->id}");
    }

    public function test_getting_empty_type_by_invalid_id()
    {
        $this->setupAuth();

        $id = $this->getInvalidId();

        $this->json('GET', "{$this->url}/$id")
             ->assertStatus(422);
    }

    public function test_getting_list_of_types()
    {
        $this->setupAuth();

        $this->addTypes();

        $this->json('GET', $this->url)
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => $this->structure
                ]
            ]);
    }

    public function test_stop_getting_list_of_types_with_no_token()
    {
        $this->addTypes();

        $this->testUnauthorised('GET', $this->url);
    }

    public function test_getting_empty_list_of_types()
    {
        $this->setupAuth();

        $this->json('GET', $this->url)
            ->assertOk()
            ->assertJson([
                'data' => []
            ]);
    }

    public function test_adding_type()
    {
        $this->setupAuth();

        $params = [
            'name' => 'Development'
        ];

        $this->json('POST', $this->url, $params)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => $this->structure
            ])
            ->assertJson([
                'data' => [
                    'name' => 'Development'
                ]
            ]);
    }

    public function test_stop_adding_type_with_no_token()
    {
        $params = [
            'name' => 'Development'
        ];

        $this->testUnauthorised('POST', $this->url, $params);
    }

    public function test_stop_adding_type_with_duplicate_name()
    {
        $this->setupAuth();

        $this->addType();

        $params = [
            'name' => 'Development'
        ];

        $this->json('POST', $this->url, $params)
             ->assertStatus(422);
    }

    public function test_editing_type()
    {
        $this->setupAuth();

        $type = $this->addType();
        $id = $type->id;

        $params = [
            'name' => 'Staging'
        ];

        $this->json('PUT', "{$this->url}/{$id}", $params)
            ->assertOk()
            ->assertJson([
                'data' => [
                    'id' => $id,
                    'name' => 'Staging'
                ]
            ]);
    }

    public function test_stop_editing_type_with_no_token()
    {
        $type = $this->addType();

        $id = $type->id;
        $params = [
            'name' => 'Staging'
        ];

        $this->testUnauthorised('PUT', "{$this->url}/{$id}", $params);
    }

    public function test_stop_editing_type_with_duplicate_name()
    {
        $this->setupAuth();

        $types = $this->addTypes();
        $id = $types[0]['id'];

        $params = [
            'name' => 'Staging'
        ];

        $this->json('PUT', "{$this->url}/{$id}", $params)
             ->assertStatus(422);
    } 

    public function test_deleting_type()
    {
        $this->setupAuth();

        $type = $this->addType();
        $id = $type->id;

        $this->json('DELETE', "{$this->url}/{$id}")
             ->assertNoContent();
    }

    public function test_stop_deleting_type_with_no_token()
    {
        $type = $this->addType();
        $id = $type->id;

        $this->testUnauthorised('DELETE', "{$this->url}/{$id}");
    }

    public function test_stop_deleting_type_with_invalid_id()
    {
        $this->setupAuth();

        $id = $this->getInvalidId();

        $this->json('DELETE', "{$this->url}/$id")
             ->assertStatus(422);
    }

    protected function addType()
    {
        $type = Type::create([
            'name' => 'Development'
        ]);

        return $type;
    }

    protected function addTypes(): array
    {
        $types = [
            Type::create([
                'name' => 'Production'
            ]),
            Type::create([
                'name' => 'Staging'
            ])
        ];

        return $types;
    }
}
