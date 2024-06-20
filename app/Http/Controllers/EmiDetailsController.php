<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmiDetailsController extends Controller
{
    public function index()
    {
        return view('process-data.index');
    }

    public function processData()
    {
        // Fetch the min and max dates
        $minDate = DB::table('loan_details')->min('first_payment_date');
        $maxDate = DB::table('loan_details')->max('last_payment_date');

        // Create the emi_details table dynamically
        DB::statement('DROP TABLE IF EXISTS emi_details');

        $createTableQuery = 'CREATE TABLE emi_details (clientid BIGINT';
        $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', $minDate);
        $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', $maxDate);

        while ($startDate->lessThanOrEqualTo($endDate)) {
            $column = $startDate->format('Y_M');
            $createTableQuery .= ", {$column} DECIMAL(10, 2) DEFAULT 0.00";
            $startDate->addMonth();
        }

        $createTableQuery .= ')';
        DB::statement($createTableQuery);

        // Process each row in loan_details and insert into emi_details
        $loanDetails = DB::table('loan_details')->get();

        foreach ($loanDetails as $detail) {
            $clientid = $detail->clientid;
            $emiAmount = $detail->loan_amount / $detail->num_of_payment;
            $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', $detail->first_payment_date);

            $insertQuery = 'INSERT INTO emi_details (clientid';
            $valuesQuery = " VALUES ({$clientid}";

            for ($i = 0; $i < $detail->num_of_payment; $i++) {
                $column = $startDate->format('Y_M');
                $insertQuery .= ", {$column}";
                $valuesQuery .= ", {$emiAmount}";
                $startDate->addMonth();
            }

            $insertQuery .= ')';
            $valuesQuery .= ')';

            $finalQuery = $insertQuery . $valuesQuery;
            DB::statement($finalQuery);
        }

        return redirect('/emi-details');
    }

    public function showEmiDetails()
    {
        $emiDetails = DB::table('emi_details')->get();
        return view('emi-details.index', compact('emiDetails'));
    }
}