<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\Clients;

class ImportWhatsappContacts extends Command
{
    protected $signature = 'import:whatsapp-contacts {file}';
    protected $description = 'Importa contatos do relatório JSON do WhatsApp';

    public function handle()
    {
        $filePath = $this->argument('file');

        if (!File::exists($filePath)) {
            $this->error("Arquivo não encontrado: $filePath");
            return;
        }

        $jsonData = File::get($filePath);
        $data = json_decode($jsonData, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error("Erro no JSON: " . json_last_error_msg());
            return;
        }

        if (!isset($data['wa_contacts'])) {
            $this->error("Nenhum contato encontrado no JSON.");
            return;
        }

        $this->info('Importando contatos...');

        foreach ($data['wa_contacts'] as $contact) {
            $name = $contact['FN'] ?? 'Desconhecido';
            $phones = $contact['TEL'] ?? [];  

            if (is_array($phones)) {
                foreach ($phones as $phone) {
                    $this->info("Importando contato: Nome: $name, Telefone: $phone");

                    if ($phone && is_string($phone)) {
                        if (is_string($name)) {
                            Clients::updateOrCreate(
                                ['phone' => $phone],  
                                ['name' => $name]     
                            );
                        } else {
                            $this->error("Nome inválido para o telefone: $phone");
                        }
                    } else {
                        $this->error("Telefone inválido ou ausente para o contato: $name");
                    }
                }
            } else {
                $phone = $phones; 
                $this->info("Importando contato: Nome: $name, Telefone: $phone");

                if ($phone && is_string($phone)) {
                    if (is_string($name)) {
                        Clients::updateOrCreate(
                            ['phone' => $phone],  
                            ['name' => $name]     
                        );
                    } else {
                        $this->error("Nome inválido para o telefone: $phone");
                    }
                } else {
                    $this->error("Telefone inválido ou ausente para o contato: $name");
                }
            }
        }

        $this->info('Importação concluída!');
    }
}
