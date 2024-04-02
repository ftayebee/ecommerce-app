<?php

namespace App\Http\Controllers\PrivateControllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use Validator;
use Exception;
use Illuminate\Support\Facades\Log;

use App\Models\Inventory;

class InventoryController extends Controller
{
    public function index()
    {
        return response()->json([
            'inventories' => Inventory::with('products')->get(),
            'message' => 'Successfully fetched inventories',
            'status' => 200
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'store_logo' => 'required|image',
        ]);

        $inventory = new Inventory([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'store_logo' => $request->store_logo->store('store_logos'),
            'user_id' => $request->user()->id,
        ]);

        if ($inventory->save()) {
            return response()->json([
                'inventory' => $inventory,
                'message' => 'Successfully created inventory',
                'status' => 201
            ]);
        } else {
            return response()->json([
                'message' => 'Failed to create inventory',
                'status' => 400
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'store_logo' => 'image',
        ]);

        $inventory = Inventory::find($id);

        if ($inventory && $inventory->user_id == $request->user()->id) {
            $inventory->name = $request->name;
            $inventory->slug = Str::slug($request->name);
            $inventory->description = $request->description;

            if ($request->hasFile('store_logo')) {
                $inventory->store_logo = $request->store_logo->store('store_logos');
            }

            if ($inventory->save()) {
                return response()->json([
                    'inventory' => $inventory,
                    'message' => 'Successfully updated inventory',
                    'status' => 200
                ]);
            } else {
                return response()->json([
                    'message' => 'Failed to update inventory',
                    'status' => 400
                ]);
            }
        } else {
            return response()->json([
                'message' => 'Inventory not found',
                'status' => 404
            ]);
        }
    }

    public function destroy(Request $request, int $id)
    {
        // Authorization and Inventory Fetching (Combined with Validation)
        $inventory = Inventory::where('id', $id)
            ->where('user_id', $request->user()->id)
            ->with('products') // Eager load products for efficient deletion check
            ->firstOrFail();

        // Inventory Deletion with Error Handling
        if (!$inventory->products->isEmpty()) {
            return response()->json([
                'message' => 'Inventory has associated products, cannot be deleted',
                'status' => 400
            ]);
        }

        try {
            if ($inventory->store_logo){
                Storage::delete($inventory->store_logo);
            }
            $inventory->delete();
            return response()->json([
                'message' => 'Successfully deleted inventory',
                'status' => 200
            ]);
        } catch (Exception $e) {
            Log::error('Inventory deletion failed: ' . $e->getMessage());
            return response()->json([
                'message' => 'Failed to delete inventory',
                'status' => 500 // Use 500 for internal server errors
            ]);
        }
    }

}
