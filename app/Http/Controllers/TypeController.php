<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TypeRepository;
use App\Http\Resources\TypeResource;
use App\Validators\TypeValidator;

class TypeController extends Controller
{
    protected $resource = TypeResource::class;

    public function __construct(
        protected TypeRepository $typeRepository,
        protected TypeValidator $typeValidator
    ) { }

    public function add(Request $request)
    {
        $params = $request->all();
        $this->typeValidator->verifyAdd($params);
        
        $row = $this->typeRepository->add($params);

        return $this->getResponse($row, 201);
    }

    public function get(Request $request, int $id)
    {
        $this->typeValidator->verifyExists($id);

        $row = $this->typeRepository->get($id);

        return $this->getResponse($row);
    }

    public function getPaginated(Request $request)
    {
        $params = $request->all();

        $pagination = $this->typeRepository->getPagination(
            $params['limit'] ?? null
        );

        return $this->getPaginatedResponse($pagination);
    }

    public function edit(Request $request, int $id)
    {
        $params = $request->all();
        $this->typeValidator->verifyEdit($id, $params);

        $isUpdated = $this->typeRepository->edit($id, $params);
        $row = null;

        if ($isUpdated == true) {
            $row = $this->typeRepository->get($id);
        }

        return $this->getResponse($row);
    }

    public function delete(Request $request, int $id)
    {
        $this->typeValidator->verifyDelete($id);

        $this->typeRepository->delete($id);

        return $this->getResponse([], 204);
    }
}
