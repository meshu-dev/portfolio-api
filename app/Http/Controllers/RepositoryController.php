<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\RepositoryResource;
use App\Http\Requests\RepositoryRequest;
use App\Repositories\GitRepoRepository;

class RepositoryController extends Controller
{
    public function __construct(
        protected GitRepoRepository $repositoryRepository
    ) {
    }

    public function add(RepositoryRequest $request)
    {
        $params = $request->except('user');
        $params['user_id'] = $request->get('user')->id;

        $row = $this->repositoryRepository->add($params);

        return new RepositoryResource($row);
    }

    public function get(Request $request, int $id)
    {
        $userId = $request->get('user')->id;
        $row    = $this->repositoryRepository->get($userId, $id);

        return new RepositoryResource($row);
    }

    public function getAll(Request $request)
    {
        $userId = $request->get('user')->id;
        $params = $request->except('user');

        $rows = $this->repositoryRepository->getAll($userId, $params);

        return RepositoryResource::collection($rows);
    }

    public function edit(RepositoryRequest $request, int $id)
    {
        $userId = $request->get('user')->id;
        $params = $request->except('user');

        $this->repositoryRepository->edit($userId, $id, $params);
        $row = $this->repositoryRepository->get($userId, $id);
        
        return new RepositoryResource($row);
    }

    public function delete(Request $request, int $id)
    {
        $userId = $request->get('user')->id;
        $this->repositoryRepository->delete($userId, $id);

        return response()->json([], 204);
    }
}
