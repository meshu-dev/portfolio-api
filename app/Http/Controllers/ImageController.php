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
        $userId = $request->get('user')->id;
        $params = $request->except('user');

        $image = $request->file('image');
        $includeThumb = (bool) $params['thumb'];

        $row = $this->imageService->add(
            $userId,
            $image,
            $includeThumb
        );

        return new ImageResource($row);
    }

    public function get(Request $request, int $id)
    {
        $userId = $request->get('user')->id;
        $row    = $this->imageRepository->get($userId, $id);

        return new ImageResource($row);
    }

    public function getAll(Request $request)
    {
        $userId = $request->get('user')->id;
        $params = $request->except('user');

        $rows = $this->imageRepository->getAll($userId, $params);

        return ImageResource::collection($rows);
    }

    public function delete(Request $request, int $id)
    {
        $userId = $request->get('user')->id;
        $this->imageRepository->delete($userId, $id);

        return response()->json([], 204);
    }
}
