<?php
require_once(HELPER.'userSession.php');
require_once(HELPER.'dates.php');
require_once(HELPER.'buttons.php');

class RequestBuilder extends Controller
{

    public function list($request) {
        $params = [];
        $params['buttons'] = array
        (
            array(
                "href" => HOST."requestBuilder/create",
                "onclick" => "",
                "label" => "Créer une liste",
                "icon" => "add"
            ),
        );

        $params['extractLists'] = $this->cURL(API.'extractList/list', 'PHP_CALL', '', 'GET');

        $this->renderWithData('render/requestBuilder/list', $params);
    }

    public function exportExcel($request) {
        $params['extractList'] = $this->cURL(API.'extractList/display/'.$request->id, 'PHP_CALL', '' , 'GET');
        $params['content']     = $this->cURL(API.'extractList/listExecuteContent/'.$request->id.'/all', 'PHP_CALL', '' , 'GET');

        $html = $this->getRenderTemplate('render/requestBuilder/_exportExcel', $params);

        $this->renderExcel($html, $params['extractList']->title);
    }

    public function create($request) {

        $params = [];

        if(isset($request->id)) {
            $params['extractList'] = $this->cURL(API.'extractList/display/'.$request->id, 'PHP_CALL', '' , 'GET');
            $params['hastList'] = true;
        } else {
            $params['hastList'] = false;
        }

        $params['call_twilio']['fields'] = [
            'checked' => [
                'clt.number' => "numéro de l'appelant",
                'clt.call_date'   => "date de l'appel",
                'clt.duration' => "durée de l'appel",
                'clt.call_time' => "heure de l'appel",
                'clt.from_person' => 'personne appelante',
            ],
            'option' => [
                'clt.status' => 'status',
                'clt.call_sid' => 'call_sid'
            ]
        ];

        $params['child']['fields'] = [

                        'checked' => [
                            'c.child_id as child_id'   => "id de l'enfant",
                            'c.lastname'               => 'Nom',
                            'c.firstname'              => 'Prénom',
                            'age'                      => 'Age',
                            'c.created_at'             => 'Date de création',
                            'c.phone'                  => 'Téléphone',
                            'u.email'                  => 'Email',
                            'ph.name as phone_name'    => 'Nom du téléphone',
                            'ph.phone as phone_number' => 'Numéro de téléphone'
                        ],
                        'option' => [
                            'c.gender'                        => 'Genre',
                            'p.person_id'                     => 'Id de la personne',
                            'p.lastname as person_lastname'   => 'Nom de la personne',
                            'p.firstname as person_firstname' => 'Prénom de la personne',
                         /**   'c.coach'                         => 'Coach référent',*/
                            'c.sportif_profil'  => 'Sportif profil',
                            'c.child_hand'      => 'Main',
                            's.name as school'  => 'Ecole nom',
                            's.postal as postal_school'  => 'Ecole code postal',
                            'c.medical'         => 'Informations médicales',
                            'c.comment'         => 'Commentaire sur le transport',
                            'c.france_resident' => 'Résident français',
                            'c.birthdate'       => 'Date de naissance',
                            'cpr.date as date_presence' => 'Date de présence'
                        ]
        ];



        $params['typeCriterias'] = [
            'int'    => ['after', 'before', 'between', 'egal', 'in'],
            'date'   => ['after', 'before', 'between', 'egal', 'like'],
            'string' => ['egal', 'like', 'in']
        ];

        $params['typeCriteriaName'] = [
                                        'after'   => ['name' => 'supérieur à', 'vars' => 'val'],
                                        'before'  => ['name' => 'inférieur à', 'vars' => 'val'],
                                        'between' => ['name' => 'compris entre', 'vars' => 'from-to'],
                                        'egal'    => ['name' => 'égal à', 'vars' => 'val'],
                                        'like'    => ['name' => 'contenant', 'vars' => 'val'],
                                        'in'      => ['name' => 'comprenant (séparé par des virgules)', 'vars' => 'val'],
        ];

        $params['child']['criterias'] = [
                                        'child_id'      => [ 'typage' => 'int'],
                                        'age'           => [ 'typage' => 'int'],
                                        "c.created_at"  => [ 'typage' => 'date', 'format' => 'YYYY-MM-DD'],
                                        'a.postal'      => [ 'typage' => 'string'], 
                                        'a.address'     => [ 'typage' => 'string'],
                                        'presence'      => [ 'typage' => 'date', 'format' => 'YYYY-MM-DD'],
                                        'c.birthdate'   => [ 'typage' => 'date', 'format' => 'YYYY-MM-DD'],
                                        's.name'        => [ 'typage' => 'string'],
                                        'c.gender'      => [ 'typage' => 'string', 'format' => 'h/f'],
                                        's.postal'      => [ 'typage' => 'string'],
                                        'cpr.date'      => [ 'typage' => 'string', 'format' => 'YYYY-MM-DD']
                                    ];

        $params['call_twilio']['criterias'] = [
            'clt.number'        => ['typage' => 'string'],
            'clt.call_date'     => [ 'typage' => 'date', 'format' => 'YYYY-MM-DD'],
            'clt.duration' => ['typage' => 'string'],
            'clt.call_time'     => ['typage' => 'string'],
            'clt.from_person'   => ['typage' => 'string'],
            'clt.status'        => ['typage' => 'string'],
            'clt.call_sid'      => ['typage' => 'string']
        ];

        $params['conversion'] = [   'child_id'      => 'id',
                                    'age'           => 'age',
                                    "c.created_at"  => 'date de création',
                                    'a.postal'      => 'code postal', 
                                    'a.address'     => 'adresse',
                                    'presence'      => 'date de presence',
                                    'c.birthdate'   => 'date de naissance',
                                    's.name'        => "nom de l'école",
                                    'c.gender'      => 'genre',
                                    's.postal'      => 'code postal école',
                                    'cpr.date'      => 'date de présence',
                                    'clt.number'        => "numéro de l'appelant",
                                    'clt.call_date'     => "date de l'appel",
                                    'clt.duration' => "durée de l'appel",
                                    'clt.call_time'     => "heure de l'appel",
                                    'clt.from_person'   => 'personne appelante',
                                    'clt.status'        => 'status',
                                    'clt.call_sid'      => 'call_sid'
                                ];

        ksort($params['child']['criterias']);

        $this->renderWithData('render/requestBuilder/create', $params);
    }
   

    public function show($request) {
        $params['extractList'] = $this->cURL(API.'extractList/display/'.$request->id, 'PHP_CALL', '' , 'GET');
        $params['content']     = $this->cURL(API.'extractList/listExecuteContent/'.$request->id.'/all', 'PHP_CALL', '' , 'GET');
        $this->renderWithData('render/requestBuilder/show', $params);

    }

}