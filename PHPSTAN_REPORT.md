# Rapport PHPStan — appli-v

## Chiffres clés

- **0 erreur**.
- **Niveau utilisé : 0** (le plus bas). `appli-v` est un framework MVC maison sans aucun type-hint natif systématique (paramètres, propriétés et retours de méthode non typés dans l'immense majorité du code) — un niveau plus élevé produirait un volume d'erreurs disproportionné par rapport à la valeur (essentiellement du bruit de typage, pas des bugs). **Trajectoire suggérée** : monter progressivement (1 → 2 → ...) au fil d'un futur chantier de typage, pas d'un coup.
- Scope : `controller/`, `application/`, `view/render/`, `view/template/`, plus les fichiers non-vendored de `services/` (`MailerService.php`, `PdfService.php`, `Transliterator.php`, `exTCPDF.php`). `application/helper/*` est inclus dans le scope analysé (ce sont des fonctions applicatives, pas du code tiers).
- `vendor/bin/phpstan analyse` est **vert** — seules les erreurs **nouvelles** feront échouer une future exécution.

## Bootstrap d'analyse (`.phpstan/bootstrap.php`)

Ce framework charge ses dépendances différemment d'un projet Composer classique : pas d'autoloading PSR-4 (une classe est résolue par nom de fichier via `spl_autoload_register` dans `MyConfiguration::autoload()`, `config/config.php`), et des fonctions globales chargées à la demande via `use_helper('dates')` (`application/Functions.php`) plutôt qu'au démarrage. Sans bootstrap dédié, PHPStan ne verrait ni les constantes (`ROOT`, `API`, `HOST`, etc., définies au runtime par `MyConfiguration::start()`) ni les fonctions des helpers non chargés par le fichier en cours d'analyse.

Le bootstrap définit les constantes avec des valeurs factices (suffisant pour l'analyse statique, pas besoin d'être fonctionnellement correct) et charge tous les fichiers de `application/helper/` d'un coup. Il ne reproduit volontairement pas `MyConfiguration::start()` (appels réseau vers l'API, session, redirections avec `exit`).

**Point d'attention** : `application/helper/evaluation.php` déclare `showEvaluationIconStatus()`, distincte de `showIconStatus()` dans `application/helper/pickupStatus.php` — les deux couvraient à l'origine le même nom avec des signatures différentes ; le nommage actuel évite la collision si jamais les deux helpers sont chargés ensemble dans une même vue.

## Bibliothèques vendored hors périmètre

`services/tcpdf/`, `services/VCard*.php`, `vendor/phpmailer/`, `php-library/twilio-php-master/` sont du code tiers — déclarés en `scanDirectories`/`scanFiles` dans `phpstan.neon` (pour que PHPStan résolve les classes utilisées par l'app, ex. `TCPDF`, `PHPMailer`, `Twilio\Rest\Client`) mais **exclus de l'analyse** elle-même, au même titre que serait exclu un `vendor/` composer classique.

## Comment l'utiliser

```bash
# Lancer l'analyse (doit rester vert)
php8.3 vendor/bin/phpstan analyse

# Après un chantier de fix, régénérer le baseline pour capturer la réduction
php8.3 vendor/bin/phpstan analyse --generate-baseline=phpstan-baseline.neon
```

Pas de CI/CD dans ce repo à ce jour — cette commande est à lancer manuellement pour l'instant.
