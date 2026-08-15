$(document).ready(function() {

    let year = $('#currentYear').val();
    let url = $('#updateUrl').val() + 'year/' + year + '/month/';
    let contentBlock = $('#curentContentBlock');
    let months = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
    let currentIndex = 0;

    function fetchNextMonth() {
        if (currentIndex < months.length) {
            let currentMonth = months[currentIndex];
            let currentUrl = `${url}${currentMonth}/`;

            $.ajax({
                type: "GET",
                url: currentUrl,
                dataType: "html",
                success: function(data) {
                    $(".loading").hide();
                    contentBlock.append(data);
                    currentIndex++;
                    fetchNextMonth();
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    currentIndex++;
                    fetchNextMonth();
                },
                beforeSend: function() {
                    $(".loading").show();
                }
            });
        } else {
            $(".loading").hide();
            console.log('done');

            // Calculer et afficher la somme des colonnes
            const columnSums = {};
            const tableRows = contentBlock.find("tr");

            // Parcourir les lignes du tableau à partir de la deuxième ligne (ignorer l'en-tête)
            for (let columnIndex = 0; columnIndex < tableRows.eq(0).find("td").length; columnIndex++) {
                let sum = 0;

                // Parcourir chaque ligne du tableau
                for (let rowIndex = 1; rowIndex < tableRows.length; rowIndex++) {
                    const cellText = tableRows.eq(rowIndex).find("td").eq(columnIndex).text();
                    const cellValue = parseFloat(cellText);

                    // Si la cellule contient un nombre valide, ajouter à la somme
                    if (!isNaN(cellValue)) {
                        sum += cellValue;
                    }
                }

                // Enregistrer la somme de la colonne dans l'objet columnSums
                columnSums[columnIndex] = sum;
            }

            // Afficher les sommes de colonnes dans la console
            console.log("Sommes des colonnes :", columnSums);

            // Créer une nouvelle ligne pour afficher les totaux des colonnes
            const totalRow = $("<tr></tr>");
            totalRow.css("font-weight", "bold");

            // Ajouter les cellules pour chaque somme de colonne
            for (let columnIndex = 0; columnIndex < tableRows.eq(0).find("td").length; columnIndex++) {
                const sum = columnSums[columnIndex] || 0;
                const totalCell = $("<td></td>").text(sum.toFixed(2)); // Formater la somme avec deux décimales
                totalRow.append(totalCell);
            }

            // Ajouter la nouvelle ligne des totaux à la fin du tableau
            tableRows.last().after(totalRow);
        }
    }

    fetchNextMonth();
});
