<?php

namespace Locomotif\Admin\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Locomotif\Admin\Models\Users;
use Locomotif\Admin\Models\AccountsAddresses;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Accounts extends Model{
    protected $table = 'accounts';

    public function user(){
        return $this->belongsTo(Users::class);
    }

    public function addresses(){
        return $this->hasMany(AccountsAddresses::class, 'account_id');

    }

    static function getInvoiceForMonth($month, $year, $accountID){
        $invoice = DB::table('reseller_invoices')
            ->select('invoice', 'invoice_status')
            ->where('designer_id', $accountID)
            ->where('month', $month)
            ->where('year', $year)
            ->first();

        if(isset($invoice->invoice_status)){
            $invoice->invoice_status = mapStatus($invoice->invoice_status);
            $month = Carbon::create()->day(1)->month($month);
            $invoice->month = $month->format('M');
        }else{
            $month = Carbon::create()->day(1)->month($month);
            $obj = new \stdClass();
            $obj->month = $month->format('M');
            return $obj;
        }
        return $invoice;
    }

    static function getInvoicesByYearMonth($accountID){
        
        $years = DB::table('reseller_invoices')->select('year')->groupBy('year')->orderBy('year', 'DESC')->get();
        $years->map(function($year) use($accountID){
            $year->months = collect(range(1,12))->map(function($month) use ($year, $accountID){
                return self::getInvoiceForMonth($month, $year->year, $accountID);
            });
        });
        return $years;
    }

    static function invoiceInfos($accountID){

        $lastDayofMonth    = checkIfIsLastDayOfMonth();
        $invoicesArePaid   = self::checkIFRelatedInvoicesArePaid($accountID);
        $recordExists      = self::checkIFInvoiceRecordExists(now()->month, now()->year, $accountID);
        
        $infos = array(
            'lastDayofMonth'  => $lastDayofMonth,
            'invoicesArePaid' => $invoicesArePaid,
            'recordExists'    => $recordExists['exists'],
            'invoiceData'     => ($recordExists['exists']) ? $recordExists['invoiceData'] : array()
        );
        
        return $infos; 
    }

    static function checkIFRelatedInvoicesArePaid($accountID){
        $orderIds = DB::table('orders_items')
                        ->select('order_id')
                        ->whereMonth('created_at', now()->month)
                        ->whereYear('created_at', now()->year)
                        ->where('designer_id', '=', $accountID)
                        ->get();
                        
        if(count($orderIds) > 0){
            $orderIds->map(function($order){
                $order->status = self::returnPaymentstatus($order->order_id);
            });
            $allPaymentConfirmed = $orderIds->every(function ($item) {
                return $item->status === 'paymentConfirmed' || $item->status === 'paymentFirstHalfConfirmed' || $item->status === 'paymentCollected';
            });
        }else{
            $allPaymentConfirmed = false;
        }
        
        return $allPaymentConfirmed;
    }

    static function checkIFInvoiceRecordExists($month, $year, $accountID){
        $currentRecord = DB::table('reseller_invoices')
                            ->select('id', 'subtotal_sales', 'amount_to_invoice', 'designer_id', 'invoice_status', 'invoice', 'nr_of_notice_sent', 'month', 'year', 'created_at')
                            ->where('month', $month)
                            ->where('year', $year)
                            ->where('designer_id', '=', $accountID)
                            ->get()->first();
                            
        $invoiceData = array(
            'exists'      => isset($currentRecord->id) ? true : false,
            'invoiceData' => $currentRecord
        );

        return $invoiceData;

    }

    static function returnPaymentstatus($orderID){
        $payStatus = DB::table('transactions')
                         ->select('status')
                         ->where('order_id', $orderID)
                         ->get()
                         ->last();
        return $payStatus->status;
    }

}
