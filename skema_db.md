-- =====================================================================
-- Skema Database Website Company Profile & Blog YISI
-- Target: PostgreSQL 14+  (untuk MySQL: ganti UUID->CHAR(36)/BIGINT AI,
-- TIMESTAMPTZ->DATETIME, JSONB->JSON, hapus CREATE TYPE & ganti ke ENUM)
-- =====================================================================
-- Implementasi aplikasi: Laravel migrations menjadi sumber skema yang
-- dijalankan; dokumen SQL ini dipertahankan sebagai referensi struktur
-- data dan target produksi PostgreSQL. Pengembangan lokal memakai SQLite.
-- Peran CMS dijalankan melalui Laravel Policies dan akses Filament.

CREATE EXTENSION IF NOT EXISTS pgcrypto;  -- gen_random_uuid()

-- ---------- Tipe enum ----------
CREATE TYPE user_role      AS ENUM ('admin', 'editor', 'author');
CREATE TYPE publish_status AS ENUM ('draft', 'review', 'scheduled', 'published', 'archived');
CREATE TYPE program_status AS ENUM ('planned', 'ongoing', 'completed');
CREATE TYPE message_status AS ENUM ('new', 'read', 'replied', 'spam');
CREATE TYPE doc_type       AS ENUM ('laporan', 'kajian', 'legalitas', 'lainnya');

-- ---------- Fungsi updated_at otomatis ----------
CREATE OR REPLACE FUNCTION set_updated_at() RETURNS trigger AS $$
BEGIN NEW.updated_at = now(); RETURN NEW; END;
$$ LANGUAGE plpgsql;

-- =====================================================================
-- 1. PENGGUNA CMS
-- =====================================================================
CREATE TABLE users (
  id             UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  name           VARCHAR(120) NOT NULL,
  email          VARCHAR(190) NOT NULL UNIQUE,
  password_hash  VARCHAR(255) NOT NULL,
  role           user_role NOT NULL DEFAULT 'author',
  totp_secret    VARCHAR(64),                 -- 2FA untuk admin
  is_active      BOOLEAN NOT NULL DEFAULT TRUE,
  last_login_at  TIMESTAMPTZ,
  created_at     TIMESTAMPTZ NOT NULL DEFAULT now(),
  updated_at     TIMESTAMPTZ NOT NULL DEFAULT now()
);

-- =====================================================================
-- 2. PUSTAKA MEDIA (gambar, dokumen)
-- =====================================================================
CREATE TABLE media (
  id           UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  file_name    VARCHAR(255) NOT NULL,
  url          VARCHAR(500) NOT NULL,
  mime_type    VARCHAR(100) NOT NULL,
  size_bytes   BIGINT,
  width        INT,
  height       INT,
  alt_text     VARCHAR(255),                  -- wajib untuk gambar (aksesibilitas)
  credit       VARCHAR(190),                  -- fotografer / sumber
  consent_ok   BOOLEAN NOT NULL DEFAULT FALSE,-- izin subjek foto (anak, disabilitas, dll.)
  uploaded_by  UUID REFERENCES users(id) ON DELETE SET NULL,
  created_at   TIMESTAMPTZ NOT NULL DEFAULT now(),
  CONSTRAINT chk_alt_gambar CHECK (mime_type NOT LIKE 'image/%' OR alt_text IS NOT NULL)
);

-- =====================================================================
-- 3. BLOG / BERITA
-- =====================================================================
CREATE TABLE post_categories (
  id          SMALLSERIAL PRIMARY KEY,
  name        VARCHAR(100) NOT NULL,
  slug        VARCHAR(120) NOT NULL UNIQUE,
  description VARCHAR(255),
  sort_order  SMALLINT NOT NULL DEFAULT 0
);

CREATE TABLE tags (
  id    SERIAL PRIMARY KEY,
  name  VARCHAR(80) NOT NULL,
  slug  VARCHAR(100) NOT NULL UNIQUE
);

CREATE TABLE posts (
  id              UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  title           VARCHAR(220) NOT NULL,
  slug            VARCHAR(240) NOT NULL UNIQUE,
  excerpt         VARCHAR(400),
  content         TEXT NOT NULL,              -- HTML/Markdown dari editor
  cover_media_id  UUID REFERENCES media(id) ON DELETE SET NULL,
  category_id     SMALLINT REFERENCES post_categories(id) ON DELETE SET NULL,
  author_id       UUID REFERENCES users(id) ON DELETE SET NULL,
  status          publish_status NOT NULL DEFAULT 'draft',
  published_at    TIMESTAMPTZ,
  is_featured     BOOLEAN NOT NULL DEFAULT FALSE,
  seo_title       VARCHAR(160),
  seo_description VARCHAR(300),
  view_count      INT NOT NULL DEFAULT 0,
  created_at      TIMESTAMPTZ NOT NULL DEFAULT now(),
  updated_at      TIMESTAMPTZ NOT NULL DEFAULT now()
);
CREATE INDEX idx_posts_list ON posts (status, published_at DESC);
CREATE INDEX idx_posts_category ON posts (category_id);
CREATE INDEX idx_posts_search ON posts
  USING GIN (to_tsvector('indonesian', title || ' ' || coalesce(excerpt,'') || ' ' || content));

