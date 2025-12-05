<div x-show="isEditingProfile" style="display: none;" x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0" class="fixed inset-0 z-[999] flex items-center justify-center p-4">

    <div class="fixed inset-0 bg-slate-950/80 backdrop-blur-sm transition-opacity" @click="isEditingProfile = false">
    </div>

    <div class="relative bg-slate-900 border border-slate-700 w-full max-w-md rounded-2xl shadow-2xl overflow-hidden">
        <div class="p-6">
            <h3 class="text-xl font-bold text-white mb-1">Edit Profile</h3>
            <p class="text-slate-400 text-sm mb-6">Update your basic information.</p>

            <form action="{{ route('user.profile.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                {{-- Name --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Full Name</label>
                    <input type="text" name="name" value="{{ $user->name }}" required
                        class="w-full bg-slate-950 border border-slate-700 rounded-lg px-3 py-2 text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- Email --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-400 mb-1">Email Address</label>
                    <input type="email" name="email" value="{{ $user->email }}" required
                        class="w-full bg-slate-950 border border-slate-700 rounded-lg px-3 py-2 text-sm text-slate-100 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="flex gap-3 pt-4">
                    <button type="button" @click="isEditingProfile = false"
                        class="flex-1 py-2.5 border border-slate-700 rounded-lg text-slate-400 font-bold hover:bg-slate-800 hover:text-white transition-all text-sm">
                        Cancel
                    </button>
                    <button type="submit"
                        class="flex-1 py-2.5 bg-blue-600 hover:bg-blue-500 text-white rounded-lg font-bold shadow-lg shadow-blue-900/30 transition-all text-sm">
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
