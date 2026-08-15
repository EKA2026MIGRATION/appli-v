<?php use_helper('dates');?>

<div class="masonry-css">

  <div class="masonry-css-item">
    <section class="title bg-silver black">Prévisions Météo</section>
    <section class="block-list expandable">


  <!-- ajouter une alerte en cas de vent > 50km et risque de neige + Pluie ----->

  <!---
  https://samples.openweathermap.org/data/2.5/weather?q=London,uk&appid=b6907d289e10d714a6e88b30761fae22

  --->

      <!-- widget meteo -->
      <!-- source : http://www.widget-meteo.com/ --->
      <div id="widget_0d5bbb24bbec94b61901a3b7ee7fb937">
      <span id="t_0d5bbb24bbec94b61901a3b7ee7fb937">Météo Bi&egrave;vres</span>
      <span id="l_0d5bbb24bbec94b61901a3b7ee7fb937"><a href="http://www.mymeteo.info/r/bievres-91_a">M&eacute;t&eacute;o Bi&egrave;vres</a></span>
      <script type="text/javascript">
      (function() {
        var my = document.createElement("script"); my.type = "text/javascript"; my.async = true;
          my.src = "https://services.my-meteo.com/widget/js?ville=1213&format=carre&nb_jours=5&temps&icones&vent&precip&c1=393939&c2=a9a9a9&c3=e6e6e6&c4=ffffff&c5=00d2ff&c6=d21515&police=0&t_icones=7&x=336&y=500&d=0&id=0d5bbb24bbec94b61901a3b7ee7fb937";
          var z = document.getElementsByTagName("script")[0]; z.parentNode.insertBefore(my, z);
      })();
      </script>
      </div>
      <!-- widget meteo -->

    </section>
  </div>



  <div class="masonry-css-item">
    <section class="title bg-silver black">Anniversaires du jour</section>
    <section class="block-list expandable">
      <ul>

            <li style="text-align: center"><b style="color: darkred; text-align: center">Enfants</b></li>


            <?php if(isset($params->child_birthdates)):?>
                  <?php $currentDate = "";?>
                  <?php foreach($params->child_birthdates as $birthkey => $datas):?>

                     <?php ($birthkey == showDate($params->date, 'm-d')) ? $colorStyle = "style='color: darkblue'" : $colorStyle = '';?>
                     <li <?=$colorStyle;?> >
                       <p>
                           <b style="color: darkblue; text-align: center">
                             <?= showDate(date('Y').'-'.$birthkey, 'd M');?>
                           </b>
                           <br/>
                            <?php $i = 0;?>
                            <?php foreach($datas as $data):?>
                                <?php if($i > 0) echo ', ';?>
                                <?= $data->full_name;?>
                                <?php $i++;?>
                            <?php endforeach;?>
                        </p>
                     </li>
                  <?php endforeach ?>

            <?php endif;?>

            <br/>


            <?php if(isset($params->staff_birthdates)):?>


                  <li style="text-align: center"><b style="color: darkred; text-align: center">Team</b></li>

                  <?php $currentDate = "";?>
                  <?php foreach($params->staff_birthdates as $birthkey => $datas):?>
                     <?php if(isDate($birthkey)):?>
                           <?php ($birthkey == showDate($params->date, 'm-d')) ? $colorStyle = "style='color: darkblue'" : $colorStyle = '';?>
                           <li <?=$colorStyle;?> >
                             <p>
                                 <b style="color: darkblue; text-align: center">
                                   <?= showDate(date('Y').'-'.$birthkey, 'd M');?>
                                 </b>
                                 <br/>
                                  <?php $i = 0;?>
                                  <?php foreach($datas as $data):?>
                                      <?php if($i > 0) echo ', ';?>
                                      <?= $data->full_name;?>
                                      <?php $i++;?>
                                  <?php endforeach;?>
                              </p>
                           </li>
                   <?php endif;?>
                  <?php endforeach ?>

            <?php endif;?>


      </ul>
    </section>
  </div>




</div>
