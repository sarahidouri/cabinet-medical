# 🏥 Cabinet Médical

Application Web de gestion des rendez-vous d'un cabinet médical.
Développée avec Laravel 13, Blade, Tailwind CSS et Axios.

---

## 🚀 Installation

```bash
# 1. Cloner le projet
git clone https://github.com/sarahidouri/cabinet-medical.git
cd cabinet-medical

# 2. Installer les dépendances
composer install
npm install

# 3. Configurer l'environnement
cp .env.example .env
php artisan key:generate

# 4. Configurer la base de données dans .env
DB_DATABASE=cabinet_medical
DB_USERNAME=root
DB_PASSWORD=

# 5. Migrer et seeder
php artisan migrate --seed

# 6. Lancer le projet
php artisan serve
npm run dev
```

---

## 🔑 Identifiants par défaut

| Rôle | Email | Password |
|---|---|---|
| Patient | patient@test.com | password |
| Médecin | medecin@test.com | password |

---

## 🔌 API Endpoints

| Méthode | Endpoint | Description |
|---|---|---|
| GET | `/api/appointments` | Liste tous les rendez-vous |
| POST | `/api/appointments` | Créer un nouveau rendez-vous |

### Exemple POST /api/appointments
```json
{
    "patient_id": 1,
    "medecin_id": 2,
    "service_id": 1,
    "appointment_date": "2026-05-01 10:00:00",
    "notes": "Première consultation"
}
```

---

## 🌍 Langues disponibles
- Français 🇫🇷
- Arabe 🇲🇦

---

## 🛠️ Technologies utilisées
- Laravel 13
- Blade + Tailwind CSS
- Axios
- Laravel Breeze
- Mailtrap