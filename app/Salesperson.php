<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Salesperson extends Model
{
  protected $table = 'salesperson';

  protected $fillable =
    [
      'name',
      'email',
      'commission'
    ];

  public function getAll(array $params = [])
  {
    $qry = $this->select('salesperson.id',
                         'salesperson.name',
                         'salesperson.email',
                         'salesperson.commission AS commission_percent')
                ->selectRaw('SUM(sale.commission) AS commission_total')
                ->leftJoin('sale',
                           'sale.id_salesperson',
                           '=',
                           'salesperson.id');

    if(!empty($params))
    {
      if(array_key_exists('date', $params))
      {
        $qry = $qry->where('sale.date', '=', $params['date']);
      }
    }

    $qry = $qry->groupBy('salesperson.id')
               ->get();

    return $qry;
  }
}
