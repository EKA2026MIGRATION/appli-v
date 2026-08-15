<?php
require_once(HELPER . 'userSession.php');
require_once(HELPER . 'dates.php');
require_once(HELPER . 'age.php');
require_once(HELPER . 'pickupStatus.php');
require_once(HELPER . 'photo.php');
require_once(HELPER . 'buttons.php');

class Transport extends Controller
{
    const FOOD_CATEGORIES = array(
        'starchy' => 'Féculents',
        'accompaniment' => 'Accompagnement',
        'condiment' => 'Condiment',
        'vegetables' => 'Légumes',
        'sandwich' => 'Sandwich'
    );

    public function viewRide($request)
    {

        if (!isset($request->date)) {
            $date = date('Y-m-d');
        } else {
            $date = $request->date;
        }

        if (isset($request->idDriver)) {
            $idDriver = $request->idDriver;
        } else {

            $idDriver = getCurrentStaffId();
        }

        $params = array();
        $params['date'] = $date;
        $params['rides'] = $this->cURL(API . 'ride/display/' . $date . '/' . $idDriver, 'PHP_CALL', '', 'GET');

        $params['active_driver'] = $this->cURL(API . 'staff/display/' . $idDriver.'/latestMeal', 'PHP_CALL', '', 'GET');
        $params['drivers'] = $this->cURL(API . 'staff/presence/list/driver/' . $date.'/PRESENCE', 'PHP_CALL', '', 'GET');

        $params['foods'] = $this->cURL(API . 'food/list', 'PHP_CALL', '', 'GET');
        $params['foodCategories'] = self::FOOD_CATEGORIES;
        $params['meals'] = $this->cURL(API . 'meal/list/' . $date . '?page=1&size=300', 'PHP_CALL', '', 'GET');

        $params['group']['dropin'] = $this->curl(API . 'ride/retrieve-group-activity/' . $date . '/' . $idDriver . '/dropin', 'PHP_CALL', '', 'GET');
        $params['group']['dropoff'] = $this->curl(API . 'ride/retrieve-group-activity/' . $date . '/' . $idDriver . '/dropoff', 'PHP_CALL', '', 'GET');
        $params['staff'] = $this->cURL(API . 'staff/display/' . PERSON_CONNECTED['staff']['staffId'], 'PHP_CALL', '', 'GET');
        $params['needCheckup'] = $this->cURL(API . 'vehicle/need/checkup', 'PHP_CALL', '', 'GET');


        if (isset($params['staff']->vehicle->vehicleId)) {

            if(array_key_exists($params['staff']->vehicle->matriculation, $params['needCheckup'])) {
                $params['needCheckup'] = true;
            } else {
                $params['needCheckup'] = false;
            }
        
            if ($params['needCheckup']) {
                $params['checkup'] = $this->cURL(API . 'vehicle/item/list', 'PHP_CALL', '', 'GET');
                $params['vehicleList'] = $this->cURL(API . 'vehicle/list?page=1&size=' . SIZE_LIST, 'PHP_CALL', '', 'GET');
             //   $params['staff'] = $this->cURL(API . 'staff/display/' . PERSON_CONNECTED['staff']['staffId'], 'PHP_CALL', '', 'GET');
                $params['dateNow'] = date('Y-m-d');
            }
        } else {
            $params['needCheckup'] = false;
        }

        $params['buttons'] = array(
            array("href" => "javascript:void(0)", "onclick" => "sendSMS()", "label" => "Envoyer SMS PEC", "icon" => "sms"),
            array("href" => HOST . 'transport/print/staffId/' . $idDriver . '/date/' . $date . '/', "onclick" => null, "label" => "Imprimer", "icon" => "print", "attributes" => ['target' => '_blank']),
            array("href" => "javascript:void(0)", "onclick" => "activeSortable()", "label" => "Modificaton de l'ordre", "icon" => "code"),
            array("href" => HOST . 'meal/add', "onclick" => null, "label" => "Ajouter son repas", "icon" => "add"),

        );

        foreach ($params['rides'] as $ride) {

            foreach ($ride->pickups as $pickup) {

                foreach ($params['meals'] as $meal) {
                    if (
                        ($pickup->child->childId != '' or $pickup->child->childId != null)
                        &&
                        ($meal->child != null or $meal->child != '')
                    ) {
                        if (isset($meal->child->childId)) {
                            if ($pickup->child->childId == $meal->child->childId) {
                                $params['meal-child' . $pickup->child->childId] = $meal;
                            }
                        }
                    }
                };
            };
        };

        $this->renderWithData('render/transport/ride', $params);
    }

