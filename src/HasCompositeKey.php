<?php

namespace Thiagoprz\CompositeKey;

use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Trait HasCompositeKey
 * @package Thiagoprz\CompositeKey
 */
trait HasCompositeKey
{

    /**
     * Set the keys for a save update query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery($query)
    {
        $keys = $this->getKeyName();
        return !is_array($keys) ? parent::setKeysForSaveQuery($query) : $query->where(function($q) use($keys) {
            foreach($keys as $key){
                $q->where($key, '=', $this->getAttribute($key));
            }
        });
    }

    /**
     * Get the casts array.
     *
     * @return array
     */
    public function getCasts()
    {
        if ($this->getIncrementing()) {
            return array_merge([$this->getKeyName() => $this->getKeyType()], $this->casts);
        }
        return $this->casts;
    }

    /**
     * @return false
     */
    public function getIncrementing()
    {
        return false;
    }

    /**
     * Get the value of the model's primary key.
     *
     * @return mixed
     */
    public function getKey()
    {
        $fields = $this->getKeyName();
        $keys = [];
        array_map(function($key) use(&$keys) {
            $keys[] = $this->getAttribute($key);
        }, $fields);
        return $keys;
    }

    /**
     * Finds model by primary keys
     *
     * @param array $ids
     * @return mixed
     */
    public static function find(array $ids)
    {
        $modelClass = self::class;
        $model = new $modelClass();
        $keys = $model->primaryKey;
        return $model->where(function($query) use($ids, $keys) {
            foreach ($keys as $idx => $key) {
                if (isset($ids[$idx])) {
                    $query->where($key, $ids[$idx]);
                } else {
                    $query->whereNull($key);
                }
            }
        })->first();
    }

    /**
     * Find model by primary key or throws ModelNotFoundException
     *
     * @param array $ids
     * @return mixed
     */
    public function findOrFail(array $ids)
    {
        if (!isset($this)) {
            $modelClass = self::class;
            $model = new $modelClass();
        } else {
            $model = $this;
        }
        $record = $model->find($ids);
        if (!$record) {
            throw new ModelNotFoundException;
        }
        return $record;
    }
}
