<?php $title = "Série des photos"; ?>
<?php use_helper('dates');?>
    <script src="https://unpkg.com/image-compressor.js/dist/image-compressor.min.js"></script>
    <style>
        #preview {
            max-width: 400px;
            min-width: 200px;
            width: auto;
            min-height: 100px;
            height: auto;
            border: 1px solid #ccc;
        }

        #messageSav {
            position: absolute;
            right: -100%;
            height: 67px;
            top: 110px;
            transform: translateY(-50%);
            width: 100%;
            background-color: lightgreen;
            transition: right 1s ease-in-out;
            color: darkblue;
            font-size: 20px;
            padding: 20px;
            border-radius: 10px;
            z-index: 9999
        }

        #messageSav.visible {
            right: 0;
        }

        #preview div {
            margin-bottom: 15px;
        }

        #preview img {
            display: block;
            max-width: 100%;
            height: auto;
        }

        #preview div div {
            height: 20px;
            background-color: #ccc;
        }

    </style>
    <h1>Série de photo</h1>

     <?php if(isset($_SESSION['message'])):?>
        <div id="messageSav">
            <?= $_SESSION['message'];?>
            <?php unset($_SESSION['message']);?>
        </div>

         <script>
             document.addEventListener("DOMContentLoaded", function(event) {
                 let div = document.getElementById("messageSav");
                 div.classList.add("visible");
                 setTimeout(function() {
                     div.style.display = "none";
                 }, 3000);
             });
         </script>
    <?php endif;?>


    <form id="photoForm" action="<?= HOST ;?>media/updateSerie" method="post" enctype="multipart/form-data">
        <div style="position: relative">
            <input type="text" id="searchChildPhoto" placeholder="Enfant" />
            <input type="hidden" id="child_id" name="child_id_list" required/>
            <div id="searchChildPhotoContent" style="position: absolute; z-index:99; background-color: white; width: 100%; padding: 10px; background-color: lightgrey">
                &nbsp;<br/>
            </div>
        </div>
        <br/><br/>
        <div>
            <label for="photo">Ajouter vos photos:</label>
            <input type="file" id="serie" name="photo[]" accept="image/*" multiple required>
        </div>
        <div id="img_compre"></div>
        <div id="preview"></div>
        <br/><br/><br/>
        <input type="hidden" value="awaiting" name="status"/>
        <div>
            <button type="submit" class="button" style="width: 100%">Envoyer</button>
        </div>
    </form>