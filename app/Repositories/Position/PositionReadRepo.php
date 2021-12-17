<?php


namespace App\Repositories\Position;


use App\Logics\ElasticSearch\CreateIndex;
use App\Models\Position;
use ElasticScoutDriverPlus\Support\Query;
use Elasticsearch\ClientBuilder;
use Elasticsearch\Endpoints\Search;
use function Symfony\Component\String\toString;

class PositionReadRepo
{

    public function paginate($int)
    {
        return Position::query()
            ->paginate($int);
    }

    public function show($id)
    {
        return Position::query()
            ->where("id", $id)
            ->first();
    }

    public function exist($id)
    {
        return Position::query()
            ->where("id", $id)
            ->exists();
    }

    public function query($request)
    {
        $request = \request();
        if ($request->isNotFilled([
            "category",
            "location",
            "education",
            "gender",
            "created_at",
            "expired_at",
            "age",
            "title",
        ])) {
            return Position::search()->paginate(10);
        }

        //compound query
        $query = Query::bool();

        //all terms queries
        $termQuery = Query::term();
        if ($request->filled("category")) {
            $termQuery->field("category")
                ->value($request->category);
            $query->filter($termQuery);
        }
        if ($request->filled("location")) {
            $termQuery->field("location")
                ->value($request->location);
            $query->filter($termQuery);
        }
        if ($request->filled("education")) {
            $termQuery->field("education")
                ->value($request->education);
            $query->filter($termQuery);
        }
        if ($request->filled("gender")) {
            $termQuery->field("gender")
                ->value($request->gender);
            $query->filter($termQuery);
        }

        //range queries
        $rangeQuery = Query::range();
        if ($request->filled("created_at")) {
            $rangeQuery->field('created_at')
                ->gte($request->created_at)
                ->lte($request->created_at)
                ->format('yyyy-MM-dd HH:mm:ss');
            $query->filter($rangeQuery);
        }

        if ($request->filled("expired_at")) {
            $rangeQuery->field('expired_at')
                ->gte($request->expired_at)
                ->lte($request->expired_at)
                ->format('yyyy-MM-dd HH:mm:ss');
            $query->filter($rangeQuery);
        }

        if ($request->filled("age")) {
            $rangeQuery->field('min_age')
                ->lte($request->age);
            $query->filter($rangeQuery);

            $rangeQuery->field('max_age')
                ->gte($request->age);
            $query->filter($rangeQuery);
        }

        //query for title with fuzzy query
        if ($request->filled("title")) {
            $fuzzyQuery = Query::fuzzy()
                ->field('title')
                ->value($request["title"]);
            $query->must($fuzzyQuery);
        }

        return Position::searchQuery($query)
            ->sortRaw([['salary' => 'asc'], ['lived_at.keyword' => 'asc']])
            ->paginate($request->limit ?? 10)
            ->onlyDocuments();
    }
}
