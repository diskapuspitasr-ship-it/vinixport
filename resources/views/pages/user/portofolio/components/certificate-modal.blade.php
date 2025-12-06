<div x-show="showCertificateModal" style="display: none;"
    class="fixed inset-0 z-[999] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-950/90 backdrop-blur-sm" @click="showCertificateModal = false"></div>

    <div class="relative bg-slate-900 border border-slate-700 w-full max-w-md rounded-2xl shadow-2xl overflow-hidden">

        {{-- VIEW MODE --}}
        <div x-show="!isEditingCertificate && selectedCertificate" class="p-8 text-center">
            <img :src="selectedCertificate?.image_path"
                class="w-full h-48 object-contain bg-slate-950 rounded-lg mb-6 border border-slate-800">
            <h2 class="text-xl font-bold text-white mb-1" x-text="selectedCertificate?.certificate_title"></h2>
            <p class="text-blue-400 text-sm mb-4" x-text="selectedCertificate?.issuer_organization"></p>
            <p class="text-slate-500 text-xs">Issued on <span x-text="selectedCertificate?.date_issued"></span></p>

            <div class="mt-8 flex gap-3 justify-center">
                <button @click="isEditingCertificate = true"
                    class="px-4 py-2 bg-slate-800 text-white rounded-lg text-sm font-bold hover:bg-slate-700 transition">Edit</button>
                <button @click="showCertificateModal = false"
                    class="px-4 py-2 border border-slate-700 text-slate-400 rounded-lg text-sm hover:text-white transition">Close</button>
            </div>
        </div>

        {{-- EDIT MODE --}}
        <div x-show="isEditingCertificate && selectedCertificate" class="p-8">
            <h3 class="text-xl font-bold text-white mb-6">Edit Certificate</h3>
            <form :action="'/certificate/update/' + selectedCertificate?.id" method="POST"
                enctype="multipart/form-data" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Title</label>
                    <input type="text" name="title" :value="selectedCertificate?.certificate_title" required
                        class="w-full bg-slate-950 border border-slate-700 rounded-lg px-3 py-2 text-sm text-slate-100">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Issuer</label>
                    <input type="text" name="issuer" :value="selectedCertificate?.issuer_organization" required
                        class="w-full bg-slate-950 border border-slate-700 rounded-lg px-3 py-2 text-sm text-slate-100">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Date Issued</label>
                    <input type="date" name="date" :value="selectedCertificate?.date_issued" required
                        class="w-full bg-slate-950 border border-slate-700 rounded-lg px-3 py-2 text-sm text-slate-100">
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" @click="isEditingCertificate = false"
                        class="flex-1 py-2.5 border border-slate-700 rounded-lg text-slate-400 hover:text-white text-sm">Cancel</button>
                    <button type="submit"
                        class="flex-1 py-2.5 bg-blue-600 hover:bg-blue-500 text-white rounded-lg font-bold transition">Save</button>
                </div>
            </form>
            <form :action="'/certificate/delete/' + selectedCertificate?.id" method="POST"
                onsubmit="return confirm('Delete this certificate?')" class="mt-4 text-center">
                @csrf @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-400 text-xs font-bold">Delete
                    Certificate</button>
            </form>
        </div>
    </div>
</div>
