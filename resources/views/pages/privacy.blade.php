@extends('layouts.app')
@section('title', 'Kebijakan Privasi — YISI')
@section('content')
    <section class="bg-[#eaf0e7] py-10 sm:py-14"><div class="container-wide"><p class="eyebrow">Kebijakan privasi</p><h1 class="serif mt-4 max-w-3xl text-5xl leading-tight text-[#143d2b]">Privasi dan informasi Anda kami jaga.</h1><p class="mt-5 text-sm text-[#64736b]">Terakhir diperbarui: {{ now()->translatedFormat('d F Y') }}</p></div></section>
    <section class="section-pad"><div class="container-wide max-w-3xl">
        <div class="prose-yisi">
            <h2>Informasi yang kami kumpulkan</h2>
            <p>Ketika Anda mengirim formulir kontak, kami memproses nama, alamat email, organisasi (jika diisi), topik, dan isi pesan agar tim YISI dapat menanggapi permintaan Anda.</p>
            <h2>Penggunaan informasi</h2>
            <p>Informasi yang dikirim melalui formulir hanya digunakan untuk menindaklanjuti komunikasi dan kebutuhan yang Anda sampaikan. Jika Anda mendaftar kabar YISI, alamat email hanya digunakan setelah persetujuan dan konfirmasi melalui email. YISI tidak menjual data pribadi kepada pihak lain.</p>
            <h2>Penyimpanan dan keamanan</h2>
            <p>Pesan disimpan pada sistem yang dikelola YISI dan hanya dapat diakses oleh personel yang berwenang. Data teknis alamat jaringan diproses dalam bentuk hash untuk membantu mencegah spam, bukan disimpan sebagai alamat IP mentah.</p>
            <h2>Hak Anda</h2>
            <p>Anda dapat berhenti berlangganan melalui tautan pada email kabar YISI, atau meminta informasi maupun penghapusan data dengan menghubungi <a href="mailto:investasisosialindonesia@gmail.com">investasisosialindonesia@gmail.com</a>.</p>
            <h2>Perubahan kebijakan</h2>
            <p>Kebijakan ini dapat diperbarui untuk mencerminkan perubahan layanan dan ketentuan yang berlaku. Silakan periksa halaman ini untuk mendapatkan informasi terbaru.</p>
        </div>
    </div></section>
@endsection
