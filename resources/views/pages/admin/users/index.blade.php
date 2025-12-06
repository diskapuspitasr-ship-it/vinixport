@extends('layouts.master')

@section('title', 'Manage Users')

@section('content')
    {{-- 1. x-data dipindah ke root element agar mencakup semua --}}
    <div class="min-h-screen bg-slate-950 text-slate-200 pt-28 pb-12 px-4 relative font-sans" x-data="{
        showModal: false,
        isEdit: false,
        userId: null,
        form: { name: '', email: '', role: 'user', password: '' },

        // Helper untuk set URL action form
        get actionUrl() {
            return this.isEdit ? '{{ url('admin/users') }}/' + this.userId : '{{ route('admin.users.store') }}';
        },

        openCreate() {
            this.isEdit = false;
            this.userId = null;
            this.form = { name: '', email: '', role: 'user', password: '' };
            this.showModal = true;
            document.body.classList.add('overflow-hidden');
        },

        openEdit(user) {
            this.isEdit = true;
            this.userId = user.id;
            // Clone object user ke form agar reaktif
            this.form = {
                name: user.name,
                email: user.email,
                role: user.role,
                password: ''
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
            <div class="absolute top-0 right-0 w-1/2 h-1/2 bg-blue-900/20 rounded-full blur-[120px]"></div>
        </div>

        <div class="container mx-auto relative z-10">

            {{-- Header --}}
            <div class="flex justify-between items-end mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-white">User Management</h1>
                    <p class="text-slate-400">Kelola akun pengguna</p>
                </div>
                <button @click="openCreate()"
                    class="bg-blue-600 hover:bg-blue-500 text-white px-5 py-2.5 rounded-xl font-bold shadow-lg flex items-center gap-2 transition">
                    <i class="fa-solid fa-plus"></i> Add User
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

            {{-- Error Validation Global (Optional) --}}
            @if ($errors->any())
                <div class="bg-red-500/10 border border-red-500/20 text-red-400 p-4 rounded-xl mb-6">
                    <ul class="list-disc list-inside text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Table Card --}}
            <div class="bg-slate-900/60 backdrop-blur-xl border border-slate-800 rounded-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-900 text-slate-400 uppercase font-semibold">
                            <tr>
                                <th class="px-6 py-4">Name</th>
                                <th class="px-6 py-4">Role</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-800">
                            @foreach ($users as $u)
                                <tr class="hover:bg-slate-800/50 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 rounded-full bg-slate-800 flex items-center justify-center text-slate-500 font-bold border border-slate-700">
                                                {{ substr($u->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-white">{{ $u->name }}</div>
                                                <div class="text-slate-500 text-xs">{{ $u->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-bold uppercase
                                    {{ $u->role === 'admin'
                                        ? 'bg-purple-500/10 text-purple-400 border border-purple-500/20'
                                        : ($u->role === 'mentor'
                                            ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20'
                                            : 'bg-blue-500/10 text-blue-400 border border-blue-500/20') }}">
                                            {{ $u->role }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-emerald-400 text-xs flex items-center gap-1">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Active
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex justify-end gap-2">
                                            {{-- View Detail --}}
                                            <a href="{{ route('admin.users.show', $u->id) }}"
                                                class="p-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded-lg transition"
                                                title="View Detail">
                                                <i class="fa-regular fa-eye"></i>
                                            </a>

                                            {{-- Edit Modal Trigger (PERBAIKAN: Pake json_encode agar aman) --}}
                                            <button type="button" @click="openEdit({{ json_encode($u) }})"
                                                class="p-2 text-blue-400 hover:bg-blue-500/10 rounded-lg transition"
                                                title="Edit">
                                                <i class="fa-solid fa-pen"></i>
                                            </button>

                                            {{-- Delete Form --}}
                                            <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST"
                                                onsubmit="return confirm('Hapus user ini? Data tidak bisa dikembalikan.')">
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
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="p-4 border-t border-slate-800">
                    {{ $users->links() }}
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

            <div class="absolute inset-0 bg-slate-950/80 backdrop-blur-sm" @click="closeModal()"></div>

            <div class="relative bg-slate-900 border border-slate-700 w-full max-w-md rounded-2xl shadow-2xl p-6">
                <h3 class="text-xl font-bold text-white mb-4" x-text="isEdit ? 'Edit User' : 'Add New User'"></h3>

                {{-- Dynamic Form Action --}}
                <form :action="actionUrl" method="POST">
                    @csrf
                    <input type="hidden" name="_method" :value="isEdit ? 'PUT' : 'POST'">

                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-400 mb-1">Full Name</label>
                            <input type="text" name="name" x-model="form.name" required
                                class="w-full bg-slate-950 border border-slate-700 rounded-lg px-3 py-2 text-white focus:border-blue-500 outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-400 mb-1">Email Address</label>
                            <input type="email" name="email" x-model="form.email" required
                                class="w-full bg-slate-950 border border-slate-700 rounded-lg px-3 py-2 text-white focus:border-blue-500 outline-none">
                        </div>

                        {{-- <div>
                            <label class="block text-xs font-bold text-slate-400 mb-1">Role</label>
                            <select name="role" x-model="form.role"
                                class="w-full bg-slate-950 border border-slate-700 rounded-lg px-3 py-2 text-white focus:border-blue-500 outline-none">
                                <option value="user">User</option>
                                <option value="mentor">Mentor</option>
                                <option value="admin">Admin</option>
                            </select>
                        </div> --}}

                        <div>
                            <label class="block text-xs font-bold text-slate-400 mb-1">Password</label>
                            <input type="password" name="password" x-model="form.password" :required="!isEdit"
                                class="w-full bg-slate-950 border border-slate-700 rounded-lg px-3 py-2 text-white focus:border-blue-500 outline-none"
                                placeholder="Min. 8 characters">
                            <p x-show="isEdit" class="text-[10px] text-slate-500 mt-1">*Leave blank to keep current password
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-3 mt-6">
                        <button type="button" @click="closeModal()"
                            class="flex-1 py-2 border border-slate-700 rounded-lg text-slate-400 hover:text-white transition">Cancel</button>
                        <button type="submit"
                            class="flex-1 py-2 bg-blue-600 hover:bg-blue-500 text-white rounded-lg font-bold transition">Save</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
