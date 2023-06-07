<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PrintLabel;
use Carbon\Carbon;

class PrintedLabelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function printall($transfer_number)
    {

        $trf = $transfer_number;

        $data = PrintLabel::where('transfer_number', $trf)->latest()->get();



        return response()->json($data, 200);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeprint($transfer_number, Request $request)
    {
        $data = $request->printed_raw_data;
        $boxn = $request->box_number;


        $printdata = new PrintLabel([
            'transfer_number' => $transfer_number,
            'printed_raw_data' => $data,
            'box_number' => $boxn
        ]);


        $printdata->save();

        $id = $printdata->id;

        $dataresponse = PrintLabel::find($id);

        $res = [

            'print_label' => $dataresponse,
            'msg' => ' Print Label has been created',

        ];



        return response()->json(
            $res,
            200
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showprintdata($id)
    {
        $data = PrintLabel::find($id);
        return response()->json($data, 200);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateprintdata($id)
    {

        $dtime = Carbon::now();
        $data = PrintLabel::find($id);

        $data->update([

            'converted_to_png' =>   $dtime
        ]);

        $res = [

            'msg' => ' Print Label has been updated',

        ];


        return response()->json($res, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
