<?PHP

use Illuminate\Database\Seeder;
use App\WatchList;
use App\SeenList;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class, 5)->create()
            ->each(function($u) {
                $u->watchList()->save(new WatchList(['user_id' => $u->id]));
                $u->seenList()->save(new SeenList(['user_id' => $u->id]));
            });
    }
}
