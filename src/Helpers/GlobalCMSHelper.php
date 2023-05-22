<?php
use Carbon\Carbon;

if (!function_exists('mapStatus')) {

    function mapStatus($status){
        $map = array(
            'published' => 'Publicat',
            'pending'   => 'În așteptare',
            'hidden'    => 'Ascuns',
        );
        $status = str_replace(array_keys($map), array_values($map), $status);
        
        return $status; 
    }
}


if (!function_exists('getOrdering')) {
    function getOrdering($table, $column='ordering'){
        $largestNumber = DB::table($table)->max($column);

        $nextNumber = $largestNumber + 1;

        return $nextNumber;
    }
}

if (!function_exists('setUserRole')) {
    function setUserRole($role, $userID){
        //check if role exists
        $roleExists = DB::table('roles')->where('name', $role)->exists(); 
        if($roleExists){
            $role_id = DB::table('roles')->where('name', $role)->first(); 
            $role_id = $role_id->id;
            $now = Carbon::now()->format('Y-m-d H:i:s');

            DB::table('role_user')->where([
                ['user_id', '=', $userID]
            ])->delete();
                
            DB::table('role_user')->insert([
                'role_id'    => $role_id,
                'user_id'    => $userID,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }else{
            echo '<pre>';print_r('Rolul de '.$role.' nu exista in baza de date');exit;
        }
    }
}

?>