CREATE TABLE post_tags (
  post_id UUID NOT NULL REFERENCES posts(id) ON DELETE CASCADE,
  tag_id  INT  NOT NULL REFERENCES tags(id)  ON DELETE CASCADE,
  PRIMARY KEY (post_id, tag_id)
);

CREATE TABLE post_revisions (               -- riwayat revisi & pemulihan versi
  id         UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  post_id    UUID NOT NULL REFERENCES posts(id) ON DELETE CASCADE,
  title      VARCHAR(220) NOT NULL,
  content    TEXT NOT NULL,
  edited_by  UUID REFERENCES users(id) ON DELETE SET NULL,
  created_at TIMESTAMPTZ NOT NULL DEFAULT now()
);
CREATE INDEX idx_revisions_post ON post_revisions (post_id, created_at DESC);

-- =====================================================================
-- 4. PILAR, MITRA, PROGRAM
-- =====================================================================
CREATE TABLE pillars (                      -- 3 pilar YISI (data tetap, di-seed)
  id          SMALLSERIAL PRIMARY KEY,
  name        VARCHAR(120) NOT NULL,
  slug        VARCHAR(120) NOT NULL UNIQUE,
  summary     VARCHAR(500),
  color_hex   CHAR(7),
  sort_order  SMALLINT NOT NULL DEFAULT 0
);

CREATE TABLE partners (
  id             UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  name           VARCHAR(190) NOT NULL,
  slug           VARCHAR(200) NOT NULL UNIQUE,
  logo_media_id  UUID REFERENCES media(id) ON DELETE SET NULL,
  website_url    VARCHAR(300),
  partner_type   VARCHAR(60),                 -- korporasi, pemerintah, donor, akademisi, komunitas
  show_logo      BOOLEAN NOT NULL DEFAULT FALSE,  -- hanya tampil bila izin tertulis ada
  created_at     TIMESTAMPTZ NOT NULL DEFAULT now()
);

CREATE TABLE programs (
  id              UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  title           VARCHAR(220) NOT NULL,
  slug            VARCHAR(240) NOT NULL UNIQUE,
  summary         VARCHAR(500),
  description     TEXT,
  focus_activity  TEXT,                       -- "Fokus Kegiatan" pada profil
  location        VARCHAR(220),               -- mis. "Pandaan, Pasuruan"
  province        VARCHAR(80),
  year_start      SMALLINT NOT NULL,
  year_end        SMALLINT,
  status          program_status NOT NULL DEFAULT 'completed',
  cover_media_id  UUID REFERENCES media(id) ON DELETE SET NULL,
  impact_summary  TEXT,                       -- data dampak (bila tersedia)
  is_featured     BOOLEAN NOT NULL DEFAULT FALSE,
  publish_status  publish_status NOT NULL DEFAULT 'draft',
  seo_title       VARCHAR(160),
  seo_description VARCHAR(300),
  created_at      TIMESTAMPTZ NOT NULL DEFAULT now(),
  updated_at      TIMESTAMPTZ NOT NULL DEFAULT now(),
  CONSTRAINT chk_tahun CHECK (year_end IS NULL OR year_end >= year_start)
);
CREATE INDEX idx_programs_filter ON programs (publish_status, year_start DESC);

CREATE TABLE program_pillars (
  program_id UUID NOT NULL REFERENCES programs(id) ON DELETE CASCADE,
  pillar_id  SMALLINT NOT NULL REFERENCES pillars(id) ON DELETE CASCADE,
  PRIMARY KEY (program_id, pillar_id)
);

CREATE TABLE program_partners (
  program_id UUID NOT NULL REFERENCES programs(id) ON DELETE CASCADE,
  partner_id UUID NOT NULL REFERENCES partners(id) ON DELETE CASCADE,
  role       VARCHAR(80),                     -- mis. "Pendana", "Pemerintah daerah"
  PRIMARY KEY (program_id, partner_id)
);

CREATE TABLE program_media (                -- galeri foto program
  program_id UUID NOT NULL REFERENCES programs(id) ON DELETE CASCADE,
  media_id   UUID NOT NULL REFERENCES media(id)    ON DELETE CASCADE,
  caption    VARCHAR(255),
  sort_order SMALLINT NOT NULL DEFAULT 0,
  PRIMARY KEY (program_id, media_id)
);

