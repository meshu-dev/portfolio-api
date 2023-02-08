<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ProjectRepository;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\TypeResource;
use App\Validators\ProjectValidator;

class ProjectController extends Controller
{
    protected $resource = ProjectResource::class;

    public function __construct(
        protected ProjectRepository $projectRepository,
        protected ProjectValidator $projectValidator
    ) {
    }

    public function add(Request $request)
    {
        $params = $request->all();
        $this->projectValidator->verifyAdd($params);

        $row = $this->projectRepository->add($params);

        return $this->getResponse($row, 201);
    }

    public function get(Request $request, int $id)
    {
        $this->projectValidator->verifyExists($id);

        $row = $this->projectRepository->get($id);

        return $this->getResponse($row);
    }

    public function getTypes(Request $request)
    {
        $this->resource = TypeResource::class;
        $rows = $this->projectRepository->getTypes();

        return $this->getResponse($rows, 200);
    }

    public function getPaginated()
    {
        $pagination = $this->projectRepository->getPagination();

        return $this->getPaginatedResponse($pagination);
    }

    public function edit(Request $request, int $id)
    {
        $params = $request->all();
        $this->projectValidator->verifyEdit($id, $params);

        $isUpdated = $this->projectRepository->edit($id, $params);
        $row = null;

        if ($isUpdated == true) {
            $row = $this->projectRepository->get($id);
        }

        return $this->getResponse($row);
    }

    public function delete(Request $request, int $id)
    {
        $this->projectValidator->verifyExists($id);

        $this->projectRepository->delete($id);

        return $this->getResponse([], 204);
    }
}
