<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\TechnologyResource;
use App\Http\Requests\TechnologyRequest;
use App\Repositories\TechnologyRepository;

class TechnologyController extends Controller
{
    public function __construct(
        protected TechnologyRepository $technologyRepository
    ) {
    }

    public function add(TechnologyRequest $request)
    {
        $params = $request->except('user');
        $params['user_id'] = $request->get('user')->id;

        $row = $this->technologyRepository->add($params);

        return new TechnologyResource($row);
    }

    public function get(Request $request, int $id)
    {
        $userId = $request->get('user')->id;
        $row    = $this->technologyRepository->get($userId, $id);

        return new TechnologyResource($row);
    }

    public function getAll(Request $request)
    {
        $userId = $request->get('user')->id;
        $params = $request->except('user');

        $rows = $this->technologyRepository->getAll($userId, $params);

        return TechnologyResource::collection($rows);
    }

    public function edit(TechnologyRequest $request, int $id)
    {
        $userId = $request->get('user')->id;
        $params = $request->except('user');

        $this->technologyRepository->edit($userId, $id, $params);
        $row = $this->technologyRepository->get($userId, $id);

        return new TechnologyResource($row);
    }

    public function delete(Request $request, int $id)
    {
        $userId = $request->get('user')->id;
        $this->technologyRepository->delete($userId, $id);

        return response()->json([], 204);
    }
}
