<?php

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

?>
