<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
  protected $table = 'sale';

  protected $fillable =
    [
      'id_salesperson',
      'total',
      'commission',
      'date'
    ];

  public function getSales(array $params = [])
  {
    $qry = $this->select('salesperson.id AS salesperson_id',
                         'salesperson.name AS salesperson_name',
                         'salesperson.email AS salesperson_email',
                         'salesperson.commission AS salesperson_commission',
                         'sale.id AS sale_id',
                         'sale.commission AS sale_commission',
                         'sale.total AS sale_total')
                ->selectRaw('DATE_FORMAT(sale.date, "%d/%m/%Y") AS sale_date')
                ->leftJoin('salesperson',
                           'salesperson.id',
                           '=',
                           'sale.id_salesperson');

    if(!empty($params))
    {
      if(array_key_exists('id_salesperson', $params))
      {
        $qry = $qry->where('sale.id_salesperson', '=', $params['id_salesperson']);
      }
    }

    $qry = $qry->get();

    return $qry;
  }
}
