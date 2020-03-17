<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
  protected $table = 'config';

  protected $fillable =
    [
      'commission_percent',
      'send_email'
    ];
}
