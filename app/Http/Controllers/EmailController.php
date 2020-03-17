<?php

namespace App\Http\Controllers;

use SendGrid;
use SendGrid\Mail\Mail;
use App\Salesperson;
use App\Http\Controllers\Controller;

class EmailController extends Controller
{
  private function send($to, $subject, $content)
  {
    $key = config('services.sendgrid.key');

    $htmlContent = view($content['view'], $content['data'])->render();

    $email = new Mail();
    $email->setFrom('teste@tray.com.br', 'Teste Tray');
    $email->setSubject($subject);
    $email->addTo($to['email'], $to['name']);
    $email->addContent("text/html", $htmlContent);

    $sendgrid = new SendGrid($key);

    try
    {
      $response = $sendgrid->send($email);
      print $response->statusCode() . "\n";
      print_r($response->headers());
      print $response->body() . "\n";
    }
    catch (Exception $e)
    {
      echo 'Falha ao enviar e-mail: '. $e->getMessage() ."\n";
    }
  }

  public function sendSalesperson()
  {
    $salesperson = new Salesperson;

    $date    = gmdate('Y-m-d'); //UTC
    $subject = 'Vendas diárias';

    $qry = $salesperson->getAll(['date' => $date]);

    if(!empty($qry))
    {
      foreach ($qry as $item)
      {
        $name  = $item->name;
        $email = $item->email;
        $total = floatval($item->commission_total);

        $to =
          [
            'email' => $email,
            'name'  => $name
          ];

        $content =
          [
            'view' => 'emails/salesperson',
            'data' =>
              [
                'name'  => $name,
                'total' => $total
              ]
          ];

        $this->send($to, $subject, $content);
      }
    }
  }
}
