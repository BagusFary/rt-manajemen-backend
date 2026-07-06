# Panduan Instalasi (Backend): Sistem Informasi Manajemen RT (SIM RT)


### Requirement 
Sebelum memulai, pastikan perangkat Anda sudah terinstal:
*   **PHP** (v8.1 atau lebih baru)
*   **Composer**
*   **Node.js** (LTS version) & **NPM**
*   **Database Server** (MySQL)

---

### 1. Setup Backend (Laravel API)

Langkah-langkah untuk menyiapkan environment server backend:

1.  **Clone Repository**
    ```bash
    git clone https://github.com/BagusFary/rt-manajemen-backend.git
    cd rt-manajemen-backend
    ```

2.  **Install Dependensi PHP**
    ```bash
    composer install
    ```

3. **Konfigurasi Environment**

    Salin file konfigurasi sesuai dengan terminal yang digunakan, lalu generate application key.

    **Linux / macOS / Git Bash / WSL**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

    **Windows Command Prompt (CMD)**
    ```cmd
    copy .env.example .env
    php artisan key:generate
    ```

    **Windows PowerShell**
    ```powershell
    Copy-Item .env.example .env
    php artisan key:generate
    ```

4.  **Konfigurasi Database**
    *   Buat database baru di MySQL (misal: `db_sim_rt`).
    *   Buka file `.env` dan sesuaikan kredensial database Anda:
    ```env
    DB_DATABASE=db_sim_rt
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5.  **Migrate & Seed**
    Jalankan migrasi tabel beserta data dummy untuk pengujian:
    ```bash
    php artisan migrate --seed
    ```

6.  **Storage Link** :
    ```bash
    php artisan storage:link
    ```

7.  **Jalankan Server Backend**
    ```bash
    php artisan serve
    ```
    *API sekarang berjalan di: `http://127.0.0.1:8000`*

---
*Dokumentasi ini disusun secara profesional untuk keperluan Skill Fit Test PT. Beon Intermedia .*
