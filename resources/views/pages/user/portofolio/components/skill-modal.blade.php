<div x-show="showSkillModal" style="display: none;" class="fixed inset-0 z-[999] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-950/90 backdrop-blur-sm" @click="showSkillModal = false"></div>

    <div
        class="relative bg-slate-900 border border-slate-700 w-full max-w-lg rounded-2xl shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">

        <div class="p-6 border-b border-slate-800">
            <h3 class="text-xl font-bold text-white">Manage Technical Skills</h3>
            <p class="text-slate-400 text-sm">Tambahkan keahlian teknis Anda (Programming, Tools, dll).</p>
        </div>

        <div class="p-6 overflow-y-auto custom-scrollbar">
            <form action="{{ route('user.skills.update') }}" method="POST" id="skillForm">
                @csrf @method('PUT')

                {{-- Container untuk daftar skill (Alpine x-for) --}}
                <div class="space-y-3">
                    <template x-for="(skill, index) in skillsList" :key="index">
                        <div class="flex gap-3 items-start">
                            <div class="flex-1">
                                <input type="text" :name="`skills[${index}][skill_name]`" x-model="skill.skill_name"
                                    class="w-full bg-slate-950 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-blue-500 outline-none"
                                    placeholder="Skill Name (e.g. Laravel)" required>
                            </div>
                            <div class="w-1/3">
                                <select :name="`skills[${index}][level]`" x-model="skill.level"
                                    class="w-full bg-slate-950 border border-slate-700 rounded-lg px-3 py-2 text-sm text-white focus:border-blue-500 outline-none">
                                    <option value="Beginner">Beginner</option>
                                    <option value="Intermediate">Intermediate</option>
                                    <option value="Advanced">Advanced</option>
                                    <option value="Expert">Expert</option>
                                </select>
                            </div>
                            <button type="button" @click="removeSkill(index)"
                                class="p-2 text-slate-500 hover:text-red-400 transition">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </template>
                </div>

                {{-- Tombol Tambah Skill --}}
                <button type="button" @click="addSkill()"
                    class="mt-4 w-full py-2 border border-dashed border-slate-700 text-slate-400 rounded-lg hover:text-white hover:border-slate-500 transition text-sm flex items-center justify-center gap-2">
                    <i class="fa-solid fa-plus"></i> Add Another Skill
                </button>

                {{-- Pesan jika kosong --}}
                <div x-show="skillsList.length === 0" class="text-center text-slate-500 text-sm py-4">
                    Belum ada skill. Klik tombol di atas untuk menambah.
                </div>

                <div class="flex gap-3 mt-6 pt-6 border-t border-slate-800">
                    <button type="button" @click="showSkillModal = false"
                        class="flex-1 py-2.5 border border-slate-700 rounded-lg text-slate-400 hover:text-white text-sm font-bold transition">Cancel</button>
                    <button type="submit"
                        class="flex-1 py-2.5 bg-blue-600 hover:bg-blue-500 text-white rounded-lg font-bold transition text-sm">Save
                        Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
