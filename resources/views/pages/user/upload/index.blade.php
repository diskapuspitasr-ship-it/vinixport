@extends('layouts.master')

@section('title', 'Upload Content')

@section('content')
    <div x-data="uploadApp()"
        class="min-h-screen bg-slate-950 font-sans selection:bg-blue-500 selection:text-white pt-28 pb-12 px-4 relative overflow-hidden">

        {{-- Background Effects --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"></div>
            <div class="absolute top-0 left-1/3 w-[600px] h-[600px] bg-blue-600/10 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-0 right-1/3 w-[500px] h-[500px] bg-purple-600/10 rounded-full blur-[100px]"></div>
        </div>

        <div class="relative z-10 container mx-auto max-w-3xl">

            <div
                class="bg-slate-900/60 backdrop-blur-xl border border-slate-800 shadow-2xl rounded-2xl p-8 md:p-10 relative overflow-hidden">
                {{-- Top Glow Line --}}
                <div
                    class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 via-purple-500 to-blue-500 opacity-50">
                </div>

                <h1 class="text-3xl font-bold mb-2 text-center text-white tracking-tight">Upload Content</h1>
                <p class="text-center text-slate-400 mb-8">Showcase your best work or achievements.</p>

                <form action="{{ route('user.upload.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-8" @submit="isLoading = true">
                    @csrf

                    {{-- Toggle Tabs (Hidden Input untuk kirim value ke controller) --}}
                    <input type="hidden" name="upload_type" x-model="uploadType">

                    <div class="flex justify-center">
                        <div class="bg-slate-950 p-1 rounded-xl border border-slate-800 inline-flex">
                            <button type="button" @click="uploadType = 'project'"
                                :class="uploadType === 'project' ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' :
                                    'text-slate-400 hover:text-white hover:bg-slate-800'"
                                class="px-6 py-2.5 text-sm font-bold rounded-lg transition-all">
                                Project
                            </button>
                            <button type="button" @click="uploadType = 'certificate'"
                                :class="uploadType === 'certificate' ? 'bg-blue-600 text-white shadow-lg shadow-blue-900/20' :
                                    'text-slate-400 hover:text-white hover:bg-slate-800'"
                                class="px-6 py-2.5 text-sm font-bold rounded-lg transition-all">
                                Certificate
                            </button>
                        </div>
                    </div>

                    {{-- Drag & Drop Area --}}
                    <div>
                        <label class="block mb-3 text-sm font-medium text-slate-300"
                            x-text="uploadType === 'project' ? 'Project Cover Image' : 'Certificate File (Image/Scan)'"></label>

                        <div @dragover.prevent="isDragging = true" @dragleave.prevent="isDragging = false"
                            @drop.prevent="handleDrop($event)"
                            :class="isDragging ? 'border-blue-500 bg-blue-500/10' :
                                'border-slate-700 bg-slate-950/50 hover:border-blue-500/50 hover:bg-slate-900'"
                            class="relative group flex justify-center items-center w-full h-64 px-4 transition-all duration-300 border-2 border-dashed rounded-xl cursor-pointer">

                            <label for="file-upload"
                                class="w-full h-full flex flex-col justify-center items-center cursor-pointer">
                                <input id="file-upload" name="image" type="file" class="hidden"
                                    @change="handleFileSelect($event)" accept="image/*" required>

                                <div x-show="fileName" class="text-center relative z-10" style="display: none;">
                                    <div
                                        class="w-16 h-16 mx-auto mb-3 bg-blue-500/20 text-blue-400 rounded-xl flex items-center justify-center border border-blue-500/30">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium text-white" x-text="fileName"></p>
                                    <p class="text-xs text-slate-500 mt-1">Click to change file</p>
                                </div>

                                <div x-show="!fileName" class="text-center">
                                    <div
                                        class="w-16 h-16 mx-auto mb-3 bg-slate-800 text-slate-400 rounded-xl flex items-center justify-center group-hover:text-blue-400 group-hover:bg-blue-500/10 group-hover:border-blue-500/30 border border-slate-700 transition-all">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                            </path>
                                        </svg>
                                    </div>
                                    <p class="text-sm text-slate-300">
                                        <span class="font-bold text-blue-400 hover:underline">Click to upload</span> or drag
                                        and drop
                                    </p>
                                    <p class="text-xs text-slate-500 mt-2">SVG, PNG, JPG or GIF (MAX. 5MB)</p>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Dynamic Fields --}}
                    <div class="space-y-5 animate-fade-in-up">

                        {{-- Field Title (Shared) --}}
                        <div>
                            <label for="title" class="block mb-2 text-sm font-medium text-slate-300"
                                x-text="uploadType === 'project' ? 'Project Title' : 'Certificate Title'"></label>
                            <input type="text" id="title" name="title"
                                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all placeholder-slate-600"
                                :placeholder="uploadType === 'project' ? 'e.g. E-Commerce Redesign' : 'e.g. AWS Certified Developer'"
                                required>
                        </div>

                        {{-- Fields Khusus Project --}}
                        <template x-if="uploadType === 'project'">
                            <div class="space-y-5">
                                <div>
                                    <label for="description"
                                        class="block mb-2 text-sm font-medium text-slate-300">Description</label>
                                    <textarea id="description" name="description" rows="4"
                                        class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all placeholder-slate-600 resize-none"
                                        placeholder="Describe your project..." required></textarea>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                    <div>
                                        <label for="link" class="block mb-2 text-sm font-medium text-slate-300">Project
                                            Link</label>
                                        <input type="url" id="link" name="link"
                                            class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all placeholder-slate-600"
                                            placeholder="https://github.com/...">
                                    </div>
                                    <div>
                                        <label for="tags"
                                            class="block mb-2 text-sm font-medium text-slate-300">Tags</label>
                                        <input type="text" id="tags" name="tags"
                                            class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all placeholder-slate-600"
                                            placeholder="React, TypeScript, UI/UX">
                                    </div>
                                </div>
                            </div>
                        </template>

                        {{-- Fields Khusus Certificate --}}
                        <template x-if="uploadType === 'certificate'">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label for="issuer" class="block mb-2 text-sm font-medium text-slate-300">Issuer
                                        Organization</label>
                                    <input type="text" id="issuer" name="issuer"
                                        class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all placeholder-slate-600"
                                        placeholder="e.g. Amazon Web Services" required>
                                </div>
                                <div>
                                    <label for="date" class="block mb-2 text-sm font-medium text-slate-300">Date
                                        Issued</label>
                                    <input type="date" id="date" name="date"
                                        class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all placeholder-slate-600"
                                        required>
                                </div>
                            </div>
                        </template>

                    </div>

                    {{-- Submit Button --}}
                    <div class="pt-4">
                        @if ($errors->any())
                            <div
                                class="mb-4 p-3 rounded-lg bg-red-500/10 text-red-400 border border-red-500/20 text-sm text-center">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <button type="submit" :disabled="isLoading"
                            class="w-full py-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white font-bold rounded-xl shadow-lg shadow-blue-900/20 transition-all transform hover:-translate-y-0.5 text-lg flex justify-center items-center gap-2">
                            <svg x-show="isLoading" style="display: none;" class="animate-spin h-5 w-5 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                            <span
                                x-text="isLoading ? 'Uploading...' : (uploadType === 'project' ? 'Publish Project' : 'Save Certificate')"></span>
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function uploadApp() {
                return {
                    uploadType: 'project',
                    isDragging: false,
                    fileName: null,
                    isLoading: false,

                    handleFileSelect(event) {
                        const file = event.target.files[0];
                        if (file) {
                            this.fileName = file.name;
                        }
                    },

                    handleDrop(event) {
                        this.isDragging = false;
                        const file = event.dataTransfer.files[0];
                        if (file) {
                            this.fileName = file.name;
                            // Assign file ke input hidden secara manual karena dataTransfer read-only di input file
                            const fileInput = document.getElementById('file-upload');
                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(file);
                            fileInput.files = dataTransfer.files;
                        }
                    }
                }
            }
        </script>
    @endpush
@endsection
