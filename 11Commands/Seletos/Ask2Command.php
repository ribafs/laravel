<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Ask2Command extends Command
{
    protected $signature = 'testes {difficulty}';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
   $questions = [
        'easy' => [
            'How old are you ?', "What is the name of your mother?",
            'Do you have 3 parents ?','Do you like Javascript?',
            'Do you know what is a JS promise?'
        ],
        'hard' => [
            'Why the sky is blue?', "Can a kangaroo jump higher than a house?",
            'Do you think i am a bad father?','why the dinosaurs disappeared?',
            "why don't whales have gills?"
        ]
    ];
    $difficulty = $this->argument('difficulty');
    $questionsToAsk = $questions[$difficulty];
    $answers = [];

    foreach($questionsToAsk as $question){
        $answer = $this->ask($question);
        array_push($answers,$answer);
    }

    $this->info("Thanks for do the quiz in the console, your answers : ");

    for($i = 0;$i <= (count($questionsToAsk) -1 );$i++){
        $this->line(($i + 1).') '. $answers[$i]);
    }

    }
}
