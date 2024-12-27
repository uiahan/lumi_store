<?php

namespace Database\Seeders;

use App\Models\Cabang;
use App\Models\Kategori;
use App\Models\Produk;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Cabang::create([
            'nama' => 'cabang 1',
        ]);
        
        User::create([
            'name' => 'kasir',
            'username' => 'kasir',
            'role' => 'kasir',
            'password' => bcrypt('kasir'),
            'cabang_id' => '1',
            'photo' => 'image/kasir.jpg'
        ]);

        User::create([
            'name' => 'admin',
            'username' => 'admin',
            'role' => 'admin',
            'password' => bcrypt('admin'),
            'cabang_id' => '1',
            'photo' => 'image/admin.jpg'
        ]);

        User::create([
            'name' => 'owner',
            'username' => 'owner',
            'role' => 'owner',
            'password' => bcrypt('owner'),
            'cabang_id' => '1',
            'photo' => 'image/owner.jpg'
        ]);

        Kategori::create([
            'nama' => 'makanan',
            'photo' => 'image/burger.png'
        ]);

        Kategori::create([
            'nama' => 'minuman',
            'photo' => 'image/soda.png'
        ]);

        Produk::create([
            'nama' => 'Silver Queen',
            'kategori_id' => 1,
            'harga' => 20000,
            'stok' => 43,
            'photo' => 'image/coklat-silver-queen.jpeg',
            'deskripsi' => 'Silver Queen adalah salah satu merek cokelat batangan terkenal di Indonesia. Didirikan sejak tahun 1950, perusahaan ini beroperasi dibawah PT Petra Food yang juga mengelola Ceres dan Delfi. Silverqueen berasal dari Indonesia tepat nya di Garut, Jawa Barat',
        ]);

        Produk::create([
            'nama' => 'Indomie Goreng',
            'kategori_id' => 1,
            'harga' => 3500,
            'stok' => 92,
            'photo' => 'image/indomie-gorengg.jpeg',
            'deskripsi' => 'Indomie Goreng adalah mi instan populer dari Indonesia yang terkenal dengan cita rasa gurih dan bumbu khasnya. Produk ini menawarkan pengalaman mi goreng autentik dengan perpaduan sempurna antara kecap manis, saus cabai, bawang goreng, dan bumbu rempah. Mudah disiapkan hanya dalam beberapa menit, Indomie Goreng menjadi favorit di berbagai kalangan dan dikenal di seluruh dunia sebagai camilan cepat saji yang lezat dan memuaskan.',
        ]);

        Produk::create([
            'nama' => 'Ciki Taro',
            'kategori_id' => 1,
            'harga' => 2000,
            'stok' => 237,
            'photo' => 'image/ciki-taro.jpeg',
            'deskripsi' => 'Ciki Taro adalah camilan ringan berbahan dasar tepung yang diproduksi oleh PT. Taro Indonesia, anak perusahaan dari GarudaFood. Dikenal dengan teksturnya yang renyah dan rasa gurihnya yang khas, ciki Taro hadir dalam berbagai varian rasa seperti Rasa Rumput Laut, Ayam Bawang, dan Keju. Selain rasanya yang lezat, camilan ini juga diperkaya dengan vitamin dan kalsium untuk memberikan nilai gizi tambahan. Dengan kemasan yang menarik dan ikonik, Ciki Taro telah menjadi salah satu camilan favorit di Indonesia, terutama di kalangan anak-anak dan remaja.',
        ]);

        Produk::create([
            'nama' => 'Golda Coffee',
            'kategori_id' => 2,
            'harga' => 4000,
            'stok' => 113,
            'photo' => 'image/golda.webp',
            'deskripsi' => 'Golda Coffee adalah merek kopi yang dikenal dengan cita rasa premium dan kualitas biji kopi terbaik. Diproduksi dengan teknologi modern dan pemilihan biji kopi pilihan, Golda Coffee menghadirkan pengalaman kopi yang kaya, beraroma kuat, dan sempurna untuk menemani berbagai momen. Tersedia dalam berbagai varian, mulai dari kopi instan hingga kopi siap minum dalam kemasan praktis, Golda Coffee cocok untuk para pecinta kopi yang menginginkan kenikmatan kopi otentik kapan saja dan di mana saja. Dengan tagline "Bold Taste, Golden Moments", Golda Coffee berkomitmen untuk memberikan kesempurnaan dalam setiap tegukan. ☕✨',
        ]);

        Produk::create([
            'nama' => 'Cornetto',
            'kategori_id' => 1,
            'harga' => 12000,
            'stok' => 141,
            'photo' => 'image/cornetto.avif',
            'deskripsi' => 'Cornetto adalah es krim kerucut dari Walls yang terkenal dengan perpaduan es krim lembut, saus lezat, dan kerucut renyah yang diakhiri dengan cokelat di dasar cone. Dikenal dengan berbagai varian rasa, seperti cokelat, vanila, dan stroberi, Cornetto menawarkan kenikmatan hingga gigitan terakhir. Es krim ini memberikan pengalaman menyegarkan dan memuaskan dalam setiap lapisan rasa. Dengan slogan "Enjoy the ride, love the ending," Cornetto menjadi pilihan favorit bagi pecinta es krim. 🍦',
        ]);

        Produk::create([
            'nama' => 'Sprite',
            'kategori_id' => 2,
            'harga' => 12000,
            'stok' => 141,
            'photo' => 'image/sprite.webp',
            'deskripsi' => 'Sprite adalah minuman soda berkarbonasi rasa lemon-limau yang diproduksi oleh Coca-Cola. Dikenal dengan kesegarannya, Sprite memiliki rasa yang ringan dan menyegarkan, ideal untuk dinikmati kapan saja, terutama saat cuaca panas. Dengan kandungan bebas kafein, Sprite memberikan sensasi dingin yang menyegarkan dan cocok dipadukan dengan berbagai makanan. Sejak diperkenalkan, Sprite telah menjadi salah satu minuman ringan paling populer di dunia.',
        ]);

        Produk::create([
            'nama' => 'Aqua',
            'kategori_id' => 2,
            'harga' => 3000,
            'stok' => 324,
            'photo' => 'image/aqua.jpeg',
            'deskripsi' => 'Aqua adalah merek air mineral kemasan terkemuka di Indonesia, yang diproduksi oleh Danone. Dikenal karena kesegarannya, Aqua menggunakan sumber mata air alami yang terjaga kualitasnya, memberikan rasa murni dan menyehatkan. Aqua hadir dalam berbagai ukuran kemasan, mulai dari botol kecil hingga galon besar, untuk memenuhi kebutuhan hidrasi sehari-hari. Sebagai merek air mineral pilihan, Aqua menjadi simbol kualitas dan kepercayaan konsumen di Indonesia.',
        ]);

        Produk::create([
            'nama' => 'Frisian Flag',
            'kategori_id' => 2,
            'harga' => 6000,
            'stok' => 273,
            'photo' => 'image/frisian-flag.jpg',
            'deskripsi' => 'Frisian Flag adalah merek susu ternama yang diproduksi oleh FrieslandCampina, salah satu perusahaan produk susu terbesar di dunia. Dikenal dengan kualitas susu yang tinggi, Frisian Flag menawarkan berbagai varian produk, mulai dari susu cair, susu bubuk, hingga produk susu untuk anak-anak. Dengan komitmen untuk memberikan gizi yang baik dan rasa yang lezat, Frisian Flag menjadi pilihan favorit banyak keluarga di Indonesia untuk mendukung gaya hidup sehat.',
        ]);
    }
}
