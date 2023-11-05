<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\AboutResource;
use App\Http\Requests\AboutRequest;
use App\Repositories\AboutRepository;

class AboutController extends Controller
{
    public function __construct(
        protected AboutRepository $aboutRepository
    ) {
    }

    public function add(AboutRequest $request)
    {
        $user = auth()->user();

        $params = $request->all();
        $params['user_id'] = $user->id;

        $row = $this->aboutRepository->add($params);

        return new AboutResource($row);
    }

    public function get(Request $request, int $id)
    {
        $row = $this->aboutRepository->get($id);

        return new AboutResource($row);
    }

    public function getAll(Request $request)
    {
        $params = $request->all();
        $rows = $this->aboutRepository->getAll($params);

        return AboutResource::collection($rows);
    }

    public function edit(AboutRequest $request, int $id)
    {
        $params = $request->all();

        $isUpdated = $this->aboutRepository->edit($id, $params);
        $row = null;

        if ($isUpdated == true) {
            $row = $this->aboutRepository->get($id);
        }

        return new AboutResource($row);
    }

    public function delete(Request $request, int $id)
    {
        $this->aboutRepository->delete($id);

        return response()->json([], 204);
    }
}
