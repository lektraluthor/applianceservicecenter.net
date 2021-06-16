<?php

namespace App\Controllers;

use App\Components\Controller as BaseController;

class HomeController extends BaseController {

  protected const REQUIRED_FIELDS = [
    'name',
    'email',
    'phone',
    'address',
    'date',
    'time',
    'description',
    'agreement',
  ];

  public function emailUs() {
    @list(
      'name' => $name,
      'email' => $email,
      'phone' => $phone,
      'address' => $address,
      'date' => $date,
      'time' => $time,
      'service' => $service,
      'description' => $description,
      'agreement' => $agreement,
    ) = $_POST;
    foreach (static::REQUIRED_FIELDS as $field) {
      if (!isset($$field) || $$field === NULL) {
        echo json_encode(['success' => false]);
        return;
      }
    }

    $adminEmail = 'for.spam.kolia@mail.ru';
    $data = [
      'name' => $name,
      'email' => $email,
      'phone' => $phone,
      'address' => $address,
      'date' => $date,
      'time' => $time,
      'service' => $service,
      'description' => $description,
      'agreement' => $agreement,
    ];
    $this->view->vars(compact('data'));
    $message = $this->view->renderEmail('email');
    $subject = 'New booking appointment';
    $result = mail($adminEmail, $subject, $message, "Content-Type: text/html; charset=UTF-8");
    $data = [
      'success' => (bool) $result,
    ];
    echo json_encode($data);
  }
}
