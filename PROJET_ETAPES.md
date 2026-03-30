# Mini-Projet Web : Site d'Informations sur la Guerre en Iran

## 📋 Vue d'ensemble du projet
Création d'un site web d'informations sur la guerre en Iran avec un système de gestion de contenu (BackOffice) et une interface publique (FrontOffice) utilisant PHP, PostgreSQL en Docker et l'URL rewriting.

---

## 📅 Étapes du projet

### **PHASE 1 : PRÉPARATION & BASE DE DONNÉES**

#### Étape 1.1 : Configurer la base de données
- [ ] Définir la structure des tables dans `postgres/init.sql` :
  - Table `articles` : id, title, slug, content, featured_image, meta_description, meta_keywords, date_created, date_updated, status (published/draft)
  - Table `categories` : id, name, slug (optionnel pour catégoriser les articles)
  - Table `users` : id, email, password, role (admin/editor) pour le BackOffice
- [ ] Initialiser les données de test
- [ ] Vérifier la connexion PostgreSQL dans `app/config/db.php`

#### Étape 1.2 : Vérifier la structure PHP existante
- [ ] Réviser `app/config/db.php` pour la connexion à PostgreSQL
- [ ] Réviser `app/config/utils.php` pour les fonctions utilitaires
- [ ] Créer des fonctions helper pour SEO et validation

---

### **PHASE 2 : CONFIGURATION DE L'URL REWRITING**

#### Étape 2.1 : Configurer nginx avec URL rewriting
- [ ] Modifier `nginx/default.conf` :
  - Rediriger toutes les requêtes vers `app/public/index.php`
  - Créer des règles de réécriture pour les slugs d'articles
  - Exemple : `/article/nom-article` → `index.php?page=article&slug=nom-article`
- [ ] Tester les routes locales

#### Étape 2.2 : Créer le routeur PHP
- [ ] Modifier `app/public/index.php` pour :
  - Parser les paramètres de la requête
  - Router vers FrontOffice ou BackOffice
  - Gérer les erreurs 404

---

### **PHASE 3 : FRONTOFFICE**

#### Étape 3.1 : Page d'accueil (`app/frontOffice/home.php`)
- [ ] **Structure HTML & SEO** :
  - ✅ Balise `<h1>` pour le titre principal (ex: "Informations sur la Guerre en Iran")
  - ✅ Balises `<h2>`, `<h3>` pour les sections
  - ✅ Balises méta : `<meta name="description">`, `<meta name="keywords">`, `<meta name="viewport">`
  - ✅ OpenGraph : `og:title`, `og:description`, `og:image`
  - ✅ Canonical tag
- [ ] Afficher les derniers articles
- [ ] Pagination ou "Lire plus"
- [ ] Navigation de qualité

#### Étape 3.2 : Page article (`app/frontOffice/article.php`)
- [ ] **SEO au niveau article** :
  - ✅ `<h1>` = titre de l'article
  - ✅ Balises méta dynamiques par article
  - ✅ Canonical tag unique
  - ✅ Structured data (Schema.org - Article)
- [ ] Récupérer l'article via slug depuis la BD
- [ ] Afficher : titre, date, contenu, images
- [ ] ✅ Alt text pour toutes les images
- [ ] Lien vers les articles similaires/associés
- [ ] Gestion des erreurs (article non trouvé = 404)

#### Étape 3.3 : Template de base (Layout)
- [ ] Créer `app/frontOffice/layout.php` ou header/footer
- [ ] Navigation cohérente
- [ ] Footer avec infos légales

---

### **PHASE 4 : BACKOFFICE**

#### Étape 4.1 : Authentification
- [ ] Créer `app/backOffice/login.php` :
  - Formulaire d'authentification
  - Hashage des mots de passe (password_hash)
  - Session PHP sécurisée
- [ ] Middleware de vérification d'accès

