# Dokumentasi Sistem Informasi Perpustakaan Digital

Berikut adalah DFD Level 0, Flowchart Sistem, Use Case Diagram, Activity Diagram, Sequence diagram, dan Entity Relationship Diagram (ERD) untuk Sistem Informasi Perpustakaan Digital.

## 1. DFD Level 0 (Context Diagram)

```mermaid
graph TD
    Anggota([Anggota]) -- Data Pendaftaran, Kredensial Login, Permintaan Peminjaman --> SIP[Sistem Informasi Perpustakaan]
    SIP -- Info Buku, Status Peminjaman, Riwayat Peminjaman --> Anggota

    Petugas([Petugas]) -- Kredensial Login, Data Buku, Konfirmasi Peminjaman/Pengembalian --> SIP
    SIP -- Laporan Data Buku, Data Peminjaman --> Petugas

    Admin([Admin]) -- Kredensial Login, Kelola Akun Users, Kelola Pegawai, Kelola Anggota --> SIP
    SIP -- Laporan Keseluruhan, Status Users --> Admin
```

## 2. Flowchart Sistem (Alur Peminjaman Buku)

```mermaid
flowchart TD
    A([Mulai]) --> B{Login}
    B -- Anggota --> C[Lihat Katalog Buku]
    C --> D[Pilih Buku & Request Pinjam]
    D --> E[Sistem Mencatat Status: Pending/Pinjam]
    B -- Petugas --> F[Lihat Daftar Peminjaman]
    E --> F
    F --> G[Verifikasi & Berikan Buku ke Anggota]
    G --> H[Anggota Membaca Buku]
    H --> I[Anggota Mengembalikan Buku]
    I --> J[Petugas Konfirmasi Pengembalian di Sistem]
    J --> K[Sistem Update Stok Buku & Status Kembali]
    K --> L([Selesai])
```

## 3. Use Case Diagram

```plantuml
@startuml
left to right direction
actor Admin
actor Petugas
actor Anggota

rectangle "Sistem Informasi Perpustakaan" {
  usecase "Login" as UC1
  usecase "Kelola Data Master (Users, Pegawai, Anggota)" as UC2
  usecase "Kelola Data Buku" as UC3
  usecase "Kelola Peminjaman" as UC4
  usecase "Lihat Katalog Buku" as UC5
  usecase "Lihat Riwayat Peminjaman" as UC6
  usecase "Pinjam Buku" as UC7
}

Admin --> UC1
Admin --> UC2
Admin --> UC3
Admin --> UC4

Petugas --> UC1
Petugas --> UC3
Petugas --> UC4

Anggota --> UC1
Anggota --> UC5
Anggota --> UC6
Anggota --> UC7
@enduml
```

## 4. Activity Diagram (Peminjaman Buku)

```mermaid
stateDiagram-v2
    [*] --> Login
    Login --> Anggota_Dashboard: Role Anggota
    Anggota_Dashboard --> Pilih_Buku
    Pilih_Buku --> Request_Pinjam
    Request_Pinjam --> Petugas_Dashboard: Sistem Meneruskan Request

    state Petugas_Dashboard {
        Verifikasi_Peminjaman
        Update_Status_Dipinjam
    }

    Update_Status_Dipinjam --> Anggota_Terima_Buku
    Anggota_Terima_Buku --> Kembalikan_Buku
    Kembalikan_Buku --> Petugas_Update_Pengembalian
    Petugas_Update_Pengembalian --> [*]
```

## 5. Sequence Diagram (Proses Login dan Peminjaman)

```mermaid
sequenceDiagram
    actor Anggota
    participant GUI as Antarmuka Sistem
    participant DB as Database (Users & Peminjaman)
    actor Petugas

    Anggota->>GUI: Masukkan NIS & Password (NISN)
    GUI->>DB: Validasi Kredensial
    DB-->>GUI: Login Berhasil (Role: Anggota)
    GUI-->>Anggota: Tampilkan Dashboard & Katalog Buku

    Anggota->>GUI: Pilih Buku & Klik Pinjam
    GUI->>DB: Insert Peminjaman & Kurangi Stok Buku
    DB-->>GUI: Berhasil
    GUI-->>Anggota: Tampilkan Status Peminjaman (Berhasil)

    Petugas->>GUI: Buka Halaman Kelola Peminjaman
    GUI->>DB: Ambil Data Peminjaman
    DB-->>GUI: Tampilkan Data Peminjaman
    GUI-->>Petugas: Daftar Anggota yang Meminjam
    Petugas->>GUI: Konfirmasi Pengembalian Buku
    GUI->>DB: Update Status Peminjaman & Tambah Stok Buku
    DB-->>GUI: Sukses
    GUI-->>Petugas: Status Terupdate
```

## 6. Entity Relationship Diagram (ERD)

```mermaid
erDiagram
    USERS ||--o| ANGGOTA : "has"
    USERS ||--o| PEGAWAI : "has"
    ANGGOTA ||--o{ PEMINJAMAN : "makes"
    PEGAWAI ||--o{ PEMINJAMAN : "processes"
    BUKU ||--o{ PEMINJAMAN : "is included in"

    USERS {
        int id_user PK
        string username
        string password
        string level
    }
    ANGGOTA {
        string ID_Anggota PK
        string Nama
        string NIS
        string nisn
        string Alamat
        string Nomor_HP
        string gender
        int id_user FK
    }
    PEGAWAI {
        string nip PK
        string username
        string nama
        string alamat
        string gender
        string level
        string nomor_hp
        int id_user FK
    }
    BUKU {
        string isbn PK
        string judul
        string pengarang
        string penerbit
        string tahun
        string genre
        int stok
    }
    PEMINJAMAN {
        string ID_Peminjaman PK
        string ID_Anggota FK
        string isbn FK
        string nip_petugas FK
        date tgl_pinjam
        date tgl_kembali
        string status
    }
```