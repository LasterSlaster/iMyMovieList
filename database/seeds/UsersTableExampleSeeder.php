<?PHP

use Illuminate\Database\Seeder;
use App\WatchList;
use App\SeenList;

class UsersTableExampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $exampleAdmin = new \App\User();
        $exampleAdmin->nickname = 'exampleAdmin';
        $exampleAdmin->email = 'exampleAdmin@email.de';
        $exampleAdmin->password = bcrypt('admin');
        $exampleAdmin->remember_token = str_random(10);
        $exampleAdmin->role = 'admin';
        $exampleAdmin->save();

        $watchlist = new WatchList(['user_id' => $exampleAdmin->id]);
        $watchlist->save();
        $seenlist = new SeenList(['user_id' => $exampleAdmin->id]);

        $seenlist->save();

        $exampleUser = new \App\User();
        $exampleUser->nickname = 'exampleUser';
        $exampleUser->email = 'exampleUser@email.de';
        $exampleUser->password = bcrypt('user');
        $exampleUser->remember_token = str_random(10);
        $exampleUser->role = 'user';
        $exampleUser->save();

        $watchlist = new WatchList(['user_id' => $exampleUser->id]);
        $watchlist->save();
        $seenlist = new SeenList(['user_id' => $exampleUser->id]);

        $seenlist->save();
    }
}
