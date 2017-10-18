<?php

namespace App;

use App\Concerns\HasMeta;

use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    protected $fillable = [ 'user_id' ];

    use HasMeta;

    function user()
    {
      return $this->belongsTo('App\User');
    }

    function game()
    {
      return $this->belongsTo('App\Game');
    }
}
