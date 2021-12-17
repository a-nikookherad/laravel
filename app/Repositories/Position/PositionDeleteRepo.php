<?php


namespace App\Repositories\Position;


use App\Models\Position;

class PositionDeleteRepo
{

    public function hard($id)
    {
        return Position::query()
            ->where("id", $id)
            ->forceDelete();
    }

    public function soft($id)
    {
        return Position::query()
            ->where("id", $id)
            ->delete();
    }
}
