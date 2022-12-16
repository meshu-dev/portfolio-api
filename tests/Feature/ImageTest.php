<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ImageTest extends TestCase
{
    use RefreshDatabase;

    protected $url = '/api/images';

    protected $structure = [
        'id',
        'url',
        'thumb' => [
            'id',
            'url'
        ]
    ];

    public function setUp(): void
    {
        parent::setUp();
        $this->imageService = $this->app->make('Tests\Services\ImageService');
    }

    public function test_getting_image_by_id()
    {
        $this->setupAuth();

        $image = $this->imageService->addImage();

        $this->json('GET', "{$this->url}/{$image->id}")
            ->assertOk()
            ->assertJsonStructure([
                'data' => $this->structure
            ]);
    }

    public function test_stop_getting_image_by_id_with_no_token()
    {
        $image = $this->imageService->addImage();

        $this->testUnauthorised('GET', "{$this->url}/{$image->id}");
    }

    public function test_getting_empty_image_by_invalid_id()
    {
        $this->setupAuth();

        $id = $this->getInvalidId();

        $this->json('GET', "{$this->url}/$id")
             ->assertStatus(422);
    }

    public function test_getting_list_of_images()
    {
        $this->setupAuth();

        $this->imageService->addImages();

        $this->json('GET', $this->url)
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    '*' => $this->structure
                ]
            ]);
    }

    public function test_stop_getting_list_of_images_with_no_token()
    {
        $this->imageService->addImages();

        $this->testUnauthorised('GET', $this->url);
    }

    public function test_getting_empty_list_of_images()
    {
        $this->setupAuth();

        $this->json('GET', $this->url)
            ->assertOk()
            ->assertJson([
                'data' => []
            ]);
    }

    public function test_adding_image()
    {
        $this->setupAuth();

        $params = [
            'image' => new UploadedFile(resource_path('images/example.jpg'), 'example.jpg', null, null, true),
            'thumb' => 'true'
        ];

        $this->json('POST', $this->url, $params)
            ->assertStatus(201)
            ->assertJsonStructure([
                'data' => $this->structure
            ]);
    }

    public function test_stop_adding_image_with_no_token()
    {
        $params = [
            'image' => new UploadedFile(resource_path('images/example.jpg'), 'example.jpg', null, null, true),
            'thumb' => true
        ];

        $this->testUnauthorised('POST', $this->url, $params);
    }

    public function test_deleting_image()
    {
        $this->setupAuth();

        $image = $this->imageService->addImage();
        $id = $image->id;

        $this->json('DELETE', "{$this->url}/{$id}")
             ->assertNoContent();
    }

    public function test_stop_deleting_image_with_no_token()
    {
        $image = $this->imageService->addImage();
        $id = $image->id;

        $this->testUnauthorised('DELETE', "{$this->url}/{$id}");
    }

    public function test_stop_deleting_image_with_invalid_id()
    {
        $this->setupAuth();

        $id = $this->getInvalidId();

        $this->json('DELETE', "{$this->url}/$id")
             ->assertStatus(422);
    }
}
