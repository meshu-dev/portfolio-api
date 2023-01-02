<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\RepositoryRepository;
use App\Http\Resources\RepositoryResource;
use App\Validators\RepositoryValidator;

class RepositoryController extends Controller
{
    protected $resource = RepositoryResource::class;

    public function __construct(
        protected RepositoryRepository $repositoryRepository,
        protected RepositoryValidator $repositoryValidator
    ) { }

    public function add(Request $request)
    {
        $params = $request->all();
        $this->repositoryValidator->verifyAdd($params);
        
        $row = $this->repositoryRepository->add($params);

        return $this->getResponse($row, 201);
    }

    public function get(Request $request, int $id)
    {
        $this->repositoryValidator->verifyExists($id);

        $row = $this->repositoryRepository->get($id);

        return $this->getResponse($row);
    }

    public function getPaginated(Request $request)
    {
        $params = $request->all();

        $pagination = $this->repositoryRepository->getPagination(
            $params['limit'] ?? null
        );

        return $this->getPaginatedResponse($pagination);
    }

    public function edit(Request $request, int $id)
    {
        $params = $request->all();
        $this->repositoryValidator->verifyEdit($id, $params);

        $isUpdated = $this->repositoryRepository->edit($id, $params);
        $row = null;

        if ($isUpdated == true) {
            $row = $this->repositoryRepository->get($id);
        }

        return $this->getResponse($row);
    }

    public function delete(Request $request, int $id)
    {
        $this->repositoryValidator->verifyDelete($id);

        $this->repositoryRepository->delete($id);

        return $this->getResponse([], 204);
    }
}
