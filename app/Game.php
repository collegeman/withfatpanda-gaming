<?php

namespace App;

use App\Concerns\HasMeta;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasMeta;

    protected $cast = [ 
      'private' => 'bool', 
      'id' => 'int', 
    ];

    protected $dates = [
      'created_at',
      'updated_at',
      'ended_at',
    ];

    function players()
    {
      return $this->hasMany('App\Player');
    }

    function createdBy()
    {
      return $this->belongsTo('App\User', 'created_by');
    }

    function nextPlayer()
    {
      return $this->belongsTo('App\Player', 'next_player');
    }
}

