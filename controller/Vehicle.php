<?php
require_once(HELPER . 'dates.php');
require_once(HELPER . 'age.php');
require_once(HELPER . 'photo.php');
require_once(HELPER . 'buttons.php');

/**
 * Class Vehicules
 *
 */


class Vehicle extends Controller
{
  public function viewList($request)
  {

    $params = array();

    $params['vehicle_action_type'] = array(
      array('id' => '282', 'name' => 'Carrosserie', 'constant_key' => 'CARROSSERIE', 'description' => ''),
      array('id' => '283', 'name' => 'Phares avant / Feux arrière', 'constant_key' => 'PHARES', 'description' => ''),
      array('id' => '284', 'name' => 'Amortisseurs', 'constant_key' => 'AMORTISSEUR', 'description' => ''),
      array('id' => '285', 'name' => 'Freinage', 'constant_key' => 'FREINAGE', 'description' => ''),
      array('id' => '286', 'name' => 'Etanchéité moteur', 'constant_key' => 'ETANCHIETE', 'description' => ''),
      array('id' => '287', 'name' => 'Jeu de distribution', 'constant_key' => 'JEUX_DISTRIBUTION', 'description' => ''),
      array('id' => '288', 'name' => 'Distribution', 'constant_key' => 'DISTRIBUTION', 'description' => ''),
      array('id' => '289', 'name' => 'Jeu d\'embrayage', 'constant_key' => 'EMBRAYAGE', 'description' => ''),
      array('id' => '290', 'name' => 'Echappement', 'constant_key' => 'ECHAPPEMENT', 'description' => ''),
      array('id' => '291', 'name' => 'Dépannage / Réparation rapide', 'constant_key' => 'DEPANNAGE', 'description' => ''),
      array('id' => '292', 'name' => 'Standard', 'constant_key' => 'STANDARD_PREV', 'description' => ''),
      array('id' => '293', 'name' => 'Pneumatique', 'constant_key' => 'PNEUMATIQUE', 'description' => '')
    );

    $params['checkup'] = $this->cURL(API . 'vehicle/item/list', 'PHP_CALL', '', 'GET');
    $params['report'] = 0;
    $params['vehicleDateStart'] = date('Y-m-d', strtotime('first day of january this year'));
    $params['vehicleDateEnd'] = date('Y-m-d', strtotime('today'));
    $params['vehicleId'] = 0;


    if (isset($request->date_start)) {
      $params['report'] = 1;
      $params['vehicleDateStart'] = $request->date_start;
      $params['vehicleDateEnd'] = $request->date_end;
    }

    $params['vehicleListBetween'] = $this->cURL(API . 'vehicle/data/date/' . $params['vehicleDateStart'] . '/' . $params['vehicleDateEnd'], 'PHP_CALL', '', 'GET');

    $params['staff'] = $this->cURL(API . 'staff/list/driver?page=1&size=200', 'PHP_CALL', '', 'GET');
    $params['vehicleList'] = $this->cURL(API . 'vehicle/list?page=1&size=' . SIZE_LIST, 'PHP_CALL', '', 'GET');


    $this->renderWithData('render/vehicle/list', $params);
  }


  public function viewAddFuel($request)
  {

    $params = array();

    $params['vehicleList'] = $this->cURL(API . 'vehicle/list?page=1&size=' . SIZE_LIST, 'PHP_CALL', '', 'GET');
    $params['staff'] = $this->cURL(API . 'staff/display/' . PERSON_CONNECTED['staff']['staffId'], 'PHP_CALL', '', 'GET');
    $params['date'] = date('Y-m-d');
    $this->renderWithData('render/vehicle/addFuel', $params);
  }

  public function viewAddCheckup($request)
  {
    $params = array();

    $params['checkup'] = $this->cURL(API . 'vehicle/item/list', 'PHP_CALL', '', 'GET');
    $params['vehicleList'] = $this->cURL(API . 'vehicle/list?page=1&size=' . SIZE_LIST, 'PHP_CALL', '', 'GET');
    $params['staff'] = $this->cURL(API . 'staff/display/' . PERSON_CONNECTED['staff']['staffId'], 'PHP_CALL', '', 'GET');
    $params['date'] = date('Y-m-d');
    $this->renderWithData('render/vehicle/addCheckup', $params);
  }

