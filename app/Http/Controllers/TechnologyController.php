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
        $user = auth()->user();

        $params = $request->all();
        $params['user_id'] = $user->id;

        $row = $this->technologyRepository->add($params);

        return new TechnologyResource($row);
    }

    public function get(Request $request, int $id)
    {
        $row = $this->technologyRepository->get($id);

        return new TechnologyResource($row);
    }

    public function getAll(Request $request)
    {
        $params = $request->all();
        $rows = $this->technologyRepository->getAll($params);

        return TechnologyResource::collection($rows);
    }

    public function edit(TechnologyRequest $request, int $id)
    {
        $params = $request->all();

        $isUpdated = $this->technologyRepository->edit($id, $params);
        $row = null;

        if ($isUpdated == true) {
            $row = $this->technologyRepository->get($id);
        }

        return new TechnologyResource($row);
    }

    public function delete(Request $request, int $id)
    {
        $this->technologyRepository->delete($id);

        return response()->json([], 204);
    }
}
