<?php

use Illuminate\Database\Seeder;

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
        $movie->movie_code =  333339;
        $movie->movie_data = '{"id": 333339, "title": "Ready Player One", "cover": "http://image.tmdb.org/t/p/w342//zLVN8W7gJQg8cfUSTxbH7DohQ1U.jpg", "description": "Im Jahr 2045 spielt sich das Leben vieler Menschen auf der heruntergekommenen Erde zum groessten Teil nur noch in der OASIS ab. Das ist eine vom ebenso genialen wie exzentrischen Programmierer und Web-Designer James Halliday (Mark Rylance) erfundene virtuelle Welt, die mehr als die duestere Realitaet zu bieten hat. Die meiste Zeit seines jungen Lebens verbringt auch der 18-jaehrige Wade Watts (Tye Sheridan) damit, mit seinem Avatar Parzival in diese Welt einzutauchen und zu versuchen, die Aufgaben zu loesen, die Halliday vor seinem Tod in der OASIS hinterlassen hat. Demjenigen, der als erster alle Herausforderungen meistert, winkt naemlich unermesslicher Reichtum und die Kontrolle über die OASIS. Bislang sind Wade und seine Freunde zwar stets schon an der ersten Aufgabe gescheitert, doch sie geben nicht auf – ebenso wenig wie der skrupellose Konzernchef Nolan Sorrento (Ben Mendelsohn), der sich OASIS unbedingt unter den Nagel reißen will…"}';
        $movie->save();
    }
}
