<?php

namespace Database\Seeders;

use App\Models\Media;
use App\Models\Partner;
use App\Models\Pillar;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\Program;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DemoDataSeeder extends Seeder
{
    private ?User $author = null;

    public function run(): void
    {
        $this->author = User::query()->where('role', 'admin')->first();

        $partners = $this->seedPartners();
        $tags = $this->seedTags();
        $this->seedPrograms($partners);
        $this->seedPosts($tags);
    }

    private function seedPartners(): array
    {
        $rows = [
            ['Pemerintah Kabupaten Pasuruan', 'pemkab-pasuruan', 'pemerintah'],
            ['Pemerintah Kabupaten Situbondo', 'pemkab-situbondo', 'pemerintah'],
            ['PT Energi Nusantara', 'pt-energi-nusantara', 'swasta'],
            ['Forum Masyarakat Pesisir', 'forum-masyarakat-pesisir', 'komunitas'],
        ];

        $partners = [];
        foreach ($rows as [$name, $slug, $type]) {
            $partners[$slug] = Partner::query()->firstOrCreate(
                ['slug' => $slug],
                ['name' => $name, 'partner_type' => $type, 'show_logo' => false],
            );
        }

        return $partners;
    }

    private function seedTags(): array
    {
        $rows = [
            ['Perempuan', 'perempuan'],
            ['Koperasi', 'koperasi'],
            ['Ekonomi Sirkular', 'ekonomi-sirkular'],
            ['Mangrove', 'mangrove'],
            ['Perubahan Iklim', 'perubahan-iklim'],
            ['Kebencanaan', 'kebencanaan'],
            ['Pendidikan', 'pendidikan'],
            ['Literasi', 'literasi'],
        ];

        $tags = [];
        foreach ($rows as [$name, $slug]) {
            $tags[$slug] = Tag::query()->firstOrCreate(['slug' => $slug], ['name' => $name]);
        }

        return $tags;
    }

    private function seedPrograms(array $partners): void
    {
        $pillars = Pillar::query()->pluck('id', 'slug');

        $programs = [
            [
                'title' => 'Perempuan Pesisir Bangkit',
                'slug' => 'perempuan-pesisir-bangkit',
                'summary' => 'Membangun koperasi perempuan pesisir agar keluarga nelayan memiliki penghasilan alternatif yang berkelanjutan.',
                'description' => "## Latar belakang\n\nSebagian besar keluarga nelayan di pesisir Situbondo bergantung pada satu sumber penghasilan yang sangat dipengaruhi musim. Perempuan kerap tidak memiliki akses pada modal, keterampilan, dan pasar.\n\n## Pendekatan\n\nKami mendampingi pembentukan koperasi, pelatihan pengolahan hasil laut, serta akses permodalan mikro yang dikelola komunitas sendiri.",
                'focus_activity' => "- Pendampingan pembentukan koperasi perempuan\n- Pelatihan pengolahan dan pengemasan hasil laut\n- Penguatan akses pasar lokal dan digital",
                'impact_summary' => "## Hasil utama\n\n- 2 koperasi perempuan terbentuk dan berjalan\n- 120 anggota aktif memiliki penghasilan tambahan\n- Rata-rata pendapatan anggota meningkat hingga 40%",
                'location' => 'Situbondo',
                'province' => 'Jawa Timur',
                'year_start' => 2021,
                'year_end' => 2023,
                'status' => 'completed',
                'is_featured' => true,
                'publish_status' => 'published',
                'pillars' => ['ekonomi'],
                'partners' => ['pemkab-situbondo', 'pt-energi-nusantara'],
                'cover_seed' => 'yisi-program-perempuan',
            ],
            [
                'title' => 'Mangrove Lestari, Nelayan Sejahtera',
                'slug' => 'mangrove-lestari-nelayan-sejahtera',
                'summary' => 'Restorasi mangrove berbasis komunitas yang memulihkan ekosistem sekaligus melindungi mata pencaharian nelayan.',
                'description' => "## Latar belakang\n\nAbrasi dan hilangnya hutan mangrove mengancam permukiman dan hasil tangkapan nelayan di pesisir utara Jawa Timur.\n\n## Pendekatan\n\nPenanaman dan perawatan mangrove dilakukan langsung oleh komunitas, didukung skema insentif ekowisata dan budi daya yang selaras dengan alam.",
                'focus_activity' => "- Penanaman dan perawatan bibit mangrove\n- Penyusunan aturan kelola bersama desa\n- Pengembangan ekowisata mangrove sederhana",
                'impact_summary' => "## Hasil utama\n\n- 15 hektare mangrove tertanam dan terawat\n- 3 kelompok tani mangrove terbentuk\n- Pendapatan ekowisata mulai mengalir ke kas komunitas",
                'location' => 'Situbondo',
                'province' => 'Jawa Timur',
                'year_start' => 2020,
                'year_end' => 2024,
                'status' => 'completed',
                'is_featured' => true,
                'publish_status' => 'published',
                'pillars' => ['lingkungan', 'ekonomi'],
                'partners' => ['pemkab-situbondo', 'forum-masyarakat-pesisir'],
                'cover_seed' => 'yisi-program-mangrove',
            ],
            [
                'title' => 'Sekolah Siaga Bencana',
                'slug' => 'sekolah-siaga-bencana',
                'summary' => 'Membangun budaya siaga bencana yang inklusif di lingkungan sekolah melalui kurikulum, simulasi, dan kesiapsiagaan komunitas.',
                'description' => "## Latar belakang\n\nKawasan sekitar Pasuruan memiliki risiko banjir, longsor, dan letusan. Anak-anak termasuk kelompok paling rentan saat terjadi bencana.\n\n## Pendekatan\n\nMengintegrasikan literasi kebencanaan ke kegiatan sekolah, menyiapkan jalur evakuasi, dan melibatkan siswa sebagai agen kesiapsiagaan.",
                'focus_activity' => "- Pelatihan guru dan fasilitator sekolah siaga\n- Penyusunan peta dan jalur evakuasi sekolah\n- Simulasi bencana berkala bersama siswa",
                'impact_summary' => "## Hasil utama\n\n- 6 sekolah menerapkan modul kesiapsiagaan\n- 1.500 siswa dan 90 guru terlibat simulasi\n- Terbentuk tim siaga di tiap sekolah",
                'location' => 'Pasuruan',
                'province' => 'Jawa Timur',
                'year_start' => 2022,
                'year_end' => null,
                'status' => 'ongoing',
                'is_featured' => true,
                'publish_status' => 'published',
                'pillars' => ['pendidikan', 'lingkungan'],
                'partners' => ['pemkab-pasuruan', 'forum-masyarakat-pesisir'],
                'cover_seed' => 'yisi-program-sekolah',
            ],
        ];

        foreach ($programs as $row) {
            $program = Program::query()->firstOrCreate(
                ['slug' => $row['slug']],
                [
                    'title' => $row['title'],
                    'summary' => $row['summary'],
                    'description' => $row['description'],
                    'focus_activity' => $row['focus_activity'],
                    'impact_summary' => $row['impact_summary'],
                    'location' => $row['location'],
                    'province' => $row['province'],
                    'year_start' => $row['year_start'],
                    'year_end' => $row['year_end'],
                    'status' => $row['status'],
                    'is_featured' => $row['is_featured'],
                    'publish_status' => $row['publish_status'],
                    'seo_title' => $row['title'],
                    'seo_description' => $row['summary'],
                ],
            );

            $pillarIds = collect($row['pillars'])->map(fn ($slug) => $pillars[$slug] ?? null)->filter();
            $program->pillars()->sync($pillarIds);

            $partnerIds = collect($row['partners'])->map(fn ($slug) => $partners[$slug] ?? null)->filter();
            $program->partners()->sync($partnerIds);

            $cover = $this->downloadCover('programs', $row['slug'], $row['cover_seed'], 'Foto dokumentasi program '.$row['title']);
            if ($cover) {
                $program->update(['cover_media_id' => $cover->id]);
            }
        }
    }

    private function seedPosts(array $tags): void
    {
        $categories = PostCategory::query()->pluck('id', 'slug');
        $programs = Program::query()->pluck('id', 'slug');

        $posts = [
            [
                'title' => 'YISI dan Pemkab Situbondo Perluas Kemitraan Pesisir',
                'slug' => 'yisi-pemkab-situbondo-perluas-kemitraan-pesisir',
                'category' => 'berita-lembaga',
                'excerpt' => 'Penandatanganan kerja sama baru memperluas pendampingan koperasi dan restorasi mangrove ke dua kecamatan pesisir.',
                'published_at' => '2026-09-12',
                'is_featured' => true,
                'tags' => ['koperasi', 'mangrove'],
                'programs' => ['mangrove-lestari-nelayan-sejahtera'],
                'cover_seed' => 'yisi-post-kemitraan',
                'content' => "YISI dan Pemerintah Kabupaten Situbondo menandatangani perluasan kemitraan untuk pendampingan masyarakat pesisir di dua kecamatan baru.\n\n## Fokus kerja sama\n\nKemitraan ini mencakup penguatan koperasi perempuan, restorasi mangrove, serta pendidikan kesiapsiagaan bencana.\n\n> Kolaborasi lintas sektor adalah kunci agar program dapat dilanjutkan oleh komunitas secara mandiri.\n\nDengan skema pendanaan bersama, program diharapkan menjangkau lebih dari 400 keluarga nelayan dalam dua tahun ke depan.",
            ],
            [
                'title' => 'Ibu-ibu Pesisir Bangkit Lewat Koperasi',
                'slug' => 'ibu-ibu-pesisir-bangkit-lewat-koperasi',
                'category' => 'cerita-lapangan',
                'excerpt' => 'Dari dapur rumah, para perempuan Situbondo membangun usaha pengolahan hasil laut yang kini menembus pasar kota.',
                'published_at' => '2026-08-28',
                'is_featured' => true,
                'tags' => ['perempuan', 'koperasi', 'ekonomi-sirkular'],
                'programs' => ['perempuan-pesisir-bangkit'],
                'cover_seed' => 'yisi-post-ibu',
                'content' => "Berawal dari arisan kecil, ibu-ibu di pesisir Situbondo kini mengelola koperasi dengan omzet yang stabil.\n\n## Awal yang sederhana\n\nBu Siti, salah satu penggerak, mengaku awalnya tidak percaya hasil olahan ikan miliknya bisa bernilai jual tinggi.\n\nSetelah mengikuti pelatihan pengemasan dan pemasaran digital, produk seperti abon ikan dan kerupuk rumput laut mulai dikirim ke luar kota.\n\n## Koperasi sebagai ruang belajar\n\nKoperasi menjadi ruang bagi para anggota untuk saling belajar, mengakses modal, dan menjaga kualitas bersama.",
            ],
            [
                'title' => 'Laporan Dampak: Mangrove dan Ketahanan Nelayan',
                'slug' => 'laporan-dampak-mangrove-dan-ketahanan-nelayan',
                'category' => 'kajian-publikasi',
                'excerpt' => 'Kajian lima tahun menunjukkan restorasi mangrove berkorelasi dengan pulihnya tangkapan dan berkurangnya abrasi.',
                'published_at' => '2026-07-15',
                'is_featured' => false,
                'tags' => ['mangrove', 'perubahan-iklim', 'literasi'],
                'programs' => ['mangrove-lestari-nelayan-sejahtera'],
                'cover_seed' => 'yisi-post-laporan',
                'content' => "Kajian lima tahun program Mangrove Lestari dirilis untuk publik.\n\n## Temuan utama\n\n- Luas tutupan mangrove bertambah 15 hektare\n- Abrasi di titik pantau menurun signifikan\n- Pendapatan nelayan lebih stabil di musim paceklik\n\n## Pelajaran\n\nPartisipasi komunitas dalam perawatan menjadi faktor terpenting keberhasilan restorasi jangka panjang.",
            ],
            [
                'title' => 'Peluncuran Sekolah Siaga Bencana di Pasuruan',
                'slug' => 'peluncuran-sekolah-siaga-bencana-pasuruan',
                'category' => 'siaran-pers',
                'excerpt' => 'Enam sekolah di Pasuruan resmi memulai program kesiapsiagaan bencana dengan simulasi pertama melibatkan ratusan siswa.',
                'published_at' => '2026-06-20',
                'is_featured' => true,
                'tags' => ['kebencanaan', 'pendidikan'],
                'programs' => ['sekolah-siaga-bencana'],
                'cover_seed' => 'yisi-post-siaga',
                'content' => "YISI bersama Pemkab Pasuruan meluncurkan program Sekolah Siaga Bencana di enam sekolah.\n\n## Simulasi perdana\n\nSimulasi gempa dan evakuasi berlangsung tertib dan melibatkan lebih dari 1.500 siswa serta 90 guru.\n\nProgram ini menyiapkan jalur evakuasi, tim siaga sekolah, serta modul literasi kebencanaan yang ramah anak.",
            ],
            [
                'title' => 'Mengembalikan Hutan Mangrove, Menjaga Mata Pencaharian',
                'slug' => 'mengembalikan-hutan-mangrove-menjaga-mata-pencaharian',
                'category' => 'cerita-lapangan',
                'excerpt' => 'Pak Rahman dan kelompok taninya menanam mangrove untuk menyelamatkan kampung dari abrasi sekaligus membuka ekowisata.',
                'published_at' => '2026-05-08',
                'is_featured' => false,
                'tags' => ['mangrove', 'kebencanaan', 'ekonomi-sirkular'],
                'programs' => ['mangrove-lestari-nelayan-sejahtera'],
                'cover_seed' => 'yisi-post-rahman',
                'content' => "Pak Rahman masih ingat bagaimana laut dulu menggerus tanah di depan rumahnya.\n\n## Menanam harapan\n\nBersama kelompok tani, ia menanam dan merawat ribuan bibit mangrove di sepanjang garis pantai.\n\nKini sebagian kawasan dibuka sebagai jalur ekowisata sederhana, memberi pemasukan tambahan bagi warga sekaligus menjaga ekosistem tetap lestari.",
            ],
        ];

        foreach ($posts as $row) {
            $post = Post::query()->firstOrCreate(
                ['slug' => $row['slug']],
                [
                    'title' => $row['title'],
                    'excerpt' => $row['excerpt'],
                    'content' => $row['content'],
                    'category_id' => $categories[$row['category']] ?? null,
                    'author_id' => $this->author?->id,
                    'status' => 'published',
                    'published_at' => $row['published_at'],
                    'is_featured' => $row['is_featured'],
                    'seo_title' => $row['title'],
                    'seo_description' => $row['excerpt'],
                ],
            );

            $tagIds = collect($row['tags'])->map(fn ($slug) => $tags[$slug] ?? null)->filter();
            $post->tags()->sync($tagIds);

            $programIds = collect($row['programs'])->map(fn ($slug) => $programs[$slug] ?? null)->filter();
            $post->programs()->sync($programIds);

            $cover = $this->downloadCover('posts', $row['slug'], $row['cover_seed'], 'Foto dokumentasi '.$row['title']);
            if ($cover) {
                $post->update(['cover_media_id' => $cover->id]);
            }
        }
    }

    private function downloadCover(string $dir, string $slug, string $seed, string $alt): ?Media
    {
        try {
            $path = "demo/{$dir}/{$slug}.jpg";
            $url = "https://picsum.photos/seed/{$seed}/1200/800";

            $response = Http::timeout(30)->retry(2, 500)->get($url);

            if (! $response->successful()) {
                return null;
            }

            Storage::disk('public')->put($path, $response->body());

            return Media::query()->firstOrCreate(
                ['url' => $path],
                [
                    'file_name' => "{$slug}.jpg",
                    'alt_text' => $alt,
                    'credit' => 'Picsum',
                    'consent_ok' => true,
                    'uploaded_by' => $this->author?->id,
                ],
            );
        } catch (\Throwable $e) {
            report($e);

            return null;
        }
    }
}
