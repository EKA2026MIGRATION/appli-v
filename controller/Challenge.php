<?php
/**
 * Class Challenge
 */

class Challenge extends Controller
{
    public function home($request) {
        $params = [];
        $seasons = $this->cURL(API.'season/list/active', 'PHP_CALL', '' , 'GET');
        foreach ($seasons as $season) {
            $new_seasons[] = ['id' => $season->seasonId, 'name' => $season->name];
        }
        $params['seasons'] = $new_seasons;
        $this->renderWithData('render/challenge/homeVue', $params);
    }

    public function updateCarte($request) {

        // season from request or default to active season
        $season_id = isset($request->season) ? $request->season : $_SESSION['SEASON_ACTIVES'][0]->seasonId;

        // get all notes challengers
        $challengers = $this->cUrl(API.'challenge/results/all/'.$season_id, 'PHP_CALL', '', 'GET');

        // challenger details {"goal":39,"decisivePass":18,"shotsSaved":25,"ballRecovered":39,"manOfTheMatch":10,"yellowCard":0,"redCard":0,"nbMatch":21,"statPoint":134.83333333333331,"cardPointValue":8.089999999999998,"cardPoint":78.09,"cardType":"card_leg"}
        foreach($challengers as $challenger) {

            $child_id = $challenger->child_id;
            $child_photo = $challenger->child_photo;
            $child_name = $challenger->child_firstname;

            $details = json_decode(json_encode($challenger->details), true);
            $this->createPlayerCard($child_id, $child_name, $child_photo, $details);

        }

        $this->renderJson('photos updated');
    }


    private function createPlayerCard($child_id, $child_name, $child_photo, $details) {
        $width = 622;
        $height = 992;

        $child_photo = HOST.$child_photo;

        // Chemin vers l'image de fond en fonction du type de carte
        $backgroundImagePath = HOST."assets/image/cards/".$details['cardType'].".png";

        // Charger l'image de fond
        $image = @imagecreatefrompng($backgroundImagePath);
        if (!$image) {
            throw new Exception("Failed to load background image.");
        }

        // Désactiver le mélange alpha et sauvegarder la transparence
        imagealphablending($image, false);
        imagesavealpha($image, true);

        // Redimensionner l'image de fond
        $image = imagescale($image, $width, $height);

        // Charger la photo de l'enfant (PNG, JPG, WEBP, GIF)
        $childPhotoData = @file_get_contents($child_photo);
        $childPhoto = $childPhotoData ? @imagecreatefromstring($childPhotoData) : false;
        if (!$childPhoto) {
            return null;
        }

        // Désactiver le mélange alpha et sauvegarder la transparence pour la photo de l'enfant
        imagealphablending($childPhoto, false);
        imagesavealpha($childPhoto, true);

        // Obtenir les dimensions de la photo de l'enfant
        $photoWidth = imagesx($childPhoto);
        $photoHeight = imagesy($childPhoto);

        // Calculer le redimensionnement et le positionnement pour la photo de l'enfant
        $photoMaxWidth = $width * 0.5;  // Utiliser 100% de la largeur comme max
        $photoMaxHeight = 360; // Hauteur maximale pour la photo
        $scale = min($photoMaxWidth / $photoWidth, $photoMaxHeight / $photoHeight);
        $newWidth = floor($scale * $photoWidth);
        $newHeight = floor($scale * $photoHeight);
        $photoX = $width - $newWidth - 60; // Positionner horizontalement
        $photoY = 90; // Position verticale fixe pour la photo

        // Superposer la photo de l'enfant sur l'image de fond
        imagecopyresampled($image, $childPhoto, $photoX, $photoY, 0, 0, $newWidth, $newHeight, $photoWidth, $photoHeight);
        imagedestroy($childPhoto);

        // Définir la couleur noire pour le texte
        $black = imagecolorallocate($image, 0, 0, 0);

        // Ajouter du texte
        $fontPath = __DIR__ . "/../assets/fonts/16021_FUTURAMC.ttf"; // Assurez-vous que le chemin vers votre police est correct

        $largeFontSize = 70; // Taille de la police plus grande pour les points
        $pointsX = 80; // Position à gauche
        $pointsY = $photoY + 160; // Aligné verticalement avec le haut de la photo
        $angle = 0;
        imagettftext($image, $largeFontSize, $angle, $pointsX, $pointsY, $black, $fontPath, $details['cardPoint']);


        $fontSize = 50; // Taille de la police normale
        $textY = $pointsY + $largeFontSize + 20;
        imagettftext($image, $fontSize, $angle, $pointsX, $textY, $black, $fontPath, $child_name);

        $fontSize = 30;

        // challenger details {"goal":39,"decisivePass":18,"shotsSaved":25,"ballRecovered":39,"manOfTheMatch":10,"yellowCard":0,"redCard":0,"nbMatch":21,"statPoint":134.83333333333331,"cardPointValue":8.089999999999998,"cardPoint":78.09,"cardType":"card_leg"}

        $textY = $textY +$fontSize+ 120;
        imagettftext($image, $fontSize, $angle, $pointsX, $textY + 20, $black, $fontPath, "But: " . $details['goal']);

        $textY = $textY +$fontSize + 15;
        imagettftext($image, $fontSize, $angle, $pointsX, $textY + 20, $black, $fontPath, "Passe décisive: " . $details['decisivePass']);

        $textY = $textY +$fontSize + 15;
        imagettftext($image, $fontSize, $angle, $pointsX, $textY + 20, $black, $fontPath, "Ballons récupérés: " . $details['ballRecovered']);

        $textY = $textY +$fontSize + 15;
        imagettftext($image, $fontSize, $angle, $pointsX, $textY + 20, $black, $fontPath, "Buts arretés: " . $details['shotsSaved']);

        $textY = $textY +$fontSize + 15;
        imagettftext($image, $fontSize, $angle, $pointsX, $textY + 20, $black, $fontPath, "Homme du match: " . $details['manOfTheMatch']);

        $textY = $textY +$fontSize + 15;
        imagettftext($image, $fontSize, $angle, $pointsX, $textY + 20, $black, $fontPath, "Carton jaune: " . $details['yellowCard']);

        $textY = $textY +$fontSize + 15;
        imagettftext($image, $fontSize, $angle, $pointsX, $textY + 20, $black, $fontPath, "Carton rouge: " . $details['redCard']);

        $textY = $textY +$fontSize + 15;
        imagettftext($image, $fontSize, $angle, $pointsX, $textY + 20, $black, $fontPath, "Nombre de match: " . $details['nbMatch']);


        // Définir l'en-tête pour indiquer que le contenu est une image PNG
        /**
        header('Content-Type: image/png');
        imagepng($image);
        exit;**/

        $outputDir = __DIR__ . "/../assets/image/cards/14/";
        if (!file_exists($outputDir)) {
            mkdir($outputDir, 0777, true);
        }

        // Construire le chemin de sortie de l'image
        $outputPath = $outputDir . "card-$child_id.png";

        // Enregistrer l'image finale
        if (!imagepng($image, $outputPath)) {
            throw new Exception("Failed to save the final image.");
        }

        imagedestroy($image);
        return $outputPath;



    }



}