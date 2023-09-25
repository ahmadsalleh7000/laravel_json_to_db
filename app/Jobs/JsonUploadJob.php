<?php

namespace App\Jobs;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class JsonUploadJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $transactions;
    public function __construct($transactions)
    {
        $this->transactions=$transactions;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Log::info("list of transactions");
        Log::info([$this->transactions]);
        
        DB::beginTransaction(); // Start a database transaction
        foreach($this->transactions as $transaction)
        {
            $this->isValidTransactionData($transaction) ? $this->createTransaction($transaction) : $this->InvalidJson($transaction);            
        }
        DB::commit(); // Commit the transaction if everything is successful
    }
     // Stor transaction in DB
     private function createTransaction($data){
        
        $dataMapping = [
            'amount'               => array_key_exists('parentAmount',$data)         ? $data['parentAmount']         : $data['balance'],
            'currency'             => array_key_exists('Currency',$data)             ? $data['Currency']             : $data['currency'],
            'email'                => array_key_exists('parentEmail',$data)          ? $data['parentEmail']          : $data['email'],
            'statusCode'           => array_key_exists('statusCode',$data)           ? $data['statusCode']           : $data['status'],
            'paymentDate'          => array_key_exists('registrationDate',$data)     ? $data['registrationDate']     : Carbon::createFromFormat('d/m/Y', $data['created_at'])->format('Y-m-d'),
            'parentIdentification' => array_key_exists('parentIdentification',$data) ? $data['parentIdentification'] : $data['id'],
            'provider'             => array_key_exists('parentIdentification',$data) ? "DataProviderX"               : "DataProviderY",
        ];
       

        // Create a new Transaction record or update existing one using the mapped data
        Transaction::updateOrCreate(['parentIdentification' => $dataMapping['parentIdentification']], $dataMapping);
    }

    // check the structure of the transaction
    private function isValidTransactionData($data)
    {
        return isset($data['parentAmount'],$data['Currency'],$data['parentEmail'],$data['statusCode'],$data['registrationDate'],$data['parentIdentification']) || 
               isset($data['balance'],$data['currency'],$data['email'],$data['status'],$data['created_at'],$data['id']);
    }

    private function InvalidJson($transaction)
    {
        Log::info("incorrect transaction pattern");
        Log::info([$transaction]);
    }
}
