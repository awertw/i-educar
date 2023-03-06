<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateLettersSituationNoteAverageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:letters-situation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Altera (media_arredondada) de números para letras e adicionando o número 1 em (situacao) onde( media) é >= 5 e (etapa) é 4 ou Rc';

    public function handle()
    {
        $obj = new \clsModulesNotaAluno();
        $obj->updateLettersSituationNoteAverage();
    }
}