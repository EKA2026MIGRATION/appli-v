<?php $title = "Gestion des gymnases"; ?>
<?php use_helper('dates');?>

<style>
    .border-li {
        border: 1px solid #e0e0e0;
        border-radius: 5px;
        margin-bottom: 10px;
        padding: 10px;
        line-height: 40px;
    }

    i {
        cursor: pointer;
    }
</style>

    <h1>Gestion des gymnases</h1>

        Lister les produits gymnases visibles dans le menu de l'inscription

        <ul class="bordered">
            <?php foreach($params->products as $product):?>
                <li class="border-li" style="list-style-type: none">
                    <i class="material-icons arrow-up">arrow_upward</i>
                    <i class="material-icons arrow-down">arrow_downward</i>
                    <input type="checkbox" class="inputCheckbox" value="<?= $product->productId;?>" <?php if($product->frontMenu != "" && $product->frontMenu != null) echo " checked ";?>>  <?= $product->name ;?>
                </li>
            <?php endforeach;?>
        </ul>

        <hr/>


        Lister des gymnases visibles dans le site client

        <ul class="bordered">
            <?php foreach($params->locations as $location):?>
                <li class="border-li" style="list-style-type: none">
                    <input type="checkbox" class="inputCheckboxGym" value="<?= $location->locationId;?>" <?php if($location->frontVisibility != "" && $location->frontVisibility != null) echo " checked ";?>>  <?= $location->name .'  //  '.$location->nameEn.'<br/>'.$location->address;?>
                </li>
            <?php endforeach;?>
        </ul>

<script>

    document.addEventListener('DOMContentLoaded', function() {

        //  PRODUCT GYMNASE
        let url = $("#urlApi").val()+"product/update/frontMenu";
        let checkboxes = document.getElementsByClassName('inputCheckbox');

        // checkbox
        $('.inputCheckbox').change('click', function () {
            updateProductOrder();
        })
        // arrow direction
        $(".arrow-up").click(function() {
            $(this).closest("li").insertBefore($(this).closest("li").prev());
            updateProductOrder();
        });
        $(".arrow-down").click(function() {
            $(this).closest("li").insertAfter($(this).closest("li").next());
            updateProductOrder();
        });
        const updateProductOrder = () => {
            let order = [];

            for (let i = 0; i < checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    let productId = checkboxes[i].value;
                    order.push(productId);
                }
            }
            data = JSON.stringify(order);

            $.ajax({
                url: url,
                type: 'PUT',
                contentType: "application/json",
                headers: {
                    'Authorization':'Bearer ' + tokenAuth
                },
                contentLength: data.length,
                crossDomain: true,
                dataType: "json",
                data,
                beforeSend() {
                }, success(data) {
                    toastr.success("Saved");
                    console.log(data);
                }, error(data) {
                    console.log("error");
                    console.log(data);
                }
            });
        }


        // liste des gymnases visibles dans le site
        let urlGym = $("#urlApi").val()+"location/update/visibility";
        // checkbox
        $('.inputCheckboxGym').change('click', function () {
            if (this.checked) {
                console.log(this.value);
                updateGymnaseFront(this.value, 1);
            } else {
                updateGymnaseFront(this.value, 0);
            }
        })

        const updateGymnaseFront = (location_id, front_visibility) => {
            let urlRequest = urlGym+'/'+location_id+'/'+front_visibility;
            let dataGym = "";
            $.ajax({
                url: urlRequest,
                type: 'GET',
                contentType: "application/json",
                headers: {
                    'Authorization':'Bearer ' + tokenAuth
                },
                contentLength: dataGym.length,
                crossDomain: true,
                dataType: "json",
                dataGym,
                beforeSend() {
                }, success(data) {
                    toastr.success("Saved");
                }, error(data) {
                    console.log("error");
                    console.log(data);
                }
            });
        }

    });

</script>
