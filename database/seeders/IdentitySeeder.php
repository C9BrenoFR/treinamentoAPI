<?php

namespace Database\Seeders;

use App\Models\Identity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IdentitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Identity::create([
            'title' => 'Missão',
            'text' => 'Nossa missão é proporcionar serviços e produtos de qualidade, buscando sempre a satisfação dos nossos clientes. Comprometemo-nos a agir com responsabilidade, integridade e inovação, garantindo um impacto positivo na vida das pessoas e na sociedade.',
        ]);

        Identity::create([
            'title' => 'Visão',
            'text' => 'Nossa visão é ser referência no nosso segmento, reconhecida pela excelência, inovação e compromisso com a sustentabilidade. Aspiramos a crescer de forma contínua e responsável, adaptando-nos às necessidades e expectativas dos nossos clientes e colaboradores.',
        ]);

        Identity::create([
            'title' => 'Valores',
            'text' => 'Nossos valores são a base de todas as nossas ações e decisões. Buscamos a excelência em tudo o que fazemos, desde a qualidade dos nossos produtos e serviços até o atendimento ao cliente. Atuamos com integridade, sempre de maneira ética e transparente.',
        ]);
    }
}
