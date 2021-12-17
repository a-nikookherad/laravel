<?php

namespace App\Http\Controllers\Api\V1;

use App\Exceptions\PositionStoreException;
use App\Http\Controllers\Controller;
use App\Http\Requests\PositionStoreRequest;
use App\Models\Position;
use App\Repositories\Position\PositionCreateRepo;
use App\Repositories\Position\PositionDeleteRepo;
use App\Repositories\Position\PositionReadRepo;
use App\Repositories\Position\PositionUpdateRepo;
use Illuminate\Http\Request;

class PositionController extends Controller
{

    public function index()
    {
        $readRepo = new PositionReadRepo();
        $positionCollection = $readRepo->query(\request());
        return $this->successResponse(__("messages.list_of_positions"), $positionCollection);
    }


    public function store(PositionStoreRequest $request)
    {
        $createRepo = new PositionCreateRepo();
        $positionInstance = $createRepo->store($request->only([
            "title",
            "category",
            "min_age",
            "max_age",
            "education",
            "gender",
            "salary",
            "location",
            "expired_at",
            "lived_at",
        ]));
        if (!$positionInstance instanceof Position) {
            throw new PositionStoreException("something went wrong!", 400);
        }

        return $this->successResponse(__("messages.store_position"), $positionInstance->toArray(), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $readRepo = new PositionReadRepo();
        $positionInstance = $readRepo->show($id);
        if (!$positionInstance instanceof Position) {
            return $this->errorResponse(__("messages.something_went_wrong"), [
                "id {$id} is not found"
            ]);
        }
        return $this->successResponse(__("messages.show_position"), $positionInstance);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $readRepo = new PositionReadRepo();
        $positionExist = $readRepo->exist($id);
        if (!$positionExist) {
            return $this->errorResponse(__("messages.something_went_wrong"), [
                "position with id {$id} is not found"
            ]);
        }

        $updateRepo = new PositionUpdateRepo();
        $rowEffect = $updateRepo->update($id, $request->only([
            "title",
            "category",
            "min_age",
            "max_age",
            "education",
            "gender",
            "salary",
            "location",
            "expired_at",
            "lived_at",
        ]));
        if (!$rowEffect) {
            return $this->errorResponse(__("messages.something_went_wrong"), [
                "id {$id} is not updated"
            ]);
        }
        return $this->successResponse(__("messages.update_position"), [], 202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $readRepo = new PositionReadRepo();
        $positionExist = $readRepo->exist($id);
        if (!$positionExist) {
            return $this->errorResponse(__("messages.something_went_wrong"), [
                "position with id {$id} is not found"
            ]);
        }

        $deleteRepo = new PositionDeleteRepo();
        $rowEffect = $deleteRepo->soft($id);
        if (!$rowEffect) {
            return $this->errorResponse(__("messages.something_went_wrong"), [
                "id {$id} is not updated"
            ]);
        }
        return $this->successResponse(__("messages.delete_position"), [], 204);
    }
}
