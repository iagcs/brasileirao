<?php

namespace App\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Matches extends Model
{
    use HasFactory;

    protected $table = 'partidas';

    protected $fillable = [
        'time_visitante_id',
        'time_casa_id',
        'gols_visitante',
        'gols_em_casa'
    ];


    public function getNumberOfMatchesByFinalResult(int $teamId, $operator)
    {
        $timesCasa = DB::table($this->table)
            ->where('time_casa_id', $teamId)
            ->whereColumn('gols_em_casa', $operator, 'gols_visitante')
            ->get()
            ->toArray();

        $timesVisitante = DB::table($this->table)
            ->where('time_visitante_id', $teamId)
            ->whereColumn('gols_visitante', $operator, 'gols_em_casa')
            ->get()
            ->toArray();

        return sizeof(array_merge($timesCasa,$timesVisitante));
    }

    public function getNumberOfMatchesByTeam(int $teamId)
    {
        $stmt = DB::table($this->table)
        ->where('time_casa_id', $teamId)
        ->orWhere('time_visitante_id', $teamId)
        ->get()
        ->toArray();

        return sizeof($stmt);
    }

    public function getForAndProGoals(int $teamId, array $typeGoal)
    {
        $timesCasa = DB::table($this->table)
            ->where('time_casa_id', $teamId)
            ->sum($typeGoal[0]);

        $timesVisitante = DB::table($this->table)
            ->where('time_visitante_id', $teamId)
            ->sum($typeGoal[1]);

        return $timesVisitante + $timesCasa;
    }

    public function verifyConfrontationBetweenTeams(int $team1,int $team2)
    {
        if($message = $this->verifyTeamExists($team1, $team2)){
            return $message;
        }

        if($team1 == $team2){
            return "O mesmo time não pode se confrontar.";
        }

        if(sizeof(self::all()) >= 38*20){
            return "Todas rodadas ja aconteceram. O campeonato acabou!";
        }

        if($message = $this->verifyRoundsBetweenTwoTeams($team1, $team2)){
            return $message;
        }

    }

    public function verifyTeamExists($team1, $team2)
    {
        $team = Team::find($team1);
        $team2 = Team::find($team2);

        if(!$team || !$team2){
            return "Esses times não existem";
        }
    }

    public function verifyRoundsBetweenTwoTeams($team1, $team2)
    {
        $stmt1 = DB::table($this->table)
        ->where('time_casa_id', $team1)
        ->where('time_visitante_id',$team2)
        ->get()
        ->toArray();
        
        if(sizeof($stmt1) >= 1){
            $stmt2 = DB::table($this->table)
            ->where('time_casa_id', $team2)
            ->where('time_visitante_id',$team1)
            ->get()
            ->toArray();
            if(sizeof($stmt2) >= 1){
                return 'Os dois turnos desses times ja aconteceram.';
            }
            return 'Esse turno já aconteceu. Tem mais uma partida entre esses times no segundo turno. Troque o time visitante pelo time de casa.';
        }
    }
}
