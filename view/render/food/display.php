<?php $title = "Aliment ".$params->name; ?>

<h1 class="text-center"><?= $params->name; ?></h1>

    <div class="actionsPage">
        <button onclick="history.back()" class="button"><i class="material-icons">arrow_back</i> </button>
        <button id="deleteFood" data-id-food="<?php echo $params->foodId ?>" class="button"><i class="material-icons">delete</i> </button>
        <a href="<?= HOST ?>food/add/id/<?php echo $params->foodId ?>/"> <button class="button"><i class="material-icons">edit</i> </button></a> </div>


<div class="flex space-arround">
    <div  class="card-ea-profil-little">

        <img  style="height: 150px; margin: 50px;" src="<?= ("" !== $params->photo) ? HOST.$params->photo : IMG.'no_photo_2.jpg';  ?>" />

    </div>
</div>

    <div class="page__profil">
        <h2>Informations</h2>
        <div class="card-wrap horizontal">
            <div class="card-img-container">
                <figure>
                    <i class="material-icons">room_service</i>
                </figure>
            </div>
            <div class="card-info">
                <div class="card-primary">
                    <figure>
                        <p class="card-title">Type</p>
                        <p><?php if($params->kind == 'starchy'):echo 'Féculents';
                            elseif($params->kind == 'accompaniment'): echo 'Accompagnement';
                            elseif($params->kind == 'condiment'): echo 'Condiment';
                            elseif($params->kind == 'vegetables'): echo 'Légumes';
                            elseif($params->kind == 'sandwich'): echo 'Sandwich';
                                //elseif($params->kind == 'dessert'): echo 'Dessert';
                            endif?></p>
                    </figure>
                </div>
            </div>
        </div>

        <div class="card-wrap horizontal">
            <div class="card-img-container">
                <figure>
                    <i class="material-icons">toggle_on</i>
                </figure>
            </div>
            <div class="card-info">
                <div class="card-primary">
                    <figure>
                        <p class="card-title">Disponibilité</p>
                        <p><?php if ($params->status == 'active'): echo '<i class="material-icons green md-36">check_circle_outline</i>';
                            elseif ($params->status == 'disabled'): echo '<i class="material-icons red md-36">highlight_off</i>';
                            else: echo '<i class="icon-outline-archive"></i>';
                            endif ?></p>
                    </figure>
                </div>
            </div>
        </div>

        <div class="card-wrap horizontal hight displayOverButtons">
            <div class="card-img-container">
                <figure>
                    <i class="material-icons">info_outline</i>
                </figure>
            </div>
            <div class="card-info">
                <div class="card-primary">
                    <figure>
                        <p class="card-title">Description</p>
                        <p><?php if (null !== $params->description): echo $params->description; endif ?></p>
                    </figure>
                </div>
            </div>
        </div>
    </div>



<div class="space_actions_page_mobile"></div>