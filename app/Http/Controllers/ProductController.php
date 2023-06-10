<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    use  ApiResponseTrait;

    public function us_index()
    {
        foreach (Product::query()->get() as $products) {

            if ($products['user_id'] == auth()->id()) {
                return $this->apiResponse($products, 'ok', 200);
            }
        }
            return $this->apiResponse(null, 'The User not have  products.', 201);


    }


    public function index()
    {
        $products = ProductResource::collection(Product::get());
        return $this->apiResponse($products, 'ok', 200);
    }


    public function store(Request $request)
    {
        $input=$request->all();
        $validator = Validator::make( $input, [
            'name' => 'required',
            'description' => 'required',
            'image' => ['nullable',],
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(null, $validator->errors(), 400);
        }
        $file_name = $this->saveImage($request->image,'images/product');
        $product =Product::query()->create([
            'name' =>$request->name,
            'description' =>$request->description,
            'image' =>$file_name,
            'user_id' =>$request->user_id,
//            'user_id' =>auth()->id(),
        ]);

        if ($product) {
            return $this->apiResponse(new ProductResource($product), 'the product save', 201);
        }
        return $this->apiResponse(null, 'the product not save', 400);

    }




    public function destroy( $id)
    {
        $products= Product::find($id);
        if(!$products)
        {
            return $this->apiResponse(null ,'the products not found ',404);
        }
        $products->delete($id);
        if($products)
            return $this->apiResponse(null ,'the products deleted ',200);
    }
}
