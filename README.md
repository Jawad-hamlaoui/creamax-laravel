# Créa'Max Paysage

Site vitrine et back-office de Créa'Max Paysage (Laravel 11 + Filament 4).

- **Site public** : page d'accueil, mentions légales, formulaire de contact (avec message vocal).
- **Admin** (`/admin`) : clients, devis (PDF), rendez-vous et calendrier (flux `.ics`), prestations, réalisations, avis, images du site.
- **Avis Google** : synchronisés chaque jour via `php artisan app:sync-google-avis` (nécessite `GOOGLE_PLACES_API_KEY`).
- **Sitemap** : régénéré chaque jour via `php artisan app:generate-sitemap`.

## Développement

```bash
composer install
npm install
cp .env.example .env && php artisan key:generate
php artisan migrate --seed
composer run dev
```

## Production

Déployé avec Docker (`Dockerfile`, dossier `docker/`). Le planificateur Laravel doit tourner
(`php artisan schedule:run` chaque minute) pour les tâches quotidiennes.

Ne jamais versionner d'identifiants : ils vont dans `.env` ou dans un gestionnaire de mots de passe.
