<?php
require_once HELPER . 'userSession.php';
use_helper('dates');
use_helper('invoice');

/**
 * Class Home.
 *
 * use to show the home page
 */
class Home extends Controller
{
    public function display($request)
    {
        if(isset($_SESSION['start'])) {

            // create SESSION STAFF
            $staffs = $this->cURL(API.'staff/list/all/all', 'PHP_CALL', '', 'GET');    
            foreach($staffs as $staff) {
                $_SESSION['STAFFS'][$staff->staffId] = ['fullname' => $staff->fullname, 'firstname' => $staff->person->firstname, 'maxChildren' => $staff->maxChildren ];
            }

            // create LOCATION DATA
            $locations = $this->cURL(API.'location/list', 'PHP_CALL', '', 'GET'); // OK

            foreach($locations as $location) {
                $_SESSION['LOCATIONS'][$location->locationId] = $location;
            }

            // create SPORT DATA
            $sports = $this->cURL(API.'sport/list', 'PHP_CALL', '', 'GET'); // OK

            if($sports == "") {
                $sportsArray = [
                        [
                            "sportId" => 1,
                            "name" => "Tennis",
                            "kind" => "SPORT_TAUGHT",
                            "color" => "#F2FC53",
                            "products" => [],
                            "createdAt" => null,
                            "createdBy" => null,
                            "updatedAt" => null,
                            "updatedBy" => null,
                            "suppressed" => false,
                            "suppressedAt" => null,
                            "suppressedBy" => null
                        ],
                        [
                            "sportId" => 2,
                            "name" => "Foot",
                            "kind" => "SPORT_TAUGHT",
                            "color" => "black",
                            "products" => [],
                            "createdAt" => null,
                            "createdBy" => null,
                            "updatedAt" => null,
                            "updatedBy" => null,
                            "suppressed" => false,
                            "suppressedAt" => null,
                            "suppressedBy" => null
                        ],
                        [
                            "sportId" => 3,
                            "name" => "Basket",
                            "kind" => "SPORT_LEISURE",
                            "color" => "#FCB753",
                            "products" => [],
                            "createdAt" => null,
                            "createdBy" => null,
                            "updatedAt" => null,
                            "updatedBy" => null,
                            "suppressed" => false,
                            "suppressedAt" => null,
                            "suppressedBy" => null
                        ],
                        [
                            "sportId" => 4,
                            "name" => "Golf",
                            "kind" => "SPORT_TAUGHT",
                            "color" => "#0AF14D",
                            "products" => [],
                            "createdAt" => null,
                            "createdBy" => null,
                            "updatedAt" => null,
                            "updatedBy" => null,
                            "suppressed" => false,
                            "suppressedAt" => null,
                            "suppressedBy" => null
                        ],
                        [
                            "sportId" => 7,
                            "name" => "Ski",
                            "kind" => "SPORT_LEISURE",
                            "color" => null,
                            "products" => [],
                            "createdAt" => null,
                            "createdBy" => null,
                            "updatedAt" => null,
                            "updatedBy" => null,
                            "suppressed" => false,
                            "suppressedAt" => null,
                            "suppressedBy" => null
                        ],
                        [
                            "sportId" => 9,
                            "name" => "Multisport",
                            "kind" => "SPORT_TAUGHT",
                            "color" => "#DA8FD0",
                            "products" => [],
                            "createdAt" => null,
                            "createdBy" => null,
                            "updatedAt" => null,
                            "updatedBy" => null,
                            "suppressed" => false,
                            "suppressedAt" => null,
                            "suppressedBy" => null
                        ],
                        [
                            "sportId" => 10,
                            "name" => "Déjeuner",
                            "kind" => "ACTIVITY_LEISURE",
                            "color" => null,
                            "products" => [],
                            "createdAt" => null,
                            "createdBy" => null,
                            "updatedAt" => null,
                            "updatedBy" => null,
                            "suppressed" => false,
                            "suppressedAt" => null,
                            "suppressedBy" => null
                        ],
                        [
                            "sportId" => 11,
                            "name" => "Trampoline",
                            "kind" => "SPORT_LEISURE",
                            "color" => null,
                            "products" => [],
                            "createdAt" => null,
                            "createdBy" => null,
                            "updatedAt" => null,
                            "updatedBy" => null,
                            "suppressed" => false,
                            "suppressedAt" => null,
                            "suppressedBy" => null
                        ],
                        [
                            "sportId" => 12,
                            "name" => "Quad / Kart",
                            "kind" => "SPORT_LEISURE",
                            "color" => null,
                            "products" => [],
                            "createdAt" => null,
                            "createdBy" => null,
                            "updatedAt" => null,
                            "updatedBy" => null,
                            "suppressed" => false,
                            "suppressedAt" => null,
                            "suppressedBy" => null
                        ],
                        [
                            "sportId" => 13,
                            "name" => "Jeux de table (carte/dessin, etc.)",
                            "kind" => "ACTIVITY_LEISURE",
                            "color" => null,
                            "products" => [],
                            "createdAt" => null,
                            "createdBy" => null,
                            "updatedAt" => null,
                            "updatedBy" => null,
                            "suppressed" => false,
                            "suppressedAt" => null,
                            "suppressedBy" => null
                        ],
                        [
                            "sportId" => 14,
                            "name" => "Gym",
                            "kind" => "SPORT_LEISURE",
                            "color" => null,
                            "products" => [],
                            "createdAt" => null,
                            "createdBy" => null,
                            "updatedAt" => null,
                            "updatedBy" => null,
                            "suppressed" => false,
                            "suppressedAt" => null,
                            "suppressedBy" => null
                        ],
                        [
                            "sportId" => 15,
                            "name" => "Jeux de ballons",
                            "kind" => "SPORT_LEISURE",
                            "color" => null,
                            "products" => [],
                            "createdAt" => null,
                            "createdBy" => null,
                            "updatedAt" => null,
                            "updatedBy" => null,
                            "suppressed" => false,
                            "suppressedAt" => null,
                            "suppressedBy" => null
                        ],
                        [
                            "sportId" => 16,
                            "name" => "Jeux vidéo",
                            "kind" => "SPORT_LEISURE",
                            "color" => null,
                            "products" => [],
                            "createdAt" => null,
                            "createdBy" => null,
                            "updatedAt" => null,
                            "updatedBy" => null,
                            "suppressed" => false,
                            "suppressedAt" => null,
                            "suppressedBy" => null
                        ],
                        [
                            "sportId" => 17,
                            "name" => "Séance vidéo",
                            "kind" => "ACTIVITY_LEISURE",
                            "color" => null,
                            "products" => [],
                            "createdAt" => null,
                            "createdBy" => null,
                            "updatedAt" => null,
                            "updatedBy" => null,
                            "suppressed" => false,
                            "suppressedAt" => null,
                            "suppressedBy" => null
                        ],
                        [
                            "sportId" => 18,
                            "name" => "Ping-pong",
                            "kind" => "SPORT_LEISURE",
                            "color" => null,
                            "products" => [],
                            "createdAt" => null,
                            "createdBy" => null,
                            "updatedAt" => null,
                            "updatedBy" => null,
                            "suppressed" => false,
                            "suppressedAt" => null,
                            "suppressedBy" => null
                        ],
                        [
                            "sportId" => 20,
                            "name" => "anglais",
                            "kind" => "ACTIVITY_TAUGHT",
                            "color" => null,
                            "products" => [],
                            "createdAt" => null,
                            "createdBy" => null,
                            "updatedAt" => null,
                            "updatedBy" => null,
                            "suppressed" => false,
                            "suppressedAt" => null,
                            "suppressedBy" => null
                        ]
                    ];

                    $_SESSION['SPORTS'] = [];

                    // Fill the session array with desired format
                    foreach ($sportsArray as $sport) {
                        $_SESSION['SPORTS'][$sport['sportId']] = [
                            'sportId' => $sport['sportId'],
                            'name' => $sport['name'],
                            'color' => $sport['color']
                        ];
                    }


            }  else
            {
                foreach($sports as $sport) {
                    $_SESSION['SPORTS'][$sport->sportId] = ['sportId' => $sport->sportId, 'name' => $sport->name, 'color' => $sport->color];
                }
            }


            $_SESSION['SEASON_ACTIVES'] = $this->cURL(API.'season/list/active?page=1&size='.SIZE_LIST, 'PHP_CALL', '' , 'GET');

            unset($_SESSION['start']);

        }



        if (!isset($request->date)) {
            $date = date('Y-m-d');
            $month = date('Y-m');
        } else {
            $date = $request->date;
            $m = explode('-', $request->date);
            $month = $m[0] . '-' . $m[1];
        }

        if (isset($request->dashboard)) {
            $params['dashboard'] = $request->dashboard;
        } else {
            $params['dashboard'] = "";
        }
        $params['callBack'] = 'app-home';
        $params['date'] = $date;


        if (hasRole(['ADMIN']) || hasCredential('reminder::show')) {
            $reminders1 = $this->cURL(API . 'reminder/list/todo/', 'PHP_CALL', '', 'GET');
            $reminders2 = $this->cURL(API . 'reminder/list/inprogress/', 'PHP_CALL', '', 'GET');
            $params['reminders'] = array_merge((array) $reminders1, (array) $reminders2);
            $params['stockAlert'] = $this->cURL(API . 'stockProduct/alert', 'PHP_CALL', '', 'GET');
        } else {
            $params['staff'] = $this->cURL(API . 'staff/display/' . PERSON_CONNECTED['staff']['staffId'], 'PHP_CALL', '', 'GET');

            if (isset($params['staff']->vehicle->vehicleId)) {
                $params['reminders'] = $this->cURL(API . 'reminder/list/todo/' . $params['staff']->vehicle->vehicleId, 'PHP_CALL', '', 'GET');
            } else {
                $params['reminders'] = null;
            }
        }
    
        $this->renderWithData('render/home/home', $params);
    }

