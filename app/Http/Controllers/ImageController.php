<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ImageResource;
use App\Http\Requests\ImageRequest;
use App\Repositories\ImageRepository;
use App\Services\ImageService;

class ImageController extends Controller
{
    public function __construct(
        protected ImageRepository $imageRepository,
        protected ImageService $imageService
    ) {
    }

    public function add(Request $request)
    {
        $params = $request->all();

        $image = $request->file('image');
        $includeThumb = (bool) $params['thumb'];

        $row = $this->imageService->add(
            $params['name'] ?? '',
            $image,
            $includeThumb
        );

        return new ImageResource($row);
    }

    public function get(Request $request, int $id)
    {
        $row = $this->imageRepository->get($id);

        return new ImageResource($row);
    }

    public function getAll(Request $request)
    {
        $params = $request->all();
        $rows = $this->imageRepository->getAll($params);

        return ImageResource::collection($rows);
    }

    public function delete(Request $request, int $id)
    {
        $this->imageRepository->delete($id);

        return response()->json([], 204);
    }
}
