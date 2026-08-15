<?php
use_helper('age');


/**
 * Class Meal.
 */
class Meal extends Controller
{
    const FOOD_CATEGORIES = array(
        'starchy' => 'Féculents',
        'accompaniment' => 'Accompagnement',
        'condiment' => 'Condiment',
        'vegetables' => 'Légumes',
        'sandwich' => 'Sandwich',
    );

    public function print($request)
    {
        if (!isset($request->date)) {
            $date = date('Y-m-d');
        } else {
            $date = $request->date;
        }
        $params['date'] = $date;
        $params['child_presence'] = $this->cURL(API.'child/presence/list/'.$date, 'PHP_CALL', '', 'GET');
        $params['staff_presence'] = $this->cURL(API.'staff/presence/list/all/'.$date, 'PHP_CALL', '', 'GET');
        $params['foods'] = $this->cURL(API.'food/list', 'PHP_CALL', '', 'GET');
        $params['foodCategories'] = self::FOOD_CATEGORIES;
        $params['meals'] = $this->cURL(API.'meal/list/'.$date.'?page=1&size=300', 'PHP_CALL', '', 'GET');
        $params['groups'] = $this->cURL(API.'group-activity/lunch/'.$date, 'PHP_CALL', '', 'GET');
        $params['counts'] = $this->cURL(API.'meal/total/'.$date, 'PHP_CALL', '', 'GET');

        $params['person_presence'] = [];
        $params['child_presence_array'] = [];
        foreach ($params['staff_presence'] as $presence) {
            $params['person_presence'][$presence->staff->person->personId] = 1;
        }
        foreach ($params['child_presence'] as $presence) {
            if(isset($presence->child->childId)) $params['child_presence_array'][$presence->child->childId] = 1;
        }

        $arr = []; $arrAge = [];

        foreach ($params['meals'] as $meal) {
            if (isset($meal->child)) {
                $type = 'child';
                $fullname = $meal->child->firstname.' '.$meal->child->lastname;
                $age = showAge($meal->child->birthdate);
            }
            if (isset($meal->person)) {
                $type = 'person';
                $fullname = $meal->person->firstname.' '.$meal->person->lastname;
                $age = null;
            }
            if (isset($meal->freename)) {
                $type = 'freename';
                $fullname = $meal->freename;
                $age = null;
            }

            foreach ($meal->foods as $food) {
                $foodArr[] = $food->name;
            }

            $arr[$type][$fullname] = implode(', ', $foodArr);
            $arrAge[$type][$fullname] = $age;
            if($meal->child) $medicalArr[$fullname] = $meal->child->medical;
            unset($foodArr);
        }

        $params['mealList'] = $arr;
        $params['age'] = $arrAge;
        $params['medical'] = $medicalArr;


        $this->renderHtml('render/meal/print', $params);
    }

    public function viewList($request)
    {
        if (!isset($request->date)) {
            $date = date('Y-m-d');
        } else {
            $date = $request->date;
        }

        $params = array();

        $params['buttons'] = array(
          array('href' => HOST.'meal/add/date/'.$date.'/', 'onclick' => null, 'label' => 'Ajouter un repas', 'icon' => 'add'),
          array('href' => HOST.'meal/print/date/'.$date.'/', 'onclick' => null, 'label' => 'Imprimer', 'icon' => 'print', 'attributes' => ['target' => '_blank']),
        );

        $params['date'] = $date;
        $params['child_presence'] = $this->cURL(API.'child/presence/list/'.$date, 'PHP_CALL', '', 'GET');
        $params['staff_presence'] = $this->cURL(API.'staff/presence/list/all/'.$date, 'PHP_CALL', '', 'GET');
        $params['foods'] = $this->cURL(API.'food/list', 'PHP_CALL', '', 'GET');
        $params['foodCategories'] = self::FOOD_CATEGORIES;
        $params['meals'] = $this->cURL(API.'meal/list/'.$date.'?page=1&size=300', 'PHP_CALL', '', 'GET');
        $params['groups'] = $this->cURL(API.'group-activity/lunch/'.$date, 'PHP_CALL', '', 'GET');
        $params['counts'] = $this->cURL(API.'meal/total/'.$date, 'PHP_CALL', '', 'GET');

        $params['person_presence'] = [];
        $params['child_presence_array'] = [];
        foreach ($params['staff_presence'] as $presence) {
            $params['person_presence'][$presence->staff->person->personId] = 1;
        }
        foreach ($params['child_presence'] as $presence) {

            if(isset($presence->child->childId)) $params['child_presence_array'][$presence->child->childId] = 1;
        }

        return $this->renderWithData('render/meal/list', $params);
    }

    public function viewAdd($request)
    {
        $params = array();
        $params['foods'] = $this->cURL(API.'food/list', 'PHP_CALL', '', 'GET');
        $params['foodCategories'] = self::FOOD_CATEGORIES;
        $params['staff'] = $this->cURL(API.'staff/list/all?page=1&size='.SIZE_LIST, 'PHP_CALL', '', 'GET');

        if (isset($request->id)) {
            $params['meal'] = $this->cURL(API.'meal/display/'.$request->id, 'PHP_CALL', '', 'GET');
        } else {
            if (!isset($request->date)) {
                $date = date('Y-m-d');
            } else {
                $date = $request->date;
            }

            $params['date'] = $date;
        }

        if (isset($request->childId)) {
            $params['child'] = $this->cURL(API.'child/display/'.$request->childId, 'PHP_CALL', '', 'GET');
        }

        if (isset($request->personId)) {
            $params['person'] = $this->cURL(API.'person/display/'.$request->personId, 'PHP_CALL', '', 'GET');
        }

        if (isset($request->callback)) {
            $params['autoreturn'] = 1;
        } else {
            $params['autoreturn'] = 0;
        }
        $params['returnUrl'] = HOST.'meal/list/date/'.$date.'/';

        $this->renderWithData('render/meal/add', $params);
    }

    public function viewDisplay($request)
    {
        if (isset($request->id)) {
            $this->renderWithData('render/meal/display', $this->cURL(API.'meal/display/'.$request->id, 'PHP_CALL', '', 'GET'));
        } else {
            header('location: '.HOST.'meal/list');
        }
    }
}
