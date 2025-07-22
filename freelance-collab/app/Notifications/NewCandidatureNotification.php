<?php

namespace App\Notifications;

use App\Models\Profil;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCandidatureNotification extends Notification 
{
    

    public function __construct(protected Profil $profil)
    {
    }

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Nouvelle candidature reçue')
            ->line('Une nouvelle candidature a été soumise par ' . $this->profil->nom . ' ' . $this->profil->prenom)
            ->line('Profil : ' . $this->profil->profil)
            ->line('Expertise :' . $this->formatExpertises($this->profil->expertise))
            ->action('Voir la candidature', route('admin.dashboard'));
    }

    public function toArray($notifiable): array
    {
        return [
            'profil_id' => $this->profil->id,
            'nom' => $this->profil->nom,
            'prenom' => $this->profil->prenom,
            'profil' => $this->profil->profil,
        ];
        }

    /**
     * Formatte proprement le champ expertise pour l'affichage dans l'email
     */
    private function formatExpertises($expertises)
    {
        // Si c'est déjà un tableau, pas besoin de json_decode
        if (is_string($expertises)) {
            $expertises = json_decode($expertises, true);
        }
        if (!is_array($expertises)) {
            return '-';
        }
        $lines = [];
        foreach ($expertises as $exp) {
            $text = $exp['text'] ?? '';
            $cat = $exp['category'] ?? '';
            $lines[] = "- {$text}" . ($cat ? " ({$cat})" : "");
        }
        return implode("\n", $lines);
    }
}

