<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\Product;
use App\Category;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->can('view-product')) {
            $product = Product::all();
            return Response::json($product);
        }
        return Response::json(['message' => 'You do not have permission'], 401);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->can('create-product')) {
            $categories = Category::all();
            return Response::json($categories);
        }
        return Response::json(['message' => 'You do not have permission'], 401);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->can('create-product')) {
            $data = $request->all();
            if(Prodcut::create($data)) {
                return Response::json(['message' => 'Product has been created'], 200);
            }
            return Repsonse::json(['message' => 'Failed to create product'], 422);
        }
        return Response::json(['message' => 'You do not have permission'], 401);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(Auth::user()->can('view-product')) {
            $product = Product::find($id);
            if($product) {
                return Response::json($product);
            }
            return Response::json(['message' => 'Product does not exist'], 404);
        }
        return Response::json(['message' => 'You do not have permission'], 401);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->can('update-product')) {
            $product = Product::find($id);
            $categories = Category::all();
            if($product) {
                return Response::json(compact(['product', 'categories']));
            }
            return Response::json(['message' => 'This product does not exist'], 404);
        }
        return Response::json(['message' => 'You do not have permission'], 401);
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
        if(Auth::user()->can('update-product')) {
            $data = $request->all();
            $product = Product::find($id);
            if($product) {
                if($product->update($data)) {
                    return Response::json(['message' => 'Product has been updated']);
                }
                return Response::json(['message' => 'Can not update this product'], 422);
            }
            return Response::json(['message' => 'This product does not exist'], 404);
        }
        return Response::json(['message' => 'You do not have permission'], 401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->can('delete-product')) {
            $product = Product::find($id);
            if($product) {
                if($product->delete()) {
                    return Response::json(['message' => 'Product has been removed']);
                }
                return Response::json(['message' => 'Can not remove this product'], 422);
            }
            return Response::json(['message' => 'This product does not exist'], 404);
        }
        return Response::json(['message' => 'You do not have permission'], 401);
    }
}
