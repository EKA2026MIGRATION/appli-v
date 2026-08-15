<?php

class Mail extends Controller
{
    public function LostPassword($request)
    {
        $url = HOST."auth/lost-password-confirm/token/".$request->token."/";

        $title   = "Récupération de votre mot de passe";
        $prehead = "Vous avez perdu votre mot de passe ?";
        $content = 'Bonjour,
            <p>Vous venez de faire une demande pour récupérer votre mot de passe.</p>
            <p>Cliquez ou copier/coller le lien ci-dessous pour créer un nouveau mot de passe.</p>
            '.$url.'
            <p>Si vous n\'avez pas effectué cette demande, merci de ne pas tenir compte de cet e-mail.</p>';

        ob_start();
        include ROOT.'view/render/sendMail/lostPasswordTemplate.php';
        $message = ob_get_clean();

        $mailerService = new MailerService();
        $mailerService->setAdd($request->email);
        $mailerService->setTitle($title);
        $mailerService->setMessage($message);
        $mailerService->setTemplateEmail(true);
        $mailerService->sendMail();

        echo json_encode(["success" => true]);
    }
}
