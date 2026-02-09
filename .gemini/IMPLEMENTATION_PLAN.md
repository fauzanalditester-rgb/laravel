# 📋 IMPLEMENTATION PLAN - Sistem Manajemen Perusahaan "Lagoi Bay"

## 🎯 Deskripsi Sistem Keseluruhan

Sistem Manajemen Perusahaan berbasis web yang dirancang untuk mengelola operasional bisnis meliputi:
- Pengelolaan material (timbangan, raw material, keluar material)
- Transaksi keuangan (penjualan, kas, hutang, piutang)
- Manajemen user dengan role-based access control
- Pelaporan dan audit trail

### Tech Stack
- **Backend**: Laravel 12 (PHP 8.2+)
- **Frontend**: Blade Templates + Alpine.js + Tailwind CSS
- **Database**: MySQL 8.0
- **Authentication**: Laravel Breeze + Spatie Laravel-Permission
- **Export**: Laravel Excel + DomPDF
- **UI Theme**: Merah (#DC2626) + Emas (#F59E0B)

---

## 🔐 1. Flowchart Alur Login & Role

```
┌─────────────────┐
│   User Access   │
│    Website      │
└────────┬────────┘
         │
         ▼
┌─────────────────┐
│  Login Page     │
│  (Email/Pass)   │
└────────┬────────┘
         │
         ▼
┌─────────────────┐     NO      ┌─────────────────┐
│  Validate       │────────────▶│  Error Message  │
│  Credentials    │             │  + Log Failed   │
└────────┬────────┘             └─────────────────┘
         │ YES
         ▼
┌─────────────────┐
│  Check Role     │
└────────┬────────┘
         │
    ┌────┼────┬────────────────┐
    ▼    ▼    ▼                ▼
┌──────┐┌──────┐┌──────┐  ┌──────────┐
│Admin ││Kasir ││Super │  │ Log      │
│Dash  ││Dash  ││Admin │  │ Activity │
└──────┘└──────┘└──────┘  └──────────┘
```

### Role Permissions Matrix

| Modul                  | Super Admin | Admin | Kasir |
|------------------------|:-----------:|:-----:|:-----:|
| User Management        | ✅ CRUD     | ❌    | ❌    |
| Rekap Timbangan        | ✅ View     | ✅ CRUD | ✅ View |
| Terima Raw Material    | ✅ View     | ✅ CRUD | ✅ View |
| Rekap Keluar Material  | ✅ View     | ✅ CRUD | ✅ View |
| Keluar Material        | ✅ View     | ✅ CRUD | ✅ View |
| Penjualan Material     | ✅ View     | ✅ CRUD | ✅ CRUD |
| Laporan Kas            | ✅ CRUD     | ❌    | ✅ CRUD |
| Pengajuan Kas          | ✅ CRUD     | ❌    | ✅ CRUD |
| Rekap Lebur            | ✅ View     | ✅ CRUD | ✅ View |
| Hutang                 | ✅ CRUD     | ❌    | ✅ CRUD |
| Piutang                | ✅ CRUD     | ❌    | ✅ CRUD |

---

## 📊 2. ERD & Struktur Database

### Entity Relationship Diagram

```
┌──────────────┐       ┌──────────────────┐
│    users     │       │      roles       │
├──────────────┤       ├──────────────────┤
│ id           │◄──┐   │ id               │
│ name         │   │   │ name             │
│ email        │   │   │ guard_name       │
│ password     │   │   └──────────────────┘
│ is_active    │   │            │
│ created_at   │   │            │
│ updated_at   │   │   ┌──────────────────┐
│ deleted_at   │   │   │  model_has_roles │
└──────────────┘   │   ├──────────────────┤
        │          └───│ model_id         │
        │              │ role_id          │
        ▼              └──────────────────┘
┌──────────────────┐
│  activity_logs   │
├──────────────────┤
│ id               │
│ user_id (FK)     │
│ action           │
│ module           │
│ description      │
│ old_values       │
│ new_values       │
│ ip_address       │
│ created_at       │
└──────────────────┘

┌──────────────────┐    ┌──────────────────┐
│ rekap_timbangan  │    │ raw_materials    │
├──────────────────┤    ├──────────────────┤
│ id               │    │ id               │
│ tanggal          │    │ tanggal_terima   │
│ nomor_kendaraan  │    │ supplier         │
│ jenis_material   │    │ jenis_material   │
│ berat_masuk      │    │ jumlah           │
│ berat_keluar     │    │ satuan           │
│ berat_bersih     │    │ harga_satuan     │
│ keterangan       │    │ total_harga      │
│ created_by       │    │ keterangan       │
│ created_at       │    │ created_by       │
│ updated_at       │    │ created_at       │
│ deleted_at       │    │ updated_at       │
└──────────────────┘    │ deleted_at       │
                        └──────────────────┘

┌──────────────────┐    ┌──────────────────┐
│ keluar_materials │    │rekap_keluar_mat  │
├──────────────────┤    ├──────────────────┤
│ id               │    │ id               │
│ tanggal          │    │ periode_awal     │
│ tujuan           │    │ periode_akhir    │
│ jenis_material   │    │ total_keluar     │
│ jumlah           │    │ total_nilai      │
│ satuan           │    │ keterangan       │
│ harga_satuan     │    │ created_by       │
│ total_harga      │    │ created_at       │
│ keterangan       │    │ updated_at       │
│ created_by       │    │ deleted_at       │
│ created_at       │    └──────────────────┘
│ updated_at       │
│ deleted_at       │
└──────────────────┘

┌──────────────────┐    ┌──────────────────┐
│   penjualans     │    │   laporan_kas    │
├──────────────────┤    ├──────────────────┤
│ id               │    │ id               │
│ nomor_invoice    │    │ tanggal          │
│ tanggal          │    │ jenis (in/out)   │
│ customer         │    │ kategori         │
│ jenis_material   │    │ keterangan       │
│ jumlah           │    │ jumlah           │
│ satuan           │    │ saldo            │
│ harga_satuan     │    │ created_by       │
│ total_harga      │    │ created_at       │
│ status_bayar     │    │ updated_at       │
│ keterangan       │    │ deleted_at       │
│ created_by       │    └──────────────────┘
│ created_at       │
│ updated_at       │
│ deleted_at       │
└──────────────────┘

┌──────────────────┐    ┌──────────────────┐
│  pengajuan_kas   │    │   rekap_lebur    │
├──────────────────┤    ├──────────────────┤
│ id               │    │ id               │
│ tanggal          │    │ tanggal          │
│ keperluan        │    │ jenis_material   │
│ jumlah           │    │ berat_awal       │
│ status           │    │ berat_hasil      │
│ approved_by      │    │ susut            │
│ approved_at      │    │ persentase_susut │
│ keterangan       │    │ keterangan       │
│ created_by       │    │ created_by       │
│ created_at       │    │ created_at       │
│ updated_at       │    │ updated_at       │
│ deleted_at       │    │ deleted_at       │
└──────────────────┘    └──────────────────┘

┌──────────────────┐    ┌──────────────────┐
│     hutangs      │    │    piutangs      │
├──────────────────┤    ├──────────────────┤
│ id               │    │ id               │
│ tanggal          │    │ tanggal          │
│ kreditur         │    │ debitur          │
│ keterangan       │    │ keterangan       │
│ jumlah           │    │ jumlah           │
│ jatuh_tempo      │    │ jatuh_tempo      │
│ status           │    │ status           │
│ tanggal_lunas    │    │ tanggal_lunas    │
│ created_by       │    │ created_by       │
│ created_at       │    │ created_at       │
│ updated_at       │    │ updated_at       │
│ deleted_at       │    │ deleted_at       │
└──────────────────┘    └──────────────────┘
```

---

## 🔌 3. API Endpoints

### Authentication
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/login` | Show login form |
| POST | `/login` | Process login |
| POST | `/logout` | Logout user |
| GET | `/register` | Show register form |
| POST | `/register` | Process registration |

### User Management (Super Admin Only)
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/admin/users` | List all users |
| GET | `/admin/users/create` | Create user form |
| POST | `/admin/users` | Store new user |
| GET | `/admin/users/{id}/edit` | Edit user form |
| PUT | `/admin/users/{id}` | Update user |
| DELETE | `/admin/users/{id}` | Soft delete user |
| POST | `/admin/users/{id}/toggle-status` | Activate/deactivate |
| POST | `/admin/users/{id}/reset-password` | Reset password |

### Rekap Timbangan
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET | `/rekap-timbangan` | List with pagination |
| GET | `/rekap-timbangan/create` | Create form |
| POST | `/rekap-timbangan` | Store |
| GET | `/rekap-timbangan/{id}/edit` | Edit form |
| PUT | `/rekap-timbangan/{id}` | Update |
| DELETE | `/rekap-timbangan/{id}` | Soft delete |
| GET | `/rekap-timbangan/export/pdf` | Export PDF |
| GET | `/rekap-timbangan/export/excel` | Export Excel |

### (Pattern yang sama untuk modul lainnya)
- `/raw-materials` - Terima Raw Material
- `/rekap-keluar-material` - Rekap Keluar Material
- `/keluar-material` - Keluar Material
- `/penjualan` - Penjualan Material
- `/laporan-kas` - Laporan Kas
- `/pengajuan-kas` - Pengajuan Kas
- `/rekap-lebur` - Rekap Lebur
- `/hutang` - Hutang
- `/piutang` - Piutang

---

## 🛡️ 4. Rekomendasi Keamanan

### SQL Injection Protection
- ✅ Gunakan Eloquent ORM (parameterized queries)
- ✅ Validasi input dengan Laravel Validator
- ✅ Escape output dengan Blade `{{ }}`

### XSS Protection
- ✅ Blade auto-escaping
- ✅ Content Security Policy headers
- ✅ Sanitize user input

### CSRF Protection
- ✅ Laravel `@csrf` directive
- ✅ Verify CSRF token middleware

### Password Security
- ✅ Bcrypt hashing (cost 12)
- ✅ Password complexity rules
- ✅ Rate limiting login attempts

### Role-Based Access
- ✅ Spatie Laravel-Permission
- ✅ Middleware protection
- ✅ Policy-based authorization

---

## 🎨 5. Desain UI Theme

### Color Palette (Merah + Emas)
```css
:root {
  /* Primary - Merah */
  --primary-50: #fef2f2;
  --primary-100: #fee2e2;
  --primary-500: #ef4444;
  --primary-600: #dc2626;
  --primary-700: #b91c1c;
  --primary-800: #991b1b;
  --primary-900: #7f1d1d;
  
  /* Secondary - Emas */
  --gold-50: #fffbeb;
  --gold-100: #fef3c7;
  --gold-400: #fbbf24;
  --gold-500: #f59e0b;
  --gold-600: #d97706;
  --gold-700: #b45309;
  
  /* Neutral */
  --gray-50: #f9fafb;
  --gray-100: #f3f4f6;
  --gray-800: #1f2937;
  --gray-900: #111827;
}
```

### UI Components
- Sidebar: Dark dengan aksen emas
- Header: Merah gradient
- Cards: White dengan shadow
- Buttons: Merah (primary), Emas (secondary)
- Tables: Striped dengan hover effect

---

## 🚀 6. Deployment Recommendation

### Development
```bash
php artisan serve
npm run dev
```

### Production (VPS)
1. **Server**: Ubuntu 22.04 LTS
2. **Web Server**: Nginx
3. **PHP**: PHP 8.2-FPM
4. **Database**: MySQL 8.0
5. **SSL**: Let's Encrypt (Certbot)
6. **Process Manager**: Supervisor

### Docker (Optional)
```yaml
# docker-compose.yml
services:
  app:
    build: .
    ports:
      - "80:80"
  mysql:
    image: mysql:8.0
    volumes:
      - mysql_data:/var/lib/mysql
  redis:
    image: redis:alpine
```

---

## 📅 7. Implementation Phases

### Phase 1: Foundation (Day 1-2)
- [x] Setup Laravel project
- [ ] Install dependencies (Breeze, Spatie, etc.)
- [ ] Configure database (MySQL)
- [ ] Create migrations
- [ ] Setup authentication
- [ ] Implement role & permission

### Phase 2: Core Modules (Day 3-5)
- [ ] User Management CRUD
- [ ] Rekap Timbangan CRUD
- [ ] Raw Material CRUD
- [ ] Keluar Material CRUD
- [ ] Rekap Keluar Material CRUD

### Phase 3: Financial Modules (Day 6-8)
- [ ] Penjualan CRUD
- [ ] Laporan Kas CRUD
- [ ] Pengajuan Kas CRUD
- [ ] Hutang CRUD
- [ ] Piutang CRUD
- [ ] Rekap Lebur CRUD

### Phase 4: Features & Polish (Day 9-10)
- [ ] Export PDF/Excel
- [ ] Audit Trail
- [ ] Dashboard statistics
- [ ] Search & Filter
- [ ] UI/UX polish
- [ ] Testing & Bug fixes

---

## ✅ Checklist Sebelum Deploy

- [ ] Environment variables configured
- [ ] Database migrations run
- [ ] Seeders for roles/permissions
- [ ] Default Super Admin account
- [ ] SSL certificate installed
- [ ] Error logging configured
- [ ] Backup strategy in place
- [ ] Performance optimized (caching)
