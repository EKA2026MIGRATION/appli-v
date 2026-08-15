<?php $title = "Url courtess"; ?>

<h1>Liste des url courtes</h1>


<table>
    <thead>
        <th></th>
        <th>Code</th>
        <th>Nouvelle url</th>
        <th>Url d'origine</th>
        <th></th>
    </thead>
    <tbody>
        <?php foreach($params->shortUrls as $shortUrl):?>
            <tr>
                <td><?= $shortUrl->id;?></td>     
                <td><?= $shortUrl->urlCode;?></td>
                <td>
                    <a href="<?= $shortUrl->newUrl;?>" target="_blank">
                        <?= $shortUrl->newUrl;?>
                    </a>
                </td>
                <td>  
                    <a href="<?= $shortUrl->originalUrl;?>" target="_blank">
                        <?= $shortUrl->originalUrl;?>
                    </a>
                </td>
                <td>delete</td>
            </tr>
        <?php endforeach;?>
    </tbody>
    <tfooter>
        <form action="<?= HOST ?>shortUrl/create" method="POST">
            <tr>
                <td colspan="4">
                    <input type="text" name="original_url" placeholder="Copier ici l'url à raccourcir"/>
                </td>
                <td colspan="5">
                    <input type="submit" value="CRÉER" class="button"/>
                </td>
            </tr>
            
        </form>
    </tfooter>

</table>
