<?php

use Illuminate\Database\Seeder;
use App\Movie;

class MoviesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $movie = new Movie();
        $movie->movie_code =  284053;
        $movie->movie_data = json_decode('{
        "backdrop_path": "http://image.tmdb.org/t/p/w1280//kaIfm5ryEOwYg8mLbq8HkPuM1Fo.jpg",
        "genre_ids": [
          {
            "id": 28,
            "name": "Action"
          },
          {
            "id": 12,
            "name": "Abenteuer"
          },
          {
            "id": 14,
            "name": "Fantasy"
          },
          {
            "id": 878,
            "name": "Science Fiction"
          },
          {
            "id": 35,
            "name": "Komödie"
          }
        ],
        "id": 284053,
        "overview": "Donnergott Thor wird auf der anderen Seite des Universums gefangengenommen. Ohne seinen nützlichen Hammer Mjölnir scheint eine Flucht nahezu ausgeschlossen. Dabei läuft ihm allmählich die Zeit davon. Denn die ebenso mächtige wie erbarmungslose Hela, die nach jahrtausendlanger Gefangenschaft aus ihrem Gefängnis freigekommen ist, droht Ragnarok einzuleiten, die Götterdämmerung. Dieses würde Asgard, Thors Heimatwelt, vernichten. Um das zu verhindern, setzt Thor alles daran, nach Hause zurückzukehren. Zwischen ihm und seiner Freiheit stehen jedoch tödliche Gladiatorenkämpfe auf dem Planeten Sakaar, die Mülldeponie des Universums. Bei einem dieser Duelle trifft Thor auf den Ex-Avenger und seinen früheren Mitstreiter Hulk den beliebtesten und erfolgreichsten Kämpfer auf Sakaar…",
        "poster_path": "http://image.tmdb.org/t/p/w342//uxxYhdSIsVOzmvUtDugBwEACbW9.jpg",
        "release_date": "2017-10-25",
        "tagline": null,
        "title": "Thor: Tag der Entscheidung",
        "vote_average": 7.4,
        "runtime": 130
         }');
        $movie->save();

        $movie2 = new Movie();
        $movie2->movie_code = 383498;
        $movie2->movie_data = json_decode(
        '{
        "backdrop_path": "http://image.tmdb.org/t/p/w1280//3P52oz9HPQWxcwHOwxtyrVV1LKi.jpg",
        "genre_ids": [
          {
              "id": 28,
            "name": "Action"
          },
          {
              "id": 35,
            "name": "Komödie"
          },
          {
              "id": 878,
            "name": "Science Fiction"
          }
        ],
        "id": 383498,
        "overview": "Nach einem weiteren herben Schicksalsschlag ist Deadpool des Lebens überdrüssig und versucht sich mithilfe von Benzinkanistern und einer Zigarette umzubringen. Doch der unkaputtbare Heros wird von seinem X-Men-Kumpan Colossus gerettet und mit auf das abgeschiedene Anwesen der Mutanten genommen, wo Deadpool auch die mittlerweile erwachsene Mutantin Negasonic Teenage Warhead wiedertrifft. Durch einen Zwischenfall mit dem Teenager-Mutanten Russell lernt Deadpool den Superschurken Cable kennen, der es auf den wütenden Halbstarken abgesehen hat. Zunächst kann Deadpool die Situation entschärfen – doch dann landen Russell und er plötzlich im Knast. Nun stellt er sich seine eigene Superheldencrew zusammen und rekrutiert unter anderem Domino und Zeitgeist um es mit Cable aufzunehmen…",
        "poster_path": "http://image.tmdb.org/t/p/w342//cqFabiBuY8JaPakSuAJIRdTOjQl.jpg",
        "release_date": "2018-05-15",
        "tagline": "Er kommt nicht allein",
        "title": "Deadpool 2",
        "vote_average": 7.7,
        "runtime": 119
      }');
        $movie2->save();
    }
}
