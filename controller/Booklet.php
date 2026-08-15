<?php
use_helper('age');
use_helper('dates');
/**
 * Class Booklet
 *
 */
class Booklet extends Controller
{
    public function viewList($request)
    {

        if (!isset($request->date)) {
            $date = date('Y-m-d');
        } else {
            $date = $request->date;    
        }


        $params = array();
        $params['date'] = $date;
        $path    = 'assets/image/icons';
        
        $params['booklets'] = $this->cURL(API.'booklet/list', 'PHP_CALL', '', 'GET');
        $params['sports']   = $this->cURL(API.'sport/list', 'PHP_CALL', '', 'GET');
        $params['staffs']        = $this->cURL(API.'staff/list/all/all', 'PHP_CALL', '', 'GET');


        $files = scandir($path);
        $params['icons'] = $files;
        $this->renderWithData('render/booklet/list', $params);
    }

    public function showBooket($request)
    {
        $type = $request->type;
        $params = $this->getBookletParams($type, $request);
        $this->renderHtml('render/booklet/_booklet' . $type, $params);
    }

    private function getBookletParams($type, $request)
    {

        if (!isset($request->date)) {
            $date = date('Y-m-d');
            $month = date('Y-m');
        } else {
            $date = $request->date;
            $m = explode('-', $request->date);
            $month = $m[0] . '-' . $m[1];
        }

        $params['callBack'] = 'app-home';
        $params['date'] = $date;


        if (!hasCredential('menu::admin') && !hasCredential('menu::manager')) {
            $staff_id = '/'.$_SESSION['PERSON_CONNECTED']->staff->staffId;
        } else {
            $staff_id = '';
        }

        if ($type == 'Draft') $type = "edition";
        if ($type == 'Published') $type = "published";


        $params['bookletChilds'] = $this->cURL(API . 'bookletchild/list/active/'.$type.$staff_id, 'PHP_CALL', '', 'GET');


        return $params;
    }


    public function searchList($request)
    {
        $params = array();

        $booklets = $this->cURL(API.'booklet/list', 'PHP_CALL', '', 'GET');

        foreach($booklets as $book) {
            $bookList[$book->id] = $book->name;
        }

        $params['bookList'] = $bookList;

        $params['staffs'] = $this->cURL(API.'staff/list/all/all', 'PHP_CALL', '', 'GET');

        $lastestBooklets = $this->cURL(API . 'bookletchild/latestList/published', 'PHP_CALL', '', 'GET');
        $lastestBookletsArray = get_object_vars($lastestBooklets);

        if (!isset($request->date)) {
            $date = date('Y-m-d');
        } else {
            $date = $request->date;
        }
        $params['date'] = $date;


        $currentDate = getDateStartWeek($date);
        while($currentDate != getDateEndWeek($currentDate)) {
            $dates[] = $currentDate;
            $currentDate = nextDay($currentDate);

        }
        $dates[] = $currentDate;

        foreach($dates as $date) {

                    $exist = [];
                    $groups = $this->cURL(API . 'group-activity/list/'.$date, 'PHP_CALL', '', 'GET');


                    foreach($groups as $group) {

                        $sportName = $group->sport->name;
                        $sportId = $group->sport->sportId;

                        if($sportId == 10) continue;

                        $locationName = $group->location->name;

                        $staffs = [];
                        foreach($group->staff as $staf) {
                            $staffname = $staf->person->firstname;

                            $staffs[] = $staffname;
                        }

                        // create row final
                        foreach($group->pickupActivities as $activity) {
                            $child =  $activity->child;

                            if(in_array($child->childId.'-'.$sportId, $exist)) continue;

                            if(isset($lastestBookletsArray[$child->childId])) {
                                $latest = $lastestBookletsArray[$child->childId];
                            } else {
                                $latest = null;
                            }

                            $list[$child->fullnameReverse][] = [
                                                                'childId'        => $child->childId,
                                                                'firstName'      => $child->firstname,
                                                                'lastName'       => $child->lastname,
                                                                'age'            => showAge($child->birthdate, ''),
                                                                'sportId'        => $sportId,
                                                                'sport'          => $sportName,
                                                                'staffs'         => implode(', ', $staffs),
                                                                'locationName'   => $locationName,
                                                                'date'           => $date,
                                                                'latestBooklets' => $latest
                            ];

                            $exist[] = $child->childId.'-'.$sportId;
                        }

                    }

        }

        ksort($list);

        $params['childs'] = $list;

        $this->renderWithData('render/booklet/searchList', $params);
    }

