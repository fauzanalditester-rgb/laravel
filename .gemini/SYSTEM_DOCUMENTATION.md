# Lagoi Bay Enterprise Management System
## Complete System Documentation v2.0

---

## 📋 1. DESKRIPSI SISTEM KESELURUHAN

**Lagoi Bay Management System** adalah aplikasi berbasis web untuk manajemen operasional perusahaan pertambangan/pengolahan material. Sistem ini mencakup:

- **Manajemen Material**: Timbangan, Raw Material, Keluar Material, Rekap Lebur
- **Manajemen Keuangan**: Penjualan, Laporan Kas, Pengajuan Kas, Hutang, Piutang
- **Manajemen User**: Role-based access control dengan 3 level akses

### Tech Stack
| Layer | Technology |
|-------|------------|
| Backend | Laravel 12 (PHP 8.2+) |
| Frontend | Blade + Alpine.js + Tailwind CSS 4 |
| Database | MySQL 8.0 |
| Authentication | Laravel Breeze + Spatie Permission |
| PDF Export | DomPDF |
| Excel Export | Laravel Excel (Maatwebsite) |

---

## 🔐 2. FLOWCHART ALUR LOGIN & ROLE

```
┌─────────────────────────────────────────────────────────────┐
│                      USER ACCESS FLOW                        │
└─────────────────────────────────────────────────────────────┘

    ┌──────────┐
    │  START   │
    └────┬─────┘
         │
         ▼
    ┌──────────────┐
    │ Login Form   │
    │ Email + Pass │
    └──────┬───────┘
           │
           ▼
    ┌──────────────────┐     NO     ┌─────────────┐
    │ Valid Credentials?├──────────►│ Error: 401  │
    └────────┬─────────┘            └─────────────┘
             │ YES
             ▼
    ┌──────────────────┐     NO     ┌─────────────┐
    │ User is Active?  ├──────────►│ Error: 403  │
    └────────┬─────────┘            └─────────────┘
             │ YES
             ▼
    ┌──────────────────┐
    │ Log Login Event  │
    │ (Activity Log)   │
    └────────┬─────────┘
             │
             ▼
    ┌──────────────────┐
    │ Check User Role  │
    └────────┬─────────┘
             │
    ┌────────┴────────┬─────────────────┐
    │                 │                 │
    ▼                 ▼                 ▼
┌────────┐      ┌─────────┐      ┌────────────┐
│ SUPER  │      │  ADMIN  │      │   KASIR    │
│ ADMIN  │      │         │      │            │
└────┬───┘      └────┬────┘      └─────┬──────┘
     │               │                 │
     ▼               ▼                 ▼
┌──────────┐   ┌──────────┐     ┌──────────────┐
│Full      │   │Material  │     │Keuangan Only │
│Access    │   │+ Limited │     │Penjualan     │
│All       │   │Finance   │     │Kas, Hutang   │
│Modules   │   │          │     │Piutang       │
└──────────┘   └──────────┘     └──────────────┘
```

---

## 📊 3. FLOW CRUD UNTUK TIAP MODUL

### Generic CRUD Flow (Berlaku untuk semua modul)

```
┌─────────────────────────────────────────────────────────────┐
│                    CRUD OPERATION FLOW                       │
└─────────────────────────────────────────────────────────────┘

[CREATE]
    User Request → Middleware Auth → Role Check → 
    Validate Input → Create Record → Log Activity → 
    Flash Success → Redirect to Index

[READ]
    User Request → Middleware Auth → Role Check →
    Query Builder (Search, Filter, Sort) → Paginate →
    Return View with Data

[UPDATE]
    User Request → Middleware Auth → Role Check →
    Find Record → Validate Input → Store Old Values →
    Update Record → Log Activity (with diff) →
    Flash Success → Redirect

[DELETE]
    User Request → Middleware Auth → Role Check →
    Find Record → Soft Delete → Log Activity →
    Flash Success → Redirect

[EXPORT]
    User Request → Middleware Auth → Role Check →
    Query All/Filtered Data → Generate PDF/Excel →
    Stream Download
```

---

## 🗄️ 4. ERD & STRUKTUR DATABASE

