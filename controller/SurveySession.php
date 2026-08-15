<?php


/**
 * Class SurveySession
 *
 */
class SurveySession extends Controller
{
    public function viewDisplay($request)
    {
        $params = array();
        $params['surveySession'] = $this->cURL(API . 'surveySession/display/'.$request->id, 'PHP_CALL', '', 'GET');
        $this->renderWithData('render/surveySession/display', $params);
    }

    public function resultSurvey($request) {
        $params = array();

        $params['buttons'] = array
        (
            array(
                "href" => HOST."survey/edit/id/".$request->id."/",
                "onclick" => "",
                "label" => "Modifier",
                "icon" => "edit"
            ),
            array(
                "href" => HOST."survey/delete/id/".$request->id."/",
                "onclick" => "",
                "label" => "Supprimer",
                "icon" => "delete"
            ),
        );

        $params['results'] = $this->cURL(API . 'surveySession/result/'.$request->id, 'PHP_CALL', '', 'GET');
        $this->renderWithData('render/surveySession/result', $params);
    }

}

