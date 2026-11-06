<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class YisiContentSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        foreach ([
            ['Ekonomi Inklusif & Berkeadilan', 'ekonomi', 'Kemandirian finansial bagi perempuan dan kelompok marginal melalui ekonomi sirkular dan nilai tambah komunitas.', '#F2B01E', 1],
            ['Lingkungan Regeneratif & Tangguh Bencana', 'lingkungan', 'Solusi berbasis alam yang memulihkan ekosistem sekaligus mendukung mitigasi dan adaptasi bencana.', '#0B6B43', 2],
            ['Pendidikan Emansipatoris & Siaga Bencana', 'pendidikan', 'Literasi ekologis dan budaya siaga bencana yang inklusif.', '#A3131B', 3],
        ] as [$name, $slug, $summary, $color, $order]) {
            DB::table('pillars')->updateOrInsert(
                ['slug' => $slug],
                ['name' => $name, 'summary' => $summary, 'color_hex' => $color, 'sort_order' => $order, 'created_at' => $now, 'updated_at' => $now],
            );
        }

        foreach ([
            ['Berita Lembaga', 'berita-lembaga', 1],
            ['Cerita Lapangan', 'cerita-lapangan', 2],
            ['Kajian dan Publikasi', 'kajian-publikasi', 3],
            ['Siaran Pers', 'siaran-pers', 4],
        ] as [$name, $slug, $order]) {
            DB::table('post_categories')->updateOrInsert(
                ['slug' => $slug],
                ['name' => $name, 'sort_order' => $order, 'created_at' => $now, 'updated_at' => $now],
            );
        }

        foreach ([
            ['nama', 'Nama', 'Yayasan Investasi Sosial Indonesia', true, 1],
            ['singkatan', 'Singkatan', 'YISI', true, 2],
            ['status_hukum', 'Status Hukum', 'Badan Hukum Yayasan', true, 3],
            ['sk_kemenkumham', 'Nomor SK Kemenkumham', 'AHU-0005043.AH.01.04.TAHUN 2015', true, 4],
            ['tgl_pengesahan', 'Tanggal Pengesahan', '7 April 2015', true, 5],
            ['akta', 'Akta Pendirian', 'Nomor 358, 31 Maret 2015', true, 6],
            ['notaris', 'Notaris', 'Zahirah Bachmid, SH', true, 7],
            ['kedudukan', 'Kedudukan', 'Kabupaten Pasuruan, Jawa Timur', true, 8],
        ] as [$key, $label, $value, $isPublic, $order]) {
            DB::table('legal_identity')->updateOrInsert(
                ['key' => $key],
                ['label' => $label, 'value' => $value, 'is_public' => $isPublic, 'sort_order' => $order, 'created_at' => $now, 'updated_at' => $now],
            );
        }

        foreach ([
            ['Kantor Pusat', 'Perum Puri Indah A2, Dusun Keputran, Desa Bakalan, Kec. Purwosari, Kab. Pasuruan, Jawa Timur 67162', 'investasisosialindonesia@gmail.com', 1],
            ['Kantor Program Situbondo', 'Jln. Pattas 21, Sumberkolak, Panarukan, Situbondo, Jawa Timur', null, 2],
        ] as [$name, $address, $email, $order]) {
            DB::table('offices')->updateOrInsert(
                ['name' => $name],
                ['address' => $address, 'email' => $email, 'sort_order' => $order, 'created_at' => $now, 'updated_at' => $now],
            );
        }

        foreach ([
            'hero' => [
                'title' => 'Ketahanan sejati ditumbuhkan dari dalam komunitas.',
                'subtitle' => 'Kami membangun ekosistem komunitas yang mandiri lewat ekonomi inklusif, lingkungan yang regeneratif, dan pendidikan yang memberdayakan.',
            ],
            'stats' => [
                ['value' => '2015', 'label' => 'Resmi berbadan hukum yayasan'],
                ['value' => '3 Pilar', 'label' => 'Ekonomi, lingkungan, pendidikan'],
                ['value' => '2 Kantor', 'label' => 'Pasuruan dan Situbondo'],
            ],
            'social' => ['instagram' => null, 'facebook' => null, 'youtube' => null, 'linkedin' => null],
        ] as $key => $value) {
            DB::table('site_settings')->updateOrInsert(
                ['key' => $key],
                ['value' => json_encode($value, JSON_THROW_ON_ERROR), 'created_at' => $now, 'updated_at' => $now],
            );
        }
    }
}
