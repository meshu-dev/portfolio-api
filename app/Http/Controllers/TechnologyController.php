<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TechnologyRepository;
use App\Http\Resources\TechnologyResource;
use App\Validators\TechnologyValidator;

class TechnologyController extends Controller
{
    protected $resource = TechnologyResource::class;

    public function __construct(
        protected TechnologyRepository $technologyRepository,
        protected TechnologyValidator $technologyValidator
    ) { }

    public function add(Request $request)
    {
        $params = $request->all();
        $this->technologyValidator->verifyAdd($params);
        
        $row = $this->technologyRepository->add($params);

        return $this->getResponse($row, 201);
    }

    public function get(Request $request, int $id)
    {
        $this->technologyValidator->verifyExists($id);

        $row = $this->technologyRepository->get($id);

        return $this->getResponse($row);
    }

    public function getAll()
    {
        $pagination = $this->technologyRepository->getPagination();

        return $this->getPaginatedResponse($pagination);
    }

    public function edit(Request $request, int $id)
    {
        $params = $request->all();
        $this->technologyValidator->verifyEdit($id, $params);

        $isUpdated = $this->technologyRepository->edit($id, $params);
        $row = null;

        if ($isUpdated == true) {
            $row = $this->technologyRepository->get($id);
        }

        return $this->getResponse($row);
    }

    public function delete(Request $request, int $id)
    {
        $this->technologyValidator->verifyDelete($id);

        $this->technologyRepository->delete($id);

        return $this->getResponse([], 204);
    }
}
