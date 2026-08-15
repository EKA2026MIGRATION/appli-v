# appli-v

Application principale d'Energy Kids Academy — interface staff (planning, activités, facturation, gestion des familles).

## Stack

- PHP 8.3, framework MVC maison (pas de framework tiers)
- Vue.js 3 pour les parties d'interface dynamiques (`vue/`)
- Consomme l'API [`api-appli-v`](https://github.com/EKA2026MIGRATION/api-appli-v)

## Architecture — code legacy

Le routeur, les contrôleurs et les vues sont un framework maison, pas Symfony/Laravel : autoload par nom de classe via `spl_autoload_register` (`config/config.php`), pas de build ni d'étape d'installation — le code s'exécute directement depuis les sources. Les bibliothèques tierces qu'il utilise (PHPMailer, TCPDF, Google API Client, Twilio) sont elles aussi embarquées directement dans `php-library/` et `services/`, pas via Composer.

**Routage** : les routes sont déclarées dans `application/routes/routes.ini` (format INI, une section par route). Chaque entrée mappe une URL à un contrôleur/méthode, avec un niveau de sécurité (`security`) et les assets JS/CSS à charger pour la page :

```ini
[app/home]
controller = "Home"
method     = "display"
security   = "ALL"
js         = "..."
css        = "..."
```

`application/Routeur.php` lit ce fichier pour dispatcher chaque requête vers le bon contrôleur.

**Configuration** : `config/config.php` lit un fichier `.env` à la racine (format INI, via `parse_ini_file` — rien à voir avec le composant Symfony du même nom) et le transforme en constantes PHP globales (`API`, `HOST`, clés de services tiers...). Copier `.env.example` en `.env` et renseigner les valeurs.

## Sessions & authentification

Authentification par session PHP native (`$_SESSION`), pas de JWT côté navigateur — le JWT existe côté `api-appli-v` pour les appels serveur-à-serveur, mais le front garde juste un token en session.

- **Cookie de session** : `httponly`, `secure` (si HTTPS), `samesite=Lax`, réglés dans `config/config.php` avant `session_start()`.
- **Avant connexion** : `$_SESSION['TOKEN']` absent → `ROLE = 'NOTHING'`. Seules quelques routes explicitement whitelistées dans `config/config.php` (`auth/display`, `auth/check`, endpoints publics/cron/download...) restent accessibles ; toute autre route redirige vers `auth/display` (avec `exit;` — sans ça la route s'exécutait quand même malgré la redirection).
- **Après connexion** : `config/config.php` définit les constantes `ROLE`, `TOKEN`, `PERSON_CONNECTED` à partir de la session. `PERSON_CONNECTED` est re-synchronisé à chaque requête via un appel à l'API (`Controller::__construct()` → `person/display/{identifier}`).
- **Contrôle d'accès par route** : chaque entrée de `routes.ini` a un champ `security` (ex. `security = "STAFF,ADMIN"` ou `"ALL"`). `application/Routeur.php` vérifie `ROLE` contre cette liste avant de dispatcher — contrairement à `energykidsacademy.net` où toutes les routes sont `"ALL"` (pas de granularité par rôle côté routeur, tout le contrôle d'accès y repose sur le couple session/redirection).
- **Déconnexion** : `session_destroy()` + redirection (avec `exit;`).

## Déploiement

Pas de CI/CD : la mise en production se fait par copie manuelle du dossier applicatif sur le serveur (voir le dépôt `api-appli-v` pour un exemple de checklist de bascule, `CUTOVER.md`). Ne jamais écraser en prod : `.env`, `uploads/`, `assets/document/` (données propres à l'environnement, non versionnées ici).

Composer ne sert qu'à l'outillage de développement (PHPStan) :

```bash
composer install
```

### Identifiants Firebase / Google

`php-library/appli_V-*.json` (clés de compte de service Firebase Admin) et `php-library/client_secret_*.json` (secret client OAuth) ne sont pas versionnés — à fournir séparément par environnement (non trackés, voir `.gitignore`).

⚠️ Les clés actuellement en service ont été exposées dans l'historique git de l'ancien dépôt. Elles doivent être régénérées côté Google Cloud Console / Firebase avant d'être considérées fiables, puis les nouvelles valeurs déployées hors du dépôt.

## Qualité du code

Analyse statique via PHPStan (niveau 0, cf. contexte dans `PHPSTAN_REPORT.md`) :

```bash
vendor/bin/phpstan analyse
```
