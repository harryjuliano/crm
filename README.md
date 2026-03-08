## CRM Lead-to-Invoice (Laravel + Inertia + React)
Project ini telah diarahkan dari starter-kit menjadi fondasi aplikasi **CRM Sales & Marketing** untuk alur:

**Lead → Opportunity → Quotation (+ Approval) → Sales/Service Order → Fulfillment → Invoice → Payment/Complaint/Feedback**.

## Teknologi
- Laravel 11
- Inertia.js
- React.js
- Tailwind CSS
- Spatie Roles & Permissions

## Cakupan Implementasi Saat Ini
Implementasi pada commit ini fokus pada **struktur database dan model inti** agar siap dikembangkan bertahap:
- Master data CRM (company, branch, customer, produk/jasa, tax, dll)
- CRM operasional (lead, activities polymorphic, opportunity)
- Penawaran & approval
- Order barang dan jasa + fulfillment
- Billing (invoice + payment)
- Quality & control (complaint, feedback, attachment, reminder, audit log, document numbering)
- Penguatan tabel users untuk kebutuhan operasional sales/marketing

## Instalasi
1. Clone repository.
2. Copy `.env.example` jadi `.env` lalu konfigurasi database.
3. Jalankan `composer install`.
4. Jalankan `php artisan key:generate`.
5. Jalankan `npm install`.
6. Jalankan migration: `php artisan migrate`.
7. Jalankan aplikasi: `php artisan serve` dan `npm run dev`.

## Catatan
- Relasi Eloquent inti sudah disiapkan untuk `Customer`, `Lead`, `Opportunity`, `Quotation`, dan `Invoice`.
- Struktur migration disusun modular untuk memudahkan pengembangan fase MVP lanjutan.