    public function createBookletChild($request) {
        $datas = [
                        ['child_id' => $request->childId, 'booklet_id' => $request->bookletId, 'staff_id' => $request->staffId ]
                ];
        $response = $this->cURL(API.'bookletchild/create/multiple', 'AJAX_CALL', $datas, 'POST');

    }
    public function createMultipleBooklet($request) {
        $datas = [

            ['child_id' => 8910, 'booklet_id' => 6, 'staff_id' => 171],
            ['child_id' => 8910, 'booklet_id' => 6, 'staff_id' => 61],
            ['child_id' => 12204, 'booklet_id' => 9, 'staff_id' => 69],
            ['child_id' => 9608, 'booklet_id' => 6, 'staff_id' => 12],
            ['child_id' => 9608, 'booklet_id' => 3, 'staff_id' => 61],
            ['child_id' => 13279, 'booklet_id' => 1 , 'staff_id' => 192],
            ['child_id' => 11908, 'booklet_id' => 1 , 'staff_id' => 83],
            ['child_id' => 13470, 'booklet_id' => 6, 'staff_id' => 12],
            ['child_id' => 9040, 'booklet_id' => 3, 'staff_id' => 73],
            ['child_id' => 12735, 'booklet_id' => 1 , 'staff_id' => 212],
            ['child_id' => 12422, 'booklet_id' => 2, 'staff_id' => 171],
            ['child_id' => 12185, 'booklet_id' => 2 , 'staff_id' => 69],
            ['child_id' => 12185, 'booklet_id' => 8, 'staff_id' => 69 ],
            ['child_id' => 12183, 'booklet_id' => 9, 'staff_id' => 69],
            ['child_id' => 12184, 'booklet_id' => 8, 'staff_id' => 69],
            ['child_id' => 13502, 'booklet_id' => 5, 'staff_id' => 73],
            ['child_id' => 8125, 'booklet_id' => 9, 'staff_id' => 69],
            ['child_id' => 8125, 'booklet_id' => 4 , 'staff_id' => 11],
            ['child_id' => 11403, 'booklet_id' => 5, 'staff_id' => 101],
            ['child_id' => 11446, 'booklet_id' => 4, 'staff_id' => 73],
            ['child_id' => 12530, 'booklet_id' => 5, 'staff_id' => 6],
            ['child_id' => 12530, 'booklet_id' => 2, 'staff_id' => 6 ],
            ['child_id' => 6118, 'booklet_id' => 4, 'staff_id' => 11],
            ['child_id' => 10460, 'booklet_id' => 3, 'staff_id' => 171],
            ['child_id' => 13047, 'booklet_id' => 5, 'staff_id' => 204],
            ['child_id' => 13048, 'booklet_id' => 1 , 'staff_id' => 184],
            ['child_id' => 11917, 'booklet_id' => 6, 'staff_id' => 12],
            ['child_id' => 13410, 'booklet_id' => 1 , 'staff_id' => 83],
            ['child_id' => 8022, 'booklet_id' => 6, 'staff_id' => 82],
            ['child_id' => 13101, 'booklet_id' => 1 , 'staff_id' => 83],
            ['child_id' => 13520, 'booklet_id' => 1 , 'staff_id' => 83],
            ['child_id' => 13088, 'booklet_id' => 1 , 'staff_id' => 137],
            ['child_id' => 13280, 'booklet_id' => 1 , 'staff_id' => 6],
            ['child_id' => 8194, 'booklet_id' => 4, 'staff_id' => 11],
            ['child_id' => 9766, 'booklet_id' => 1 , 'staff_id' => 212],
            ['child_id' => 9765, 'booklet_id' => 3, 'staff_id' => 83],
            ['child_id' => 11405, 'booklet_id' => 2, 'staff_id' => 83],
            ['child_id' => 13490, 'booklet_id' => 2, 'staff_id' => 61],
            ['child_id' => 11934, 'booklet_id' => 5, 'staff_id' => 220],
            ['child_id' => 11934, 'booklet_id' => 2, 'staff_id' => 220],
            ['child_id' => 13614, 'booklet_id' => 1 , 'staff_id' => 83],
            ['child_id' => 12726, 'booklet_id' => 2, 'staff_id' => 83],
            ['child_id' => 12493, 'booklet_id' => 1 , 'staff_id' => 203],
            ['child_id' => 12308, 'booklet_id' => 5, 'staff_id' => 101],
            ['child_id' => 8188, 'booklet_id' => 6, 'staff_id' => 66],
            ['child_id' => 8188, 'booklet_id' => 3, 'staff_id' => 11],
            ['child_id' => 13597, 'booklet_id' => 1 , 'staff_id' => 83],
            ['child_id' => 13031, 'booklet_id' => 1 , 'staff_id' => 6],
            ['child_id' => 13489, 'booklet_id' => 1 , 'staff_id' => 192],
            ['child_id' => 10196, 'booklet_id' => 1 , 'staff_id' => 83],
            ['child_id' => 12023, 'booklet_id' => 1 , 'staff_id' => 83],
            ['child_id' => 12459, 'booklet_id' => 5, 'staff_id' => 101],
            ['child_id' => 12240, 'booklet_id' => 1 , 'staff_id' => 83],
            ['child_id' => 13322, 'booklet_id' => 1 , 'staff_id' => 82],
            ['child_id' => 13249, 'booklet_id' => 1 , 'staff_id' => 203],
            ['child_id' => 13247, 'booklet_id' => 5, 'staff_id' => 204],
            ['child_id' => 11432, 'booklet_id' => 6, 'staff_id' => 171],
            ['child_id' => 11432, 'booklet_id' => 3, 'staff_id' => 61],
            ['child_id' => 13524, 'booklet_id' => 1 , 'staff_id' => 212],
            ['child_id' => 13000, 'booklet_id' => 5, 'staff_id' => 73],
            ['child_id' => 11808, 'booklet_id' => 6, 'staff_id' => 12],
            ['child_id' => 11809, 'booklet_id' => 6, 'staff_id' => 12],
            ['child_id' => 11809, 'booklet_id' => 3 , 'staff_id' => 61],
            ['child_id' => 12546, 'booklet_id' => 1 , 'staff_id' => 211],
            ['child_id' => 12463, 'booklet_id' => 6, 'staff_id' => 204],
            ['child_id' => 12464, 'booklet_id' => 1 , 'staff_id' => 203],
            ['child_id' => 11468, 'booklet_id' => 1 , 'staff_id' => 137],
            ['child_id' => 12509, 'booklet_id' => 7, 'staff_id' => 7],
            ['child_id' => 12012, 'booklet_id' => 4 , 'staff_id' => 73],
            ['child_id' => 11689, 'booklet_id' => 5, 'staff_id' => 73],
            ['child_id' => 11689, 'booklet_id' => 8, 'staff_id' => 69],
            ['child_id' => 11688, 'booklet_id' => 6, 'staff_id' => 66],
            ['child_id' => 12395, 'booklet_id' => 1 , 'staff_id' => 83],
            ['child_id' => 12961, 'booklet_id' => 1 , 'staff_id' => 192],
            ['child_id' => 12960, 'booklet_id' => 5, 'staff_id' => 101],
            ['child_id' => 12125, 'booklet_id' => 1 , 'staff_id' => 150],
            ['child_id' => 13426, 'booklet_id' => 1 , 'staff_id' => 101],
            ['child_id' => 13462, 'booklet_id' => 6, 'staff_id' => 12],
            ['child_id' => 13177, 'booklet_id' => 1 , 'staff_id' => 101],
            ['child_id' => 12236, 'booklet_id' => 5, 'staff_id' => 204],
            ['child_id' => 12348, 'booklet_id' => 1 , 'staff_id' => 198],
            ['child_id' => 10749, 'booklet_id' => 6, 'staff_id' => 12],
            ['child_id' => 10749, 'booklet_id' => 3, 'staff_id' => 61],
            ['child_id' => 10805, 'booklet_id' => 1 , 'staff_id' => 101],
            ['child_id' => 13511, 'booklet_id' => 3 , 'staff_id' => 73],
            ['child_id' => 11172, 'booklet_id' => 1 , 'staff_id' => 6],
            ['child_id' => 10797, 'booklet_id' => 6, 'staff_id' => 12],
            ['child_id' => 8123, 'booklet_id' => 6, 'staff_id' => 12],
            ['child_id' => 8100, 'booklet_id' => 7, 'staff_id' => 7],
            ['child_id' => 11488, 'booklet_id' => 5, 'staff_id' => 150],
            ['child_id' => 8988, 'booklet_id' => 3, 'staff_id' => 73],
            ['child_id' => 8653, 'booklet_id' => 9, 'staff_id' => 69],
            ['child_id' => 10943, 'booklet_id' => 5, 'staff_id' => 82],
            ['child_id' => 12727, 'booklet_id' => 1 , 'staff_id' => 83],
            ['child_id' => 12521, 'booklet_id' => 9, 'staff_id' => 69],
            ['child_id' => 13512, 'booklet_id' => 1 , 'staff_id' => 83],
            ['child_id' => 12044, 'booklet_id' => 1 , 'staff_id' => 83],
            ['child_id' => 13538, 'booklet_id' => 1 , 'staff_id' => 220],
            ['child_id' => 10886, 'booklet_id' => 7, 'staff_id' => 7],
            ['child_id' => 11952, 'booklet_id' => 1 , 'staff_id' => 83],
            ['child_id' => 10855, 'booklet_id' => 1 , 'staff_id' => 137],
            ['child_id' => 11248, 'booklet_id' => 1 , 'staff_id' => 150],
            ['child_id' => 11247, 'booklet_id' => 6, 'staff_id' => 12],
            ['child_id' => 11247, 'booklet_id' => 3, 'staff_id' => 61],
            ['child_id' => 12203, 'booklet_id' => 1 , 'staff_id' => 150],
            ['child_id' => 11466, 'booklet_id' => 6, 'staff_id' => 12],
            ['child_id' => 7368, 'booklet_id' => 4, 'staff_id' => 73],
            ['child_id' => 12729, 'booklet_id' => 1 , 'staff_id' => 83],
            ['child_id' => 12568, 'booklet_id' => 1 , 'staff_id' => 203],
            ['child_id' => 3326, 'booklet_id' => 7, 'staff_id' => 7],
            ['child_id' => 8307, 'booklet_id' => 6, 'staff_id' => 12],
            ['child_id' => 7724, 'booklet_id' => 6, 'staff_id' => 12],
            ['child_id' => 7724, 'booklet_id' => 3, 'staff_id' => 11],
            ['child_id' => 11404, 'booklet_id' => 1 , 'staff_id' => 150],
            ['child_id' => 7723, 'booklet_id' => 6, 'staff_id' => 12],
            ['child_id' => 7723, 'booklet_id' => 3, 'staff_id' => 61],
            ['child_id' => 12035, 'booklet_id' => 1 , 'staff_id' => 212],
            ['child_id' => 11038, 'booklet_id' => 5, 'staff_id' => 3],
            ['child_id' => 12040, 'booklet_id' => 1 , 'staff_id' => 83],
            ['child_id' => 12041, 'booklet_id' => 1 , 'staff_id' => 83],
            ['child_id' => 12740, 'booklet_id' => 1 , 'staff_id' => 6],
            ['child_id' => 12520, 'booklet_id' => 1 , 'staff_id' => 83],
            ['child_id' => 12440, 'booklet_id' => 5, 'staff_id' => 73],
            ['child_id' => 12470, 'booklet_id' => 1 , 'staff_id' => 150],
            ['child_id' => 13438, 'booklet_id' => 6, 'staff_id' => 66],
            ['child_id' => 10946, 'booklet_id' => 7  , 'staff_id' => 12],
            ['child_id' => 13196, 'booklet_id' => 1 , 'staff_id' => 192],
            ['child_id' => 7388, 'booklet_id' => 9, 'staff_id' => 69],
            ['child_id' => 13487, 'booklet_id' => 1 , 'staff_id' => 83],
            ['child_id' => 13488, 'booklet_id' => 1 , 'staff_id' => 83],
            ['child_id' => 12866, 'booklet_id' => 5, 'staff_id' => 73],
            ['child_id' => 13338, 'booklet_id' => 1 , 'staff_id' => 6],
            ['child_id' => 12602, 'booklet_id' => 5, 'staff_id' => 73],
            ['child_id' => 12408, 'booklet_id' => 1 , 'staff_id' => 203],
            ['child_id' => 12407, 'booklet_id' => 1 , 'staff_id' => 203],
            ['child_id' => 13092, 'booklet_id' => 8, 'staff_id' => 69],
            ['child_id' => 12956, 'booklet_id' => 5, 'staff_id' => 12],
            ['child_id' => 13522, 'booklet_id' => 1 , 'staff_id' => 192],
            ['child_id' => 12923, 'booklet_id' => 5, 'staff_id' => 6],
            ['child_id' => 12923, 'booklet_id' => 2, 'staff_id' => 6 ],
            ['child_id' => 13083, 'booklet_id' => 7, 'staff_id' => 7]



        ];


        $response = $this->cURL(API.'bookletchild/create/multiple', 'AJAX_CALL', $datas, 'POST');


        dd($response);

    }