    public function print($request)
    {

        $date = $request->date;
        $staffId = $request->staffId;

        $params = array();
        $params['date'] = $date;
        $params['rides'] = $this->cURL(API . 'ride/display/' . $date . '/' . $staffId, 'PHP_CALL', '', 'GET');
        $params['driver'] = $this->cURL(API . 'staff/display/' . $staffId, 'PHP_CALL', '', 'GET');


        $this->renderHtml('render/transport/print', $params);
    }

    public function viewCalendar($request)
    {
        if (!isset($request->date)) {
            $dateRef = date('Y-m-d');
        } else {
            $dateRef = $request->date;
        }

        $params = array();
        $monday = getDateStartWeek($dateRef);
        $params = array();
        $params['pickups'] = $this->cURL(API . 'pickup/listWeek/' . $monday, 'PHP_CALL', '', 'GET');

        $params['dateRef'] = $dateRef;

        $this->renderWithData('render/transport/week', $params);
    }
/*
    public function realTime2($request)
    {

        if (!isset($request->date)) {
            $date = date('Y-m-d');
        } else {
            $date = $request->date;
        }

        $params = explode(',', $request->filter);

        $kind = $params[0];
        $moment = $params[1];



        $params = array();
        $params['rides'] = $this->cURL(API . 'ride/realtime/' . $date . '/' . $kind . '/' . $moment, 'PHP_CALL', '', 'GET');
        $params['date'] = $date;

        $this->renderHtml('render/transport/realTime2', $params);
    }
*/
    public function getSupervisionData($request)
    {
        if (!isset($request->date)) {
            $date = date('Y-m-d');
        } else {
            $date = $request->date;
        }

        if (!isset($request->showAddress)) {
            $showAddress = "show";
        } else {
            $showAddress = $request->showAddress;
        }

        $params = explode(',', $request->filter);

        $kind = $params[0];
        $moment = $params[1];


        $params = array();
        $params['kind'] = $kind;
        $params['moment'] = $moment;
        $params['showAddress'] = $showAddress;
        $params['rides'] = $this->cURL(API . 'ride/realtime/' . $date . '/' . $kind . '/' . $moment, 'PHP_CALL', '', 'GET');
        $params['date'] = $date;
        $params['filter'] = $request->filter;

        return $params;
    }

    public function supervision($request)
    {

        $params = $this->getSupervisionData($request);
        $this->renderHtml('render/transport/supervision', $params);
    }

    public function supervisionReload($request)
    {
        $params = $this->getSupervisionData($request);

        $this->renderHtml('render/transport/supervisionReload', $params);
    }


    public function viewCreatePickup($request)
    {
        if (!isset($request->date)) {
            $date = date('Y-m-d');
        } else {
            $date = $request->date;
        }


        $params = array();
        $params['date'] = $date;
        $params['child'] = $request->child;

        $this->renderWithData('render/transport/_createPickupInline', $params);
    }

    public function viewDispatch($request)
    {

        ini_set('memory_limit', '64M');
        ini_set('max_execution_time', '200');

        if (!isset($request->date)) {
            $date = date('Y-m-d');
        } else {
            $date = $request->date;
        }


        $params = array();
        $params['date'] = $date;

        $params['prestas'] = [
            ['name' => 'Franck Mounir', 'email' => 'shertourstransport@gmail.com'],
            ['name' => 'Mounir', 'email' => 'lmwtransports@gmail.com'],
            ['name' => 'Yohann', 'email' => 'yohann.delfour@gmail.com']

        ];

        $params['buttons'] = array(
            array("href" => "javascript:void(0)", "onclick" => "modeEdit(this)", "label" => "Mode édition (drag/drop)", "icon" => "edit"),
            array("href" => "javascript:void(0)", "onclick" => "openRevealJS('revealCreateTrajet');changeActionRide();loadDrivers();loadVehicles();loadRidesForList()", "label" => "Créer un trajet", "icon" => "add"),
            array("href" => "javascript:void(0)", "onclick" => "openRevealJS('revealPickUp');changeActionPickUp()", "label" => "Créer un pickup", "icon" => "add"),
            array("href" => "javascript:void(0)", "onclick" => "openRevealJS('auto-dispatch')", "label" => "Auto Dispatch", "icon" => "code"),
            array("href" => "javascript:void(0)", "onclick" => "closeAll()", "label" => "Fermer / ouvrir", "icon" => "close"),
            array("href" => "javascript:void(0)", "onclick" => "openRevealJS('multiplesRides');loadDrivers();", "label" => "Trajets multiples", "icon" => "format_list_numbered"),
            //array("href" => "javascript:void(0)", "onclick" => "changeColumn()", "label" => "1 ou 2 colonnes", "icon" => "personal_video"),
            array("href" => "javascript:void(0)", "onclick" => "openCreateDropOff()", "label" => "Créer les retours", "icon" => "directions_car"),
            array('href' => HOST . 'transport/duplicate/date/' . $date . '/', "onclick" => null, "label" => 'Dupliquer', 'icon' => 'file_copy')
        );


        // showFloatingActionButton($params['buttons']);

        $this->renderWithData('render/transport/dispatch', $params);
    }

