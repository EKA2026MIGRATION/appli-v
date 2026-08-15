<?php

/**
 * Class Person
 *
 */

class Person extends Controller
{
    public function viewDisplay($request)
    {
        if(isset($request->id))
        {
            $params['buttons'] = array
            (
                    array(
                        'attributes' => ['data-open' => 'revealSearchAssociatedChild'],
                        "href" => "javascript:void(0)",
                        "onclick" => "associateChild(".$request->id.")",
                        "label" => "Associer un Enfant",
                            "icon" => "person_add"
                        ),

                    array(
                            "attributes" => ['data-open' => 'revealAddress'],
                            "href" => "javascript:void(0)",
                            "onclick" => "changeActionAdress()",
                            "label" => "Nouvelle Adresse",
                            "icon" => "place"
                            ),
                    array(
                        "attributes" => ['data-open' => 'revealPhone'],
                        "href" => "javascript:void(0)",
                        "onclick" => "changeActionPhone()",
                        "label" => "Nouveau Tél",
                        "icon" => "phone"
                        ),
                    array("href" => HOST."person/add/id/".$request->id.'/',
                        "onclick" => "return:true",
                        "label" => "Modifier",
                        "icon" => "edit"),
                    array(
                        "attributes" => ['id' => 'createUser', 'data-id-person' => $request->id],
                        "href" => "javascript:void(0)",
                        "onclick" => "",
                        "label" => "Créer un user",
                        "icon" => "add"),
                    array(
                        "attributes" => ['id' => 'deletePerson', 'data-id-person' => $request->id],
                        "href" => "javascript:void(0)",
                        "onclick" => "",
                        "label" => "Supprimer",
                        "icon" => "delete"),
                array(
                    "href" => HOST."notification/vcf/type/person/id/".$request->id.'/',
                    "onclick" => "return:true",
                    "label" => "Télécharger le contact",
                    "icon" => "contact_phone"),

            );


            $params['person'] = $this->cURL(API.'person/display/'.$request->id, 'PHP_CALL', '', 'GET');
            $this->renderWithData('render/person/display', $params);
        }
        else
        {
            header('location: '.HOST.'person/list');
        }

    }

    public function viewAdd($request)
    {
        if(isset($request->id))
        {
            $this->renderWithData('render/person/add', $this->cURL(API.'person/display/'.$request->id, 'PHP_CALL', '', 'GET'));

        }
        else
        {
            if(isset($request->identifier))
            {
                $params = array();
                $params['identifier'] = $request->identifier;
                $params['email'] = $request->email;
                 $this->renderWithData('render/person/add', $params);
            }
            elseif(isset($request->person))
            {
                $params = array();
                $params['personId'] = $request->person;
                 $this->renderWithData('render/person/add', $params);
            }
            else
            {
                $this->render('render/person/add');
            }

        }
    }

    public function associateChild($request) {
        $childId = $request->childId;
        $personId = $request->personId;

        $html = $childId.' '.$personId;

        $datas = ['links' => ['personId' => $personId], ''];

        $result = $this->cURL(API.'child/modify/'.$childId, 'PHP_CALL', $datas, 'PUT');

        return $this->renderJson($result);

    }

    public function search($request)
    {
        $params['data'] = ['number' => '', 'name' => '', 'childname' => ''];
        $this->renderWithData('render/person/search', $params);
    }

    public function doSearch($request)
    {
        $params = array();
        $data = ['number' => $request->number, 'name' => $request->name, 'childname' => $request->childname];
        $params['result'] = $this->cURL(API.'person/search/criterias', 'PHP_CALL', $data, 'POST');
        $params['data'] = $data;
        $this->renderWithData('render/person/search', $params);
    }


    public function searchEmail($request)
    {
        $params['results'] = [];
        $params['email']   = '';

        if (isset($request->email) && !empty($request->email)) {
            $params['email']   = $request->email;
            $params['results'] = $this->cURLWithToken(API.'person/search/email/'.$request->email, 'PHP_CALL', '', 'GET', TOKEN);
        }

        $this->renderWithData('render/person/searchEmail', $params);
    }

    public function viewList($request)
    {
        $this->renderWithData('render/person/list', $this->cURL(API.'person/list?page=1&size='.SIZE_LIST, 'PHP_CALL', '', 'GET'));
    }


}
