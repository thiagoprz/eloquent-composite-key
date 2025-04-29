<?php

namespace Thiagoprz\CompositeKey;

use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Trait HasCompositeKey
 * @package Thiagoprz\CompositeKey
 */
trait HasCompositeKey
{

    public function getIncrementing()
    {
        return false;
    }

    public function getCasts()
    {
        if ($this->getIncrementing()) {
            return array_merge([$this->getKeyName() => $this->getKeyType()], $this->casts);
        }
        return $this->casts;
    }

    public function getKeyName()
    {
        return $this->primaryKey;
    }

    public function getKey()
    {
        $fields = $this->getKeyName();
        $keys = [];
        array_map(function ($key) use (&$keys) {
            $keys[] = $this->getAttribute($key);
        }, $fields);
        return $keys;
    }

    protected function getKeysForSaveQuery($query)
    {
        foreach ($this->primaryKey as $key) {
            $query->where($key, '=', $this->getAttribute($key));
        }
        return $query;
    }

    protected function setKeysForSaveQuery($query)
    {
        $keys = $this->getKeyName();
        return !is_array($keys) ? parent::setKeysForSaveQuery($query) : $query->where(function ($q) use ($keys) {
            foreach ($keys as $key) {
                $q->where($key, '=', $this->getAttribute($key));
            }
        });
    }

    public function getQueueableId()
    {
        return implode(':', array_map(fn($key) => $this->getAttribute($key), $this->getKeyName()));
    }


    public static function find(string|array $ids)
    {
        if (is_string($ids)) {
            $ids = explode(':', $ids);
        }

        $model = new static();
        $keyNames = $model->getKeyName();

        if (!is_array($ids) || count($ids) !== count($keyNames)) {
            return null;
        }

        return static::where(function ($query) use ($keyNames, $ids) {
            foreach ($keyNames as $index => $key) {
                $query->where($key, '=', $ids[$index]);
            }
        })->first();
    }


    /**
     * Find model by primary key or throws ModelNotFoundException
     *
     * @param array $ids
     * @return mixed
     */
    public static function findOrFail(array $ids)
    {
        $modelClass = get_called_class();
        $model = new $modelClass();
        $record = $model->find($ids);
        if (!$record) {
            throw new ModelNotFoundException;
        }
        return $record;
    }

    public function newQueryForRestoration($ids)
    {
        if (is_string($ids) && str_contains($ids, ':')) {
            $ids = explode(':', $ids);
        }

        if (is_array($ids)) {
            $keyNames = $this->getKeyName();

            if (count($ids) !== count($keyNames)) {
                return parent::newQueryForRestoration($ids);
            }

            $query = $this->newQueryWithoutScopes();
            foreach ($keyNames as $index => $key) {
                $query->where($key, '=', $ids[$index]);
            }

            return $query;
        }

        return parent::newQueryForRestoration($ids);
    }
}
