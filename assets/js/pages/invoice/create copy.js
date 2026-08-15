var family = new Array();
var address = new Array();

function updateFamily(key, el){
  $('#freename').val(family[key]);
  el.style.color = "darkgreen";
  
}

function updateFamilyName(name, el) {
    $('#freename').val("Mme/M. "+name);
    el.style.color = "darkgreen";
}

function updateAddress(key, el){
  let element = address[key].split('|');
  $('#invoiceAddress').val(element[0]);
  $('#invoicePostal').val(element[1]);
  $('#invoiceTown').val(element[2]);
  el.style.color = "darkgreen";

}

function updateAddressElement(address, postal, town, el) {
    $('#invoiceAddress').val(address);
    $('#invoicePostal').val(postal);
    $('#invoiceTown').val(town);
    el.style.color = "darkgreen";

}


function closeChildList()
{
  $("#childList").html("");
  $("#childList").hide();
}

function updateChildInfo(childId, firstname, name) {
  $("#childList").html("");
  $("#childList").append("<div onClick='closeChildList()' style='color: red; cursor: pointer; float: left'>X</div><hr style='clear: both'/>");

  $('#child_id').val(childId);
  $('#searchListChild').val(firstname+' '+name);

  let url = `child/display/${childId}`;

  $.ajax({
      type: "POST",
      url: urlRequest,
      data: { url, type: "GET" },
      dataType: "json",
      success(json) {

        family = new Array();
        address = new Array();

        let html = "<i>Sélectionnez l'intitulé et l'adresse de facturation</i><br/><br/>";

        html += "<ul>";
        for(let i = 0; i<json.persons.length; i++) {

          family[i] = "Mme/M. "+json.persons[i].lastname;

          html += "<li style='font-weight: bold; cursor: pointer' onClick='updateFamily("+i+", this)'>Mme/M. "+json.persons[i].lastname+"</li>";

          html += "<ul>";
          for(let j = 0; j<json.persons[0].addresses.length; j++) {
            address[j] = json.persons[0].addresses[j].address+"|"+json.persons[0].addresses[j].postal+"|"+json.persons[0].addresses[j].town;
            html += "<li style='cursor: pointer' onClick='updateAddress("+j+", this)'>"+json.persons[0].addresses[j].address+" - "+json.persons[0].addresses[j].postal+", "+json.persons[0].addresses[j].town+"</li>";
          }
          html += "</ul>";
        };

        $("#childList").append(html);

      }
  })

}


