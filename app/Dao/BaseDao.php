<?php

namespace App\Dao;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BaseDao
{
    private $baseModel;

    protected function __construct(Model $baseModel)
    {
        $this->baseModel = $baseModel;
    }

    protected function getSql($query)
    {
        return Str::replaceArray('?', $query->getBindings(), $query->toSql());
    }

    public function get($id)
    {
        return $this->baseModel->find($id);
    }

    public function delete($id)
    {
        $getItem = $this->get($id);
        return $getItem->delete($id);
    }

    public function cleanData(&$object) {

        foreach ($object as $property => &$value) {
            if (is_object($value)) {
                $this->cleanData($value);
                if (empty(get_object_vars($value))) {
                    unset($object->$property);
                }
            }
            if (is_array($value) && is_object($value[0])) {
                foreach ($value as $val) {
                    $this->cleanData($val);
                }
            }
            if (is_null($value) || (is_array($value) && empty($value))) {
                unset($object->$property);
            }
        }

        /*exit(var_dump($object));*/

        return $object;
    }
}
