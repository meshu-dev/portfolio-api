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
        $user = auth()->user();

        $params = $request->all();
        $params['user_id'] = $user->id;

        $row = $this->projectRepository->add($params);

        return new ProjectResource($row);
    }

    public function get(Request $request, int $id)
    {
        $row = $this->projectRepository->get($id);

        return new ProjectResource($row);
    }

    public function getAll(Request $request)
    {
        $params = $request->all();
        $rows = $this->projectRepository->getAll($params);

        return ProjectResource::collection($rows);
    }

    public function edit(ProjectRequest $request, int $id)
    {
        $params = $request->all();

        $isUpdated = $this->projectRepository->edit($id, $params);
        $row = null;

        if ($isUpdated == true) {
            $row = $this->projectRepository->get($id);
        }

        return new ProjectResource($row);
    }

    public function delete(Request $request, int $id)
    {
        $this->projectRepository->delete($id);

        return response()->json([], 204);
    }
}
