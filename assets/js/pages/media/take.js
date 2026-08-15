$(document).ready(function() {

    let childIds = [];

    // fast search child
    $('#searchChildPhoto').keyup(function () {
        let search = $(this).val();

        if (search.length > 2) {

            const regex = /'/gi;
            search = search.replace(regex, '27');

            let url = `child/fastsearch/${search}`;

            $.ajax({
                type: "POST",
                url: urlRequest,
                data: {
                    url,
                    type: "GET"
                },
                dataType: "json",
                beforeSend() {
                    $('#searchChildPhotoContent').show();
                    $('#searchChildPhotoContent').empty();
                },
                success(json) {

                    const numberOfElements = json.length;
                    if (numberOfElements > 0) {
                        let line = "<ul>";
                        for (i = 0; i < numberOfElements; i++) {
                            line += `<li style="list-style: none; border-bottom: 1px solid lightgrey; display: flex; justify-content: space-between;">
                                        <span data-childid="${json[i].id}" class="childPhotoLiResult" style="padding-top: 10px; color: darkblue; cursor: pointer;">`;

                                        if(json[i].photo !== null) {
                                            line += `<img src="https://appli-v.net/${json[i].photo}" style="width: 50px; height: 50px; margin-right: 10px">`;
                                        }
                            line += ` #${json[i].id} - ${json[i].fullname}
                                            </span>
                                               <button type="button" class="remove-child" data-childid="${json[i].id}" style="color: darkred; font-weight: bold; cursor: pointer;">X</button>
                                      </li>`;
                        }
                        line += "</ul>";
                        $("#searchChildPhotoContent").html(line);
                    } else {
                        $("#searchChildPhotoContent").html(
                            "<p><strong><center>Aucun résultat.</center></strong></p>"
                        );
                    }
                }
            });
        }
    })


    // Ajoute l'enfant sélectionné au formulaire
    $(document).on('click', '.childPhotoLiResult', function() {
        let childId = $(this).data('childid');
        if (!childIds.includes(childId)) {
            childIds.push(childId);
            let content = $(this).parent().html();
            $('#img_compre').append(`<div>${content}</div>`);
            $('#child_id').val(childIds.join(','));
            $('#searchChildPhotoContent').empty();
        }
    });

    // Supprime un enfant de la liste
    $(document).on('click', '.remove-child', function() {
        let childId = $(this).data('childid');
        childIds = childIds.filter(id => id !== childId);
        $(this).parent().remove();
        $('#child_id').val(childIds.join(','));
    });


    // Afficher la photo sélectionnée dans la div de prévisualisation
    $('#photo').change(function() {
        let file = $(this)[0].files[0];
        let reader = new FileReader();
        let src;
        reader.onload = function(e) {
            src = e.target.result;
            $('#preview').html('<img id="myImge" src="' + src + '">');

            const image = new Image();
            image.src = src;

            image.onload = function() {
                const originalWidth = image.width;
                const originalHeight = image.height;

                let targetWidth = originalWidth;
                let targetHeight = originalHeight;

                const maxWidth = 1600;
                const maxHeight = 1600;
                const minWidth = 600;
                const minHeight = 600;

                // Réduire la taille de l'image si elle dépasse la limite maximale
                while (targetWidth > maxWidth || targetHeight > maxHeight) {
                    targetWidth = Math.floor(targetWidth / 2);
                    targetHeight = Math.floor(targetHeight / 2);
                }

                // Augmenter la taille de l'image si elle est en dessous de la limite minimale
                while (targetWidth < minWidth || targetHeight < minHeight) {
                    targetWidth *= 2;
                    targetHeight *= 2;
                }

                const compressorSettings = {
                    toWidth: targetWidth,
                    toHeight: targetHeight,
                    mimeType: "image/jpeg",
                    quality: 0.6,
                    speed: "low"
                };

                const imageCompressor = new ImageCompressor();
                imageCompressor.run(src, compressorSettings, saveImg64);
            };
        }
        reader.readAsDataURL(file);

    });


    const saveImg64 = (compressedImg) => {
        $('#image_data_64').val(compressedImg);
    }

    let inputDiv = document.getElementById('img_compre');

    // Intercepter la soumission du formulaire
    document.getElementById('photoForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Empêcher la soumission normale du formulaire
       uploadImagesOneByOne();
    });

    // Gérer les changements sur l'input de fichier
    document.getElementById('serie').addEventListener('change', function(event) {
        let files = event.target.files;
        let previewDiv = document.getElementById('preview');
        previewDiv.innerHTML = ''; // Nettoyer la prévisualisation précédente
        Array.from(files).forEach(file => {
            handleFile(file, previewDiv);
        });
    });

    // Traiter et afficher chaque fichier
    function handleFile(file, previewDiv) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const imgElement = createImagePreview(e.target.result, previewDiv);
            compressImage(e.target.result)
                .then(compressedImage => {
                    imgElement.dataset.compressed = compressedImage; // Stocker l'image compressée pour l'upload
                });
        };
        reader.readAsDataURL(file);
    }

    // Créer une prévisualisation de l'image
    function createImagePreview(imageDataUrl, previewDiv) {
        const img = document.createElement('img');
        img.src = imageDataUrl;
        img.style.width = '200px';
        previewDiv.appendChild(img);
        return img;
    }

    // Compresser l'image
    function compressImage(imageDataUrl) {
        return new Promise(resolve => {
            const img = new Image();
            img.onload = () => {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                const maxWidth = 1600;
                const maxHeight = 1200;

                let width = img.width;
                let height = img.height;

                // Calcul des nouvelles dimensions
                if (width > height) {
                    if (width > maxWidth) {
                        height *= maxWidth / width;
                        width = maxWidth;
                    }
                } else {
                    if (height > maxHeight) {
                        width *= maxHeight / height;
                        height = maxHeight;
                    }
                }

                canvas.width = width;
                canvas.height = height;
                ctx.drawImage(img, 0, 0, width, height);
                resolve(canvas.toDataURL('image/jpeg', 0.7)); // Ajuster la qualité ici
            };
            img.src = imageDataUrl;
        });
    }

    // Upload des images une par une
    // Upload des images une par une avec $.ajax
    function uploadImagesOneByOne() {
        const images = document.querySelectorAll('#preview img');
        let index = 0;

        let url = 'updateSerieOneToOne';

        function next() {
            if (index < images.length) {
                const img = images[index++];
                const progressBar = document.createElement('div');
                progressBar.style.width = '0%';
                progressBar.style.height = '20px';
                progressBar.style.backgroundColor = '#1E7FCB';
                progressBar.textContent = 'Uploading...';
                img.parentNode.insertBefore(progressBar, img.nextSibling);

                // Construction du formData pour l'envoi
                const formData = new FormData();
                formData.append('photo', img.dataset.compressed);
                formData.append('child_id', document.getElementById('child_id').value);

                // Préparez data pour $.ajax
                const data = {
                    type: "PUT",
                    url: img.dataset.compressed
                };

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: "json",
                    beforeSend: function() {
                        console.log('Sending image...');
                    },
                    success: function(response) {
                        console.log('Upload complete:', response);
                        progressBar.style.width = '100%';
                        progressBar.textContent = 'Upload Complete';
                        next();
                    },
                    error: function(xhr, status, error) {
                        console.error('Upload failed:', error);
                        progressBar.style.backgroundColor = 'red';
                        progressBar.textContent = 'Failed';
                    }
                });
            }
        }

        next();
    }




});
