<?php

namespace App\Service;

use App\Dao\BaseDao;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;


class BaseService
{
    private $baseDao;

    public function __construct(BaseDao $baseDao)
    {
        $this->baseDao = $baseDao;
    }

    protected function transaction($okFunction){
        DB::transaction(function () use ($okFunction) {
            $okFunction();
        }, 5);
    }

    protected function beginTransaction(){
        DB::beginTransaction();
    }

    protected function rollBack(){
        DB::rollBack();
    }

    protected function commit(){
        DB::commit();
    }

    protected function getSql($query)
    {
        return Str::replaceArray('?', $query->getBindings(), $query->toSql());
    }

    public function get($id)
    {
        return $this->baseDao->get($id);
    }

    public function paginate($items, $perPage = 15, $page = null, $options = []){
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }


    public function delete($id)
    {
        return $this->baseDao->delete($id);
    }
}