  public function viewAddWash($request)
  {
    $params = array();

    $params['vehicleList'] = $this->cURL(API . 'vehicle/list?page=1&size=' . SIZE_LIST, 'PHP_CALL', '', 'GET');
    $params['staff'] = $this->cURL(API . 'staff/display/' . PERSON_CONNECTED['staff']['staffId'], 'PHP_CALL', '', 'GET');
    $params['date'] = date('Y-m-d');
    $this->renderWithData('render/vehicle/addWash', $params);
  }

  public function viewAddMaintenance($request)
  {
    $params = array();

    $params['vehicle_action_type'] = array(
      array('id' => '282', 'name' => 'Carrosserie', 'constant_key' => 'CARROSSERIE', 'description' => ''),
      array('id' => '283', 'name' => 'Phares avant / Feux arrière', 'constant_key' => 'PHARES', 'description' => ''),
      array('id' => '284', 'name' => 'Amortisseurs', 'constant_key' => 'AMORTISSEUR', 'description' => ''),
      array('id' => '285', 'name' => 'Freinage', 'constant_key' => 'FREINAGE', 'description' => ''),
      array('id' => '286', 'name' => 'Etanchéité moteur', 'constant_key' => 'ETANCHIETE', 'description' => ''),
      array('id' => '287', 'name' => 'Jeu de distribution', 'constant_key' => 'JEUX_DISTRIBUTION', 'description' => ''),
      array('id' => '288', 'name' => 'Distribution', 'constant_key' => 'DISTRIBUTION', 'description' => ''),
      array('id' => '289', 'name' => 'Jeu d\'embrayage', 'constant_key' => 'EMBRAYAGE', 'description' => ''),
      array('id' => '290', 'name' => 'Echappement', 'constant_key' => 'ECHAPPEMENT', 'description' => ''),
      array('id' => '291', 'name' => 'Dépannage / Réparation rapide', 'constant_key' => 'DEPANNAGE', 'description' => ''),
      array('id' => '292', 'name' => 'Standard', 'constant_key' => 'STANDARD_PREV', 'description' => ''),
      array('id' => '293', 'name' => 'Pneumatique', 'constant_key' => 'PNEUMATIQUE', 'description' => '')
    );


    $params['vehicleList'] = $this->cURL(API . 'vehicle/list?page=1&size=' . SIZE_LIST, 'PHP_CALL', '', 'GET');
    $params['staff'] = $this->cURL(API . 'staff/display/' . PERSON_CONNECTED['staff']['staffId'], 'PHP_CALL', '', 'GET');
    $params['date'] = date('Y-m-d');
    $this->renderWithData('render/vehicle/addMaintenance', $params);
  }

  public function viewDisplay($request)
  {
    $params = array();


    if (isset($request->id)) {
      $params['checkup'] = $this->cURL(API . 'vehicle/item/list', 'PHP_CALL', '', 'GET');
      $params['vehicleDateStart'] = date('Y-m-d', strtotime('first day of last year'));
      $params['vehicleDateEnd'] = date('Y-m-d', strtotime('today'));



      $params['vehicleListBetween'] = $this->cURL(API . 'vehicle/data/date/' . $params['vehicleDateStart'] . '/' . $params['vehicleDateEnd'], 'PHP_CALL', '', 'GET');
      $params['id'] = $request->id;
      $params['staff'] = $this->cURL(API . 'staff/list/driver?page=1&size=200', 'PHP_CALL', '', 'GET');
      $params['reminders'] = $this->cURL(API . 'reminder/list/all/'.$request->id, 'PHP_CALL', '', 'GET');

      $params['date'] = date('Y-m-d');
      $this->renderWithData('render/vehicle/display', $params);
    } else {
      header('location: ' . HOST . 'vehicle/list');
    }
  }


  public function viewAddReminder($request)
  {
    $params = array();

    $params['vehicleList'] = $this->cURL(API . 'vehicle/list?page=1&size=' . SIZE_LIST, 'PHP_CALL', '', 'GET');
    $params['staff'] = $this->cURL(API . 'staff/display/' . PERSON_CONNECTED['staff']['staffId'], 'PHP_CALL', '', 'GET');
    $params['date'] = date('Y-m-d');
    $this->renderWithData('render/vehicle/addReminder', $params);
  }
}