    public function edit($request) {
        $bookletChildId          = $request->id;
        $datas  = $this->cURL(API.'bookletchild/display/'.$bookletChildId, 'PHP_CALL', '' , 'GET');

        if(isset($datas->navigation)) {
            $navdata = $datas->navigation;
        } else {
            $navdata = null;
        }

        $bookletChildId;
        $bookletId = $datas->bookletChildArray->booklet->id;
        $childId =   $datas->bookletChildArray->child->childId;
        
        $previousBookletChild  = $this->cURL(API.'bookletchild/previousbyChild/'.$childId.'/'.$bookletId.'/'.$bookletChildId, 'PHP_CALL', '' , 'GET');

        if($previousBookletChild == "no bookletChild founded") {
            $params['bookletChildPrev'] = null;
        } else {
            $params['bookletChildPrev'] = $previousBookletChild->bookletChildArray;
        }


        $params['bookletChild'] = $datas->bookletChildArray;
        $params['navigation']   = $navdata;
        
        $params['staffs']        = $this->cURL(API.'staff/list/all/all', 'PHP_CALL', '', 'GET');
        $this->renderHtml('render/booklet/childEdit', $params);
    }


    public function viewDisplay($request)
    {
        /*$params = array();
        $path    = 'assets/image/icons';
        $files = scandir($path);
        $params['icons'] = $files;
        $this->renderWithData('render/booklet/display', $params);*/
    }

    public function viewCreate($request)
    {
        /*$params = array();
        $path    = 'assets/image/icons';
        $files = scandir($path);
        $params['icons'] = $files;
        $this->renderWithData('render/booklet/create', $params);*/
    }

}

