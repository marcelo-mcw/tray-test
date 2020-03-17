<?php

namespace App\Http\Controllers\Api;

use App\Config;
use App\Salesperson;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SalespersonController extends Controller
{
  private $salesperson;

  public function __construct(Salesperson $salesperson)
  {
    $this->salesperson = $salesperson;
  }

  public function index()
  {
    $data = $this->salesperson->getAll();

    return response()->json($data, 200);
  }

  public function create(Request $request)
  {
    try
    {
      $params = $request->all();

      $validator = Validator::make($params,
        [
          'name'  => 'required',
          'email' => 'required|email:rfc,dns|unique:salesperson',
        ]);

      if($validator->fails())
      {
        return response()->json($validator->messages(), 400);
      }

      $config    = new Config;
      $qryConfig = $config->find(1); //Get params

      $params['commission'] = $qryConfig->commission_percent;

      $data = $this->salesperson->create($params);

      return response()->json(
        [
          'id'    => $data->id,
          'name'  => $data->name,
          'email' => $data->email
        ], 201);
    }
    catch (\Exception $e)
    {
      return response()->json($e, 400);
    }
  }
}
