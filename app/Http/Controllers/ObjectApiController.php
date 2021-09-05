<?php

namespace App\Http\Controllers;

use App\Models\Mykey;
use DB;

class ObjectApiController extends Controller
{
    public function process() {
        // store json object into arr
        $jsonArr = json_decode( request()->getContent(), true );

        if( empty( $jsonArr ) ) { // check if json object is empty
            // return error message if is empty
            return 'Please provide "mykey":"value"';
        } else {
            // continue do something if json object not empty
            foreach ($jsonArr as $key => $value) { // loop through the json object

                \DB::beginTransaction(); // begin transaction

                if( Mykey::where('key', '=', $key)->count() == 0 ) {
                    // mykey not exist in the record
                    try {

                        $mykey = Mykey::create( [
                            'key'   => $key
                        ] );

                        $mykey->myvalue()->create( [
                            'value' => $value
                        ] );

                    } catch (Exception $e) {  // catch if there's error

                        \DB::rollback(); // rollback the transaction

                        // return error message
                        return [
                            'error' => 'Something went wrong'
                        ];

                    }

                    \DB::commit(); // commit and process the transaction

                    // return success message
                    return [
                        'success' => true
                    ];

                } else {

                    // mykey existed in the record
                    try {
                        // get the existing record
                        $mykey = Mykey::where( 'key', '=', $key )->first();

                        $myvalue = $mykey->myvalue()->latest()->first();

//                        var_dump( $myvalue->value );

                        if( $myvalue->value != $value ) { // check if value not existed
                            // add in new value
                            $mykey->myvalue()->create( [
                                'value' => $value
                            ] );
                        } else {
                            return [
                                $key        => $value
                            ];
                        }

                    } catch (Exception $e) {
                        \DB::rollback();

                        return [
                            'error' => 'Something went wrong'
                        ];
                    }

                    \DB::commit();

                    return [
                        'success' => true
                    ];
                }
            }
        }
    }

    public function show( $key )
    {
        $mykey = Mykey::searchByKey( $key )->first();

        if( $timestamp = request()->query( 'timestamp' ) ) {
            if( false === ( $myvalue = $mykey->myvalue()->wherePivot( 'created_at', '<=', $timestamp )->latest()->first() ) ) {
                return [
                    'message'   => 'No value before this timestamp'
                ];
            }
        } else {
            $myvalue = $mykey->myvalue()->latest()->first();
        }

        return [
            $mykey->key => $myvalue->value
        ];
    }

    public function showAll()
    {
        return Mykey::with('myvalue')->get();
    }
}
