<?php
require_once(HELPER.'dates.php');

class Staff extends Controller
{
    public function viewList($request)
    {
        (isset($request->kind)) ? $kind = $request->kind : $kind = "all";
        $params['staff'] = $this->cURL(API.'staff/list/'.$kind.'/all', 'PHP_CALL', '', 'GET');
        $params['kind'] = $kind;

        $params['criterias'] = $this->curl(API.'credential/list', 'PJP_CALL', '', 'GET');

        $this->renderWithData('render/staff/list', $params);
    }

    public function viewListDrivers($request)
    {
        $params['drivers'] = $this->cURL(API.'staff/list/driver?page=1&size=200', 'PHP_CALL', '', 'GET');
        $params['vehicles'] = $this->cURL(API.'vehicle/list?page=1&size='.SIZE_LIST, 'PHP_CALL', '', 'GET');

        $this->renderWithData('render/staff/drivers', $params);
    }

    public function resumeStaffProfil($request)
    {
          $params = array();

          $params['config'] = ['staffId' => $request->id, 'pagination' => true ];

          $params['seasons_actives'] = $this->cURL(API.'season/list/active', 'PHP_CALL', '' , 'GET');

          $season = $params['seasons_actives'][0];

          $weeks = $season->weeks;

          foreach($weeks as $week) {
            $allweeks[$week->dateStart] = ['type' => $week->kind, 'name' => $week->name];
          }

          $params['weeks'] = $allweeks;

          $dateStart = $season->dateStart;
          $dateEnd = $season->dateEnd;

          $params['season'] = $season;

          $params['tasks_todo']= $this->cURL(API.'task/staff/list/step/TODO/'.$request->id.'/'.$dateStart.'/'.$dateEnd, 'PHP_CALL', '', 'GET');
          $params['tasks_done']= $this->cURL(API.'task/staff/list/step/DONE/'.$request->id.'/'.$dateStart.'/'.$dateEnd, 'PHP_CALL', '', 'GET');

          $params['callBack'] = 'staff/resume/id/'.$request->id.'/';

          $params['supervisor']= $this->cURL(API.'staff/supervisor', 'PHP_CALL', '', 'GET');
          $params['presences'] = $this->curl(API.'staff/presence/'.$season->seasonId.'/'.$request->id, 'PHP_CALL', '', 'GET');

          $params['staff'] = $this->cURL(API.'staff/display/'.$request->id, 'PHP_CALL', '', 'GET');

          $this->renderWithData('render/staff/resume', $params);

    }

    public function planning($request)
    {
          $params = array();


          $params['teams'] = [
                      1 => 'coach',
                      2 => 'driver',
                      3 => 'maintenace',
                      4 => 'secrétariat',
                      5 => 'TIC',
          ];

          
          $params['locations'] = $this->cURL(API.'location/list', 'PHP_CALL', '', 'GET');


          (isset($request->target)) ? $params['target'] = $request->target :$params['target'] = date('Y-m-d');

          $params['staff'] = $this->cURL(API.'staff/list/all?page=1&size='.SIZE_LIST, 'PHP_CALL', '', 'GET');

          $params['seasons_actives'] = $this->cURL(API.'season/list/active', 'PHP_CALL', '' , 'GET');
          $params['seasons_drafts'] = $this->cURL(API.'season/list/draft', 'PHP_CALL', '' , 'GET');



          if(isset($request->id)) {

            $params['buttons'] = array
            (
                array(
                    'attributes' => ['id' => 'exportPdf', 'target' => '_blank'],
                    "href" => HOST."staff/exportPdf/id/".$request->id."/hours/0/",
                    "onclick" => "",
                    "label" => "Export Pdf",
                    "icon" => "picture_as_pdf"
                ),
                array(
                    'attributes' => ['id' => 'exportPdf', 'target' => '_blank'],
                    "href" => HOST."staff/exportPdf/id/".$request->id."/hours/1/",
                    "onclick" => "",
                    "label" => "Export Pdf - avec heures",
                    "icon" => "picture_as_pdf"
                ),
                array(
                    'attributes' => ['id' => 'createAllPresence'],
                    "href" => HOST."staffPresence/display/id/".$request->id."/",
                    "onclick" => "",
                    "label" => "Créer les présences annuelles",
                    "icon" => "calendar_today"
                )
            );
  
            $params['config'] = ['staffId' => $request->id, 'pagination' => true ];


            if(isset($request->seasonId)) {
              $season = $this->cURL(API.'season/display/'.$request->seasonId, 'PHP_CALL', '' , 'GET');
            } else {
              $params['seasons_actives'] = $this->cURL(API.'season/list/active', 'PHP_CALL', '' , 'GET');
              $season = $params['seasons_actives'][0];
            }


            $weeks = $season->weeks;
  
            foreach($weeks as $week) {
              $allweeks[$week->dateStart] = ['type' => $week->kind, 'name' => $week->name];
            }
  
            $params['weeks'] = $allweeks;
  
            $dateStart = $season->dateStart;
            $dateEnd = $season->dateEnd;

            $params['tasks_todo']= $this->cURL(API.'task/staff/list/step/TODO/'.$request->id.'/'.$dateStart.'/'.$dateEnd, 'PHP_CALL', '', 'GET');
            $params['tasks_done']= $this->cURL(API.'task/staff/list/step/DONE/'.$request->id.'/'.$dateStart.'/'.$dateEnd, 'PHP_CALL', '', 'GET');
  
       
            $params['season'] = $season;
  
            $params['presences'] = $this->curl(API.'staff/presence/'.$season->seasonId.'/'.$request->id, 'PHP_CALL', '', 'GET');
  
            $params['currentStaff'] = $this->cURL(API.'staff/display/'.$request->id, 'PHP_CALL', '', 'GET');
            
          }

          $this->renderWithData('render/staff/planning', $params);

    }

    public function exportPdf($request) {
        
     
        $params['seasons_actives'] = $this->cURL(API.'season/list/active', 'PHP_CALL', '' , 'GET');
        $season = $params['seasons_actives'][0];
        $weeks = $season->weeks;
        foreach($weeks as $week) {
          $allweeks[$week->dateStart] = ['type' => $week->kind, 'name' => $week->name];
        }


        $params['hours'] = $request->hours;

        $params['weeks'] = $allweeks;

        $dateStart = $season->dateStart;
        $dateEnd = $season->dateEnd;

        $params['tasks_todo']= $this->cURL(API.'task/staff/list/step/TODO/'.$request->id.'/'.$dateStart.'/'.$dateEnd, 'PHP_CALL', '', 'GET');
        $params['tasks_done']= $this->cURL(API.'task/staff/list/step/DONE/'.$request->id.'/'.$dateStart.'/'.$dateEnd, 'PHP_CALL', '', 'GET');

   
        $params['season'] = $season;
        $params['presences'] = $this->curl(API.'staff/presence/'.$season->seasonId.'/'.$request->id, 'PHP_CALL', '', 'GET');
        $params['currentStaff'] = $this->cURL(API.'staff/display/'.$request->id, 'PHP_CALL', '', 'GET');

        // export pdf
        $name = "PLANNING-".$params['currentStaff']->fullname;
        $pdf = new PdfService();
        $pdf->setTitle($name);
        $html = $this->getRenderTemplate('render/staff/exportPdf', $params);

       // echo $html; exit;
        
        $pdf->setHtmlContent($html);

        $pdf->renderHtml();
  }


}
