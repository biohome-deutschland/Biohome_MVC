# Biohome MVC – Website

PHP MVC-Webanwendung für [biohome-filter-material.de](https://biohome-filter-material.de).

## Voraussetzungen

- [Git](https://git-scm.com/)
- [Docker Desktop](https://www.docker.com/products/docker-desktop/)
- (Optional lokal) PHP 8.1+, MySQL 8

## Lokale Entwicklungsumgebung einrichten

### 1. Repository klonen

```bash
git clone https://github.com/DEIN-USERNAME/biohome-mvc.git
cd biohome-mvc
```

> **Hinweis:** Den GitHub-Link mit deinem echten Benutzernamen und Repository-Namen ersetzen.

### 2. Umgebungsvariablen einrichten

```bash
# .env.example kopieren und anpassen
cp .env.example .env
```

Öffne `.env` und trage die echten Werte ein:

| Variable | Beschreibung |
|---|---|
| `DB_HOST` | Datenbank-Host (Standard: `db` für Docker) |
| `DB_NAME` | Datenbank-Name |
| `DB_USER` | Datenbank-Benutzer |
| `DB_PASS` | Datenbank-Passwort |
| `APP_URL` | URL der Anwendung |
| `ADMIN_USERNAME` | Admin E-Mail-Adresse |
| `ADMIN_PASSWORD_HASH` | Bcrypt-Hash des Admin-Passworts |

**Admin-Passwort-Hash generieren:**
```bash
php -r "echo password_hash('DeinPasswort', PASSWORD_BCRYPT) . PHP_EOL;"
```

### 3. Docker starten

```bash
docker-compose up -d
```

Die Anwendung ist dann erreichbar unter:
- **Frontend:** http://localhost/Biohome_MVC/Biohome_New_App/public
- **Admin:** http://localhost/Biohome_MVC/Biohome_New_App/public/admin

### 4. Datenbank importieren

Beim ersten Start wird die Datenbank automatisch angelegt. Um einen Dump einzuspielen:

```bash
docker exec -i biohome_db mysql -uroot -psecret biohome_db < database/dump.sql
```

---

## Projektstruktur

```
Biohome_New_App/
├── Core/              # Framework-Kernklassen (Router, Controller, Model, EnvLoader)
├── app/
│   ├── Controllers/   # Request-Handler
│   ├── Models/        # Datenbankmodelle
│   └── Views/         # PHP-Templates
├── config/
│   └── config.php     # Konfiguration (liest aus .env)
├── public/            # Web-Root (index.php, CSS, Assets)
├── routes/
│   └── web.php        # Routendefinitionen
├── .env               # Lokale Umgebungsvariablen (NICHT im Git!)
├── .env.example       # Template für .env
└── docker-compose.yml # Docker-Konfiguration
```

---

## Versionsverwaltung (Git Workflow)

```bash
# Änderungen anzeigen
git status

# Dateien stagen
git add .

# Commit erstellen
git commit -m "Kurze, beschreibende Nachricht auf Englisch"

# Auf GitHub pushen
git push origin main
```

**Auf einem anderen Rechner aktualisieren:**
```bash
git pull origin main
```

---

## Sicherheitshinweise

- **Niemals** die `.env`-Datei committen oder teilen
- Die `.env`-Datei ist in `.gitignore` ausgeschlossen
- Admin-Passwörter nur als Bcrypt-Hash speichern
