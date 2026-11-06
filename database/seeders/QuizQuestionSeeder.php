<?php

namespace Database\Seeders;

use App\Models\QuizQuestion;
use Illuminate\Database\Seeder;

class QuizQuestionSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [
            ['facil', 'Em qual cidade brasileira Neymar nasceu?', ['Rio de Janeiro', 'Mogi das Cruzes', 'Santos', 'São Paulo'], 1, 'Neymar nasceu em Mogi das Cruzes, no estado de São Paulo.'],
            ['facil', 'Qual clube revelou Neymar para o futebol profissional?', ['Santos', 'Flamengo', 'Palmeiras', 'Corinthians'], 0, 'Foi no Santos FC que Neymar surgiu para o futebol profissional.'],
            ['facil', 'Qual é o apelido pelo qual Neymar ficou conhecido na base do Santos?', ['Menino da Vila', 'Rei do Maracanã', 'Furacão', 'Garoto de Ouro'], 0, 'Neymar é lembrado como um dos grandes Meninos da Vila.'],
            ['facil', 'Em qual seleção Neymar joga?', ['Argentina', 'Portugal', 'Brasil', 'Espanha'], 2, 'Neymar representa a Seleção Brasileira.'],
            ['facil', 'Qual camisa ficou mais associada a Neymar na Seleção?', ['7', '9', '10', '11'], 2, 'A camisa 10 é uma das marcas de Neymar na Amarelinha.'],
            ['medio', 'Em que ano o Santos conquistou a Libertadores com Neymar?', ['2009', '2010', '2011', '2012'], 2, 'O Santos venceu a Libertadores em 2011.'],
            ['medio', 'Qual prêmio individual Neymar recebeu em 2011 pelo gol mais bonito do ano?', ['Bola de Ouro', 'Prêmio Puskás', 'Chuteira de Ouro', 'The Best'], 1, 'Neymar recebeu o Prêmio Puskás da FIFA em 2011.'],
            ['medio', 'Qual foi o adversário do Barcelona na final da Champions de 2015?', ['Real Madrid', 'Bayern de Munique', 'Juventus', 'Manchester United'], 2, 'O Barcelona venceu a Juventus por 3 a 1 na final de 2015.'],
            ['medio', 'Em qual cidade foram disputados os Jogos Olímpicos em que o Brasil conquistou o ouro no futebol?', ['Londres', 'Tóquio', 'Atenas', 'Rio de Janeiro'], 3, 'O ouro olímpico veio nos Jogos do Rio, em 2016.'],
            ['medio', 'Qual trio ofensivo ficou conhecido como MSN no Barcelona?', ['Messi, Suárez e Neymar', 'Messi, Iniesta e Neymar', 'Suárez, Neymar e Pedro', 'Messi, Suárez e Pedro'], 0, 'MSN era o trio formado por Messi, Suárez e Neymar.'],
            ['dificil', 'Contra qual clube Neymar marcou seu primeiro gol profissional pelo Santos?', ['Palmeiras', 'Mogi Mirim', 'Corinthians', 'Oeste'], 1, 'O primeiro gol profissional foi contra o Mogi Mirim, em 2009.'],
            ['dificil', 'Em qual estádio foi disputada a final olímpica de futebol masculino em 2016?', ['Mineirão', 'Maracanã', 'Arena Corinthians', 'Mané Garrincha'], 1, 'A final olímpica foi disputada no Maracanã, no Rio de Janeiro.'],
            ['dificil', 'Qual clube Neymar enfrentou na final do Mundial de Clubes de 2011?', ['Chelsea', 'Manchester United', 'Barcelona', 'Bayern de Munique'], 2, 'O Santos enfrentou o Barcelona na final do Mundial de Clubes de 2011.'],
            ['dificil', 'Em qual competição Neymar marcou o gol que garantiu o ouro olímpico ao Brasil?', ['Copa América', 'Copa das Confederações', 'Jogos Olímpicos', 'Copa do Mundo'], 2, 'O gol decisivo foi na final dos Jogos Olímpicos Rio 2016.'],
            ['dificil', 'Em que ano Neymar estreou pela Seleção principal?', ['2009', '2010', '2011', '2012'], 1, 'Neymar estreou pela Seleção principal em 2010.'],
        ];

        foreach ($questions as [$difficulty, $question, $choices, $answerIndex, $explanation]) {
            QuizQuestion::query()->updateOrCreate(
                ['question' => $question],
                [
                    'difficulty' => $difficulty,
                    'choices' => $choices,
                    'answer_index' => $answerIndex,
                    'explanation' => $explanation,
                ]
            );
        }
    }
}
