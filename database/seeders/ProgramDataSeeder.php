<?php

namespace Database\Seeders;

use App\Models\Partner;
use App\Models\Program;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProgramDataSeeder extends Seeder
{
    public function run(): void
    {
        $partners = [
            'tirta' => ['PT. Tirta Investama (AQUA-Danone)', 'korporasi'],
            'kdm' => ['PT. Karyadibya Mahardhika (KDM)/JTI', 'korporasi'],
            'dow' => ['PT. Dow Indonesia', 'korporasi'],
            'pdtc' => ['Konsorsium PDTC - Kemitraan Australia–Indonesia untuk Kesiapsiagaan Bencana', 'donor'],
            'gema' => ['Forum Perhutanan Sosial Kabupaten Pasuruan & Aliansi Gerakan Masyarakat Peduli Hutan (GEMA DUTA)', 'komunitas'],
        ];

        $partnerIds = [];
        foreach ($partners as $key => [$name, $type]) {
            $partner = Partner::query()->firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'partner_type' => $type, 'show_logo' => false],
            );
            $partnerIds[$key] = $partner->id;
        }

        $programs = [
            ['year' => 2024, 'title' => 'ICD Sekolah Pensiunan (Fase Lanjutan)', 'location' => 'Dusun Jatianom & Sukorejo, Pasuruan', 'partner' => 'tirta', 'description' => 'Skalasi model ICD, pendampingan usaha hijau, monitoring dampak ekologis'],
            ['year' => 2024, 'title' => 'Integrated Area Development (IAD) Social Forestry Programme Kabupaten Pasuruan', 'location' => 'Kabupaten Pasuruan', 'partner' => 'gema', 'description' => 'Inisiasi Advokasi kebijakan Implementasi Perhutanan lintas OPD dan Pemerintahan'],
            ['year' => 2024, 'title' => 'Program "Tandur Banyu" (lanjutan) (Penguatan Kelompok Perhutanan Sosial)', 'location' => 'KTH Sumadi, Desa Jatiarjo, Kec. Prigen, Pasuruan', 'partner' => 'kdm', 'description' => 'Penguatan Rencana Kelola Perhutanan Sosial dan kelembagaan'],
            ['year' => 2024, 'title' => 'PELIBATAN-II (Pengembangan Ekonomi Lokal & Lingkungan)', 'location' => 'Desa Bakalan, Kec. Purwosari, Pasuruan', 'partner' => 'kdm', 'description' => 'Penguatan kelembagaan, pertanian regeneratif, sanitasi berbasis komunitas'],
            ['year' => 2024, 'title' => 'Integrated Community Development (ICD) Sekolah Pensiunan', 'location' => 'Desa Karangjati, Kec. Pandaan, Pasuruan', 'partner' => 'tirta', 'description' => 'Pensiunan sebagai agen perubahan, konservasi biodiversitas, ekonomi sirkular'],
            ['year' => 2023, 'title' => 'ICD Sekolah Pensiunan (Fase Lanjutan)', 'location' => 'Dusun Jatianom & Sukorejo, Pasuruan', 'partner' => 'tirta', 'description' => 'Skalasi model ICD, pendampingan usaha hijau, monitoring dampak ekologis'],
            ['year' => 2023, 'title' => 'Program "Tandur Banyu" (Penguatan Kelompok Perhutanan Sosial)', 'location' => 'KTH Sumadi, Desa Jatiarjo, Kec. Prigen, Pasuruan', 'partner' => 'kdm', 'description' => 'Penguatan Rencana Kelola Perhutanan Sosial dan kelembagaan'],
            ['year' => 2023, 'title' => 'PELIBATAN-II (Pengembangan Ekonomi Lokal & Lingkungan)', 'location' => 'Desa Bakalan, Kec. Purwosari, Pasuruan', 'partner' => 'kdm', 'description' => 'Penguatan kelembagaan, pertanian regeneratif, sanitasi berbasis komunitas'],
            ['year' => 2023, 'title' => 'Integrated Community Development (ICD) Sekolah Pensiunan', 'location' => 'Desa Karangjati, Kec. Pandaan, Pasuruan', 'partner' => 'tirta', 'description' => 'Pensiunan sebagai agen perubahan, konservasi biodiversitas, ekonomi sirkular'],
            ['year' => 2022, 'title' => 'Program Memperkuat Desa dalam Pengurangan Risiko Bencana (PRB) dan Pemulihan Dampak Covid-19 (lanjutan)', 'location' => 'Kabupaten Pasuruan dan Kabupaten Pacitan', 'partner' => 'pdtc', 'description' => 'Memperkuat ketangguhan desa dalam kesiapsiagaan bencana, ekonomi, dan kesehatan masyarakat, melalui pendataan kelompok terdampak pandemi, kebutuhan aktivitas ekonomi berkelanjutan, dan peta rawan bencana, penguatan kapasitas kesiapsiagaan bencana, masyarakat rentan dan marginal, pembentukan Forum Pengurangan Risiko Bencana (FPRB).'],
            ['year' => 2022, 'title' => 'ICD Sekolah Pensiunan (Fase Lanjutan)', 'location' => 'Dusun Jatianom & Sukorejo, Pasuruan', 'partner' => 'tirta', 'description' => 'Skalasi model ICD, pendampingan usaha hijau, monitoring dampak ekologis'],
            ['year' => 2022, 'title' => 'PELIBATAN-II (Pengembangan Ekonomi Lokal & Lingkungan)', 'location' => 'Desa Bakalan, Kec. Purwosari, Pasuruan', 'partner' => 'kdm', 'description' => 'Penguatan kelembagaan, pertanian regeneratif, sanitasi berbasis komunitas'],
            ['year' => 2022, 'title' => 'Integrated Community Development (ICD) Sekolah Pensiunan', 'location' => 'Desa Karangjati, Kec. Pandaan, Pasuruan', 'partner' => 'tirta', 'description' => 'Pensiunan sebagai agen perubahan, konservasi biodiversitas, ekonomi sirkular'],
            ['year' => 2021, 'title' => 'Program Memperkuat Desa dalam Pengurangan Risiko Bencana (PRB) dan Pemulihan Dampak Covid-19', 'location' => 'Kabupaten Pasuruan dan Kabupaten Pacitan', 'partner' => 'pdtc', 'description' => 'Memperkuat ketangguhan desa dalam kesiapsiagaan bencana, ekonomi, dan kesehatan masyarakat, melalui pendataan kelompok terdampak pandemi, kebutuhan aktivitas ekonomi berkelanjutan, dan peta rawan bencana, penguatan kapasitas kesiapsiagaan bencana, masyarakat rentan dan marginal, pembentukan Forum Pengurangan Risiko Bencana (FPRB).'],
            ['year' => 2021, 'title' => 'Pengelolaan Sampah Berbasis Sirkular Ekonomi', 'location' => 'Kec. Jambangan, Surabaya', 'partner' => 'dow', 'description' => 'TPS 3R, konversi limbah organik (BSF, kompos), model bisnis sirkular'],
            ['year' => 2021, 'title' => 'PELB (Program Pembangunan Ekonomi & Lingkungan Berkelanjutan)', 'location' => 'Desa Bakalan, Kec. Purwosari, Pasuruan', 'partner' => null, 'description' => null],
        ];

        foreach ($programs as $program) {
            $description = $program['description'];
            $title = $program['title'];
            $slug = Str::slug($title) . '-' . $program['year'];

            $record = Program::query()->firstOrCreate(
                ['slug' => $slug],
                [
                    'title' => $title,
                    'summary' => $description ? Str::limit($description, 490) : null,
                    'description' => $description,
                    'location' => $program['location'],
                    'province' => 'Jawa Timur',
                    'year_start' => $program['year'],
                    'year_end' => $program['year'],
                    'status' => 'completed',
                    'publish_status' => 'published',
                    'seo_title' => $title,
                    'seo_description' => $description ? Str::limit($description, 290) : null,
                ],
            );

            if ($program['partner'] && isset($partnerIds[$program['partner']])) {
                $record->partners()->syncWithoutDetaching([$partnerIds[$program['partner']]]);
            }
        }
    }
}
