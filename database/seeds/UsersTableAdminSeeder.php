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
        $adminDima->password = 'admin';
        $adminDima->remember_token = str_random(10);
        $adminDima->role = 'admin';
        $adminDima->watchList = new WatchList(['user_id' => $adminDima->id]);
        $adminDima->seenList = new SeenList(['user_id' => $adminDima->id]);

        $adminMarius = new \App\User();
        $adminMarius->nickname = 'marius';
        $adminMarius->email = 'marius@email.de';
        $adminMarius->password = 'admin';
        $adminMarius->remember_token = str_random(10);
        $adminMarius->role = 'admin';
        $adminMarius->watchList = new WatchList(['user_id' => $adminMarius->id]);
        $adminMarius->seenList = new SeenList(['user_id' => $adminMarius->id]);
    }
}
