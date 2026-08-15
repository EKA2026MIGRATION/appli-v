<?php

/**
 * Class API
 *
 */

class Api extends Controller
{

    public function sendRequest($request)
    {


   		if($request->type == "GET" || $request->type == "DELETE") // Pas d'envoi de données car GET ou DELETE
   		{
        if(!isset($request->ressource))
        {
          $url = API.$request->url;
          $data = $this->cURL($url, 'AJAX_CALL', '', $request->type);
        }
        else
        {
          $data = $this->cURL($request->url, 'AJAX_CALL', '', $request->type);
        }

   		}
   		elseif($request->type == "POST" || $request->type == "PUT") // Si c'est un POST ou PUT il y a un envoi de données
   		{

        if(isset($request->data))
        {
          $requestSend = $request->data;

          if(isset($request->links)) // Si il y a un array in array LINKS
          {
             $requestSend['links'] = $request->links;
          }

          if(isset($request->components)) // Si il y a un array in array LINKS
          {
                $requestSend['components'] = $request->components;
          }

          if(isset($request->categories)) // Si il y a un array in array LINKS
          {
              $requestSend['categories'] = $request->categories;
          }

          if(isset($request->locations)) // Si il y a un array in array LINKS
          {
              $requestSend['locations'] = $request->locations;
          }

          if(isset($request->sports)) // Si il y a un array in array LINKS
          {
              $requestSend['sports'] = $request->sports;
          }

          if(isset($request->dates)) // Si il y a un array in array LINKS
          {
              $requestSend['dates'] = $request->dates;
          }

          if(isset($request->hours)) // Si il y a un array in array LINKS
          {
              $requestSend['hours'] = $request->hours;
          }

          if(isset($request->staff)) // Si il y a un array in array LINKS
          {
              $requestSend['staff'] = $request->staff;
          }

          if(isset($request->relations))
          {
              $requestSend['relations'] = $request->relations;
          }

          if(isset($request->items))
          {
              $items = json_encode($request->items);
              $items = str_replace("[", '', $items);
              $items = str_replace("]", '', $items);
              $requestSend['items'] = $items;
          }

          if(isset($request->invoiceProducts)) // Si il y a un array in array LINKS
          {
              $requestSend['invoiceProducts'] = $request->invoiceProducts;
          }
        }

        else
        {
          $requestSend = "";
        }
 
   			$data = $this->cURL(API.$request->url, 'AJAX_CALL', $requestSend, $request->type);

           }
           
        echo json_encode($data);
    }


}
