<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('klasifikasi_buku', function (Blueprint $table): void {
            $table->id();
            $table->string('nama', 120);
            $table->string('slug', 140)->unique();
            $table->string('kode', 20)->unique();
            $table->string('program_studi', 100)->nullable();
            $table->text('deskripsi')->nullable();
            $table->json('keywords');
            $table->string('warna', 20)->default('#1674c8');
            $table->string('ikon', 50)->default('bi-book');
            $table->boolean('is_active')->default(true)->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        Schema::table('buku', function (Blueprint $table): void {
            $table->longText('abstrak')->nullable();
            $table->foreignId('klasifikasi_id')
                ->nullable()
                ->constrained('klasifikasi_buku')
                ->nullOnDelete();
            $table->decimal('classification_score', 5, 2)->nullable();
            $table->json('classification_keywords')->nullable();
            $table->string('classification_source', 20)->nullable();
            $table->string('cover_image')->nullable();
            $table->string('external_url')->nullable();
            $table->boolean('is_recommended')->default(false)->index();
            $table->boolean('is_featured')->default(false)->index();
        });

        Schema::table('anggota', function (Blueprint $table): void {
            $table->string('email')->nullable()->unique();
            $table->boolean('reminder_opt_in')->default(true);
        });

        Schema::table('peminjaman', function (Blueprint $table): void {
            $table->timestamp('reminder_sent_at')->nullable();
        });

        Schema::create('konten_publik', function (Blueprint $table): void {
            $table->id();
            $table->string('type', 30)->index();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('body')->nullable();
            $table->string('image_path')->nullable();
            $table->string('attachment_path')->nullable();
            $table->string('external_url')->nullable();
            $table->dateTime('event_at')->nullable()->index();
            $table->dateTime('event_end_at')->nullable();
            $table->json('metadata')->nullable();
            $table->boolean('is_published')->default(false)->index();
            $table->boolean('is_featured')->default(false)->index();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamp('published_at')->nullable()->index();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('permintaan_publik', function (Blueprint $table): void {
            $table->id();
            $table->string('type', 30)->index();
            $table->string('name', 120);
            $table->string('email')->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('member_number', 50)->nullable();
            $table->string('subject')->nullable();
            $table->longText('message');
            $table->json('metadata')->nullable();
            $table->string('status', 20)->default('baru')->index();
            $table->text('admin_notes')->nullable();
            $table->foreignId('handled_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('handled_at')->nullable();
            $table->timestamps();
        });

        $this->seedClassifications();
        $this->seedPublicContent();

        $generalId = DB::table('klasifikasi_buku')->where('kode', 'UMUM')->value('id');

        DB::table('buku')->whereNull('klasifikasi_id')->update([
            'klasifikasi_id' => $generalId,
            'classification_score' => 0,
            'classification_keywords' => json_encode([]),
            'classification_source' => 'legacy',
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('permintaan_publik');
        Schema::dropIfExists('konten_publik');

        Schema::table('peminjaman', function (Blueprint $table): void {
            $table->dropColumn('reminder_sent_at');
        });

        Schema::table('anggota', function (Blueprint $table): void {
            $table->dropUnique(['email']);
            $table->dropColumn(['email', 'reminder_opt_in']);
        });

        Schema::table('buku', function (Blueprint $table): void {
            $table->dropConstrainedForeignId('klasifikasi_id');
            $table->dropIndex(['is_recommended']);
            $table->dropIndex(['is_featured']);
            $table->dropColumn([
                'abstrak',
                'classification_score',
                'classification_keywords',
                'classification_source',
                'cover_image',
                'external_url',
                'is_recommended',
                'is_featured',
            ]);
        });

        Schema::dropIfExists('klasifikasi_buku');
    }

    private function seedClassifications(): void
    {
        $now = now();
        $classifications = [
            [
                'nama' => 'Teknik Industri dan Operasi',
                'kode' => 'TIO',
                'program_studi' => 'Teknik Industri Otomotif',
                'deskripsi' => 'Produksi, mutu, ergonomi, logistik, dan optimasi sistem industri.',
                'warna' => '#1674c8',
                'ikon' => 'bi-gear-wide-connected',
                'keywords' => ['teknik industri', 'manufaktur', 'produksi', 'quality control', 'pengendalian mutu', 'six sigma', 'lean manufacturing', 'ergonomi', 'logistik', 'supply chain', 'rantai pasok', 'persediaan', 'optimasi', 'riset operasi', 'perencanaan produksi', 'produktivitas', 'maintenance', 'keselamatan kerja'],
            ],
            [
                'nama' => 'Sistem Informasi Industri',
                'kode' => 'SIIO',
                'program_studi' => 'Sistem Informasi Industri Otomotif',
                'deskripsi' => 'Sistem informasi, data, perangkat lunak, dan transformasi digital industri.',
                'warna' => '#2f9f98',
                'ikon' => 'bi-cpu',
                'keywords' => ['sistem informasi', 'teknologi informasi', 'database', 'basis data', 'data mining', 'machine learning', 'artificial intelligence', 'kecerdasan buatan', 'software', 'perangkat lunak', 'enterprise resource planning', 'erp', 'internet of things', 'iot', 'business intelligence', 'cyber security', 'keamanan siber', 'transformasi digital', 'pemrograman', 'algoritma', 'analisis data'],
            ],
            [
                'nama' => 'Administrasi Bisnis Otomotif',
                'kode' => 'ABO',
                'program_studi' => 'Administrasi Bisnis Otomotif',
                'deskripsi' => 'Manajemen, pemasaran, keuangan, SDM, dan layanan bisnis otomotif.',
                'warna' => '#e39a32',
                'ikon' => 'bi-briefcase',
                'keywords' => ['administrasi bisnis', 'manajemen', 'pemasaran', 'marketing', 'keuangan', 'akuntansi', 'sumber daya manusia', 'sdm', 'kewirausahaan', 'strategi bisnis', 'perilaku konsumen', 'layanan pelanggan', 'purna jual', 'dealer', 'penjualan', 'ekonomi', 'organisasi', 'kepemimpinan', 'bisnis otomotif'],
            ],
            [
                'nama' => 'Teknik Kimia Polimer',
                'kode' => 'TKP',
                'program_studi' => 'Teknik Kimia Polimer',
                'deskripsi' => 'Polimer, material, proses kimia, plastik, komposit, dan daur ulang.',
                'warna' => '#8256b3',
                'ikon' => 'bi-bezier2',
                'keywords' => ['polimer', 'kimia', 'plastik', 'material', 'komposit', 'resin', 'elastomer', 'karet', 'termoplastik', 'polipropilena', 'polietilena', 'karakterisasi material', 'proses kimia', 'reaksi kimia', 'daur ulang', 'bioplastik', 'nanomaterial', 'petrokimia'],
            ],
            [
                'nama' => 'Rekayasa Teknologi Otomotif',
                'kode' => 'TRO',
                'program_studi' => 'Teknologi Rekayasa Otomotif',
                'deskripsi' => 'Kendaraan, mesin, sistem kendali, emisi, baterai, dan kendaraan listrik.',
                'warna' => '#d65f52',
                'ikon' => 'bi-car-front',
                'keywords' => ['otomotif', 'kendaraan', 'mesin kendaraan', 'motor bakar', 'engine', 'chassis', 'transmisi', 'sistem kemudi', 'sistem rem', 'emisi', 'kendaraan listrik', 'electric vehicle', 'baterai', 'motor listrik', 'sistem kendali', 'diagnostik kendaraan', 'bahan bakar', 'aerodinamika'],
            ],
            [
                'nama' => 'Umum dan Referensi',
                'kode' => 'UMUM',
                'program_studi' => null,
                'deskripsi' => 'Koleksi lintas disiplin, bahasa, referensi umum, dan pengembangan diri.',
                'warna' => '#607187',
                'ikon' => 'bi-bookshelf',
                'keywords' => ['kamus', 'ensiklopedia', 'referensi', 'bahasa', 'komunikasi', 'pendidikan', 'metodologi penelitian', 'statistika', 'matematika', 'agama', 'hukum', 'sejarah', 'budaya', 'pengembangan diri'],
            ],
        ];

        foreach ($classifications as $index => $classification) {
            DB::table('klasifikasi_buku')->insert([
                'nama' => $classification['nama'],
                'slug' => Str::slug($classification['nama']),
                'kode' => $classification['kode'],
                'program_studi' => $classification['program_studi'],
                'deskripsi' => $classification['deskripsi'],
                'keywords' => json_encode($classification['keywords'], JSON_UNESCAPED_UNICODE),
                'warna' => $classification['warna'],
                'ikon' => $classification['ikon'],
                'is_active' => true,
                'sort_order' => $index + 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }

    private function seedPublicContent(): void
    {
        $now = now();
        $contents = [
            ['type' => 'berita', 'title' => 'Perpustakaan Politeknik STMI Terakreditasi', 'excerpt' => 'Komitmen peningkatan mutu layanan, koleksi, dan pengelolaan perpustakaan.', 'body' => 'Akreditasi menjadi pijakan untuk terus meningkatkan kualitas layanan informasi bagi seluruh sivitas akademika.', 'image_path' => 'images/berita/AKREDITASI_B.png', 'featured' => true],
            ['type' => 'berita', 'title' => 'Program Duta Baca Kampus', 'excerpt' => 'Menghidupkan budaya literasi melalui kolaborasi mahasiswa dan perpustakaan.', 'body' => 'Duta baca hadir sebagai penggerak kegiatan literasi, rekomendasi koleksi, dan pemanfaatan sumber ilmiah di lingkungan kampus.', 'image_path' => 'images/berita/dutabaca.png', 'featured' => false],
            ['type' => 'berita', 'title' => 'Donasi dan Pengembangan Koleksi', 'excerpt' => 'Koleksi tumbuh melalui seleksi dan dukungan berbagai pihak.', 'body' => 'Program donasi membantu memperkaya bahan bacaan yang relevan dengan kebutuhan pendidikan dan penelitian.', 'image_path' => 'images/berita/donasi.png', 'featured' => false],
            ['type' => 'agenda', 'title' => 'Klinik Penelusuran Referensi', 'excerpt' => 'Pendampingan menemukan jurnal dan sumber ilmiah untuk tugas akhir.', 'body' => 'Peserta akan mempelajari strategi kata kunci, evaluasi sumber, dan pemanfaatan database ilmiah.', 'event_at' => $now->copy()->addDays(14)->setTime(10, 0), 'featured' => true],
            ['type' => 'karya', 'title' => 'Karya Mahasiswa Pilihan', 'excerpt' => 'Ruang apresiasi untuk penelitian terapan dan inovasi mahasiswa STMI.', 'body' => 'Karya terpilih akan diperbarui secara berkala oleh pengelola perpustakaan.', 'featured' => true],
            ['type' => 'tantangan', 'title' => 'Tantangan Baca 30 Hari', 'excerpt' => 'Bangun kebiasaan membaca dan bagikan temuan terbaikmu.', 'body' => 'Pilih satu topik, baca sedikitnya tiga koleksi, lalu tuliskan rangkuman singkat untuk dibagikan kepada komunitas kampus.', 'event_at' => $now->copy()->addDays(7)->startOfDay(), 'event_end_at' => $now->copy()->addDays(37)->endOfDay(), 'featured' => true],
            ['type' => 'panduan', 'title' => 'Alur Peminjaman dan Pengembalian', 'excerpt' => 'Panduan singkat menggunakan layanan sirkulasi.', 'body' => 'Cari koleksi, bawa buku dan kartu identitas ke meja layanan, lalu petugas akan mencatat transaksi. Pengembalian dilakukan sebelum tanggal jatuh tempo.', 'featured' => false],
            ['type' => 'panduan', 'title' => 'Persiapan Bebas Perpustakaan', 'excerpt' => 'Checklist untuk menyelesaikan administrasi tugas akhir.', 'body' => 'Pastikan seluruh koleksi telah dikembalikan, unggah tugas akhir ke repository, dan lengkapi dokumen yang dipersyaratkan.', 'featured' => false],
            ['type' => 'faq', 'title' => 'Berapa lama masa peminjaman buku?', 'body' => 'Masa peminjaman mengikuti kebijakan perpustakaan yang ditampilkan pada halaman layanan. Perpanjangan dapat dilakukan apabila koleksi tidak sedang dibutuhkan pemustaka lain.', 'featured' => false],
            ['type' => 'faq', 'title' => 'Bagaimana mengakses jurnal dan repository?', 'body' => 'Gunakan menu E-Resources atau akses cepat di beranda untuk membuka jurnal, repository, dan database ilmiah yang tersedia.', 'featured' => false],
            ['type' => 'faq', 'title' => 'Apakah saya dapat mengusulkan buku baru?', 'body' => 'Ya. Gunakan formulir Usulkan Buku pada halaman Eksplorasi. Tim perpustakaan akan meninjau kesesuaian usulan dengan kebutuhan akademik.', 'featured' => false],
            ['type' => 'profil', 'title' => 'Tim Layanan Pemustaka', 'excerpt' => 'Membantu sirkulasi, penelusuran informasi, dan kebutuhan referensi.', 'body' => 'Hubungi tim layanan melalui kanal Tanya Pustakawan untuk konsultasi referensi dan layanan perpustakaan.', 'featured' => true],
            ['type' => 'unduhan', 'title' => 'Panduan Layanan Perpustakaan', 'excerpt' => 'Ringkasan layanan, tata tertib, dan sumber digital.', 'body' => 'Panduan daring dapat dibaca melalui halaman layanan perpustakaan.', 'external_url' => '/layanan', 'featured' => false],
        ];

        foreach ($contents as $index => $content) {
            DB::table('konten_publik')->insert([
                'type' => $content['type'],
                'title' => $content['title'],
                'slug' => Str::slug($content['title']).'-'.($index + 1),
                'excerpt' => $content['excerpt'] ?? null,
                'body' => $content['body'] ?? null,
                'image_path' => $content['image_path'] ?? null,
                'external_url' => $content['external_url'] ?? null,
                'event_at' => $content['event_at'] ?? null,
                'event_end_at' => $content['event_end_at'] ?? null,
                'metadata' => null,
                'is_published' => true,
                'is_featured' => $content['featured'],
                'sort_order' => $index + 1,
                'published_at' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
};
