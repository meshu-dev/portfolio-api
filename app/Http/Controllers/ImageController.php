<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ImageRepository;
use App\Http\Resources\ImageResource;
use App\Validators\ImageValidator;

class ImageController extends Controller
{
    protected $resource = ImageResource::class;

    public function __construct(
        protected ImageRepository $imageRepository,
        protected ImageValidator $imageValidator
    ) { }

    public function add(Request $request)
    {
        $params = $request->all();
        $this->imageValidator->verifyAdd($params);
        
        $row = $this->imageRepository->add($params);

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

    public function getSites(Request $request, int $id)
    {
        $this->imageValidator->verifyExists($id);

        $row = $this->imageRepository->get($id);

        $this->resource = SiteResource::class;
        return $this->getResponse($row->sites);
    }

    public function edit(Request $request, int $id)
    {
        $params = $request->all();
        $this->imageValidator->verifyEdit($id, $params);

        $isUpdated = $this->imageRepository->edit($id, $params);
        $row = null;

        if ($isUpdated == true) {
            $row = $this->imageRepository->get($id);
        }

        return $this->getResponse($row);
    }

    public function delete(Request $request, int $id)
    {
        $this->imageValidator->verifyExists($id);

        $this->imageRepository->delete($id);

        return $this->getResponse([], 204);
    }
}