<?php
use_helper('dates');
/**
 * Class FootMatch
 *
 */
class FootMatch extends Controller
{
    public function init($request)
    {
        $result = $this->cURL(API.'foot-match/init', 'PHP_CALL', '', 'GET');
        dd($result);
    }

    public function home($request) {
        $params = [];
        $seasons = $this->cURL(API.'season/list/active', 'PHP_CALL', '' , 'GET');

        foreach ($seasons as $season) {
            $new_seasons[] = ['id' => $season->seasonId, 'name' => $season->name];
        }

        $params['seasons'] = $new_seasons;

        $this->renderWithData('render/footMatch/homeVue', $params);

    }

}

