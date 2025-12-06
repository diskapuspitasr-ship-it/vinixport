@extends('layouts.master')

@section('title', 'Manage Assessments')

@section('content')
    <div class="min-h-screen bg-slate-950 text-slate-200 pt-28 pb-12 px-4 relative font-sans" x-data="{
        showModal: false,
        isEdit: false,
        itemId: null,
        form: { question: '', type: 'soft_skill' },

        // Helper untuk URL action form
        get actionUrl() {
            return this.isEdit ? '{{ url('admin/assessments') }}/' + this.itemId : '{{ route('admin.assessments.store') }}';
        },

        openCreate() {
            this.isEdit = false;
            this.itemId = null;
            this.form = { question: '', type: 'soft_skill' };
            this.showModal = true;
            document.body.classList.add('overflow-hidden');
        },

        openEdit(item) {
            this.isEdit = true;
            this.itemId = item.id;
            this.form = {
                question: item.question,
                type: item.type
            };
            this.showModal = true;
            document.body.classList.add('overflow-hidden');
        },

        closeModal() {
            this.showModal = false;
            document.body.classList.remove('overflow-hidden');
        }
    }">

        {{-- Background --}}
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute inset-0 bg-[url('https://grainy-gradients.vercel.app/noise.svg')] opacity-20"></div>
            <div class="absolute top-0 left-1/4 w-1/2 h-1/2 bg-emerald-900/20 rounded-full blur-[120px]"></div>
        </div>

        <div class="container mx-auto relative z-10">

            {{-- Header --}}
            <div class="flex flex-col md:flex-row justify-between items-end mb-8 gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-white">Assessment Management</h1>
                    <p class="text-slate-400">Kelola Bank Soal untuk penilaian skill pengguna.</p>
                </div>
                <button @click="openCreate()"
                    class="bg-emerald-600 hover:bg-emerald-500 text-white px-5 py-2.5 rounded-xl font-bold shadow-lg flex items-center gap-2 transition">
                    <i class="fa-solid fa-plus"></i> Add Question
                </button>
            </div>

            {{-- Alert Success --}}
            @if (session('success'))
                <div
                    class="bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 p-4 rounded-xl mb-6 flex justify-between items-center">
                    <span>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-200"><i
                            class="fa-solid fa-xmark"></i></button>
                </div>
            @endif

            {{-- Table Card --}}
            <div class="bg-slate-900/60 backdrop-blur-xl border border-slate-800 rounded-2xl overflow-hidden shadow-xl">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-900 text-slate-400 uppercase font-semibold">
                            <tr>
                                <th class="px-6 py-4 w-16">#</th>
                                <th class="px-6 py-4">Question</th>
                                <th class="px-6 py-4">Type</th>
                                <th class="px-6 py-4 w-32 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @forelse($assessments as $index => $item)
                                <tr class="hover:bg-slate-800/50 transition group">
                                    <td class="px-6 py-4 text-slate-500">{{ $assessments->firstItem() + $index }}</td>
                                    <td class="px-6 py-4">
                                        <p class="text-slate-200 font-medium line-clamp-2" title="{{ $item->question }}">
                                            {{ Str::limit($item->question, 80) }}
                                        </p>
                                    </td>
                                    <td class="px-6 py-4">
                                        @php
                                            $badgeClass = match ($item->type) {
                                                'soft_skill' => 'bg-blue-500/10 text-blue-400 border-blue-500/20',
                                                'digital_skill'
                                                    => 'bg-purple-500/10 text-purple-400 border-purple-500/20',
                                                'workplace_readiness'
                                                    => 'bg-amber-500/10 text-amber-400 border-amber-500/20',
                                                default => 'bg-slate-800 text-slate-400 border-slate-700',
                                            };
                                        @endphp
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-bold uppercase border {{ $badgeClass }}">
                                            {{ str_replace('_', ' ', $item->type) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div
                                            class="flex justify-end gap-2 opacity-60 group-hover:opacity-100 transition-opacity">
                                            {{-- Edit Button --}}
                                            <button type="button" @click="openEdit({{ json_encode($item) }})"
                                                class="p-2 text-blue-400 hover:bg-blue-500/10 rounded-lg transition"
                                                title="Edit">
                                                <i class="fa-solid fa-pen"></i>
                                            </button>

                                            {{-- Delete Form --}}
                                            <form action="{{ route('admin.assessments.destroy', $item->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus soal ini? Data jawaban user terkait soal ini juga akan terhapus.')">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                    class="p-2 text-red-400 hover:bg-red-500/10 rounded-lg transition"
                                                    title="Delete">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                                        <i class="fa-regular fa-folder-open text-4xl mb-3 block"></i>
                                        Belum ada pertanyaan assessment.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="p-4 border-t border-slate-800">
                    {{ $assessments->links() }}
                </div>
            </div>
        </div>

        {{-- =========================== --}}
        {{-- MODAL FORM (ADD / EDIT)     --}}
        {{-- =========================== --}}
        <div x-show="showModal" style="display: none;" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" class="fixed inset-0 z-50 flex items-center justify-center p-4">

            {{-- Backdrop --}}
            <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-sm" @click="closeModal()"></div>

            <div class="relative bg-slate-900 border border-slate-700 w-full max-w-lg rounded-2xl shadow-2xl p-6">
                <h3 class="text-xl font-bold text-white mb-6" x-text="isEdit ? 'Edit Question' : 'Add New Question'"></h3>

                {{-- Form --}}
                <form :action="actionUrl" method="POST">
                    @csrf
                    <input type="hidden" name="_method" :value="isEdit ? 'PUT' : 'POST'">

                    <div class="space-y-5">
                        {{-- Type Selection --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-400 mb-1 uppercase tracking-wider">Question
                                Category</label>
                            <select name="type" x-model="form.type"
                                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-emerald-500 outline-none appearance-none cursor-pointer">
                                <option value="soft_skill">Soft Skill</option>
                                <option value="digital_skill">Digital Skill</option>
                                <option value="workplace_readiness">Workplace Readiness</option>
                            </select>
                        </div>

                        {{-- Question Text --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-400 mb-1 uppercase tracking-wider">Question
                                Text</label>
                            <textarea name="question" x-model="form.question" rows="4" required
                                class="w-full bg-slate-950 border border-slate-700 rounded-xl px-4 py-3 text-white focus:border-emerald-500 outline-none resize-none leading-relaxed"
                                placeholder="Tulis pertanyaan di sini..."></textarea>
                        </div>
                    </div>

                    <div class="flex gap-3 mt-8">
                        <button type="button" @click="closeModal()"
                            class="flex-1 py-2.5 border border-slate-700 rounded-xl text-slate-400 hover:text-white font-medium transition">Cancel</button>
                        <button type="submit"
                            class="flex-1 py-2.5 bg-emerald-600 hover:bg-emerald-500 text-white rounded-xl font-bold shadow-lg shadow-emerald-900/20 transition">
                            <span x-text="isEdit ? 'Update Changes' : 'Save Question'"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
