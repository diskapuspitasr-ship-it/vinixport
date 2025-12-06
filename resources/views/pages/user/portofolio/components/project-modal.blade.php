<div x-show="showProjectModal" style="display: none;" class="fixed inset-0 z-[999] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-950/90 backdrop-blur-sm" @click="showProjectModal = false"></div>

    <div
        class="relative bg-slate-900 border border-slate-700 w-full max-w-2xl rounded-2xl shadow-2xl overflow-hidden max-h-[90vh] flex flex-col">

        {{-- VIEW MODE --}}
        <div x-show="!isEditingProject && selectedProject" class="flex flex-col h-full">
            <div class="relative h-64 bg-slate-800">
                <img :src="selectedProject?.image_path" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-slate-900 to-transparent"></div>
                <button @click="showProjectModal = false"
                    class="absolute top-4 right-4 bg-black/50 text-white py-1.5 px-3 rounded-full hover:bg-black/70 transition"><i
                        class="fa-solid fa-xmark"></i></button>
                <button @click="isEditingProject = true"
                    class="absolute bottom-4 right-4 bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-lg hover:bg-blue-500 transition flex items-center gap-2">
                    <i class="fa-solid fa-pen"></i> Edit
                </button>
            </div>
            <div class="p-8 overflow-y-auto">
                <h2 class="text-3xl font-bold text-white mb-2" x-text="selectedProject?.project_title"></h2>
                <a :href="selectedProject?.project_link" target="_blank"
                    class="text-blue-400 hover:text-blue-300 text-sm mb-6 inline-flex items-center gap-1">
                    <i class="fa-solid fa-link"></i> Visit Project
                </a>
                <p class="text-slate-300 leading-relaxed whitespace-pre-line mb-6"
                    x-text="selectedProject?.description"></p>
                <div class="flex flex-wrap gap-2">
                    <template x-for="tag in selectedProject?.tags">
                        <span class="px-3 py-1 bg-slate-800 text-slate-300 text-sm rounded-full border border-slate-700"
                            x-text="tag"></span>
                    </template>
                </div>
            </div>
        </div>

        {{-- EDIT MODE --}}
        <div x-show="isEditingProject && selectedProject" class="p-8 overflow-y-auto">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-xl font-bold text-white">Edit Project</h3>
                <button @click="isEditingProject = false" class="text-slate-400 hover:text-white">Cancel</button>
            </div>

            <form :action="'/project/update/' + selectedProject?.id" method="POST" enctype="multipart/form-data"
                class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Title</label>
                    <input type="text" name="title" :value="selectedProject?.project_title" required
                        class="w-full bg-slate-950 border border-slate-700 rounded-lg px-3 py-2 text-sm text-slate-100">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Description</label>
                    <textarea name="description" rows="4" :value="selectedProject?.description"
                        class="w-full bg-slate-950 border border-slate-700 rounded-lg px-3 py-2 text-sm text-slate-100 resize-none"></textarea>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Link</label>
                    <input type="url" name="link" :value="selectedProject?.project_link"
                        class="w-full bg-slate-950 border border-slate-700 rounded-lg px-3 py-2 text-sm text-slate-100">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Cover Image (Optional)</label>
                    <input type="file" name="image" accept="image/*"
                        class="block w-full text-xs text-slate-400 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-500">
                </div>
                <div class="flex gap-3 pt-4">
                    <button type="submit"
                        class="flex-1 py-2.5 bg-blue-600 hover:bg-blue-500 text-white rounded-lg font-bold transition">Save
                        Changes</button>
                    {{-- Delete Button (Form terpisah di controller disarankan, tapi ini contoh cepat) --}}
                    {{-- Anda butuh route delete project --}}
                </div>
            </form>
            <form :action="'/project/delete/' + selectedProject?.id" method="POST"
                onsubmit="return confirm('Delete this project?')" class="mt-2 text-center">
                @csrf @method('DELETE')
                <button type="submit" class="text-red-500 hover:text-red-400 text-xs font-bold">Delete Project</button>
            </form>
        </div>
    </div>
</div>
