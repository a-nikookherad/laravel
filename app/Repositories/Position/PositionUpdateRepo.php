<?php


namespace App\Repositories\Position;


use App\Models\Position;

class PositionUpdateRepo
{

    public function update($id, array $fields)
    {
        return Position::query()
            ->where("id",$id)
            ->update($fields);
    }
}
