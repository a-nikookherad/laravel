<?php

namespace App\Models;

use ElasticScoutDriverPlus\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory, Searchable;
    protected $fillable = [
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
    ];

    public function toSearchableArray()
    {
        $array = $this->toArray();
        unset($array["updated_at"]);
        return $array;
    }
}
