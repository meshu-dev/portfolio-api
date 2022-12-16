<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ImageRepository;
use App\Http\Resources\ImageResource;
use App\Validators\ImageValidator;
use App\Services\ImageService;

class ImageController extends Controller
{
    protected $resource = ImageResource::class;

    public function __construct(
        protected ImageRepository $imageRepository,
        protected ImageValidator $imageValidator,
        protected ImageService $imageService
    ) { }

    public function add(Request $request)
    {
        $params = $request->all();
        $this->imageValidator->verifyAdd($params);

        $image = $request->file('image');
        $includeThumb = (bool) $params['thumb'];

        $row = $this->imageService->add(
            $params['name'] ?? '',
            $image,
            $includeThumb
        );

        return $this->getResponse($row, 201);
    }

    public function get(Request $request, int $id)
    {
        $this->imageValidator->verifyExists($id);

        $row = $this->imageRepository->get($id);

        return $this->getResponse($row);
    }

    public function getAll(Request $request)
    {
        $params = $request->all();
        $rows = $this->imageRepository->getAll($params);

        return $this->getResponse($rows, 200);
    }

    public function delete(Request $request, int $id)
    {
        $this->imageValidator->verifyDelete($id);

        $this->imageService->delete($id);

        return $this->getResponse([], 204);
    }
}
