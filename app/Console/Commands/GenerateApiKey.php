<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ApiKey;
use App\Models\Zeitraum;

class GenerateApiKey extends Command
{
    protected $signature = 'api:generate-key {vertrag_id} {--master} {--bearbeiter_id=1}';
    protected $description = 'Generate a new API key for a contract';

    public function handle()
    {
        $vertragId = $this->argument('vertrag_id');
        $isMaster = $this->option('master');
        $bearbeiterId = $this->option('bearbeiter_id');

        // Create a long-term validity period
        $zeitraum = Zeitraum::create([
            'von' => now(),
            'bis' => now()->addYears(50)
        ]);

        // Generate API key
        $apikey = hash('sha1', uniqid() . microtime() . random_bytes(32));

        $apiKey = ApiKey::create([
            'apikey' => $apikey,
            'vertrag_id' => $vertragId,
            'zeitraum_id' => $zeitraum->zeitraum_id,
            'ist_masterkey' => $isMaster,
            'bearbeiter_id' => $bearbeiterId
        ]);

        $this->info('API Key generated successfully!');
        $this->line('API Key: ' . $apikey);
        $this->line('Contract ID: ' . $vertragId);
        $this->line('Is Master Key: ' . ($isMaster ? 'Yes' : 'No'));
        $this->line('Valid from: ' . $zeitraum->von);
        $this->line('Valid until: ' . $zeitraum->bis);

        return 0;
    }
}
