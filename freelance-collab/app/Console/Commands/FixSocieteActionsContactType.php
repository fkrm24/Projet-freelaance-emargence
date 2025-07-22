<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FixSocieteActionsContactType extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fix-societe-actions-contact-type';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Corrige le champ contact_type des actions de société (manuel/référence)';

    public function handle()
    {
        // Correction pour les contacts manuels
        $manualIds = \DB::table('manual_contacts')->pluck('id')->toArray();
        $countManual = \DB::table('societe_actions')
            ->whereNull('contact_type')
            ->whereIn('contact_id', $manualIds)
            ->update(['contact_type' => \App\Models\ManualContact::class]);

        // Correction pour les contacts de référence
        $contactIds = \DB::table('contacts')->pluck('id')->toArray();
        $countReference = \DB::table('societe_actions')
            ->whereNull('contact_type')
            ->whereIn('contact_id', $contactIds)
            ->update(['contact_type' => \App\Models\Contact::class]);

        $this->info("$countManual actions corrigées (manuel), $countReference actions corrigées (référence)");
    }
}
