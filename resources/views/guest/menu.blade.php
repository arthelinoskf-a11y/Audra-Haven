@extends('layouts.public')

@section('title', 'Pesan Makanan - Audra Haven')

{{-- Panggil Alpine.js --}}
@push('scripts')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush

@section('content')
    <section class="py-20 bg-gray-50 min-h-screen" x-data="{ 
        cart: [],
        showCheckout: false,
        selectedTable: '',
        isSubmitting: false,
        activeTab: 'semua', // State untuk tombol filter
        addToCart(item) {
            let existing = this.cart.find(i => i.id === item.id);
            if (existing) {
                existing.qty++;
            } else {
                this.cart.push({ ...item, qty: 1 });
            }
        },
        removeFromCart(index) {
            this.cart.splice(index, 1);
        },
        get totalPrice() {
            return this.cart.reduce((sum, item) => sum + (item.price * item.qty), 0);
        },
        get totalItems() {
            return this.cart.reduce((sum, item) => sum + item.qty, 0);
        },
        submitOrder() {
            if(!this.selectedTable) {
                alert('Silakan pilih meja terlebih dahulu!');
                return;
            }
            if(this.isSubmitting) return;
            this.isSubmitting = true;

            fetch('/pesan-makanan/store', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    table_id: this.selectedTable,
                    items: this.cart,
                    total: this.totalPrice
                })
            })
            .then(response => {
                if(response.ok || response.redirected) {
                    window.location.href = '/riwayat-pesanan';
                } else {
                    alert('Gagal membuat pesanan.');
                    this.isSubmitting = false;
                }
            })
            .catch(err => {
                alert('Terjadi kesalahan sistem.');
                this.isSubmitting = false;
            });
        }
    }">
        <div class="max-w-6xl mx-auto px-6 relative">
            
            <div class="text-center mb-8">
                <h2 class="text-4xl font-bold mb-4 font-serif">Pesan Makanan</h2>
                <p class="text-gray-500">Pilih menu favorit Anda dan nikmati hidangan lezat kami.</p>
            </div>

            {{-- ==================== TOMBOL FILTER KATEGORI ==================== --}}
            <div class="flex justify-center gap-3 mb-10">
                <button @click="activeTab = 'semua'" 
                        :class="activeTab === 'semua' ? 'bg-[#b8935a] text-white' : 'bg-white text-gray-600 hover:bg-gray-100'"
                        class="px-6 py-2 rounded-full font-semibold shadow-sm transition border border-gray-200">
                    Semua Menu
                </button>
                <button @click="activeTab = 'makanan'" 
                        :class="activeTab === 'makanan' ? 'bg-[#b8935a] text-white' : 'bg-white text-gray-600 hover:bg-gray-100'"
                        class="px-6 py-2 rounded-full font-semibold shadow-sm transition border border-gray-200">
                    Makanan
                </button>
                <button @click="activeTab = 'minuman'" 
                        :class="activeTab === 'minuman' ? 'bg-[#b8935a] text-white' : 'bg-white text-gray-600 hover:bg-gray-100'"
                        class="px-6 py-2 rounded-full font-semibold shadow-sm transition border border-gray-200">
                    Minuman
                </button>
            </div>

            {{-- Mengelompokkan menu berdasarkan kategori --}}
            @php
                $categories = [
                    'appetizer' => ['label' => 'Appetizer (Pembuka)', 'type' => 'makanan'],
                    'main' => ['label' => 'Main Course (Makanan Utama)', 'type' => 'makanan'],
                    'dessert' => ['label' => 'Dessert (Penutup)', 'type' => 'makanan'],
                    'beverage' => ['label' => 'Beverage (Minuman)', 'type' => 'minuman']
                ];
                $groupedItems = $items->groupBy('category');
            @endphp

            @foreach($categories as $key => $cat)
                {{-- Logika Filter: Tampilkan jika "semua" atau tipenya cocok --}}
                <div x-show="activeTab === 'semua' || activeTab === '{{ $cat['type'] }}'" 
                     x-transition
                     class="mb-12">
                    
                    @if(isset($groupedItems[$key]) && $groupedItems[$key]->count() > 0)
                        <h3 class="text-2xl font-bold font-serif mb-6 border-b-2 border-[#b8935a] pb-2 inline-block">{{ $cat['label'] }}</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($groupedItems[$key] as $item)
                            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition flex flex-col justify-between">
                                <div class="p-6">
                                    <h4 class="text-xl font-bold text-gray-800 mt-1 mb-2">{{ $item->name }}</h4>
                                    <p class="text-sm text-gray-500 mb-4">{{ $item->description ?? 'Tidak ada deskripsi.' }}</p>
                                </div>
                                <div class="p-6 pt-0">
                                    <div class="flex items-center justify-between border-t pt-4">
                                        <span class="text-lg font-bold text-[#b8935a]">Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                                        
                                        <button type="button" @click="addToCart({ id: {{ $item->id }}, name: '{{ $item->name }}', price: {{ $item->price }} })" 
                                                class="bg-[#222] text-white px-4 py-2 rounded text-sm hover:bg-gray-800 transition">
                                            + Tambah
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach

        </div>

        {{-- ==================== KERANJANG BELANJA ==================== --}}
        <div x-show="cart.length > 0" x-transition style="display: none;" 
             class="fixed bottom-6 right-6 z-50 bg-white rounded-xl shadow-2xl border border-gray-200 w-80 overflow-hidden flex flex-col max-h-[80vh]">
            
            <div class="bg-[#222] text-white p-4 flex justify-between items-center flex-shrink-0">
                <h3 class="font-bold font-serif text-lg">Pesanan Anda</h3>
                <span class="bg-[#b8935a] text-xs font-bold px-2 py-1 rounded-full" x-text="totalItems + ' Item'"></span>
            </div>

            <div class="overflow-y-auto p-4 space-y-3 flex-1">
                <template x-for="(item, index) in cart" :key="index">
                    <div class="flex justify-between items-start border-b pb-2">
                        <div>
                            <p class="font-semibold text-sm text-gray-800" x-text="item.name"></p>
                            <p class="text-xs text-gray-500">
                                <span x-text="item.qty"></span> x Rp <span x-text="item.price.toLocaleString('id-ID')"></span>
                            </p>
                        </div>
                        <button type="button" @click="removeFromCart(index)" class="text-red-500 hover:text-red-700 text-xs font-bold">Hapus</button>
                    </div>
                </template>
            </div>

            <div class="p-4 bg-gray-50 border-t flex-shrink-0">
                <div class="flex justify-between items-center mb-3">
                    <span class="text-sm text-gray-600">Total</span>
                    <span class="text-xl font-bold text-[#b8935a]">Rp <span x-text="totalPrice.toLocaleString('id-ID')"></span></span>
                </div>
                
                <button type="button" @click="showCheckout = true" class="w-full bg-[#b8935a] hover:bg-[#9a7a44] text-white font-bold py-2 rounded transition">
                    BAYAR
                </button>
            </div>
        </div>

        {{-- ==================== MODAL CHECKOUT ==================== --}}
        <div x-show="showCheckout" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center bg-black bg-opacity-70 p-4" x-transition.opacity>
            <div @click.away="showCheckout = false" class="bg-white rounded-lg shadow-2xl p-6 w-full max-w-md relative" x-transition.scale.origin.center>
                <h3 class="text-xl font-bold font-serif mb-4">Konfirmasi Pesanan</h3>
                
                <div class="mb-4">
                    <label class="block text-sm font-semibold mb-2">Pilih Meja Anda</label>
                    <select x-model="selectedTable" class="w-full border border-gray-300 rounded px-3 py-2">
                        <option value="">-- Pilih Meja --</option>
                        <option value="T01">Meja T01 (Indoor)</option>
                        <option value="T02">Meja T02 (Indoor)</option>
                        <option value="T03">Meja T03 (Teras)</option>
                        <option value="T04">Meja T04 (Ruang Privat)</option>
                    </select>
                </div>

                <div class="flex justify-between items-center mb-6">
                    <span class="text-sm text-gray-600">Total Tagihan</span>
                    <span class="text-xl font-bold text-[#b8935a]">Rp <span x-text="totalPrice.toLocaleString('id-ID')"></span></span>
                </div>

                <div class="flex gap-2">
                    <button type="button" @click="showCheckout = false" class="w-1/2 bg-gray-200 text-gray-800 font-bold py-2 rounded">Batal</button>
                    
                    <button type="button" @click="submitOrder()" :disabled="isSubmitting" class="w-1/2 bg-[#222] text-white font-bold py-2 rounded hover:bg-gray-800 disabled:opacity-50">
                        <span x-show="!isSubmitting">Konfirmasi</span>
                        <span x-show="isSubmitting" style="display: none;">Memproses...</span>
                    </button>
                </div>
            </div>
        </div>
        {{-- ==================== END MODAL ==================== --}}

    </section>
@endsection