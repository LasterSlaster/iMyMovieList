<?PHP

use Illuminate\Database\Seeder;
use App\WatchList;
use App\SeenList;

/**
 * Class UsersTableAdminSeeder for seeding admins
 */
class UsersTableAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminDima = new \App\User();
        $adminDima->nickname = 'dima';
        $adminDima->email = 'dima@email.de';
        $adminDima->password = bcrypt('admin');
        $adminDima->remember_token = str_random(10);
        $adminDima->role = 'admin';
        $adminDima->save();

        $watchlist = new WatchList(['user_id' => $adminDima->id]);
        $watchlist->save();
        $seenlist = new SeenList(['user_id' => $adminDima->id]);

        $seenlist->save();

        $adminMarius = new \App\User();
        $adminMarius->nickname = 'marius';
        $adminMarius->email = 'marius@email.de';
        $adminMarius->password = bcrypt('admin');
        $adminMarius->remember_token = str_random(10);
        $adminMarius->role = 'admin';
        $adminMarius->save();

        $watchlist = new WatchList(['user_id' => $adminMarius->id]);
        $watchlist->save();
        $seenlist = new SeenList(['user_id' => $adminMarius->id]);
        $seenlist->save();

    }
}
