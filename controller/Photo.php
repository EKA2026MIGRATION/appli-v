<?php

/**
 * Class Photo
 *
 */

class Photo extends Controller
{

    public function tvPhoto($request)
    {
        $params = array();
        $path    = 'uploads/tv';
        $files = scandir($path);
        foreach ($files as $key => $link) {
            if(is_dir($path.'/'.$link)){
                unset($files[$key]);
            }
        }
        $params['pic'] = $files;

        $pathBackgroundImage   = 'uploads/tv/background';
        $filesBackground = scandir($pathBackgroundImage);
        
        
        $filesBackgroundPush = array();
        $i = 0;
        foreach($filesBackground as $background) {
            if(strlen($background) > 5) {
                $filesBackgroundPush[$i] = $background;
                $i++;
            } 
            
        }

        if(count((array) $filesBackgroundPush) > 1) {
            $bgChoice = $filesBackgroundPush[mt_rand(0, count((array) $filesBackgroundPush) - 1)];
        } else {
            $bgChoice = $filesBackgroundPush[0];
        }
        
        $params['picBackground'] = $filesBackgroundPush;
        
        echo json_encode(["photo" => $params, "bgChoice" => $bgChoice]);
    }

    public function savePhoto($request)
    {
        $allowedFolders = ['child', 'person'];
        $folder = $request->folder;

        if (!in_array($folder, $allowedFolders, true)) {
            http_response_code(400);
            echo json_encode(["error" => "Dossier non autorisé."]);
            return;
        }

        $base64 = $request->base64;
        $decoded = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64), true);

        if ($decoded === false || @getimagesizefromstring($decoded) === false) {
            http_response_code(400);
            echo json_encode(["error" => "Fichier image invalide."]);
            return;
        }

        $key = sha1(uniqid(mt_rand(), true));

        file_put_contents('uploads/' . $folder . '/' . $key . '.jpeg', $decoded);

        echo json_encode(["url" => 'uploads/' . $folder . '/' . $key . '.jpeg']);
    }

    public function rotatePhoto($request)
    {
        $urlPhoto = $request->urlOfImage;

        if (preg_match('#^uploads/(child|person)/[0-9a-f]{40}\.jpeg$#', $urlPhoto) !== 1) {
            http_response_code(400);
            echo json_encode(["error" => "Chemin d'image invalide."]);
            return;
        }

        $filename = $urlPhoto;

        $source = imagecreatefromstring(file_get_contents('https://appli-v.net/' . $filename));

        $rotate = imagerotate($source, 90, 0);

        imagejpeg($rotate, $filename);

        echo json_encode(["success" => true]);
    }

    public function imageOrientation(string $directory)
    {

        if (file_exists($directory)) {
            $destination_extension = strtolower(pathinfo($directory, PATHINFO_EXTENSION));

            if (in_array($destination_extension, ["jpg", "jpeg"])) {
                if (function_exists('exif_read_data')) {
                    $exif = exif_read_data($directory);
                    if (!empty($exif) && isset($exif['Orientation'])) {
                        $orientation = $exif['Orientation'];
                        switch ($orientation) {
                            case 2:
                                $flip = 1;
                                $deg = 0;
                                break;
                            case 3:
                                $flip = 0;
                                $deg = 180;
                                break;
                            case 4:
                                $flip = 2;
                                $deg = 0;
                                break;
                            case 5:
                                $flip = 2;
                                $deg = -90;
                                break;
                            case 6:
                                $flip = 0;
                                $deg = -90;
                                break;
                            case 7:
                                $flip = 1;
                                $deg = -90;
                                break;
                            case 8:
                                $flip = 0;
                                $deg = 90;
                                break;
                            default:
                                $flip = 0;
                                $deg = 0;
                        }
                        $img = imagecreatefromjpeg($directory);
                        if ($deg !== 1 && $img !== null) {
                            if ($flip !== 0) {
                                imageflip($img, $flip);
                            }
                            $img = imagerotate($img, $deg, 0);
                            imagejpeg($img, $directory);
                        }
                    }
                }
            }
        }
    }
}