```
┌─────────────────────────────────────────────────────────────┐
│                    ENTITY RELATIONSHIP DIAGRAM               │
└─────────────────────────────────────────────────────────────┘

                          ┌──────────────┐
                          │    USERS     │
                          ├──────────────┤
                          │ id           │
                          │ name         │
                          │ email        │
                          │ password     │
                          │ is_active    │
                          │ timestamps   │
                          │ deleted_at   │
                          └──────┬───────┘
                                 │
           ┌─────────────────────┼─────────────────────┐
           │                     │                     │
           ▼                     ▼                     ▼
    ┌──────────────┐     ┌──────────────┐     ┌──────────────┐
    │    ROLES     │     │ PERMISSIONS  │     │ACTIVITY_LOGS │
    ├──────────────┤     ├──────────────┤     ├──────────────┤
    │ id           │     │ id           │     │ id           │
    │ name         │     │ name         │     │ user_id (FK) │
    │ guard_name   │     │ guard_name   │     │ action       │
    └──────────────┘     └──────────────┘     │ module       │
                                              │ description  │
                                              │ old_values   │
                                              │ new_values   │
                                              │ ip_address   │
                                              │ timestamps   │
                                              └──────────────┘

┌─────────────────────────────────────────────────────────────┐
│                    MATERIAL MODULES                          │
└─────────────────────────────────────────────────────────────┘

┌──────────────────┐   ┌──────────────────┐   ┌──────────────────┐
│ REKAP_TIMBANGANS │   │  RAW_MATERIALS   │   │ KELUAR_MATERIALS │
├──────────────────┤   ├──────────────────┤   ├──────────────────┤
│ id               │   │ id               │   │ id               │
│ tanggal          │   │ tanggal_terima   │   │ tanggal          │
│ nomor_kendaraan  │   │ supplier         │   │ tujuan           │
│ jenis_material   │   │ jenis_material   │   │ jenis_material   │
│ berat_masuk      │   │ jumlah           │   │ jumlah           │
│ berat_keluar     │   │ satuan           │   │ satuan           │
│ berat_bersih     │   │ harga_satuan     │   │ harga_satuan     │
│ keterangan       │   │ total_harga      │   │ total_harga      │
│ created_by (FK)  │   │ keterangan       │   │ keterangan       │
│ timestamps       │   │ created_by (FK)  │   │ created_by (FK)  │
│ deleted_at       │   │ timestamps       │   │ timestamps       │
└──────────────────┘   │ deleted_at       │   │ deleted_at       │
                       └──────────────────┘   └──────────────────┘

┌──────────────────┐   ┌──────────────────┐
│   REKAP_LEBURS   │   │REKAP_KELUAR_MAT  │
├──────────────────┤   ├──────────────────┤
│ id               │   │ id               │
│ tanggal          │   │ periode_awal     │
│ jenis_material   │   │ periode_akhir    │
│ berat_awal       │   │ total_keluar     │
│ berat_hasil      │   │ total_nilai      │
│ susut            │   │ keterangan       │
│ persentase_susut │   │ created_by (FK)  │
│ keterangan       │   │ timestamps       │
│ created_by (FK)  │   │ deleted_at       │
│ timestamps       │   └──────────────────┘
│ deleted_at       │
└──────────────────┘

┌─────────────────────────────────────────────────────────────┐
│                    FINANCE MODULES                           │
└─────────────────────────────────────────────────────────────┘

┌──────────────────┐   ┌──────────────────┐   ┌──────────────────┐
│   PENJUALANS     │   │   LAPORAN_KAS    │   │  PENGAJUAN_KAS   │
├──────────────────┤   ├──────────────────┤   ├──────────────────┤
│ id               │   │ id               │   │ id               │
│ nomor_invoice    │   │ tanggal          │   │ tanggal          │
│ tanggal          │   │ jenis (in/out)   │   │ keperluan        │
│ customer         │   │ kategori         │   │ jumlah           │
│ jenis_material   │   │ keterangan       │   │ status           │
│ jumlah           │   │ jumlah           │   │ approved_by (FK) │
│ satuan           │   │ saldo            │   │ approved_at      │
│ harga_satuan     │   │ created_by (FK)  │   │ keterangan       │
│ total_harga      │   │ timestamps       │   │ created_by (FK)  │
│ status_bayar     │   │ deleted_at       │   │ timestamps       │
│ keterangan       │   └──────────────────┘   │ deleted_at       │
│ created_by (FK)  │                          └──────────────────┘
│ timestamps       │
│ deleted_at       │
└──────────────────┘

┌──────────────────┐   ┌──────────────────┐
│     HUTANGS      │   │    PIUTANGS      │
├──────────────────┤   ├──────────────────┤
│ id               │   │ id               │
│ tanggal          │   │ tanggal          │
│ kreditur         │   │ debitur          │
│ keterangan       │   │ keterangan       │
│ jumlah           │   │ jumlah           │
│ jatuh_tempo      │   │ jatuh_tempo      │
│ status           │   │ status           │
│ tanggal_lunas    │   │ tanggal_lunas    │
│ created_by (FK)  │   │ created_by (FK)  │
│ timestamps       │   │ timestamps       │
│ deleted_at       │   │ deleted_at       │
└──────────────────┘   └──────────────────┘
```

