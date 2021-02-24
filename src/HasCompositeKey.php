<?php
namespace Thiagoprz\CompositeKey;

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
}
