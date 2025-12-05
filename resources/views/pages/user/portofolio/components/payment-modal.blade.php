<div x-show="showReviewModal" style="display: none;" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" class="fixed inset-0 z-[999] flex items-center justify-center p-4">
    {{-- Ubah items-start jadi items-center agar di tengah --}}

    {{-- Backdrop (Gelap) --}}
    <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm transition-opacity" @click="showReviewModal = false">
    </div>

    {{-- Modal Content (Scrollable secara internal jika panjang) --}}
    <div
        class="relative bg-slate-900 border border-slate-700 w-full max-w-md rounded-2xl shadow-2xl overflow-hidden max-h-[90vh] flex flex-col">

        {{-- Area Scrollable --}}
        <div class="overflow-y-auto p-8 custom-scrollbar">
            {{-- Modal Header --}}
            <div class="text-center">
                <div
                    class="mx-auto w-16 h-16 bg-indigo-500/10 rounded-full flex items-center justify-center mb-6 text-indigo-400 border border-indigo-500/20">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-white mb-2">Unlock Premium Review</h3>
                <p class="text-slate-400 mb-6 text-sm">Hubungkan portofoliomu dengan mentor expert.</p>
            </div>

            {{-- Pricing Box --}}
            <div class="bg-slate-950 rounded-xl p-5 border border-slate-800 mb-6 text-left">
                <div class="flex justify-between items-center mb-2 text-sm">
                    <span class="text-slate-400">Total Biaya</span>
                    <span class="text-xl font-bold text-white"
                        x-text="'Rp ' + paymentAmount.toLocaleString('id-ID')"></span>
                </div>
                <p class="text-xs text-emerald-400 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                        </path>
                    </svg>
                    Termasuk CV Audit & 1-on-1 Chat
                </p>
            </div>

            {{-- Form (Isinya tetap sama) --}}
            <form action="#" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                {{-- Input Fields (Sama seperti sebelumnya) --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Bank Pengirim</label>
                    <input type="text" name="payment_bank" required
                        class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Nama Pemilik Rekening</label>
                    <input type="text" name="payment_account_name" required
                        class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Nominal Transfer</label>
                    <input type="number" name="payment_amount" x-model="paymentAmount" required
                        class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Bukti Transfer</label>
                    <input type="file" name="payment_proof" accept="image/*" required
                        class="block w-full text-xs text-slate-400 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500">
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" @click="showReviewModal = false"
                        class="flex-1 py-3 border border-slate-700 rounded-xl text-slate-400 font-bold hover:bg-slate-800 hover:text-white transition-all text-sm">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 py-3 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl font-bold shadow-lg shadow-indigo-900/30 transition-all text-sm">
                        Bayar Sekarang
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
