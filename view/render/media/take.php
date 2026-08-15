<?php $title = "Prendre une photo"; ?>
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
        }

        #messageSav.visible {
            right: 0;
        }
    </style>
    <h1>Prendre une photo</h1>

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


    <form id="photoForm" action="<?= HOST ;?>media/update" method="post" enctype="multipart/form-data">
        <div>
            <label for="photo">Photo:</label>
            <input type="file" id="photo" accept="image/*"  required>
            <input type="hidden" name="image_data_64" id="image_data_64"/>
        </div>
        <div id="preview"></div>
        <div>
            <label for="title">Titre:</label>
            <input type="text" id="title" name="title" >
        </div>
        <div>
            <label for="description">Description:</label>
            <textarea id="description" name="description"></textarea>
        </div>
        <div style="position: relative">
            <input type="text" id="searchChildPhoto" placeholder="Enfant" />
            <input type="hidden" id="child_id" name="child_id"/>
            <div id="searchChildPhotoContent" style="position: absolute; z-index:99; background-color: white; width: 100%; padding: 10px; background-color: lightgrey">
                &nbsp;<br/>
            </div>
        </div>
        <br/><br/><br/>
        <div>
            <select name="status">
                <option value="awaiting">En attente de validation</option>
               <!-- <option value="online">En ligne</option>-->
            </select>
        </div>
        <div>
            <button type="submit" class="button" style="width: 100%">Envoyer</button>
        </div>
    </form>