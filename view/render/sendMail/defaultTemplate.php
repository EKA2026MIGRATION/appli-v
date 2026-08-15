<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="format-detection" content="telephone=no" />
    <title>Template Hippocampe</title>
    <style type="text/css">
        body, #bodyTable, #bodyCell {
            height: 100% !important; margin: 0; padding: 0;
            width: 100% !important; font-family: sans-serif;
        }
        table { border-collapse: collapse; }
        table[id=bodyTable] {
            width: 100% !important; margin: auto;
            max-width: 600px !important; color: #4A5056; font-weight: normal;
        }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; outline: none; text-decoration: none; }
        body, table, td, p, a, li, blockquote {
            -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; font-weight: normal !important;
        }
        body, #bodyTable { background-color: #fff; }
        #emailHeader { background-color: #fff; }
        #emailTitle { background: #222529; border-radius: 6px 6px 0px 0px; }
        #emailBody { background-color: #F7FAFC; border-radius: 0px 0px 6px 6px; border: 1px solid #E2E8F0; }
        #emailFooter { background-color: #fff; }
        .btn { border-radius: 6px; background-color: #182d61; text-align: center; border: none; cursor: pointer; }
        .btn-text { color: #ffffff !important; font-family: Arial !important; font-weight: bold !important; font-size: 14px !important; }
        .logo { width: 100%; text-align: center; margin-top: 24px; margin-bottom: 24px; }
        .email-title-text { text-align: left; width: 100%; font-family: Arial; font-weight: bold; font-size: 19px; line-height: 22px; color: #fff; }
        #emailBody p { font-family: Arial; font-size: 14px; line-height: 24px; color: #4A5568; margin-bottom: 15px; }
        #emailBody a { font-family: Arial; font-size: 14px; color: #0091EA; text-decoration: none; }
        #emailBody ul { list-style: none; padding-left: 0; }
        #emailBody ul li { margin-bottom: 16px; position: relative; padding-left: 24px; font-size: 15px; line-height: 24px; color: #4a5568; }
        #emailBody ul li:before { content: ""; position: absolute; width: 4px; height: 4px; top: 10px; left: 4px; border-radius: 4px; background: #0054A8; z-index: 1; }
        #emailBody ul li:after { content: ""; position: absolute; top: 5.5px; left: 0; width: 12px; height: 12px; border-radius: 12px; background-color: #d8ecd0; }
        @media only screen and (max-width: 480px) {
            body { width: 100% !important; min-width: 100% !important; }
            table[id="emailHeader"], table[id="emailBody"], table[id="emailFooter"],
            table[id="emailTitle"], table[class="flexibleContainer"] { width: 100% !important; }
            td[class="flexibleContainerBox"], td[class="flexibleContainerBox"] table { display: block; width: 100%; text-align: left; }
        }
    </style>
</head>

<body bgcolor="#fff" leftmargin="0" marginwidth="0" topmargin="0" marginheight="0" offset="0">
    <center style="background-color: #fff;">
        <table border="0" cellpadding="0" cellspacing="0" height="100%" width="100%" id="bodyTable" style="table-layout: fixed; max-width:100% !important; width: 100% !important; min-width: 100% !important;">
            <tr>
                <td align="center" valign="top" id="bodyCell">

                    <!-- HEADER -->
                    <table bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" width="600" id="emailHeader">
                        <tr><td align="center" valign="top">
                            <table border="0" cellpadding="10" cellspacing="0" width="600" class="flexibleContainer">
                                <tr><td valign="top" width="600">
                                    <div class="logo">
                                        <img style="max-width: 170px;" src="https://www.energykidsacademy.fr/assets/img/energy-kids-academy.svg" />
                                    </div>
                                </td></tr>
                            </table>
                        </td></tr>
                    </table>

                    <!-- TITLE -->
                    <table bgcolor="#fff" border="0" cellpadding="0" cellspacing="0" width="600" id="emailTitle">
                        <tr><td align="center" valign="top">
                            <table border="0" cellpadding="32" cellspacing="0" width="600" class="flexibleContainer">
                                <tr><td valign="top" width="600">
                                    <div class="email-title-text"><?= $subject; ?></div>
                                </td></tr>
                            </table>
                        </td></tr>
                    </table>

                    <!-- CONTENT -->
                    <table bgcolor="#F7FAFC" border="0" cellpadding="0" cellspacing="0" width="598" id="emailBody">
                        <tr><td align="center" valign="top">
                            <table border="0" cellpadding="32" cellspacing="0" width="598" class="flexibleContainer">
                                <tr><td align="center" valign="top">
                                    <p><?= $content; ?></p>
                                </td></tr>
                            </table>
                        </td></tr>
                    </table>

                </td>
            </tr>
        </table>
    </center>
</body>

</html>
