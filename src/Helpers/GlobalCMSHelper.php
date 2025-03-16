<?php
use Carbon\Carbon;

if (!function_exists('redirectArea')) {
    function redirectArea($user){
        
        $role = (isset($user->roles->pluck('name')[0]) && !empty($user->roles->pluck('name')[0])) ? $user->roles->pluck('name')[0] : '';
        if(!empty($role)){   
            switch ($role) {
                case 'client':
                    $endpoint = '/cont-client/dashboard.html';
                break;

                case 'designer':
                    $endpoint = '/cont-designer/dashboard.html';
                break;

                case 'administrator':
                    $endpoint = '/admin';
                break;
                
                default:
                    $endpoint = '/login.html';
                break;
            }
        }else{
            Auth::logout();
            $endpoint = '/';
        }
        
        return $endpoint;
    }
}
if (!function_exists('mapCharacters')) {
    function mapCharacters($inputString) {
        $mapping = [
            'ș' => 's',
            'ț' => 't',
            'ă' => 'a',
            'î' => 'i',
            'â' => 'a',
            'Ș' => 'S',
            'Ț' => 'T',
            'Ă' => 'A',
            'Î' => 'I',
            'Â' => 'A'
        ];

        $returnClean = preg_replace_callback('/[^\x00-\x7F]/u', function ($matches) use ($mapping) {
            $char = $matches[0];
            return $mapping[$char] ?? $char;
        }, $inputString);

        return $returnClean;
    }
}

if (!function_exists('buildUrl')) {

    function buildUrl($inputValue){

        $inputValue = preg_replace('/\s+/u', '-', $inputValue);
        $inputValue = strtolower($inputValue);
        $inputValue = mapCharacters($inputValue);
        $inputValue = preg_replace('/[^a-zA-Z0-9-]/', '', $inputValue);
        
        return $inputValue;
    }
}

if (!function_exists('mapStatus')) {

    function mapStatus($status){
        $map = array(
            'published'                      => 'Publicat',
            'pending'                        => 'În așteptare',
            'hidden'                         => 'Ascuns',
            'sentToShop'                     => 'Procesare',
            'inTransition-sentToCarrier'     => 'Spre curier',
            'inTransition-pickedUpByCarrier' => 'La curier',
            'inTransition-sentFromCarrier'   => 'Tranzit',
            'delivered'                      => 'Livrată',
            'canceled'                       => 'Anulată',
            'delayed'                        => 'Întârziere',
            'contested'                      => 'Contestată',
            'transactionRecieved'            => 'Înregistrată',
            'transactionFirstHalfRecieved'   => 'Avans înregistrat',
            'transactionSecondHalfRecieved'  => 'Factură finală generată',
            'paymentFirstHalfConfirmed'      => 'Avans încasat',
            'paymentAwaitAdditionalInfos'    => 'Fără detalii cont',
            'paymentConfirmed'               => 'Plătită',
            'paymentCollected'               => 'Încasată integral',
            'processing'                     => 'În procesare',
            'requiresPaymentMethod'          => 'Fără metodă de plată',
            'paymentFailed'                  => 'Eroare/Anulată',
            'fgo_sentHalf'                   => '50% generată și trimisă spre FGO',
            'fgo_sent'                       => 'Generată și trimisă spre FGO',
            'fgo_storno'                     => 'Storno',
            'fgo_invoicedHalf'               => 'Factură încasată 50%',
            'fgo_invoiced'                   => 'Factură încasată integral',
            'fgo_error'                      => 'Eroare la înregistrare factură',
            'uploaded'                       => 'Încărcată',
            'notUploaded'                    => 'Nu este încărcată',
            'inProcesare'                    => 'În procesare',
            'inregistrata'                   => 'Înregistrată în sistem',
            'incasata'                       => 'Încasată',
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
if (!function_exists('getOrderingFiltered')) {
    function getOrderingFiltered($table, $column, $value, $orderColumn='ordering'){
        $largestNumber = DB::table($table)->where($column, $value)->max($orderColumn);
        
        $nextNumber = $largestNumber + 1;
        
        return $nextNumber;
    }
}

if (!function_exists('checkRoleExists')){
    function checkRoleExists($role){
        $roleExists = DB::table('roles')->where('name', $role)->exists();
        $roleExists = ($roleExists) ? true : false;
        return $roleExists;
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
            $response = array(
                'success' => false,
                'type'    => 'display',
                'message' => array('A intervenit o eroare la creearea contului. Te rugăm încearcă din nou.')
            );
            return response()->json($response);
        }
    }
}

if (!function_exists('extractTVA')) {
    function extractTVA($total, $tva, $tvaType){
        $tva   = (double)$tva;
        $total = (double)$total;

        switch ($tvaType) {
            case 'percent':
                $tvaPrice = ($tva/100) * $total;
                break;

            case 'fixed':
                $tvaPrice = $tva;
                break;
            
            default:
                $tvaPrice = ($tva/100) * $total;
                break;
        }

        return $tvaPrice;
    }
}

if (!function_exists('extractResellerPrice')) {
    function extractResellerPrice($total, $fee, $type){
        $fee   = (double)$fee;
        $total = (double)$total;

        switch ($type) {
            case 'percent':
                $price = ($fee/100) * $total;
                break;

            case 'fixed':
                $price = $tva;
                break;
            
            default:
                $price = ($tva/100) * $total;
                break;
        }

        return $price;
    }
}

if (!function_exists('checkIfIsLastDayOfMonth')) {
    function checkIfIsLastDayOfMonth(){
            
        $lastDayOfMonth = Carbon::now()->endOfMonth();
        $today          = Carbon::now()->today();

        $lastDayOfMonth = $lastDayOfMonth->format('Y-m-d');
        $today          = $today->format('Y-m-d');

        $isLastDay      = ($today==$lastDayOfMonth) ? true : false;
        
        return $isLastDay;
        
    }
}
 if(!function_exists('checkIfCurrentMonthIsSame')){
    function checkIfCurrentMonthIsSame($month){
        return ($month === now()->format('M'));
    }
}

?>
