<?php

namespace App\Controllers;

use App\Http\Http;
use Tightenco\Collect\Support\Collection;

class PlayerController
{
    /**
     * Show a player profile
     *
     * @param  int $id
     * @return \Illuminate\View\View
     */
    public function show($id = 1)
    {
        $c_id = $id;
        $p_id = (($id - 1) == 0) ? 8 : ($id - 1);
        $n_id = (($id + 1) == 9) ? 1 : ($id + 1);

        $player = $this->player($c_id);
        $prev_player = $this->player($p_id);
        $next_player = $this->player($n_id);

        // split first & last name
        $player->put('is_allblacks',  true);
        $names = collect(preg_split('/\s+/', $player->get('name')));
        $player->put('player_ids',  [$p_id, $c_id, $n_id]);
        $prev_player_name = $prev_player->get('name');
        $next_player_name = $next_player->get('name');
        $player->put('full_name', $names->join(' '));
        $player->put('prev_full_name', $prev_player_name);
        $player->put('next_full_name', $next_player_name);
        $player->put('image', $this->image($names->join(' ')));
        $player->put('last_name', $names->pop());
        $player->put('first_name', $names->join(' '));

        // determine the image filename from the name

        // stats to feature
        $player->put('featured', $this->feature($player));

        return view('player', $player);
    }

    public function nba_show($id = 1)
    {
        $c_id = $id;
        $p_id = (($id - 1) == 0) ? 7 : ($id - 1);
        $n_id = (($id + 1) == 8) ? 1 : ($id + 1);

        $player = $this->nba_player($c_id);
        $prev_player = $this->nba_player($p_id);
        $next_player = $this->nba_player($n_id);


        // split first & last name
        $player->put('is_allblacks',  false);
        $player->put('current_team',  $player->get("current_team"));
        $names = [$player->get('first_name'), $player->get('last_name')];
        $player->put('player_ids',  [$p_id, $c_id, $n_id]);
        $prev_player_name = $prev_player->get('first_name') . ' ' . $prev_player->get('last_name');
        $next_player_name = $next_player->get('first_name') . ' ' . $next_player->get('last_name');
        $player->put('full_name', $names[0].' '.$names[1]);
        $player->put('prev_full_name', $prev_player_name);
        $player->put('next_full_name', $next_player_name);
        $player->put('last_name', $names[1]);
        $player->put('first_name', $names[0]);

        // calculating age
        $dateOfBirth = $player->get('birthday');
        $today = date("Y-m-d");
        $diff = date_diff(date_create($dateOfBirth), date_create($today));
        $player->put('age', $diff->format('%y'));

        //calculating height
        $player->put('height', round(((($player->get('feet') * 12) + $player->get('inches') * 2.54) * 2.54),2));

        // determine the image filename from the name
        $player->put('image', $this->image($names[0].' '.$names[1]));

        // stats to feature
        $player_stats = $this->nba_stats($c_id);
        $player->put('featured', $this->nba_feature($player_stats));

        return view('player', $player);
    }

    /**
     * Retrieve player data from the API
     *
     * @param int $id
     * @return \Tightenco\Collect\Support\Collection
     */
    protected function player(int $id): Collection
    {
        $baseEndpoint = 'https://www.zeald.com/developer-tests-api/x_endpoint/allblacks';

        $json = Http::get("$baseEndpoint/id/$id", [
            'API_KEY' => env('API_KEY'),
        ])->json();

        return collect(array_shift($json));
    }

    protected function nba_player(int $id): Collection
    {
        $baseEndpoint = 'https://www.zeald.com/developer-tests-api/x_endpoint/nba.players';

        $json = Http::get("$baseEndpoint/id/$id", [
            'API_KEY' => env('API_KEY'),
        ])->json();

        return collect(array_shift($json));
    }

    protected function nba_stats(int $id): Collection
    {
        $baseEndpoint = 'https://www.zeald.com/developer-tests-api/x_endpoint/nba.stats';

        $json = Http::get("$baseEndpoint/player_id/$id", [
            'API_KEY' => env('API_KEY'),
        ])->json();

        return collect(array_shift($json));
    }

    /**
     * Determine the image for the player based off their name
     *
     * @param string $name
     * @return string filename
     */
    protected function image(string $name): string
    {
        return preg_replace('/\W+/', '-', strtolower($name)) . '.png';
    }

    protected function nba_image(string $name): string
    {
        return preg_replace('/\W+/', '-', strtolower($name)) . '.png';
    }

    /**
     * Build stats to feature for this player
     *
     * @param \Illuminate\Support\Collection $player
     * @return \Illuminate\Support\Collection features
     */
    protected function feature(Collection $player): Collection
    {
        return collect([
            ['label' => 'Points', 'value' => $player->get('points')],
            ['label' => 'Games', 'value' => $player->get('games')],
            ['label' => 'Tries', 'value' => $player->get('tries')],
        ]);
    }

    protected function nba_feature(Collection $player): Collection
    {
        $games = intval($player->get('games'));
        $assists = (intval( $player->get('points')));
        $points =  (intval( $player->get('rebounds')));
        $rebounds = (intval( $player->get('assists')));
        return collect([
            ['label' => 'Assists per game', 'value' => round(($assists / $games),2)],
            ['label' => 'Points per game', 'value' =>  round(($points / $games),2)],
            ['label' => 'Rebounds per game', 'value' => round(($rebounds / $games),2)],
        ]);
    }
}