---

## 🔌 5. API ENDPOINTS (Web Routes)

### Authentication
| Method | URI | Controller | Middleware |
|--------|-----|------------|------------|
| GET | /login | Auth\LoginController@create | guest |
| POST | /login | Auth\LoginController@store | guest |
| POST | /logout | Auth\LoginController@destroy | auth |
| GET | /register | Auth\RegisterController@create | guest |
| POST | /register | Auth\RegisterController@store | guest |

### Dashboard
| Method | URI | Controller | Middleware |
|--------|-----|------------|------------|
| GET | /dashboard | DashboardController@index | auth |

### User Management (Super Admin Only)
| Method | URI | Controller | Middleware |
|--------|-----|------------|------------|
| GET | /admin/users | Admin\UserController@index | auth, role:Super Admin |
| GET | /admin/users/create | Admin\UserController@create | auth, role:Super Admin |
| POST | /admin/users | Admin\UserController@store | auth, role:Super Admin |
| GET | /admin/users/{user}/edit | Admin\UserController@edit | auth, role:Super Admin |
| PUT | /admin/users/{user} | Admin\UserController@update | auth, role:Super Admin |
| DELETE | /admin/users/{user} | Admin\UserController@destroy | auth, role:Super Admin |
| POST | /admin/users/{user}/toggle | Admin\UserController@toggleStatus | auth, role:Super Admin |
| POST | /admin/users/{user}/reset-password | Admin\UserController@resetPassword | auth, role:Super Admin |

### Material Modules (Admin + Super Admin input, All read)
| Method | URI | Controller | Middleware |
|--------|-----|------------|------------|
| Resource | /rekap-timbangan | RekapTimbanganController | auth |
| Resource | /raw-material | RawMaterialController | auth |
| Resource | /keluar-material | KeluarMaterialController | auth |
| Resource | /rekap-keluar-material | RekapKeluarMaterialController | auth |
| Resource | /rekap-lebur | RekapLeburController | auth |
| GET | /{module}/export/pdf | *Controller@exportPdf | auth |
| GET | /{module}/export/excel | *Controller@exportExcel | auth |

### Finance Modules
| Method | URI | Controller | Middleware |
|--------|-----|------------|------------|
| Resource | /penjualan | PenjualanController | auth |
| Resource | /laporan-kas | LaporanKasController | auth, role:Kasir|Super Admin |
| Resource | /pengajuan-kas | PengajuanKasController | auth, role:Kasir|Super Admin |
| Resource | /hutang | HutangController | auth, role:Kasir|Super Admin |
| Resource | /piutang | PiutangController | auth, role:Kasir|Super Admin |

---

## 🛡️ 6. MIDDLEWARE & PERMISSION MATRIX

### Permission Matrix
| Module | Super Admin | Admin | Kasir |
|--------|:-----------:|:-----:|:-----:|
| User Management | ✅ CRUD | ❌ | ❌ |
| Rekap Timbangan | ✅ CRUD | ✅ CRUD | 👁️ Read |
| Raw Material | ✅ CRUD | ✅ CRUD | 👁️ Read |
| Keluar Material | ✅ CRUD | ✅ CRUD | 👁️ Read |
| Rekap Keluar | ✅ CRUD | ✅ CRUD | 👁️ Read |
| Rekap Lebur | ✅ CRUD | ✅ CRUD | 👁️ Read |
| Penjualan | ✅ CRUD | ✅ CRUD | ✅ CRUD |
| Laporan Kas | ✅ CRUD | 👁️ Read | ✅ CRUD |
| Pengajuan Kas | ✅ CRUD + Approve | ❌ | ✅ CRUD |
| Hutang | ✅ CRUD | ❌ | ✅ CRUD |
| Piutang | ✅ CRUD | ❌ | ✅ CRUD |

