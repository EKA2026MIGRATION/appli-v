<?php $title = "Valider les photos"; ?>
<?php use_helper('dates');?>
    <style>
        .gallery {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .photo {
            position: relative;
            margin: 10px;
            cursor: pointer;
        }

        .photo img {
            width: 200px;
            height: auto;
            object-fit: cover;
        }

        .photo .overlay {
            position: absolute;
            top: 0;
            left: 0;
            background-color: rgba(0, 0, 0, 0.7);
            color: #fff;
            padding: 10px;
            opacity: 0;
            transition: opacity 0.3s ease;
            padding: 10px;
            width: 100%;
        }

        .child-name-bold {
            font-weight: bold;
            font-size: 14px;
            color: #fff;
        }

        .photo:hover .overlay {
            opacity: 1;
        }

        #fullscreen {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.9);
            z-index: 9999;
            text-align: center;
            overflow: auto;
        }

        #fullscreen .close {
            color: #fff;
            font-size: 30px;
            position: absolute;
            top: 10px;
            right: 20px;
            cursor: pointer;
        }

        #fullscreen img {
            max-width: 100%;
            max-height: 90vh;
            margin-top: 10vh;
        }

        #fullscreen .overlay {
            position: relative;
            margin: 10px auto;
            width: 500px;
            padding: 20px;
        }

        .full .buttons {
            margin-top: 20px;
        }

        .full .buttons button {
            margin: 0 5px;
            padding: 8px 12px;
            cursor: pointer;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            color: #fff;
            transition: background-color 0.3s ease;
        }

        .full .buttons button.awaiting-validation {
            background-color: #999;
        }

        .full .buttons button.online {
            background-color: #00cc66;
        }

        .full .buttons button.delete {
            background-color: #ff3300;
        }

        #fullscreen input {
            border-radius: 10px;
        }

        .photo[data-status="awaiting"] img,
        .photo[data-status="awaiting"] .overlay,
        #fullscreen .overlay[data-status="awaiting"] {
            border: 4px solid #999;
        }

        .photo[data-status="online"] img,
        .photo[data-status="online"] .overlay,
        #fullscreen .overlay[data-status="online"] {
            border: 4px solid #00cc66;
        }

        .photo[data-status="deleted"] img,
        .photo[data-status="deleted"] .overlay,
        #fullscreen .overlay[data-status="deleted"] {
            border: 4px solid #ff3300;
        }

        @media (max-width: 768px) {
            .photo {
                width: 40%;
            }
            .photo img {
                width: 100%;
            }
        }
    </style>

    <h1>Valider les photos</h1>



    <!-- actions button --->
<div class="full">
    <div class="buttons">
        Modifier le statut de la sélection :
        <button class="online groupButton" data-status="online">En ligne</button>
        <button class="delete groupButton" data-status="deleted">Supprimer</button>
        <button class="awaiting-validation groupButton" data-status="awaiting-validation">En attente de validation</button>
    </div>
</div>

    <div class="gallery">

        <?php $currentLabel = ""; $previousLabel = ""; ?>

        <?php foreach ($params->medias as $media): ?>

            <?php if($media->status == 'deleted') continue; ?>

            <?php
                $mediaDate = $media->updatedAt;
                $today =  date('Y-m-d');

                $diffDate = newDiffDate($today, $mediaDate);
                
                // switch diffDate
                switch($diffDate) {
                    case 0:
                        $currentLabel = "Aujourd'hui";
                        break;
                    case 1:
                        $currentLabel = "Hier";
                        break;
                    case $diffDate > 1 && $diffDate <= 7:
                        $currentLabel = "La semaine dernière";
                        break;
                    case $diffDate > 7 && $diffDate <= 30:
                        $currentLabel = "Le dernier mois";
                        break;
                    case $diffDate > 30 && $diffDate <= 180:
                        $currentLabel = "Les 6 derniers mois";
                        break;
                    case $diffDate > 180 && $diffDate <= 365:
                        $currentLabel = "Plus de 6 mois";
                        break;
                    default:
                        $currentLabel = "Plus ancien";
                        break;
                }

            ?>

            <?php if( $currentLabel !== $previousLabel) echo '<div style="width: 100%;"></div><b>'.$currentLabel.'</b><div style="width: 100%; color: red"></div>';?>

            <div class="photo" data-id="<?= $media->id; ?>"  data-status="<?= $media->status; ?>">
                <div style="display: flex; flex-direction: column; border:1px solid black">
                    <img src="<?= HOST.$media->url; ?>" alt="<?= $media->title; ?>">
                    <div class="selectGroupAction">
                        <label>
                            &nbsp;&nbsp;&nbsp;
                            <input type="checkbox" value="<?= $media->id; ?>" class="selectGroup"/>
                            #<?= $media->id; ?>
                        </label>
                        <?php if ($media->child): ?>
                            <div id="child-name<?= $media->id;?>" data-childid="<?= $media->child->id;?>">&nbsp;&nbsp;&nbsp;<?php echo $media->child->full_name; ?></div>
                        <?php else :?>
                        &nbsp;<br/>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="overlay">
                    <span class="child_name child-name-bold"><?php if($media->child) echo $media->child->full_name.'<br/>';?></span>
                    <h4><?php echo $media->title; ?></h4>
                    <p class="description"><?php echo $media->description; ?></p>
                    <i class="status" style="font-size: 14px!important"><?php echo $media->status; ?></i>
                    <input type="hidden" class="child_id" value="<?php if($media->child) echo $media->child->id;?>"/>
                </div>
            </div>
            <?php $previousLabel = $currentLabel; ?>
        <?php endforeach; ?>
    </div>

    <div id="fullscreen" class="full">
        <span class="close">&times;</span>f
        <img src="" alt="">
        <div class="overlay" style="color: white;">
            <input type="text" id="fullscreenTitle" />
            <input type="text" id="fullscreenDesc" />
            <input type="text" id="fullscreenChildName" placeholder="Nom de l'enfant" />
            <input type="hidden" id="fullscreenChildId"/>
            <div id="searchChildPhotoContent" style="display: none; position: absolute; z-index:99; background-color: white; padding: 10px; background-color: lightgrey">
                &nbsp;<br/>
            </div>


            <p id="fullscreenStatus"></p>
            <div class="buttons">
                <button class="awaiting-validation">En attente de validation</button>
                <button class="online">En ligne</button>
                <button class="delete">Supprimer</button>
                <br/>
                <button class="previous">Précédent</button>
                <button class="next">Suivant</button>
            </div>
        </div>
</div>

<input type="hidden" id="media_id">

<script>


</script>