<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ProjectResource;
use App\Http\Requests\ProjectRequest;
use App\Repositories\ProjectRepository;

class ProjectController extends Controller
{
    public function __construct(
        protected ProjectRepository $projectRepository
    ) {
    }

    public function add(ProjectRequest $request)
    {
        $params = $request->except('user');
        $params['user_id'] = $request->get('user')->id;

        $row = $this->projectRepository->add($params);

        return new ProjectResource($row);
    }

    public function get(Request $request, int $id)
    {
        $userId = $request->get('user')->id;
        $row = $this->projectRepository->get($userId, $id);

        return new ProjectResource($row);
    }

    public function getAll(Request $request)
    {
        $userId = $request->get('user')->id;
        $params = $request->except('user');

        $rows = $this->projectRepository->getAll($userId, $params);

        return ProjectResource::collection($rows);
    }

    public function edit(ProjectRequest $request, int $id)
    {
        $userId = $request->get('user')->id;
        $params = $request->except('user');

        $this->projectRepository->edit($userId, $id, $params);
        $row = $this->projectRepository->get($userId, $id);

        return new ProjectResource($row);
    }

    public function delete(Request $request, int $id)
    {
        $userId = $request->get('user')->id;
        $this->projectRepository->delete($userId, $id);

        return response()->json([], 204);
    }
}
