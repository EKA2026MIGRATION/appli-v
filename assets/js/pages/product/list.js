$( document ).ready(function() {

        $('.productListChildButton').click(function(e) {
            let url = $(this).data('url');
            console.log('registreation');
            console.log(url);
            window.location = url;
        })

        $('.checkboxCategory').change(function() {
            let category = $(this).val();
            let products = $('.checkbox'+category);
            products.each(function() {
               if($(this).prop('checked')) {
                   $(this).prop('checked', false);
               } else {
                   $(this).prop('checked', true);
               }
            })
        });

        $('#submitMasseButton').click(function() {
             

            let visibility = $('#visibilitySelect').val();
            let idList = [];

            if(visibility != "") {

                $('.checkboxProduct:checked').each(function() {
                    idList.push($(this).val())
                })

                let url = urlHost+'product/fastUpdate/';

                $('#showNone').load(url, {idList:idList, visibility:visibility}, function() {
                    toastr.success("Produit(s) modifié(s)");
                    document.location.reload();
                
                });
                   
            } 
        })


        $('#selectShowComponent').change(function() {
            let value = $(this).val();
            if(value == "hide") {
                $('.showComponent').hide();
            } else {
                $('.showComponent').show();
            }
        })

});