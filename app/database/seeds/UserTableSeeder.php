<?php
class UserTableSeeder extends Seeder {

    public function run()
    {
        for($i=0; $i<10;$i++){
            $user = new User;
            $user->user_name = 'user' . $i;
            $user->password= hash("sha256","123456");
            $user->first_name = "User";
            $user->last_name = $i;
            $user->isactive = 1;
            if(! $user->save()) {
                echo "add User $i fail\n";
                 print_r((array)$user->errors());
            } else {
                echo "add User $i success \n";
            }
        }
        echo "Add Users Done!";
    }
}