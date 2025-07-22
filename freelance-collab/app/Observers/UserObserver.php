<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    public function creating(User $user)
    {
        // Par défaut, l'utilisateur n'est pas admin
        $user->is_admin = false;

        // Vérifie si l'email se termine par @emargence.fr
        if (str_ends_with($user->email, '@emargence.fr')) {
            $user->is_admin = true;
        }
    }
}
