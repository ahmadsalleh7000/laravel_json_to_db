<?php

namespace App\Http\Controllers;

use App\Http\Requests\JsonUploadRequest;
use App\Jobs\JsonUploadJob;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class JsonUploadController extends Controller
{
    // upload json file (transactions)
    public function upload(JsonUploadRequest $request)
    {
        // check json file is valid
        if ($request->file('json_file')->isValid()) 
        {
            // get file content then decode
            $jsonContent = file_get_contents($request->file('json_file'));
            $decodedData = json_decode($jsonContent, true);

            // ensure that the array of transactions start with key (transactions)
            if(array_key_exists("transactions",$decodedData))
            {
                JsonUploadJob::dispatch($decodedData['transactions']);                
            }
            else 
            {
                $this->InvalidJson();
            }

            return redirect()->back()->with('success', 'JSON file uploaded successfully.');
        }
        return redirect()->back()->with('error', 'Error uploading JSON file.');
    }

    private function InvalidJson()
    {
        if (DB::transactionLevel() > 0) {
            DB::rollBack(); // Roll back the open transaction
        }
        return redirect()->back()->with('error', 'Invalid JSON structure.');
    }

    

}
