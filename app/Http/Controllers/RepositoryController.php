<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\RepositoryResource;
use App\Http\Requests\RepositoryRequest;
use App\Repositories\RepositoryRepository;

class RepositoryController extends Controller
{
    public function __construct(
        protected RepositoryRepository $repositoryRepository
    ) {
    }

    public function add(RepositoryRequest $request)
    {
        $user = auth()->user();

        $params = $request->all();
        $params['user_id'] = $user->id;

        $row = $this->repositoryRepository->add($params);

        return new RepositoryResource($row);
    }

    public function get(Request $request, int $id)
    {
        $row = $this->repositoryRepository->get($id);

        return new RepositoryResource($row);
    }

    public function getAll(Request $request)
    {
        $params = $request->all();
        $rows = $this->repositoryRepository->getAll($params);

        return RepositoryResource::collection($rows);
    }

    public function edit(RepositoryRequest $request, int $id)
    {
        $params = $request->all();

        $isUpdated = $this->repositoryRepository->edit($id, $params);
        $row = null;

        if ($isUpdated == true) {
            $row = $this->repositoryRepository->get($id);
        }

        return new RepositoryResource($row);
    }

    public function delete(Request $request, int $id)
    {
        $this->repositoryRepository->delete($id);

        return response()->json([], 204);
    }
}