---

## 🔒 7. REKOMENDASI KEAMANAN

### SQL Injection Prevention
- ✅ Eloquent ORM (parameterized queries by default)
- ✅ Query Builder with bindings
- ✅ Input validation before database operations

### XSS Prevention
- ✅ Blade templating with `{{ }}` auto-escaping
- ✅ `{!! !!}` only for trusted content
- ✅ CSP Headers (Content Security Policy)

### CSRF Protection
- ✅ `@csrf` directive on all forms
- ✅ CSRF token validation middleware

### Password Security
- ✅ Bcrypt hashing (cost factor 12)
- ✅ Password strength validation (min 8 chars)
- ✅ Password confirmation on registration

### Session Security
- ✅ Database session driver
- ✅ Session regeneration on login
- ✅ Secure cookie flags (HttpOnly, Secure, SameSite)

### Role-Based Security
- ✅ Spatie Permission middleware
- ✅ Gate & Policy authorization
- ✅ Audit trail logging

---

## 🎨 8. UI MOCKUP SPECIFICATIONS

### Color Palette (Red + Gold Theme)
```css
Primary Red:    #DC2626 (Red-600)
Primary Dark:   #991B1B (Red-800)
Gold Accent:    #F59E0B (Amber-500)
Gold Light:     #FEF3C7 (Amber-100)
Background:     #F8FAFC (Slate-50)
Text Primary:   #1E293B (Slate-800)
Text Secondary: #64748B (Slate-500)
```

### Typography
- **Font Family**: Outfit (Google Fonts)
- **Headings**: Extra Bold, Tracking Tight
- **Labels**: Black, Uppercase, Wide Tracking

### Component Styles
- **Cards**: Glassmorphism with subtle borders
- **Buttons**: Gradient backgrounds with hover scale
- **Tables**: Clean borders, zebra striping on hover
- **Forms**: Rounded inputs with focus rings

---

## 🚀 9. DEPLOYMENT RECOMMENDATIONS

### Production Environment
```yaml
Server:
  - VPS: 2 vCPU, 4GB RAM minimum
  - OS: Ubuntu 22.04 LTS
  - Web Server: Nginx with PHP-FPM

Docker Stack:
  - PHP 8.2 Alpine
  - MySQL 8.0
  - Redis (for session/cache)
  - Nginx

SSL/Security:
  - Let's Encrypt SSL Certificate
  - Cloudflare CDN (optional)
  - WAF (Web Application Firewall)

Backup:
  - Daily MySQL dumps
  - Weekly full server snapshots
  - Off-site backup storage
```

### Docker Compose Example
```yaml
version: '3.8'
services:
  app:
    build: .
    ports:
      - "8000:8000"
    environment:
      - APP_ENV=production
      - DB_HOST=db
    depends_on:
      - db
      - redis
  
  db:
    image: mysql:8.0
    volumes:
      - mysql_data:/var/lib/mysql
    environment:
      - MYSQL_DATABASE=lagoi_bay
      - MYSQL_ROOT_PASSWORD=secret
  
  redis:
    image: redis:alpine

volumes:
  mysql_data:
```

---

## 📝 10. DRAFT PROPOSAL (Tema Merah-Emas)

### Executive Summary
Lagoi Bay Management System adalah solusi enterprise terintegrasi untuk manajemen operasional perusahaan. Dengan desain premium berwarna merah dan emas yang mencerminkan profesionalisme dan kemewahan, sistem ini menyediakan:

1. **Efisiensi Operasional**: Automasi pencatatan material dan keuangan
2. **Kontrol Akses Bertingkat**: 3 level user dengan permission granular
3. **Audit Trail Lengkap**: Pelacakan setiap perubahan data
4. **Reporting Komprehensif**: Export PDF/Excel untuk semua modul

### Return on Investment
- Pengurangan waktu input manual: 60%
- Akurasi data meningkat: 95%
- Real-time visibility operasional
- Paperless documentation

---

*Document Version: 2.0*
*Last Updated: February 2026*
*Author: Lagoi Bay Development Team*
