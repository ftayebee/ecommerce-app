<?php

namespace App\Http\Controllers\PrivateControllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Validator;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\Inventory;

class ProductController extends Controller
{
    public function index(Inventory $inventory)
    {
        $products = $inventory->products;

        return response()->json([
            'products' => $products,
            'status' => 200
        ]);
    }

    public function store(Request $request, Inventory $inventory)
    {
        $request->validate([
            'name'          => 'required|string',
            'description'   => 'required|string',
            'sale_price'    => 'required|numeric',
            'quantity'      => 'required|numeric',
            'image'         => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'sku'           => 'required|string',
        ]);

        $product = new Product([
            'name'              => $request->name,
            'slug'              => Str::slug($request->name),
            'sku'               => $request->sku,
            'description'       => $request->description,
            'supplier_price'    => $request->supplier_price,
            'sale_price'        => $request->sale_price,
            'quantity'          => $request->quantity,
            'inventory_id'      => $inventory->id,
            'image'             => $request->image->store('product_images'),
        ]);

        if ($product->save()) {
            return response()->json([
                'product'   => $product,
                'message'   => 'Successfully created product',
                'status'    => 201
            ]);
        } else {
            return response()->json([
                'message'   => 'Failed to create product',
                'status'    => 400
            ]);
        }
    }

    public function update(Request $request, Inventory $inventory, Product $product)
    {
        $request->validate([
            'name'          => 'required|string',
            'description'   => 'required|text',
            'sale_price'    => 'required|numeric',
            'quantity'      => 'required|numeric',
            'image'         => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'sku'           => 'required|string',
        ]);

        $product->name           = $request->name;
        $product->slug           = Str::slug($request->name);
        $product->sku            = $request->sku;
        $product->description    = $request->description;
        $product->supplier_price = $request->supplier_price;
        $product->sale_price     = $request->sale_price;
        $product->quantity       = $request->quantity;
        $product->inventory_id   = $inventory->id;

        if ($request->hasFile('image')) {
            Storage::delete($product->image);
            $product->image = $request->image->store('product_images');
        }

        if ($product->update()) {
            return response()->json([
                'product'   => $product,
                'message'   => 'Successfully updated product',
                'status'    => 200
            ]);
        } else {
            return response()->json([
                'message'   => 'Failed to update product',
                'status'    => 400
            ]);
        }
    }

    public function destroy(Inventory $inventory, $pid)
    {
        $product = Product::find($pid);
        if ($product) {
            Storage::delete($product->image);
            $product->delete();
            return response()->json([
                'message'   => 'Successfully deleted product',
                'status'    => 200
            ]);
        } else {
            return response()->json([
                'message'   => 'Failed to delete product',
                'status'    => 400
            ]);
        }
    }
}
