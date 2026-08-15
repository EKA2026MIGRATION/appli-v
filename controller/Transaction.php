<?php

class Transaction extends Controller
{
    public function viewList($request)
    {

        if(!isset($request->week))
        {
            $week = date('W');
            $year = date('Y');
        }
        else
        {
            $week = $request->week;
            $year = $request->year;
        }
 

        $params['week'] = $week;
        $params['year'] = $year;
        $params['date'] = date('m/d/Y', strtotime($year."W".$week."1"))."\n";

        for($day=1; $day<=7; $day++)
        {
            $dateEn = date('Y-m-d', strtotime($year."W".$week.$day));
            $params['transactions'][$day]['dateEn'] = $dateEn;
            $params['transactions'][$day]['day'] = date('d/m/Y', strtotime($year."W".$week.$day))."\n";
            $params['transactions'][$day]['transaction'] = $this->cURL(API.'transaction/list/'.$dateEn.'/payed', 'PHP_CALL', '', 'GET');

        }

        $this->renderWithData('render/transaction/list', $params);

    }


    public function viewJson($request)
    {

        if(!isset($request->date))
        {
            $date = date('Y-m');
        }
        else
        {
            $date = $request->date;
        }

        $params['transactions'] = $this->cURL(API.'transaction/list/'.$date, 'PHP_CALL', '', 'GET');
        $json = array();
        $i = 0;
        foreach($params['transactions'] as $transaction):

            $json[$i]['title'] = $transaction->amount." € par ";
            $json[$i]['date'] = $transaction->date; 
            $json[$i]['id'] =  $transaction->transactionId;                        
            $i++;

        endforeach;

        echo json_encode($json);

    }    


}
