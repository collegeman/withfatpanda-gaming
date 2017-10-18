<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    protected $fillable = [ 'name', 'value' ];

    function meta()
    {
      return $this->morphTo();   
    }

    function setValueAttribute($value)
    {
      $this->attributes['value'] = serialize($value);
    }

    function getValueAttribute($value)
    {
      if (array_key_exists('value', $this->attributes)) {
        return unserialize($this->attributes['value']);
      } else {
        return null;
      } 
    }
}
