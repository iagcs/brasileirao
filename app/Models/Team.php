<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Matches;

class Team extends Model
{
    use HasFactory;

    protected $table = 'clubes';

    protected $fillable = [
        'name',
        'logo'
    ];

    public function getInfosByEachTeam()
    {
        $teams = json_decode(self::all(),true);
        $match = new Matches();

        foreach($teams as $team){
            $jogos = $match->getNumberOfMatchesByTeam($team['id']);
            $vitorias = $match->getNumberOfMatchesByFinalResult($team['id'], '>');
            $empates = $match->getNumberOfMatchesByFinalResult($team['id'], '=');
            $derrotas = $match->getNumberOfMatchesByFinalResult($team['id'], '<');
            $pontos = ($vitorias * 3) + $empates;
            $golsPro = $match->getForAndProGoals($team['id'], ['gols_em_casa', 'gols_visitante']);
            $golsContra = $match->getForAndProGoals($team['id'], ['gols_visitante', 'gols_em_casa']);
            $saldoGols = $golsPro - $golsContra;

            $dados[$team['id']] = [
                'nome' => $team['name'],
                'jogos' => $jogos,
                'vitorias' => $vitorias,
                'derrotas' => $derrotas,
                'empates' => $empates,
                'pontos' => $pontos,
                'gols_pro' => $golsPro,
                'gols_contra' => $golsContra,
                'saldo_gols' => $saldoGols,
            ];
        }

        return $this->ordenaTimes($dados);
    }

    public function ordenaTimes(array $dados)
    {
        usort($dados, fn ($item1, $item2): int =>
            [
                $item2['pontos'],
                $item2['vitorias'],
                $item2['saldo_gols'],
                $item2['gols_pro'],
            ]
            <=>
            [
                $item1['pontos'],
                $item1['vitorias'],
                $item1['saldo_gols'],
                $item1['gols_pro'],
            ]
        );

        return $dados;
    }
}