$(() => {

    resetListenner();
/*
    $('#searchListChild').focusout(function() {
        $("#childList").html("");
        $("#childList").hide();
    })
*/
    $('#searchListChild').keyup(function(e) {

      let searchTerm = $(this).val();
      let url = `child/search/${searchTerm}?size=50&page=1`;
      $("#childList").html("");
      $("#childList").show();

      $.ajax({
          type: "POST",
          url: urlRequest,
          data: { url, type: "GET" },
          dataType: "json",

          success(json) {
              const numberOfElements = json.length;

              if (numberOfElements > 0) {
                  $("#childList").html("");
                  $("#childList").append("<div onClick='closeChildList()' style='color: red; cursor: pointer; float: left'>X</div><hr style='clear: both'/>");
                  for (i = 0; i < numberOfElements; i++) {
                      let photo = photoProfilDefault;

                      if (json[i].photo != null) {
                          photo = urlHost + json[i].photo;
                      }

                      $("#childList").append(
                          `<li><a href="${
                              json[i].childId
                              }" onClick="updateChildInfo(${json[i].childId},'${json[i].firstname}','${json[i].lastname}');return false"><div><p class="list-header"><img src="${photo}" class="width-30 height-30" height="" width="" alt="">${
                              json[i].firstname
                              } ${
                              json[i].lastname
                              }`
                      );
                  }
              } else {
                  $("#childList").html(
                      "<p><strong><center>Aucun résultat.</center></strong></p>"
                  );
              }
          }
      });


    })

    $('input:submit').click(function(e){
        e.preventDefault();
        
        const invoiceProducts = [];

        let form = $("#invoiceForm");
        let data = $(form).serializeToJSON();

        if($('#date_invoice').val() == "") {
            toastr.error("Ajoutez une date de facturation", 'Erreur');
            return false;
        }

        var i = 0;

        $('#tableContentBody tr').each(function() {

            let type = $(this).attr('id').split('-')[0];
            let id   = $(this).attr('id').split('-')[2];

            let nameFr = $('#'+type+'-nameFr-'+id).html();
            let nameEn = $('#'+type+'-nameEn-'+id).html();
            let descriptionFr = $('#'+type+'-descriptionFr-'+id).html();
            let descriptionEn = $('#'+type+'-descriptionEn-'+id).html();
            let priceTtc = $('#'+type+'-uTtc-'+id).html();
            let priceHt  = $('#'+type+'-uHt-'+id).html();
            let quantity = $('#'+type+'-qantity-'+id).val();
            let totalTtc = $('#'+type+'-totalTtc-'+id).html();
            let totalHt  = $('#'+type+'-totalHt-'+id).html ();


            const invoiceComponents = [];

            // if type = component
                        if(type == 'comp') {

                          console.log('composant');

                            priceHt  = $('#'+type+'-Ht-'+id).html();
                            let vat      = $('#'+type+'-vat-'+id).val();
                            priceTtc = $('#'+type+'-Ttc-'+id).val();
                            let totalHt  = $('#'+type+'-totalHt-'+id).html();
                            let totalTtc = $('#'+type+'-totalTtc-'+id).html();

                            console.log("comp"+totalTtc);

                            invoiceComponents[0] = {
                                nameFr: nameFr, // ok
                                nameEn: nameEn, // ok
                                priceHt: priceHt,
                                quantity: 1, // ok
                                vat: vat,
                                priceVat: priceTtc-priceHt,
                                priceTtc: priceTtc, // ok
                                totalHt: priceHt,
                                totalTtc: priceTtc,
                            }
                            // if type == product
                        } else {
                            let k = 0;

                            $('#hiddenComponent .invoicesComponents-product-'+id).each(function() {

                                let nameFr   = $('#nameFr-invoiceComponent-'+type+'-'+id+'-'+k).val();
                                let nameEn   = $('#nameEn-invoiceComponent-'+type+'-'+id+'-'+k).val();
                                let priceHt  = $('#priceHt-invoiceComponent-'+type+'-'+id+'-'+k).val();
                                let quantity = $('#quantity-invoiceComponent-'+type+'-'+id+'-'+k).val();
                                let vat      = $('#vat-invoiceComponent-'+type+'-'+id+'-'+k).val();

                                let priceVat = $('#priceVat-invoiceComponent-'+type+'-'+id+'-'+k).val();
                                let priceTtc = $('#priceTtc-invoiceComponent-'+type+'-'+id+'-'+k).val();
                                let totalHt  = $('#totalHt-invoiceComponent-'+type+'-'+id+'-'+k).val();
                                let totalTtc = $('#totalTtc-invoiceComponent-'+type+'-'+id+'-'+k).val();

                                invoiceComponents[k] = {
                                    nameFr: nameFr,
                                    nameEn: nameEn,
                                    priceHt: priceHt,
                                    quantity: quantity,
                                    vat: vat,
                                    priceVat: priceVat,
                                    priceTtc: priceTtc,
                                    totalHt: totalHt,
                                    totalTtc: totalTtc,

                                }
                                k++;
                            })
                        }



            invoiceProducts[i] = {
                      nameFr: nameFr,
                      nameEn: nameEn,
                      descriptionFr: descriptionFr,
                      descriptionEn: descriptionEn,
                      priceTtc: priceTtc,
                      priceHt: priceHt,
                      totalTtc: totalTtc,
                      totalHt: totalHt,
                      invoiceComponents: invoiceComponents,
                      quantity: quantity
            };

            i++;
        });

        delete data.child_name;
        delete data.product;
        delete data.vat;

        url = "invoice/create";
        type = "POST";
        $.ajax({
           type: "POST",
           url: urlRequest,
           data: { url, type, data, invoiceProducts: invoiceProducts },
           dataType: "json",
            beforeSend() {
               $(".loading").show();
           },
           success(data) {
               $(".loading").hide();
               toastr.success("Facture ajoutée", 'Confirmation');
               document.location.reload();
           }
        });

    })

    $('#addCompontent').click(function() {
        let comp = $('#componentSelect :selected');
        let vat = $(comp).attr('data-vat');
        let name = $(comp).attr('data-name-fr');
        let id   = $(comp).val();

        let line =
        "<tr id='comp-line-"+id+"'><td id='comp-nameFr-"+id+"'>"+name+
        "</td><td  id='comp-descriptionFr-"+id+"'>"+name+
        "</td><td id='comp-priceUTtc-"+id+"' >"+
        "<input type='text' style='width: 50px' class='comp-values' id='comp-Ttc-"+id+"'/>"+
        "</td><td id='comp-Ht-"+id+"' >"+
        "</td><td id='comp-qtt-"+id+"'>"+
        "<input type='number' class='comp-values' value='1' style='width: 20px' id='comp-qantity-"+id+"'/>"
        +"</td><td  class='totalLineTtc' id='comp-totalTtc-"+id+"'>"+
        "</td><td class='totalLineHt' id='comp-totalHt-"+id+"'>"+
        "</td><td id='comp-delete-"+id+"' class='delete-line'><i class='material-icons' style='color: red; cursor: pointer'>close</i></td></tr>";

        $('#tableContentBody').append(line);
        $('#hiddenComponent').append("<input type='hidden' value="+vat+" name='comp-vat-"+id+"' id='comp-vat-"+id+"' />");


        resetListenner();
    })

    $('#selectProduct').change(function() {
      let product_id = $(this).val();
      let url = `product/display/${product_id}`;
        $.ajax({
            type: "POST",
            url: urlRequest,
            data: { url, type: "GET" },
            dataType: "json",
            success(product) {



                let line =
                "<tr  id='product-line-"+product_id+"'><td  id='product-nameFr-"+product_id+"'>"+product.nameFr+
                "</td><td  id='product-descriptionFr-"+product_id+"'>"+product.descriptionFr+
                "</td><td id='product-uTtc-"+product_id+"'>"+product.priceTtc+
                "</td><td id='product-uHt-"+product_id+"'>"+
                "</td><td id='product-qtt-"+product_id+"'>"+
                "<input type='number' class='product-quantity' value='1' style='width: 20px' id='product-qantity-"+product_id+"'/>"
                +"</td><td  class='totalLineTtc' id='product-totalTtc-"+product_id+"'>"+
                "</td><td class='totalLineHt' id='product-totalHt-"+product_id+"'>"+
                "</td><td id='product-delete-"+product_id+"' class='delete-product-line'><i class='material-icons' style='color: red; cursor: pointer'>close</i></td></tr>";
                $('#tableContentBody').append(line);

                for(j = 0; j < product.components.length; j++)
                {

                    let component = product.components[j];
                    let componentLine =
                    "<div class='invoicesComponents-product-"+product_id+"'>"+
                    "<b>"+product.nameFr+" - Détails </b>"+
                    "<input type='text' class='' name='nameFr-invoiceComponent-product-"+product_id+"' id='nameFr-invoiceComponent-product-"+product_id+"-"+j+"' value='"+component['nameFr']+"' />"+
                    "<input type='text' class='' name='nameEn-invoiceComponent-product-"+product_id+"'  id='nameEn-invoiceComponent-product-"+product_id+"-"+j+"' value='"+component['nameEn']+"' />"+
                    "<input type='text' class='' name='priceHt-invoiceComponent-product-"+product_id+"'  id='priceHt-invoiceComponent-product-"+product_id+"-"+j+"' value='"+component['priceHt']+"' />"+
                    "<input type='text' class='' name='quantity-invoiceComponent-product-"+product_id+"'  id='quantity-invoiceComponent-product-"+product_id+"-"+j+"' value='"+component['quantity']+"' />"+
                    "<input type='text' class='' name='vat-invoiceComponent-product-"+product_id+"'  id='vat-invoiceComponent-product-"+product_id+"-"+j+"' value='"+component['vat']+"' />"+
                    "<input type='text' class='' name='priceVat-invoiceComponent-product-"+product_id+"'  id='priceVat-invoiceComponent-product-"+product_id+"-"+j+"' value='"+component['priceVat']+"' />"+
                    "<input type='text' class='' name='priceTtc-invoiceComponent-product-"+product_id+"'  id='priceTtc-invoiceComponent-product-"+product_id+"-"+j+"' value='"+component['priceTtc']+"' />"+
                    "<input type='text' class='' name='totalHt-invoiceComponent-product-"+product_id+"'  id='totalHt-invoiceComponent-product-"+product_id+"-"+j+"' value='"+component['totalHt']+"' />"+
                    "<input type='text' class='' name='totalTtc-invoiceComponent-product-"+product_id+"'  id='totalTtc-invoiceComponent-product-"+product_id+"-"+j+"' value='"+component['totalTtc']+"' />"+

                    "</div>";

                    $('#hiddenComponent').append(componentLine);

                }

                resetListenner();
                calculeTotalProductLine(product_id);
            }
        });


    })

    function resetListenner()
    {
        $(document).off();

        $('.product-quantity').change(function(){
            let id = $(this).attr('id').split('-')[2];
            calculeTotalProductLine(id);
        })

        $('.delete-product-line').click(function() {
            let id = $(this).attr('id').split('-')[2];
            $('#product-line-'+id).remove();
            calculTotal();
        })

        $('.comp-values').change(function() {
            let id = $(this).attr('id').split('-')[2];
            let uTtc = parseFloat($('#comp-Ttc-'+id).val());
            let qtt = parseInt($('#comp-qantity-'+id).val());
            let vat = parseFloat($('#comp-vat-'+id).val());
            let uHt    = uTtc-uTtc*vat/100;
            let totalTtc = uTtc*qtt;
            let totalHt  = uHt*qtt;
            $('#comp-Ht-'+id).html(uHt)
            $('#comp-totalHt-'+id).html(totalHt);
            $('#comp-totalTtc-'+id).html(totalTtc);

            calculTotal();

        });
    }

    function calculeTotalProductLine(product_id){
        let qtt  = parseInt($('#product-qantity-'+product_id).val());
        let uTtc = parseFloat($('#product-uTtc-'+product_id).html());
        let uHt = parseFloat($('#product-uHt-'+product_id).html());
        let totalTtc = uTtc*qtt;
        let totalHt  = uHt*qtt;

        $('#product-totalTtc-'+product_id).html(totalTtc);
        $('#product-totalHt-'+product_id).html(totalHt);

        calculTotal();

    }

    function calculTotal()
    {
        var totalTtc = 0;
        var totalHt = 0;

        $('#tableContentBody .totalLineTtc').each(function() {
            let lineTtc = $(this).html();
            totalTtc  = totalTtc+parseFloat(lineTtc);
        })

        $('#tableContentBody .totalLineHt').each(function() {
            let lineHt = $(this).html();
            totalHt  = totalHt+parseFloat(lineHt);
        })

        $('#invoicePriceTtc').val(totalTtc);
        $('#invoice-totalTtc').html(totalTtc);
        $('#invoice-totalHt').html(totalHt);
    }

    $("#date_invoice").datepicker({
        altField: "#datepicker",
        altFormat: "yy-mm-dd",
        closeText: "Fermer",
        firstDay: 1,
        yearRange: "-5:+0",
        prevText: "Précédent",
        nextText: "Suivant",
        currentText: "Aujourd'hui",
        monthNames: [
            "Janvier",
            "Février",
            "Mars",
            "Avril",
            "Mai",
            "Juin",
            "Juillet",
            "Août",
            "Septembre",
            "Octobre",
            "Novembre",
            "Décembre"
        ],
        monthNamesShort: [
            "Janv.",
            "Févr.",
            "Mars",
            "Avril",
            "Mai",
            "Juin",
            "Juil.",
            "Août",
            "Sept.",
            "Oct.",
            "Nov.",
            "Déc."
        ],
        dayNames: [
            "Dimanche",
            "Lundi",
            "Mardi",
            "Mercredi",
            "Jeudi",
            "Vendredi",
            "Samedi"
        ],
        dayNamesShort: ["Dim.", "Lun.", "Mar.", "Mer.", "Jeu.", "Ven.", "Sam."],
        dayNamesMin: ["D", "L", "M", "M", "J", "V", "S"],
        weekHeader: "Sem.",
        dateFormat: "dd/mm/yy",
        changeYear: true,
        maxDate: new Date()
    });
});