CREATE TABLE program_posts (                -- artikel terkait program
  program_id UUID NOT NULL REFERENCES programs(id) ON DELETE CASCADE,
  post_id    UUID NOT NULL REFERENCES posts(id)    ON DELETE CASCADE,
  PRIMARY KEY (program_id, post_id)
);

-- =====================================================================
-- 5. TIM & TATA KELOLA
-- =====================================================================
CREATE TABLE team_members (
  id            UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  name          VARCHAR(150) NOT NULL,
  position      VARCHAR(150) NOT NULL,        -- Pembina, Ketua, Pengawas, Direktur Program, ...
  group_name    VARCHAR(80)  NOT NULL,        -- 'Organ Yayasan', 'Manajemen', 'Divisi'
  division      VARCHAR(190),                 -- nama divisi bila ada
  bio           TEXT,
  photo_media_id UUID REFERENCES media(id) ON DELETE SET NULL,
  sort_order    SMALLINT NOT NULL DEFAULT 0,
  is_visible    BOOLEAN NOT NULL DEFAULT TRUE
);

-- =====================================================================
-- 6. DOKUMEN & LEGALITAS
-- =====================================================================
CREATE TABLE documents (
  id           UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  title        VARCHAR(220) NOT NULL,
  doc_type     doc_type NOT NULL DEFAULT 'lainnya',
  description  VARCHAR(400),
  media_id     UUID NOT NULL REFERENCES media(id) ON DELETE RESTRICT,
  year         SMALLINT,
  program_id   UUID REFERENCES programs(id) ON DELETE SET NULL,
  is_public    BOOLEAN NOT NULL DEFAULT TRUE,
  download_count INT NOT NULL DEFAULT 0,
  created_at   TIMESTAMPTZ NOT NULL DEFAULT now()
);

CREATE TABLE legal_identity (               -- identitas legal (key-value, tampil di halaman Legalitas)
  key         VARCHAR(80) PRIMARY KEY,        -- 'nama', 'sk_kemenkumham', 'npwp', ...
  label       VARCHAR(120) NOT NULL,
  value       VARCHAR(300) NOT NULL,
  is_public   BOOLEAN NOT NULL DEFAULT TRUE,
  sort_order  SMALLINT NOT NULL DEFAULT 0
);

-- =====================================================================
-- 7. HALAMAN STATIS & PENGATURAN SITUS
-- =====================================================================
CREATE TABLE pages (                        -- Tentang, Pilar & Pendekatan, Kebijakan Privasi, dll.
  id              UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  title           VARCHAR(220) NOT NULL,
  slug            VARCHAR(240) NOT NULL UNIQUE,
  content         TEXT,
  status          publish_status NOT NULL DEFAULT 'draft',
  seo_title       VARCHAR(160),
  seo_description VARCHAR(300),
  updated_by      UUID REFERENCES users(id) ON DELETE SET NULL,
  updated_at      TIMESTAMPTZ NOT NULL DEFAULT now()
);

CREATE TABLE site_settings (                -- kontak, alamat, medsos, hero beranda, statistik
  key         VARCHAR(80) PRIMARY KEY,
  value       JSONB NOT NULL,
  updated_at  TIMESTAMPTZ NOT NULL DEFAULT now()
);

CREATE TABLE offices (
  id         SMALLSERIAL PRIMARY KEY,
  name       VARCHAR(120) NOT NULL,           -- Kantor Pusat / Kantor Program Situbondo
  address    VARCHAR(400) NOT NULL,
  phone      VARCHAR(40),
  email      VARCHAR(190),
  latitude   NUMERIC(9,6),
  longitude  NUMERIC(9,6),
  sort_order SMALLINT NOT NULL DEFAULT 0
);

-- =====================================================================
-- 8. INTERAKSI PENGUNJUNG
-- =====================================================================
CREATE TABLE contact_messages (
  id            UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  name          VARCHAR(150) NOT NULL,
  email         VARCHAR(190) NOT NULL,
  organization  VARCHAR(190),
  topic         VARCHAR(80),                  -- kemitraan, media, relawan, lainnya
  message       TEXT NOT NULL,
  status        message_status NOT NULL DEFAULT 'new',
  ip_hash       CHAR(64),                     -- hash IP, bukan IP mentah (privasi)
  created_at    TIMESTAMPTZ NOT NULL DEFAULT now()
);
CREATE INDEX idx_messages_status ON contact_messages (status, created_at DESC);