    public function showDashboard($request)
    {
        $type = $request->type;
        $params = $this->getDashboardParams($type, $request);
        $this->renderHtml('render/home/_dashboard' . $type, $params);
    }

    private function getDashboardParams($type, $request)
    {

        $arr = [];

        if (!isset($request->date)) {
            $date = date('Y-m-d');
            $month = date('Y-m');
        } else {
            $date = $request->date;
            $m = explode('-', $request->date);
            $month = $m[0] . '-' . $m[1];
        }

        // days_week
        $dateProvided = new DateTime($date);

        $startOfWeek = clone $dateProvided;
        $startOfWeek->modify('Monday this week');

        $endOfWeek = clone $dateProvided;
        $endOfWeek->modify('Sunday this week');

        $daysOfWeek = [];
        for ($currentDate = clone $startOfWeek; $currentDate <= $endOfWeek; $currentDate->modify('+1 day')) {
            $daysOfWeek[] = $currentDate->format('m-d');
        }

        $_SESSION['DAYS_WEEK'] = $daysOfWeek;

        $params['callBack'] = 'app-home';
        $params['date'] = $date;

        if ($type == 'Operationnel') {
            $params['child_presence'] = $this->cURL(API . 'child/presence/list/' . $date, 'PHP_CALL', '', 'GET');
            $params['staff_presence'] = $this->cURL(API . 'staff/presence/list/all/' . $date, 'PHP_CALL', '', 'GET');
            //$params['tasks_todo']= $this->cURL(API.'task/staff/list/step/TODO/'.getCurrentStaffId().'/'.$date,'PHP_CALL', '', 'GET');

            if (hasCredential('dashboard::task') ) {
                $params['tasks_aday'] = $this->cURL(API.'task/staff/list/'.$date, 'PHP_CALL', '', 'GET');
                $params['tasks_done'] = $this->cURL(API.'task/staff/list/step/DONE/null/'.$date, 'PHP_CALL', '', 'GET');
            } else {
                $params['tasks_aday'] = $this->cURL(API.'task/staff/retrieve/'.getCurrentStaffId().'/'.$date, 'PHP_CALL', '', 'GET');
                $params['tasks_done'] = $this->cURL(API.'task/staff/list/step/DONE/'.getCurrentStaffId().'/'.$date, 'PHP_CALL', '', 'GET');
            }
        }

        if ($type == 'Club') {
            $params['child_birthdates'] = $this->cURL(API . 'child/birthdate', 'PHP_CALL', '', 'GET');
            $params['staff_birthdates'] = $this->cURL(API . 'staff/birthdate', 'PHP_CALL', '', 'GET');
        }

        if ($type == 'Registration') {
            $params['registrations'] = $this->cURL(API . 'registration/list/without-cart?page=1&size=10', 'PHP_CALL', '', 'GET');

            if (hasCredential('dashboard::registration')) {
                $transactions_failed1  = $this->cURL(API.'transaction/list/'.$month.'/process?page=1&size=1000', 'PHP_CALL', '', 'GET');
                $transactions_failed2 = $this->cURL(API.'transaction/list/'.$month.'/paiementInProgress?page=1&size=100', 'PHP_CALL', '', 'GET');
                $params['registrationCarts']  = $this->cURL(API.'registration/list/cart', 'PHP_CALL', '', 'GET');

                $params['historicActions'] = $this->cURL(API.'historicPersonAction/listByAction/EKA-CLIENT-CONNEXION', 'PHP_CALL', '', 'GET');

                if ($transactions_failed1) {
                    foreach ($transactions_failed1 as $trans1) {
                        $arr[$trans1->date] = $trans1;
                    }
                }

                if ($transactions_failed2) {
                    foreach ($transactions_failed2 as $trans2) {
                        $arr[$trans2->date] = $trans2;
                    }
                }

                $params['transactions_failed'] = $arr;
            }
        }

        if ($type == "Transaction") {

            /*
            $params['transactions'] = $this->cURL(API.'transaction/list/'.$month.'/payed?page=1&size=1000', 'PHP_CALL', '', 'GET');
            $params['transactionsDay'] = $this->cURL(API.'transaction/list/'.$date.'/payed', 'PHP_CALL', '', 'GET');
            */

            // invoice week
            $monday = getDateStartWeek($date);
            $end = nextDay($monday, 7);

            $invoices_week = $this->cURL(API . 'invoice/search/' . $monday . '/' . $end . '/cb', 'PHP_CALL', '', 'GET');
            $currentDay = $monday;
            for ($i = 0; $i < 7; $i++) {
                $arr[$currentDay] = [];
                $currentDay = nextDay($currentDay);
            }

            $existDate = [];
            foreach ($invoices_week as $invoice) {
                $key = showDate($invoice->date, 'YmdHis');
                if (in_array($key, $existDate)) {
                    $key++;
                }
                $existDate[] = $key;
                $arr[showDate($invoice->date, 'Y-m-d')][$key] = $invoice;
            }
            $params['invoicesWeek'] = $arr;;

            // invoices months
            $invoices_month = $this->cURL(API . 'invoice/search/' . $month . '-01' . '/' . $end . '/CB', 'PHP_CALL', '', 'GET');

            $totalMonth['Total TTC'] = 0;
            $totalMonth['Total HT']  = 0;
            $totalMonth['Total TVA'] = 0;
            $totalMonth['TVA 10%']   = 0;
            $totalMonth['TVA 20%']   = 0;

            foreach ($invoices_month as $invoice) {
                $datas = extractTva($invoice);

                if ($datas == "no products") continue;

                if (isset($datas['vat10'])) $totalMonth['TVA 10%'] += $datas['vat10'];
                if (isset($datas['vat20'])) $totalMonth['TVA 20%'] += $datas['vat20'];
                $totalMonth['Total TTC'] += $datas['totalTtc'];
                $totalMonth['Total HT'] += $datas['totalHt'];
                $totalMonth['Total TVA']  += $datas['totalTva'];
            }

            $params['totalMonth'] = $totalMonth;
        }

        if ($type == 'Task') {
            $params['tasks_todo'] = $this->cURL(API . 'task/staff/list/stepAll/TODO', 'PHP_CALL', '', 'GET');
        }

        return $params;
    }
}
