<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::select('id', 'name', 'price')->simplePaginate(10);
        return response()->json([
            'status' => 1,
            'products' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric'
        ]);

        Product::create([
            'name' => $data['name'],
            'price' => $data['price']
        ]);
        return response()->json([
            'status' => 1,
            'message' => "Producto añadido"
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        if ($product !== null) {
            return response()->json($product);
        } else {
            return response()->json([
                'status' => 0,
                'message' => "Producto no encontrado"
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if ($product !== null) {
            $product->name = $request['name'];
            $product->price = $request['price'];
            $product->save();
            return response()->json([
                'status' => 1,
                'message' => "Producto actualizado"
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => "Producto no encontrado"
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  id
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {

        $product = Product::find($id);

        if ($product !== null) {
            $product->delete();
            return response()->json([
                'status' => 1,
                'message' => "Producto eliminado"
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'message' => "Producto no encontrado"
            ]);
        }
    }
}
