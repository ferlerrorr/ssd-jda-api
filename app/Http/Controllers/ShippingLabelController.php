<?php

namespace App\Http\Controllers;

use App\Models\ShippingLabel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ShippingLabelController extends Controller
{


    public function status()
    {

        $responseFalse = [

            "responseCode" => 200,
            'timestamp' =>  Carbon::now(),
            'Details' => [
                'status' => 'connected',
            ]
        ];



        return response()->json($responseFalse, 200);
    }




    public function index()
    {

        $product = ShippingLabel::where('printed_at', '')->orWhereNull('printed_at')->orderBy('created_at', 'ASC')->limit(500)->get();
        // ? filter first (50)
        // ? descending(datetime)	





        return response()->json($product, 200);
    }

    public function store(Request $request)
    {

        $datas = $request->all();

        foreach ($datas as $data) {
            $validator = Validator::Make($data, [
                'transfer_number' => 'required|string|max:20', // * 8 > 20 
                'po_trans_loc_code_from' => 'required|numeric|digits_between:1,10', // * 5 > 10
                'po_trans_loc_from_name' => 'required|string|max:20', // * 8 > 20
                'po_trans_loc_code_to' => 'required|numeric|digits_between:1,10', // * 5 > 10
                'po_trans_loc_to_name' => 'required|string|max:20', // * 8 > 20
                'po_trans_loc_to_route_desc' => 'required|string|max:50', // * 35 > 50
                'po_number' => 'required|numeric|digits_between:1,20', // * 10 > 20
                'counter_number' => 'required|numeric|digits_between:1,10', // * 3 > 10
                'od_number' => 'required|numeric|digits_between:1,30', // * 15 > 30
                'sales_invoice_number' => 'required|string|max:50', // * 20 > 50
                'total_box_count' => 'required|numeric|digits_between:1,10', // * 6 > 10
                'checked_by' => 'required|string|max:10', //* 3 > 10
                'po_vendor_name' => 'required|string|max:100' // * 75 > 100
            ]);


            if ($validator->fails()) {

                $responseFalse = [
                    "responseCode" => 400,
                    'timestamp' =>  Carbon::now(),
                    'errorDetails' => [
                        'status' => 'Shipping Failed to Create',
                        'statusMessage' =>  array_values($validator->errors()->toArray())
                    ]

                ];



                return response($responseFalse, 400);
            }
        }



        foreach ($datas as $data) {

            $transfer_number = $data['transfer_number'];
            $po_trans_loc_code_from = $data['po_trans_loc_code_from'];
            $po_trans_loc_from_name = $data['po_trans_loc_from_name'];
            $po_trans_loc_code_to = $data['po_trans_loc_code_to'];
            $po_trans_loc_to_name = $data['po_trans_loc_to_name'];
            $po_trans_loc_to_route_desc = $data['po_trans_loc_to_route_desc'];
            $po_number = $data['po_number'];
            $counter_number = $data['counter_number'];
            $od_number = $data['od_number'];
            $sales_invoice_number = $data['sales_invoice_number'];
            $total_box_count = $data['total_box_count'];
            $checked_by = $data['checked_by'];
            $po_vendor_name = $data['po_vendor_name'];


            $shippingLabel = new ShippingLabel([
                'transfer_number' => $transfer_number,

                'po_trans_loc_code_from' => $po_trans_loc_code_from,
                'po_trans_loc_from_name' => $po_trans_loc_from_name,

                'po_trans_loc_code_to' => $po_trans_loc_code_to,
                'po_trans_loc_to_name' => $po_trans_loc_to_name,

                'po_trans_loc_to_route_desc' => $po_trans_loc_to_route_desc,

                'po_number' => $po_number,

                'counter_number' => $counter_number,

                'od_number' => $od_number,

                'sales_invoice_number' => $sales_invoice_number,

                'total_box_count' => $total_box_count,

                'checked_by' => $checked_by,

                'po_vendor_name' => $po_vendor_name,

            ]);


            $shippingLabel->save();
        }


        $responseOK = [
            "responseCode" => 200,
            'timestamp' =>  $shippingLabel->created_at,
            'details' => [

                'Item Created'
            ]

        ];


        if ($shippingLabel->save() == true) {


            return response()->json($responseOK, 200);
        }
    }


    public function print($id)
    {

        if (!is_numeric($id)) {
            $err = ["error" => "Input must be a number."];

            return response()->json($err, 400);
        }


        $shippingLabelCC = ShippingLabel::where('id', $id)->firstOrfail();

        $printed_at =  $shippingLabelCC->printed_at;


        if ($printed_at == !null) {

            $err = [

                'msg' => 'Shipping label not found',

            ];

            return response()->json($err, 404);
        } else {

            $shippingLabel = ShippingLabel::where('id', $id);
            $time = Carbon::now();

            $shippingLabel->update([

                'printed_at' => $time
            ]);

            $res = [

                'msg' => 'Shipping Label has been Printed',

            ];


            return response()->json($res, 200);
        }
    }


    public function searchreprint($created)
    {

        // $date = $request->date;

        $shippingLabel = ShippingLabel::where('created_at', 'LIKE', '%' . $created . '%')
            ->whereNotNull('printed_at')->get();


        $dd = $shippingLabel;

        if ($dd->isEmpty()) {

            $err = ["error" => "no shipping label printed at this date."];

            return response()->json($err, 400);
        }


        $res =  $shippingLabel;

        return response()->json($res, 200);
    }



    public function reprint($id)
    {


        if (!is_numeric($id)) {
            $err = ["error" => "Input must be a number."];

            return response()->json($err, 400);
        }


        $shippingLabel = ShippingLabel::where('id', $id)->get();


        if ($shippingLabel->isEmpty()) {

            $err = ["error" => "No shipping label with this ID."];

            return response()->json($err, 400);
        }


        $dd = $shippingLabel->toArray();
        $pa =  $dd[0]["printed_at"];


        if ($pa == null) {

            $err = ["error" => "Shipping label not in reprint list."];

            return response()->json($err, 400);
        } else {
            $shippingLabel = ShippingLabel::where('id', $id);


            $shippingLabel->update([

                'printed_at' => null
            ]);

            $res = [

                'msg' => 'Shipping Label now can be Reprinted',

            ];
            return response()->json(
                $res,
                200
            );
        }
    }
}
