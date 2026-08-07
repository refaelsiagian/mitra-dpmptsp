function projectForm(config) {
    return {
        type: config.type || '',
        title: config.title || '',
        description: config.description || '',
        ruang_lingkup: config.ruang_lingkup || '',
        isUmkm: config.isUmkm || false,
        offerings: config.offerings && config.offerings.length > 0 ? config.offerings : [''],
        requirements: config.requirements && config.requirements.length > 0 ? config.requirements : [''],
        
        categories: [
            { id: 'subkontrak', name: 'Subkontrak', desc: 'Pekerjaan spesifik untuk vendor.', activeClass: 'border-blue-600 bg-blue-50 ring-1 ring-blue-600', isUbOnly: true },
            { id: 'rantai_pasok', name: 'Rantai Pasok', desc: 'Suplai bahan berkelanjutan.', activeClass: 'border-blue-600 bg-blue-50 ring-1 ring-blue-600', isUbOnly: false },
            { id: 'outsourcing', name: 'Penyumberluaran', desc: 'Outsourcing tenaga kerja/jasa.', activeClass: 'border-blue-600 bg-blue-50 ring-1 ring-blue-600', isUbOnly: false },
            { id: 'konstruksi', name: 'Konstruksi', desc: 'Pembangunan sarana prasarana.', activeClass: 'border-blue-600 bg-blue-50 ring-1 ring-blue-600', isUbOnly: false },
            { id: 'kso', name: 'KSO / Bagi Hasil', desc: 'Kerja sama & berbagi keuntungan.', activeClass: 'border-emerald-600 bg-emerald-50 ring-1 ring-emerald-600', isUbOnly: false },
            { id: 'distribusi', name: 'Distribusi & Keagenan', desc: 'Penyaluran produk atau perwakilan agensi.', activeClass: 'border-teal-600 bg-teal-50 ring-1 ring-teal-600', isUbOnly: false },
            { id: 'perdagangan', name: 'Perdagangan Umum', desc: 'Penjualan barang / pengadaan langsung.', activeClass: 'border-purple-600 bg-purple-50 ring-1 ring-purple-600', isUbOnly: false }
        ],

        get availableCategories() {
            return this.categories.filter(c => {
                if (this.isUmkm && c.isUbOnly) return false;
                return true;
            });
        },

        errors: {},

        validate(e) {
            this.errors = {};
            if (!this.type) {
                this.errors.type = 'Kategori kemitraan wajib dipilih.';
            }
            if (!this.title || this.title.trim() === '') {
                this.errors.title = 'Judul proyek / kemitraan wajib diisi.';
            }
            if (!this.description || this.description.trim() === '') {
                this.errors.description = 'Deskripsi kemitraan wajib diisi.';
            }
            if (!this.ruang_lingkup || this.ruang_lingkup.trim() === '') {
                this.errors.ruang_lingkup = 'Ruang lingkup pekerjaan wajib diisi.';
            }
            
            const validOfferings = this.offerings.filter(o => typeof o === 'string' && o.trim() !== '');
            if (validOfferings.length === 0) {
                this.errors.offerings = 'Minimal satu item wajib diisi.';
            }

            const validRequirements = this.requirements.filter(r => typeof r === 'string' && r.trim() !== '');
            if (validRequirements.length === 0) {
                this.errors.requirements = 'Minimal satu item wajib diisi.';
            }

            if (Object.keys(this.errors).length > 0) {
                e.preventDefault(); // Prevent form submission
                
                // Scroll to top to see errors
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        },

        getOfferingsTitle() {
            if (this.type === 'kso') return 'Aset / Modal yang Kami Siapkan';
            if (this.type === 'perdagangan') return this.isUmkm ? 'Katalog Produk / Jasa Kami' : 'Informasi Pengadaan / Pembayaran';
            if (this.type === 'outsourcing') return this.isUmkm ? 'Layanan Jasa & Kualifikasi Kami' : 'Fasilitas & Tunjangan Tenaga Kerja';
            if (this.type === 'rantai_pasok') return this.isUmkm ? 'Kapasitas Suplai / Material Kami' : 'Kemudahan / Dukungan untuk Suplier';
            if (this.type === 'distribusi') return this.isUmkm ? 'Fasilitas Distribusi / Dukungan Keagenan' : 'Dukungan Prinsipal / Fasilitas Agen';
            return this.isUmkm ? 'Layanan Konstruksi & Alat Kami' : 'Fasilitas yang Disediakan Pemberi Tugas';
        },
        
        getOfferingsDesc() {
            if (this.type === 'kso') return 'Sebutkan aset, perizinan, atau modal yang sudah Anda siapkan.';
            if (this.type === 'perdagangan') return this.isUmkm ? 'Sebutkan jenis barang yang Anda jual (kapasitas produksi, spesifikasi).' : 'Sebutkan ketentuan pembayaran, sistem PO, atau fasilitas untuk vendor.';
            if (this.type === 'outsourcing') return this.isUmkm ? 'Sebutkan jenis jasa yang Anda tawarkan.' : 'Apa yang didapat oleh penyedia jasa outsourcing (misal: area kerja).';
            if (this.type === 'rantai_pasok') return this.isUmkm ? 'Sebutkan jenis barang yang bisa Anda suplai.' : 'Sebutkan dukungan untuk vendor (misal: pembayaran tunai, kontrak jangka panjang).';
            if (this.type === 'distribusi') return this.isUmkm ? 'Sebutkan jangkauan wilayah, fasilitas gudang, atau dukungan promosi.' : 'Sebutkan produk yang didistribusikan, margin keuntungan, atau materi promosi.';
            return this.isUmkm ? 'Sebutkan alat berat atau spesialisasi yang Anda miliki.' : 'Sebutkan material atau akses yang akan Anda berikan ke pelaksana.';
        },

        getRequirementsTitle() {
            if (this.type === 'kso') return 'Kewajiban Calon Mitra KSO';
            if (this.type === 'perdagangan') return this.isUmkm ? 'Syarat Pembelian / Ketentuan' : 'Spesifikasi Barang / Jasa yang Dicari';
            if (this.type === 'outsourcing') return this.isUmkm ? 'Ketentuan Kontrak Jasa' : 'Kualifikasi Tenaga Kerja / Jasa';
            if (this.type === 'rantai_pasok') return this.isUmkm ? 'Syarat Kontrak / Kebutuhan Pembeli' : 'Spesifikasi Barang / Suplai yang Dicari';
            if (this.type === 'distribusi') return this.isUmkm ? 'Syarat Mitra Keagenan / Prinsipal' : 'Kualifikasi Mitra Distributor / Agen';
            return this.isUmkm ? 'Ketentuan Kontrak Konstruksi' : 'Tanggung Jawab Vendor / Pelaksana';
        },

        getRequirementsDesc() {
            if (this.type === 'kso') return 'Sebutkan apa yang harus disediakan oleh mitra (contoh: modal tambahan, teknologi).';
            if (this.type === 'perdagangan') return this.isUmkm ? 'Sebutkan minimal order, atau kriteria pembeli jika ada.' : 'Sebutkan standar kualitas, kuantitas, atau sertifikasi yang wajib dimiliki vendor.';
            if (this.type === 'outsourcing') return this.isUmkm ? 'Sebutkan durasi minimal, atau syarat kerja.' : 'Sebutkan sertifikasi, atau jumlah tenaga yang dibutuhkan.';
            if (this.type === 'rantai_pasok') return this.isUmkm ? 'Sebutkan minimal pemesanan atau syarat pembayaran.' : 'Sebutkan standar kualitas material, jadwal pengiriman, dsb.';
            if (this.type === 'distribusi') return this.isUmkm ? 'Sebutkan kriteria yang Anda cari dari mitra agen atau tipe produk prinsipal.' : 'Sebutkan syarat keagenan (misal: memiliki gudang, jangkauan armada, target penjualan).';
            return this.isUmkm ? 'Sebutkan apa yang harus disiapkan pemberi kerja.' : 'Sebutkan alat, tenaga kerja, atau standar kerja vendor.';
        },

        getTitlePlaceholder() {
            if (this.type === 'subkontrak') return 'Contoh: Subkontrak Pengerjaan Drainase / Fabrikasi Komponen Mesin';
            if (this.type === 'kso') return 'Contoh: Pembangunan Fasilitas Bersama / Kolaborasi Pengembangan Bisnis';
            if (this.type === 'perdagangan') return this.isUmkm ? 'Contoh: Penjualan Kerajinan Rotan / Suplai Makanan Ringan' : 'Contoh: Pengadaan Alat Tulis Kantor (ATK) / Kebutuhan Catering';
            if (this.type === 'outsourcing') return this.isUmkm ? 'Contoh: Penawaran Jasa Keamanan / Layanan Kebersihan' : 'Contoh: Kebutuhan Tenaga IT / Pengadaan Jasa Cleaning Service';
            if (this.type === 'rantai_pasok') return this.isUmkm ? 'Contoh: Suplai Bahan Baku Kopi / Pengadaan Material Pasir' : 'Contoh: Kebutuhan Bahan Baku Produksi / Suplai Komponen Elektronik';
            if (this.type === 'distribusi') return this.isUmkm ? 'Contoh: Kesediaan Menjadi Agen / Distributor Wilayah Bali' : 'Contoh: Pencarian Distributor Area Jawa Timur / Keagenan Produk X';
            if (this.type === 'konstruksi') return this.isUmkm ? 'Contoh: Jasa Pengerjaan Atap / Sub-pekerjaan Instalasi Listrik' : 'Contoh: Pembangunan Gudang Logistik / Pekerjaan Sipil Pabrik';
            
            return 'Contoh: Pengadaan Material Besi Baja / Penawaran Jasa Konstruksi Baja';
        }
    }
}
