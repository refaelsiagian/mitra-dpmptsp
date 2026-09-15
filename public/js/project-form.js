function projectForm(config) {
    return {
        ...config,
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
        },

        clearLocation() {
            this.province_id = '';
            this.regency_id = '';
            this.district_id = '';
            this.village_id = '';
            this.address = '';
            this.regencies = [];
            this.districts = [];
            this.villages = [];
            
            this.uncheckShortcuts();
        },

        uncheckShortcuts() {
            document.querySelectorAll('input[name="loc_shortcut"]').forEach(r => r.checked = false);
            const cb = document.querySelector('#loc_shortcut_checkbox');
            if(cb) cb.checked = false;
        }
    }
}

document.addEventListener('alpine:init', () => {
    Alpine.data('rabBuilder', (initialData) => ({
        categories: [],
        
        init() {
            // Handle initial data formatting if provided
            if (initialData && Array.isArray(initialData) && initialData.length > 0) {
                // Make sure IDs are assigned so Alpine :key works properly
                this.categories = initialData.map(cat => ({
                    ...cat,
                    id: cat.id || this.generateId(),
                    items: (cat.items || []).map(item => ({
                        ...item,
                        id: item.id || this.generateId(),
                        volume: parseFloat(item.volume) || 0,
                        unit_price: parseFloat(item.unit_price) || 0
                    }))
                }));
            } else {
                // Default empty state with 1 category
                this.categories = [
                    { id: this.generateId(), name: '', items: [{ id: this.generateId(), name: '', volume: 0, unit: '', unit_price: 0 }] }
                ];
            }
        },
        
        generateId() {
            return Date.now() + Math.random().toString(36).substr(2, 9);
        },
        
        addCategory() {
            this.categories.push({ 
                id: this.generateId(), 
                name: '', 
                items: [{ id: this.generateId(), name: '', volume: 0, unit: '', unit_price: 0 }] 
            });
        },
        
        removeCategory(catIndex) {
            if(confirm('Hapus kategori ini beserta seluruh isinya?')) {
                this.categories.splice(catIndex, 1);
            }
        },
        
        addItem(catIndex) {
            this.categories[catIndex].items.push({ id: this.generateId(), name: '', volume: 0, unit: '', unit_price: 0 });
        },
        
        removeItem(catIndex, itemIndex) {
            this.categories[catIndex].items.splice(itemIndex, 1);
        },
        
        getCategoryTotal(catIndex) {
            if (!this.categories[catIndex] || !this.categories[catIndex].items) return 0;
            return this.categories[catIndex].items.reduce((sum, item) => {
                return sum + ((parseFloat(item.volume) || 0) * (parseFloat(item.unit_price) || 0));
            }, 0);
        },
        
        get grandTotal() {
            return this.categories.reduce((sum, cat, index) => sum + this.getCategoryTotal(index), 0);
        },
        
        formatCurrency(val) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(val);
        }
    }));
});