    public function duplicate($request)
    {

        $date = $request->date;
        $params = [];
        $params['date'] = $date;
        $this->renderWithData('render/transport/duplicate', $params);
    }

    public function executeDuplicate($request)
    {
        $source = $request->source;
        $target = $request->target;
        $params['data'] = $this->cURL(API . 'ride/duplicate/' . $source . '/' . $target, 'PHP_CALL', '', 'GET');
        $this->renderHtml('render/transport/duplicateResult', $params);
    }

    public function exportReceiptPickup($request)
    {

        $params['driver'] = $request->driver;
        $params['pickup'] = $this->cURL(API . 'pickup/display/' . $request->pickupId, 'PHP_CALL', '', 'GET');

        $pdf = new PdfService();

        $pdf->setTitle('Bon de réservation');

        $html = $this->getRenderTemplate('render/transport/receiptPickup', $params);

        $pdf->setHtmlContent($html);

        $pdf->renderHtml();
    }


    public function loadOneRide($request)
    {
        $params = array();
        $params['idRide'] = $request->idRide;
        $params['date'] = $request->date;
        $params['rides'] = $this->cURL(API . 'ride/list/' . $request->date, 'PHP_CALL', '', 'GET');
        $params['ride'] = $this->cURL(API . 'ride/display/' . $request->idRide, 'PHP_CALL', '', 'GET');
        $this->renderHtml('render/transport/_loadOneRide', $params);
    }

    public function loadNpec($request)
    {

        $params = array();
        $params['date'] = $request->date;
        $params['pickups_unaffected_dropin'] = $this->cURL(API . 'pickup/list/' . $request->date . '/unaffected/dropin?size=300', 'PHP_CALL', '', 'GET');
        $params['pickups_unaffected_dropoff'] = $this->cURL(API . 'pickup/list/' . $request->date . '/unaffected/dropoff?size=300', 'PHP_CALL', '', 'GET');

        $this->renderHtml('render/transport/_loadNpec', $params);
    }

    public function loadAllRides($request)
    {
        $params = array();
        $params['date'] = $request->date;
        $params['rides'] = $this->cURL(API . 'ride/list/' . $request->date, 'PHP_CALL', '', 'GET');

        $this->renderHtml('render/transport/_loadAllRides', $params);
    }


    public function loadChangeRide($request)
    {
        $params = array();
        $params['date'] = $request->date;
        $params['rides'] = $this->cURL(API . 'ride/list/' . $request->date, 'PHP_CALL', '', 'GET');

        $this->renderHtml('render/transport/_loadChangeRide', $params);
    }

    public function loadValidation($request)
    {
        $params = array();
        $params['date'] = $request->date;
        $params['rides'] = $this->cURL(API . 'ride/list/' . $request->date, 'PHP_CALL', '', 'GET');
        $params['pickups_unaffected_dropin'] = $this->cURL(API . 'pickup/list/' . $request->date . '/unaffected/dropin?size=300', 'PHP_CALL', '', 'GET');
        $params['pickups_unaffected_dropoff'] = $this->cURL(API . 'pickup/list/' . $request->date . '/unaffected/dropoff?size=300', 'PHP_CALL', '', 'GET');

        $i = 0;
        
        $params['validated'] = "";
        
        foreach ($params['rides'] as $ride) {
            if (is_object($ride)) {
                foreach ($ride->pickups as $pickup) {

                    if ($i == 0 and $pickup->validated == "VALIDATED") {
                        $person = $this->cURL(API . 'person/display/' . $pickup->updatedBy, 'PHP_CALL', '', 'GET');
                        $params['validated'] = "par " . $person->firstname . " le " . date('d/m/Y à H:i', strtotime($pickup->updatedAt));
                    }

                    $i++;
                };
            }
        };
        

        $this->renderHtml('render/transport/_loadValidation', $params);
    }


    public function viewOptimize($request)
    {
        $this->render('render/transport/optimize');
    }
}
