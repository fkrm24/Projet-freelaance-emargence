
    open: false,
    showModal: false,
    societes: [],
    loading: false,
    form: {
        nom: '',
        adresse: '',
        siren: '',
        code_naf: ''
    },
    async fetchSocietes() {
        const res = await fetch('{{ route('admin.societes.list') }}', { headers: { 'Accept': 'application/json' } });
        this.societes = await res.json();
    },
    async addSociete() {
        if (!this.form.nom.trim()) return;
        this.loading = true;
        const res = await fetch('{{ route('admin.societes.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify(this.form)
        });
        const data = await res.json();
        if (data.success) {
            await this.fetchSocietes();
            this.form = { nom: '', adresse: '', siren: '', code_naf: '' };
            this.showModal = false;
        }
        this.loading = false;
    }
}"
    x-init="fetchSocietes()"
    class="relative inline-block text-left ml-4"
>
    <button @click="open = !open" class="bg-[#152C54] text-white px-4 py-2 rounded flex items-center gap-2">
        <span>🏢 Sociétés</span>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
    </button>
    <div x-show="open" @click.away="open = false" class="absolute z-30 mt-2 w-64 bg-white border border-gray-200 rounded shadow-lg p-2" x-transition>
        <div class="mb-2 flex justify-between items-center">
            <span class="font-semibold text-[#152C54]">Sociétés</span>
            <button @click.stop="showModal = true" title="Ajouter une société" class="w-8 h-8 flex items-center justify-center bg-green-500 text-blue-500 rounded-full hover:bg-green-600 transition">
                <span class="text-2xl leading-none">+</span>
            </button>
        </div>
        <!-- Modal -->
        <div x-show="showModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50" style="display: none;">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md relative">
                <button @click="showModal = false" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700">&times;</button>
                <h3 class="text-lg font-bold mb-4">Ajouter une société</h3>
                <form @submit.prevent="addSociete">
                    <div class="mb-3">
                        <label class="block text-sm font-semibold mb-1">Nom</label>
                        <input type="text" x-model="form.nom" required class="w-full border rounded px-2 py-1 text-sm">
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-semibold mb-1">Adresse</label>
                        <input type="text" x-model="form.adresse" class="w-full border rounded px-2 py-1 text-sm">
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-semibold mb-1">SIREN</label>
                        <input type="text" x-model="form.siren" maxlength="9" class="w-full border rounded px-2 py-1 text-sm">
                    </div>
                    <div class="mb-3">
                        <label class="block text-sm font-semibold mb-1">Code NAF</label>
                        <input type="text" x-model="form.code_naf" maxlength="5" class="w-full border rounded px-2 py-1 text-sm">
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="submit" :disabled="loading" class="bg-[#152C54] text-white px-4 py-2 rounded">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="max-h-60 overflow-y-auto">
            <template x-for="soc in societes" :key="soc.id">
                <div class="flex items-center justify-between group">
                  <a :href="'{{ url('/admin/societes') }}/' + soc.id" class="block px-2 py-1 hover:bg-gray-100 rounded text-sm flex-1"><span x-text="soc.nom"></span></a>
                  <form :action="'{{ url('/admin/societes') }}/' + soc.id" method="POST" class="ml-2" @submit.prevent.stop="if(confirm('Supprimer cette société ?')) { $event.target.submit(); }">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:text-red-900 font-bold text-lg opacity-0 group-hover:opacity-100 transition-opacity duration-150" title="Supprimer la société">&times;</button>
                  </form>
                </div>
            </template>
        </div>
    </div>
</div>
