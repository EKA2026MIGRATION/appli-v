<?php use_helper('dates')?>

<?php $pickup = $params->pickup;?>

<h1 style="text-align: center">Bon de Réservation</h1>

&nbsp;<br/>
&nbsp;<br/>
&nbsp;<br/>


<div style="background-color: darkblue; color: white; font-weight: bold; font-size: 16px; text-align: center;">
    &nbsp;<br/>
    SERVICE DE VOITURE DE TRANSPORT AVEC CHAUFFEUR
    <br/>
</div>

<br/><br/><br/>

<table width="100%">
    <tr>
        <td width="50%" align="left">
            <br/>
            <i>Billet collectif</i><br/>
            <i>Ordre de mission</i>
        </td>
        <td width="50%" align="right">
            <br/>
            Arrêté du 14 février 1986 - Article 5<br/>
            Arrêté du 6 janvier 1993 - Article 3
        </td>
    </tr>
</table>

<hr/>

&nbsp;<br/>
&nbsp;<br/>
&nbsp;<br/>

<div style="color: darkblue; font-size: 16px; text-align: center;">
    ENERGY KIDS ACADEMY
    <br/>
    Enseignement sportif avec transport à domicile
</div>


&nbsp;<br/>
&nbsp;<br/>
&nbsp;<br/>

<table width="100%" style="">
    <tr>
        <td width="25%" rowspan="9">
            <img src="<?= IMG;?>/logoInvoiceEKA.JPG" alt="LOGO Energy Kids Academy" border="0" />
        </td>
        <td width="5%" rowspan="9"></td>
        <td width="30%" align="left">
            Conducteur
        </td>
        <td width="40%" align="left">
            <?= $params->driver;?>
        </td>

    </tr>
    <tr>
        <td width="30%" align="left">
            Passager
        </td>
        <td width="40%" align="left">
            <?= $pickup->child->firstname.' '.$pickup->child->lastname;?>
        </td>
    </tr>
    <tr>
        <td>&nbsp;<br/>&nbsp;<br/></td>
        <td>&nbsp;<br/>&nbsp;<br/></td>
    </tr>
    <tr>
        <td width="30%" align="left">
            Commande passée le :
        </td>
        <td width="40%" align="left">
            <?= showDate($pickup->createdAt);?>
        </td>
    </tr>
    <tr>
        <td width="30%" align="left">
            Date de la prise en charge:
        </td>
        <td width="40%" align="left">
            <?= showDate($pickup->start);?>
        </td>
    </tr>
    <tr>
        <td>&nbsp;<br/>&nbsp;<br/></td>
        <td>&nbsp;<br/>&nbsp;<br/></td>
    </tr>
    <tr>
        <td width="30%" align="left">
            Prise en charge
        </td>
        <td width="40%" align="left">
            <?php echo ($pickup->kind == "dropin") ? $pickup->address : "Club Energy Kids Academy - Les Jonnières 91570 Bièvres";?>
        </td>
    </tr>
    <tr>
        <td width="30%" align="left">
            Destination
        </td>
        <td width="40%" align="left">
            <?php echo ($pickup->kind == "dropoff") ? $pickup->address : "Club Energy Kids Academy - Les Jonnières 91570 Bièvres";?>
        </td>
    </tr>
    <tr>
        <td>&nbsp;<br/>&nbsp;<br/></td>
        <td>&nbsp;<br/>&nbsp;<br/></td>
    </tr>
    <tr>
        <td width="30%" align="left">
            Tarif
        </td>
        <td width="40%" align="left">
            45€
        </td>
    </tr>
</table>