#### Étape 4.2 : Dashboard (`app/backOffice/dashboard.php`)
- [ ] Vue d'ensemble des articles
- [ ] Statistiques (nombre d'articles, visiteurs si analytics)
- [ ] Accès rapide à la création/édition

#### Étape 4.3 : Gestion des articles
- [ ] **Créer article** (`app/backOffice/article_add.php`) :
  - [ ] Formulaire : titre, contenu, image featured, description meta, keywords
  - [ ] Générateur de slug automatique (depuis le titre)
  - [ ] Validation des données (côté serveur)
  - [ ] Upload d'image (validation & stockage)

- [ ] **Éditer article** (`app/backOffice/article_edit.php`) :
  - [ ] Charger l'article depuis la BD
  - [ ] Modification du contenu
  - [ ] Mise à jour de `date_updated`

- [ ] **Supprimer article** (`app/backOffice/article_delete.php`) :
  - [ ] Confirmation de suppression
  - [ ] Suppression physique ou soft-delete (archivage)

- [ ] **Sauvegarder** (`app/backOffice/save_article.php`) :
  - [ ] Traiter la soumission du formulaire
  - [ ] Insérer ou mettre à jour en BD
  - [ ] Retour au listorique/dashboard

---

### **PHASE 5 : OPTIMISATION SEO & ACCESSIBILITÉ**

#### Étape 5.1 : SEO On-Page
- [ ] ✅ Tous les articles ont des titres `<h1>` uniques
- [ ] ✅ Meta descriptions < 160 caractères
- [ ] ✅ Meta keywords pertinents
- [ ] ✅ URL slugs explicites (ex: `/article/tensions-iran-2026`)
- [ ] ✅ Images with alt text descriptif
- [ ] ✅ Sitemap.xml (optionnel mais recommandé)
- [ ] ✅ Robots.txt

#### Étape 5.2 : Performance & Lighthouse
- [ ] Optimiser les images (format WebP, compression)
- [ ] Minifier CSS/JS
- [ ] Cacher les ressources (headers de cache)
- [ ] Lazy-loading pour les images

#### Étape 5.3 : Accessibilité
- [ ] Contraste des couleurs (WCAG AA minimum)
- [ ] Labels pour tous les inputs
- [ ] Navigation au clavier

---

### **PHASE 6 : TESTS & DÉPLOIEMENT**

#### Étape 6.1 : Lighthouse Testing
- [ ] **Desktop** :
  - [ ] Générer rapport Lighthouse en local
  - [ ] Vérifier Performance, Accessibility, Best Practices, SEO
  - [ ] Cible : Performance > 80, SEO 100

- [ ] **Mobile** :
  - [ ] Tester avec Chrome DevTools (iPhone/Android émulé)
  - [ ] Tester responsive design
  - [ ] Vérifier Core Web Vitals

#### Étape 6.2 : Tests de navigation
- [ ] Tester toutes les routes (URL rewriting)
- [ ] Vérifier les redirections 404
- [ ] Tester Back/Forward du navigateur
- [ ] Tester les formulaires du BackOffice

#### Étape 6.3 : Tests de sécurité basique
- [ ] Vérifier les injections SQL (prepared statements)
- [ ] Valider tous les inputs
- [ ] Protéger les cookies session (HttpOnly, Secure)
- [ ] CSRF tokens si nécessaire

---

## 🗂️ Structure des fichiers finaux

```
docker-compose.yml
app/
  ├── backOffice/
  │   ├── login.php
  │   ├── dashboard.php
  │   ├── article_add.php
  │   ├── article_edit.php
  │   ├── article_delete.php
  │   ├── save_article.php
  │   └── layout_admin.php
  ├── config/
  │   ├── db.php
  │   ├── utils.php
  │   └── config.php
  ├── frontOffice/
  │   ├── home.php
  │   ├── article.php
  │   └── layout.php
  ├── public/
  │   ├── index.php (routeur principal)
  │   ├── css/
  │   ├── js/
  │   └── images/
  └── uploads/ (images d'articles)
nginx/
  ├── default.conf (URL rewriting)
  └── Dockerfile
php/
  └── Dockerfile
postgres/
  └── init.sql
robots.txt
sitemap.xml
```

---

## 📋 Checklist - Critères de validation

### URL & Routing
- [ ] ✅ Toutes les URLs sont rewritées (pas d'extensions .php visibles)
- [ ] ✅ Slugs cohérents (tirets au lieu d'espaces)
- [ ] ✅ 404 personnalisée pour pages inexistantes

### Structure HTML & Sémantique
- [ ] ✅ Chaque page a UN `<h1>` principal
- [ ] ✅ Hiérarchie H2 → H3 → H4 respectée
- [ ] ✅ Pas de sauts de niveaux (ex: H1 → H3)
- [ ] ✅ Titles `<title>` uniques et descriptifs

### Balises Meta & SEO
- [ ] ✅ Meta description sur chaque page
- [ ] ✅ Meta keywords pertinents
- [ ] ✅ Canonical tags
- [ ] ✅ OpenGraph tags (og:title, og:description, og:image)
- [ ] ✅ Viewport meta pour mobile

### Images
- [ ] ✅ TOUS les `<img>` ont un alt text
- [ ] ✅ Images optimisées (< 500KB)
- [ ] ✅ Format moderne (WebP si possible)

### Lighthouse
- [ ] ✅ Desktop: Performance ≥ 80, SEO 100
- [ ] ✅ Mobile: Performance ≥ 70, SEO 100
- [ ] ✅ Core Web Vitals verts

### Sécurité Basique
- [ ] ✅ Prepared statements (pas de SQL injection)
- [ ] ✅ Input validation
- [ ] ✅ Protection de session

---

## 🚀 Commandes Docker utiles

```bash
# Lancer le projet
docker-compose up -d

# Arrêter
docker-compose down

# Voir les logs
docker-compose logs -f php

# Accéder au shell PostgreSQL
docker-compose exec postgres psql -U user -d dbname

# Reconstruire les images
docker-compose up -d --build
```

---

## 📝 Notes importantes

1. **URL Rewriting** : Doit être configuré dans nginx pour masquer les index.php
2. **SEO** : Chaque article doit avoir un slug unique en BD
3. **Images** : Stocker dans `/app/uploads/` et servir via URL rewritée
4. **Sécurité** : Toujours utiliser des prepared statements avec PDO
5. **Tests Lighthouse** : À faire local avant de pousser en production

---

## 📞 Recursos utiles

- [Google Search Central](https://search.google.com/search-console/)
- [Lighthouse Docs](https://developers.google.com/web/tools/lighthouse)
- [Schema.org](https://schema.org/) pour structured data
- [WCAG 2.1](https://www.w3.org/WAI/WCAG21/quickref/) pour accessibilité

---

**Bonne chance pour votre projet ! 🚀**
