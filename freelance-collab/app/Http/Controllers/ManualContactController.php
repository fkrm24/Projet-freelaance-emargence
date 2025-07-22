<?php

namespace App\Http\Controllers;

use App\Models\ManualContact;
use Illuminate\Http\Request;

class ManualContactController extends Controller
{

    // Met à jour un contact manuel
    public function update(Request $request, ManualContact $manualcontact)
    {
        $validated = $request->validate([
            'societe' => 'required|string|max:255',
            'secteur' => 'required|string|max:255',
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'fonction' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'telephone' => 'required|string|max:20',
        ]);
        $manualcontact->update($validated);
        return redirect()->route('admin.contacts.index')->with('success', 'Contact mis à jour avec succès');
    }

    // Supprime un contact manuel
    public function destroy(ManualContact $manualcontact)
    {
        $manualcontact->delete();
        return redirect()->route('admin.contacts.index')->with('success', 'Contact supprimé avec succès');
    }
}