CREATE TABLE subscribers (
  id               UUID PRIMARY KEY DEFAULT gen_random_uuid(),
  email            VARCHAR(190) NOT NULL UNIQUE,
  name             VARCHAR(150),
  consent_at       TIMESTAMPTZ NOT NULL,      -- persetujuan eksplisit (UU PDP)
  confirmed_at     TIMESTAMPTZ,               -- double opt-in
  unsubscribed_at  TIMESTAMPTZ,
  token            VARCHAR(64) NOT NULL UNIQUE
);

-- =====================================================================
-- 9. TRIGGER updated_at
-- =====================================================================
CREATE TRIGGER trg_users_upd    BEFORE UPDATE ON users    FOR EACH ROW EXECUTE FUNCTION set_updated_at();
CREATE TRIGGER trg_posts_upd    BEFORE UPDATE ON posts    FOR EACH ROW EXECUTE FUNCTION set_updated_at();
CREATE TRIGGER trg_programs_upd BEFORE UPDATE ON programs FOR EACH ROW EXECUTE FUNCTION set_updated_at();
CREATE TRIGGER trg_pages_upd    BEFORE UPDATE ON pages    FOR EACH ROW EXECUTE FUNCTION set_updated_at();

-- =====================================================================
-- 10. DATA AWAL (SEED) dari Profil YISI 2026 & PRD
-- =====================================================================
INSERT INTO pillars (name, slug, summary, color_hex, sort_order) VALUES
 ('Ekonomi Inklusif & Berkeadilan', 'ekonomi', 'Kemandirian finansial bagi perempuan dan kelompok marginal melalui ekonomi sirkular dan nilai tambah komunitas.', '#F2B01E', 1),
 ('Lingkungan Regeneratif & Tangguh Bencana', 'lingkungan', 'Solusi berbasis alam yang memulihkan ekosistem sekaligus mitigasi dan adaptasi bencana.', '#0B6B43', 2),
 ('Pendidikan Emansipatoris & Siaga Bencana', 'pendidikan', 'Literasi ekologis dan budaya siaga bencana yang inklusif.', '#A3131B', 3);

INSERT INTO post_categories (name, slug, sort_order) VALUES
 ('Berita Lembaga', 'berita-lembaga', 1),
 ('Cerita Lapangan', 'cerita-lapangan', 2),
 ('Kajian dan Publikasi', 'kajian-publikasi', 3),
 ('Siaran Pers', 'siaran-pers', 4);

INSERT INTO legal_identity (key, label, value, is_public, sort_order) VALUES
 ('nama',            'Nama',                 'Yayasan Investasi Sosial Indonesia', TRUE, 1),
 ('singkatan',       'Singkatan',            'YISI', TRUE, 2),
 ('status_hukum',    'Status Hukum',         'Badan Hukum Yayasan', TRUE, 3),
 ('sk_kemenkumham',  'Nomor SK Kemenkumham', 'AHU-0005043.AH.01.04.TAHUN 2015', TRUE, 4),
 ('tgl_pengesahan',  'Tanggal Pengesahan',   '7 April 2015', TRUE, 5),
 ('akta',            'Akta Pendirian',       'Nomor 358, 31 Maret 2015', TRUE, 6),
 ('notaris',         'Notaris',              'Zahirah Bachmid, SH', TRUE, 7),
 ('npwp',            'NPWP',                 '72.744.488.7-624.000', FALSE, 8),  -- default disembunyikan, [PERLU DIKONFIRMASI]
 ('kedudukan',       'Kedudukan',            'Kabupaten Pasuruan, Jawa Timur', TRUE, 9);

INSERT INTO offices (name, address, phone, email, sort_order) VALUES
 ('Kantor Pusat', 'Perum Puri Indah A2, Dusun Keputran, Desa Bakalan, Kec. Purwosari, Kab. Pasuruan, Jawa Timur 67162', NULL, 'investasisosialindonesia@gmail.com', 1),
 ('Kantor Program Situbondo', 'Jln. Pattas 21, Sumberkolak, Panarukan, Situbondo, Jawa Timur', NULL, NULL, 2);

INSERT INTO site_settings (key, value) VALUES
 ('hero', '{"title":"Ketahanan sejati ditumbuhkan dari dalam komunitas.","subtitle":"Kami membangun ekosistem komunitas yang mandiri lewat ekonomi inklusif, lingkungan yang regeneratif, dan pendidikan yang memberdayakan."}'),
 ('stats', '[{"value":"2015","label":"Resmi berbadan hukum yayasan"},{"value":"3 Pilar","label":"Ekonomi, lingkungan, pendidikan"},{"value":"2 Kantor","label":"Pasuruan dan Situbondo"}]'),
 ('social', '{"instagram":null,"facebook":null,"youtube":null,"linkedin":null}');