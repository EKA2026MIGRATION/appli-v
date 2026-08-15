<!doctype html>
<html>
  <head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title><?= $title; ?></title>
    <style>
      img { border: none; -ms-interpolation-mode: bicubic; max-width: 100%; }
      body { background-color: #f6f6f6; font-family: sans-serif; -webkit-font-smoothing: antialiased; font-size: 14px; line-height: 1.4; margin: 0; padding: 0; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; }
      table { border-collapse: separate; mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%; }
      table td { font-family: sans-serif; font-size: 14px; vertical-align: top; }
      .body { background-color: #f6f6f6; width: 100%; }
      .container { display: block; margin: 0 auto !important; max-width: 580px; padding: 10px; width: 580px; }
      .content { box-sizing: border-box; display: block; margin: 0 auto; max-width: 580px; padding: 10px; }
      .main { background: #ffffff; border-radius: 3px; width: 100%; }
      .wrapper { box-sizing: border-box; padding: 20px; }
      .footer { clear: both; margin-top: 10px; text-align: center; width: 100%; }
      .footer td, .footer p, .footer span, .footer a { color: #999999; font-size: 12px; text-align: center; }
      h1, h2, h3, h4 { color: #000000; font-family: sans-serif; font-weight: 400; line-height: 1.4; margin: 0; margin-bottom: 30px; }
      h1 { font-size: 35px; font-weight: 300; text-align: center; text-transform: capitalize; }
      p, ul, ol { font-family: sans-serif; font-size: 14px; font-weight: normal; margin: 0; margin-bottom: 15px; }
      a { color: #3498db; text-decoration: underline; }
      .btn { box-sizing: border-box; width: 100%; }
      .btn-primary table td { background-color: #3498db; }
      .btn-primary a { background-color: #3498db; border-color: #3498db; color: #ffffff; }
      .preheader { color: transparent; display: none; height: 0; max-height: 0; max-width: 0; opacity: 0; overflow: hidden; mso-hide: all; visibility: hidden; width: 0; }
      hr { border: 0; border-bottom: 1px solid #f6f6f6; margin: 20px 0; }
      @media only screen and (max-width: 620px) {
        table[class=body] .container { padding: 0 !important; width: 100% !important; }
        table[class=body] .main { border-left-width: 0 !important; border-radius: 0 !important; border-right-width: 0 !important; }
      }
    </style>
  </head>
  <body class="">
    <span class="preheader"><?= $prehead; ?></span>
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="body">
      <tr>
        <td>&nbsp;</td>
        <td class="container">
          <div class="content">
            <table role="presentation" class="main">
              <tr>
                <td class="wrapper">
                  <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                      <td><?= $content; ?></td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            <div class="footer">
              <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td class="content-block"><span class="apple-link">Energy Kids Academy</span></td>
                </tr>
                <tr>
                  <td class="content-block">Copyright - Tous droits réservés.</td>
                </tr>
              </table>
            </div>
          </div>
        </td>
        <td>&nbsp;</td>
      </tr>
    </table>
  </body>
</html>
