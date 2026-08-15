<?php
use_helper('dates');

/**
 * Statistique Booklet
 *
 */
class Statistique extends Controller
{


    private $metaGroupProduct = [
                                    'Ecole de sport' => 'Ecole de sport',
                                    "Ski Alpe d'Huez" => "Séjours",
                                    "Séjours Vacances" => "Séjours",
                                    "Ecole à l'année" => "Ecole de sport",
                                    "Anniversaire" => "Anniversaire",
                                    "A la carte" => "Stage à Paris",
                                    "Gymnases Parisiens" => "Gymnases Parisiens",
                                    "Stage semaine" => "Stage à Paris",
                                    "Stage Sport & Anglais" => "Stage à Paris",
                                    "Stage compétition" => "Stage à Paris",
              ];



    public function list($request)
    {
        $params = array();
        $this->renderWithData('render/statistique/list', $params);
    }


    public function index($request)
    {
        $params = [];

        $params['type'] = $request->type;

        if( $request->type == 'ca') {
            
            $params['seasonActives']  = $this->cURL(API.'season/list/active?page=1&size='.SIZE_LIST, 'PHP_CALL', '' , 'GET');
            $params['seasonDisabled'] = $this->cURL(API.'season/list/disabled?page=1&size='.SIZE_LIST, 'PHP_CALL', '' , 'GET');
            $params['seasonDraft']    = $this->cURL(API.'season/list/draft?page=1&size='.SIZE_LIST, 'PHP_CALL', '' , 'GET');

            $params['datas'] =  $this->cURL(API.'product/list', 'PHP_CALL', '', 'GET');

            foreach($params['datas'] as $product) {
                if($product->child == "" && $product->priceTtc > 0) {
                    $params['products'][$product->categories[0]->publicName][$product->productId] = strip_tags($product->nameFr);
                }
            }

            unset($params['datas']);
        }

        if( $request->type == 'repartition') {

            if(!isset($request->dateStart))
            {   
                $today = date('Y-m-d');
                $params['dateEnd'] = nextDay($today, 1);
                $params['dateStart'] =  getStartMonth($params['dateEnd']);
                $params['modePayement'] = 'all';
            }
            else
            {
                $params['dateStart'] = $request->dateStart;
                $params['dateEnd'] = $request->dateEnd;
                $params['modePayement'] = $request->modePayement;
            }


            $params['datas'] =  $this->cURL(API.'product/list', 'PHP_CALL', '', 'GET');


            foreach($params['datas'] as $product) {
                if($product->child == "" && $product->priceTtc > 0) {
                    if(key_exists($product->categories[0]->publicName, $this->metaGroupProduct)) {
                        $metaGroup = $this->metaGroupProduct[$product->categories[0]->publicName];

                    } else {
                        $metaGroup = "non classé";
                    }
                    $params['products'][$metaGroup][$product->productId] = strip_tags($product->nameFr);
                }

            }
        }


        $this->renderWithData('render/statistique/show', $params);
    }

    

}

