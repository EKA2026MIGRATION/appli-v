<?php
use_helper('age');
use_helper('dates');
/**
 * Class Booklet
 *
 */
class Media extends Controller
{
    public function take() {
        $params = [];
        $this->renderWithData('render/media/take', $params);
    }

    public function serie() {
        $params = [];
        $this->renderWithData('render/media/serie', $params);
    }

    public function list($request) {
        $params = [];
        if(isset($request->childid)) {
            $childid = $request->childid;
            $params['medias'] = $this->cURL(API.'media/list/child/'.$childid.'/all', 'AJAX_CALL', '', 'GET');
        } else {
            $params['medias'] = $this->cURL(API.'media/list', 'AJAX_CALL', '', 'GET');
        }
        $this->renderWithData('render/media/list', $params);
    }

    public function updateSerie($request) {

        ini_set('upload_max_filesize', '20M'); // Limite à 10 Mo
        ini_set('post_max_size', '20M'); // Limite à 10 Mo

        if(isset($request->compressed_photos)) {
            $compressedPhotos = $request->compressed_photos;
            $datas = [];

            foreach ($compressedPhotos as $compressedPhoto) {

                $image_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $compressedPhoto), true);

                if ($image_data === false || @getimagesizefromstring($image_data) === false) {
                    continue;
                }

                $filename = uniqid() . '.jpg';
                $destination = 'uploads/child/' . $filename;

                // Enregistrer l'image sur le serveur
                file_put_contents($destination, $image_data);

                $photos = [
                    'child_id' => $request->child_id_list,
                    'url' => $destination,
                    'title' => null,
                    'description' => null,
                    'status' => $request->status
                ];

                $datas[] = $photos;
            }

            $response = $this->cURL(API . 'media/create', 'AJAX_CALL', $datas, 'POST');
            $message = "Image(s) sauvegardée(s)";


        } else {
            $message = "Image(s) NON sauvegardée(s) - problème de poids";
        }



        $_SESSION['message'] = $message;
        $this->redirect('media/serie');

    }

    public function updateSerieOneToOne($request) {
        $params = [];

        ini_set('upload_max_filesize', '20M');
        ini_set('post_max_size', '20M');

        if(isset($request->photo)) {
            $compressedPhoto = $request->photo;
            $datas = [];


            $image_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $compressedPhoto), true);

            if ($image_data === false || @getimagesizefromstring($image_data) === false) {
                $this->renderJson("Image(s) NON sauvegardée(s) - fichier invalide");
                return;
            }

            $filename = uniqid() . '.jpg';
            $destination = 'uploads/child/' . $filename;

            // Enregistrer l'image sur le serveur
            file_put_contents($destination, $image_data);

            $photos = [
                'child_id' => $request->child_id,
                'url' => $destination,
                'title' => null,
                'description' => null,
                'status' => "awaiting"
            ];

            $datas[] = $photos;


            $response = $this->cURL(API . 'media/create', 'AJAX_CALL', $datas, 'POST');
            $message = "Image(s) sauvegardée(s)";


        } else {
            $message = "Image(s) NON sauvegardée(s) - problème de poids";
        }

        $this->renderJson($message);
    }

    public function update($request) {
        $params = [];

        $base64 = $request->image_data_64;
        $image_data = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64), true);
        $filename = uniqid() . '.jpg';
        $destination = 'uploads/child';

        if ($image_data === false || @getimagesizefromstring($image_data) === false) {
            $_SESSION['message'] = 'Erreur : fichier image invalide';
            $this->redirect('media/photoTake');
            return;
        }

        if (!is_dir(dirname($destination))) {
            if (!mkdir(dirname($destination . '/' . $filename), 0755, true)) {
                die('Erreur lors de la création des dossiers.');
            }
        }

        if(file_put_contents($destination.'/'.$filename, $image_data)) {


            // update in api
            $datas = [
                    'child_id'    => $request->child_id,
                    'url'         => $destination.'/'.$filename,
                    'title'       => $request->title,
                    'description' => $request->description,
                    'status'      => $request->status
                ];

            $response = $this->cURL(API.'media/create', 'AJAX_CALL', $datas, 'POST');

            $message = "Image sauvegardée";
            // uppdate in bdd
        } else {
            $message = 'Erreur : Image non sauvergardée';
        }

        $_SESSION['message'] = $message;
        $this->redirect('media/photoTake');

    }


    /**
     *  update date_latest_media in child
     *  massive fonction
     * @param $request
     */

    public function updateAllDateLatestMedia($request) {

        // call api function to update date_latest_media in child
        $response = $this->cURL(API.'media/updateAllDateLatestMedia', 'AJAX_CALL', '', 'GET');
        dd($response);
    }
}

