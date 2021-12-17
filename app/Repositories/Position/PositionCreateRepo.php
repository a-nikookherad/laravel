<?php


namespace App\Repositories\Position;


use App\Models\Position;

class PositionCreateRepo
{
    public function store($data)
    {
        return Position::query()
            ->create($data);

    }
}
