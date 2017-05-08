<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use DB;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('products')->get();
        return view('edit_product', [
          'data' => $data
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $name= $request->input('name');
        $category= $request->input('category');
        $desc= $request->input('desc');

        $data = array('name'=>$name,'category_id'=>$category,'desc'=>$desc);

        DB::table('products')->insert($data);
        // get product id from product that just build
        $product_id = DB::table('products')->where('name', $name)->value('id');

        $one_day_price= $request->input('one_day_price');
        $three_day_price= $request->input('three_day_price');
        $five_day_price= $request->input('five_day_price');

        $data = array('product_id'=>$product_id,'day'=>'1','price'=>$one_day_price);
        DB::table('rental_products')->insert($data);

        $data2 = array('product_id'=>$product_id,'day'=>'3','price'=>$three_day_price);
        DB::table('rental_products')->insert($data2);

        $data3 = array('product_id'=>$product_id,'day'=>'5','price'=>$five_day_price);
        DB::table('rental_products')->insert($data3);

        return view('admin_main');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product_id = $request->input('product_id');

        $category = $request->input('category');
        $desc = $request->input('desc');

        $rental_product_id1 = DB::table('rental_products')->where([['product_id', '=', $product_id],['day','=','1']])->value('id');
        $rental_product_id2 = DB::table('rental_products')->where([['product_id', '=', $product_id],['day','=','3']])->value('id');
        $rental_product_id3 = DB::table('rental_products')->where([['product_id', '=', $product_id],['day','=','5']])->value('id');

        $pd_name = DB::table('products')->where('id', $product_id)->value('name');
        print
        DB::table('products')->whereId($product_id)->update([['name' => $pd_name ],['category_id' => $category],['desc' => $desc]]);

        return view('admin_main');
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