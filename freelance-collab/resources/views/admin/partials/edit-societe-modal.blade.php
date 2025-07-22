
<script>
function openEditSocieteModal(societe) {
    document.getElementById('editSocieteId').value = societe.id;
    document.getElementById('editSocieteNom').value = societe.nom ?? '';
    document.getElementById('editSocieteAdresse').value = societe.adresse ?? '';
    document.getElementById('editSocieteSiren').value = societe.siren ?? '';
    document.getElementById('editSocieteCodeNaf').value = societe.code_naf ?? '';
    document.getElementById('editSocieteModal').classList.remove('hidden');
}
</script>

<div id="editSocieteModal" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-md relative">
        <button type="button" onclick="document.getElementById('editSocieteModal').classList.add('hidden')" class="absolute top-2 right-2 text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
        <h3 class="text-lg font-bold mb-4">Modifier la société</h3>
        <form id="editSocieteForm" method="POST">
            @csrf
            @method('PUT')
            <input type="hidden" name="id" id="editSocieteId">
            <div class="mb-3">
                <label class="block text-sm font-semibold mb-1">Nom</label>
                <input type="text" name="nom" id="editSocieteNom" required class="w-full border rounded px-2 py-1 text-sm">
            </div>
            <div class="mb-3">
                <label class="block text-sm font-semibold mb-1">Adresse</label>
                <input type="text" name="adresse" id="editSocieteAdresse" class="w-full border rounded px-2 py-1 text-sm">
            </div>

            <div class="mb-3">
                <label class="block text-sm font-semibold mb-1">SIREN</label>
                <input type="text" name="siren" id="editSocieteSiren" maxlength="9" class="w-full border rounded px-2 py-1 text-sm">
            </div>
            <div class="mb-3">
                <label class="block text-sm font-semibold mb-1">Code NAF</label>
                <input type="text" name="code_naf" id="editSocieteCodeNaf" maxlength="5" class="w-full border rounded px-2 py-1 text-sm">
            </div>
            <div class="flex justify-end gap-2 mt-4">
                <button type="button" onclick="document.getElementById('editSocieteModal').classList.add('hidden')" class="px-4 py-2 bg-gray-200 text-[#152C54] rounded hover:bg-gray-300">Annuler</button>
                <button type="submit" class="px-4 py-2 bg-[#152C54] text-white rounded hover:bg-[#2748E9]">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
