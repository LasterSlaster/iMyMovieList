<?php

use Faker\Generator as Faker;

$factory->define(App\Movie::class, function (Faker $faker) {
    $movieData = ['{"id":447332 , "title": "A Quiet Place", "cover": "http://image.tmdb.org/t/p/w342//nAU74GmpUk7t5iklEp3bufwDq4n.jpg", "description": "Die Welt ist von rätselhaften, scheinbar unverwundbaren Kreaturen eingenommen worden, die durch jedes noch so kleine Geräusch angelockt werden und sich auf die Jagd begeben… Lediglich einer einzigen Familie gelang es bisher zu überleben. Der Preis hierfür ist jedoch hoch: Ihr gesamter Alltag ist darauf ausgerichtet, sich vollkommen lautlos zu verhalten, denn das kleinste Geräusch könnte ihr Ende bedeuten..."}',
        '{"id": 333339, "title": "Ready Player One", "cover": "http://image.tmdb.org/t/p/w342//zLVN8W7gJQg8cfUSTxbH7DohQ1U.jpg", "description": "Im Jahr 2045 spielt sich das Leben vieler Menschen auf der heruntergekommenen Erde zum groessten Teil nur noch in der OASIS ab. Das ist eine vom ebenso genialen wie exzentrischen Programmierer und Web-Designer James Halliday (Mark Rylance) erfundene virtuelle Welt, die mehr als die duestere Realitaet zu bieten hat. Die meiste Zeit seines jungen Lebens verbringt auch der 18-jaehrige Wade Watts (Tye Sheridan) damit, mit seinem Avatar Parzival in diese Welt einzutauchen und zu versuchen, die Aufgaben zu loesen, die Halliday vor seinem Tod in der OASIS hinterlassen hat. Demjenigen, der als erster alle Herausforderungen meistert, winkt naemlich unermesslicher Reichtum und die Kontrolle über die OASIS. Bislang sind Wade und seine Freunde zwar stets schon an der ersten Aufgabe gescheitert, doch sie geben nicht auf – ebenso wenig wie der skrupellose Konzernchef Nolan Sorrento (Ben Mendelsohn), der sich OASIS unbedingt unter den Nagel reißen will…"}',
        '{"id": 338970, "title": "Tomb Raider", "cover": "http://image.tmdb.org/t/p/w342//nUxWQuprczliC9iw3SViJ8ga63F.jpg", "description": "Vor sieben Jahren verschwand Lord Richard Croft, der Vater der mittlerweile 21-jährigen Lara Croft , doch noch immer hat sie nicht die Kontrolle über dessen global agierendes Wirtschaftsimperium übernommen, sondern lebt als Studentin und Fahrradkurierin in London. Eines Tages beschließt Lara dann jedoch, dem Verschwinden ihres Vaters nachzuspüren, und reist dafür zu seinem letzten bekannten Aufenthaltsort, einer kleinen Insel vor der Küste von Japan. Dort hatte dieser ein geheimnisvolles Grabmal untersucht. Doch kaum auf der Insel angekommen, sieht sich Lara zahlreichen lebensbedrohlichen Gefahren ausgesetzt und sie muss bis an ihre Grenzen gehen und - ausgestattet lediglich mit ihrem scharfen Verstand und ihrem beträchtlichen Willen - um ihr Überleben kämpfen."}',
        '{"id": 396371, "title": "Molly\'s Game", "cover": "http://image.tmdb.org/t/p/w342//83k7FXpyV3xyOwyq1W7hBO6GVJA.jpg", "description": "Molly Bloom (Jessica Chastain) ist eine junge talentierte Skifahrerin und die große Hoffnung der USA bei den Olympischen Spielen, doch nach einer schweren Verletzung muss sie ihre Karriere notgedrungen aufgeben. Auch ihr Jurastudium schmeißt Molly wenig später hin und landet über Umwege schließlich in der Welt des Underground-Pokers. Schnell erkennt sie, dass sie ein Talent für die Organisation der illegalen Wettbewerbe hat und stellt schließlich ihr eigenes Pokerturnier auf die Beine – der Beginn einer langen Karriere. Zu Mollys Klientel zählen prominente Gesichter aus Hollywood, Sportstars, einflussreiche Geschäftsmänner sowie auch – allerdings ohne Blooms Wissen – die russische Mafia. Dadurch findet das große Geschäft eines Tages ein jähes Ende – mitten in der Nacht wird Molly vom FBI verhaftet. Als ihr einziger Verbündeter entpuppt sich ihr Strafverteidiger Harlie Jaffey (Idris Elba). Er ahnt, dass in Bloom mehr steckt als in den Boulevard-Blätter geschrieben steht…"}',
        '{"id": 429351, "title": "Operation: 12 Strong", "cover": "http://image.tmdb.org/t/p/w342//j18021qCeRi3yUBtqd2UFj1c0RQ.jpg", "description": "Ein Team aus CIA-Agenten und Spezialeinheiten zieht nach den Anschlägen des 11. September in Afghanistan ein, um die Taliban zu zerschlagen."}',
        '{"id": 268896, "title": "Pacific Rim 2: Uprising", "cover": "http://image.tmdb.org/t/p/w342//v5HlmJK9bdeHxN2QhaFP1ivjX3U.jpg", "description": "Vor einiger Zeit sah es noch danach aus, als würde Jake Pentecost eine glorreiche Zukunft als Jaeger-Pilot beschieden sein, der mit seinen Fähigkeiten dabei hilft, die Menschheit vor den monströsen Kaiju zu beschützen. Damit hätte er in die Fußstapfen seines Vaters treten können, der einst den Widerstand gegen die Monster aus einer anderen Welt anführte. Aber weil dieser in seine Ziehtochter Mako mehr Hoffnungen legte und Jake dessen Erwartungen nie wirklich zu erfüllen vermochte, verabschiedete er sich vom Pilotentraining und landete in der Unterwelt, wo er sich zum Dieb und Schwarzmarkthändler mauserte. Doch die Welt braucht ihn: Eine nie zuvor gesehene Bedrohung schickt sich dazu an, Städte in Schutt und Asche zu legen und Mako führt eine neue Generation junger Jaeger-Piloten an, zu der sich auch Jake gesellen soll."}'];
    return [

        'movie_code' => $faker->unique()->name(),
        //TODO: Change movie data back to $faker->randomElement($movieData);
        'movie_data' => '{"id": 268896, "title": "Pacific Rim 2: Uprising", "cover": "http://image.tmdb.org/t/p/w342//v5HlmJK9bdeHxN2QhaFP1ivjX3U.jpg", "description": "Vor einiger Zeit sah es noch danach aus, als würde Jake Pentecost eine glorreiche Zukunft als Jaeger-Pilot beschieden sein, der mit seinen Fähigkeiten dabei hilft, die Menschheit vor den monströsen Kaiju zu beschützen. Damit hätte er in die Fußstapfen seines Vaters treten können, der einst den Widerstand gegen die Monster aus einer anderen Welt anführte. Aber weil dieser in seine Ziehtochter Mako mehr Hoffnungen legte und Jake dessen Erwartungen nie wirklich zu erfüllen vermochte, verabschiedete er sich vom Pilotentraining und landete in der Unterwelt, wo er sich zum Dieb und Schwarzmarkthändler mauserte. Doch die Welt braucht ihn: Eine nie zuvor gesehene Bedrohung schickt sich dazu an, Städte in Schutt und Asche zu legen und Mako führt eine neue Generation junger Jaeger-Piloten an, zu der sich auch Jake gesellen soll."}'
    ];
});
