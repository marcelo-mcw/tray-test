<?php

namespace App\Http\Controllers\Api;

use App\Sale;
use App\Salesperson;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SaleController extends Controller
{
  private $sale;

  private function getCommission($commission, $total)
  {
    return ($total * $commission) / 100;
  }

  public function __construct(Sale $sale)
  {
    $this->sale = $sale;
  }

  public function index(Request $request)
  {
    $params = $request->all();

    $validator = Validator::make($params,
      [
        'id_salesperson' => 'required|exists:salesperson,id'
      ]);

    if($validator->fails())
    {
      return response()->json($validator->messages(), 400);
    }

    $data = $this->sale->getSales(['id_salesperson' => $params['id_salesperson']]);

    return response()->json($data, 200);
  }

  public function create(Request $request)
  {
    try
    {
      $params = $request->all();

      $validator = Validator::make($params,
        [
          'id_salesperson' => 'required|exists:salesperson,id',
          'total'          => 'required|numeric|min:0.01'
        ]);

      if($validator->fails())
      {
        return response()->json($validator->messages(), 400);
      }

      $salesperson    = new Salesperson;
      $qrySalesperson = $salesperson->find($params['id_salesperson']); //Get salesperson data

      $commission = $this->getCommission($qrySalesperson->commission, $params['total']);

      $params['commission'] = $commission;
      $params['date']       = gmdate('Y-m-d'); //UTC

      $data = $this->sale->create($params);

      return response()->json(
          [
            'id'         => $data->id,
            'name'       => $qrySalesperson->name,
            'email'      => $qrySalesperson->email,
            'commission' => round($commission, 2),
            'total'      => round($data->total, 2),
            'date'       => date('m/d/Y', strtotime($data->date))
          ], 201);
    }
    catch (\Exception $e)
    {
      return response()->json($e, 400);
    }
  }
}
