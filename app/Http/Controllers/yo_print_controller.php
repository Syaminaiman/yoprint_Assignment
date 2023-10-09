<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Request;
use App\Models\UploadLog;
use App\Models\yoprint_test_import;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class yo_print_controller extends Controller implements ShouldQueue
{
    public function index(){
        $uploadLogs = UploadLog::all(); // Replace UploadLog with your actual model name

        return view('index', ['uploadLogs' => $uploadLogs]);
    }

    public function show($id){
        $printing_service = UploadLog::findorFail($id);

        return view('show', ['item' => $printing_service]);
    }
    
    public function create(){
        return view('create');
    }

    public function store(Request $request)
    {
        // Get the uploaded CSV file from the request
        $csvFile = $request->file('file');
    
        if ($csvFile) {
            // Read the CSV file as an array
            $csvData = array_map('str_getcsv', file($csvFile));
    
            // Skip the header row (row 1)
            array_shift($csvData);
    
            foreach ($csvData as $row) {
                // Extract the UNIQUE_KEY value from the CSV row
                $uniqueKey = $row[0];
    
                // Query the database to check for a matching record
                $matchingRecord = yoprint_test_import::where('UNIQUE_KEY', $uniqueKey)->first();
    
                if ($matchingRecord) {
                    // Update the PIECE_PRICE in the matching record

                    $CSV_ProductTitle = $row['1'];
                    $CSV_ProductDesc = $row['2'];
                    $CSV_Style = $row['3'];
                    $CSV_SANMAR = $row['28'];
                    $CSV_Size = $row['18'];
                    $CSV_ColourName = $row['14'];
                    $CSV_Price = $row['21'];

                    $ProductTitle = $matchingRecord->PRODUCT_TITLE;
                    $ProductDesc = $matchingRecord->PRODUCT_DESCRIPTION;
                    $ProductStyle = $matchingRecord->getAttribute('STYLE#');
                    $ProductSANMAR = $matchingRecord->SANMAR_MAINFRAME_COLOR;
                    $ProductSize = $matchingRecord->SIZE;
                    $ProductColourName = $matchingRecord->COLOR_NAME;
                    $Price = $matchingRecord->PIECE_PRICE;

                    if ($CSV_ProductTitle != $ProductTitle) {
                        // Update the PIECE_PRICE in the matching record
                        $matchingRecord->PRODUCT_TITLE = $CSV_ProductTitle;
                    }
                    if ($CSV_ProductDesc != $ProductDesc) {
                        // Update the PIECE_PRICE in the matching record
                        $matchingRecord->PRODUCT_DESCRIPTION = $CSV_ProductDesc;
                    }
                    if ($CSV_Style != $ProductStyle) {
                        // Update the PIECE_PRICE in the matching record
                        $matchingRecord->setAttribute('STYLE#', $CSV_Style);
                    }
                    if ($CSV_SANMAR != $ProductSANMAR) {
                        // Update the PIECE_PRICE in the matching record
                        $matchingRecord->SANMAR_MAINFRAME_COLOR = $CSV_SANMAR;
                    }
                    if ($CSV_Size != $ProductSize) {
                        // Update the PIECE_PRICE in the matching record
                        $matchingRecord->SIZE = $CSV_Size;
                    }
                    if ($CSV_ColourName != $ProductColourName) {
                        // Update the PIECE_PRICE in the matching record
                        $matchingRecord->COLOR_NAME = $CSV_ColourName;
                    }
                    if ($CSV_Price != $Price) {
                        // Update the PIECE_PRICE in the matching record
                        $matchingRecord->PIECE_PRICE = $CSV_Price;
                    }


                    $matchingRecord->save();
                } else {
                    // Insert a new row and retrieve the auto-incremented UNIQUE_KEY
                    yoprint_test_import::insert([
                        'PRODUCT_TITLE' => $CSV_ProductTitle,
                        'PRODUCT_DESCRIPTION' => $CSV_ProductDesc,
                        'STYLE#' => $CSV_Style,
                        'SANMAR_MAINFRAME_COLOR' => $CSV_SANMAR,
                        'SIZE' => $CSV_Size,
                        'COLOR_NAME' => $CSV_ColourName,
                        'PIECE_PRICE' => $CSV_Price,
                    ]);
                    // $uniqueKeyId now contains the auto-incremented UNIQUE_KEY value for the new row
                    echo "New row inserted with UNIQUE_KEY:<br>";
                }
            }

            // Insert a new log record
            DB::table('upload_logs')->insert([
                'file_name' => $request->file('file')->getClientOriginalName(),
                'status' => 'Uploaded', // You can set the status as needed
            ]);
        } else {
            echo "No file uploaded.";
        }
        return redirect('/YoPrint');
    }
    
}
