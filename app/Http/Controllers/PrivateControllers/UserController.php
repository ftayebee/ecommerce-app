<?php

namespace App\Http\Controllers\PrivateControllers;

use Illuminate\Http\Request;

// Required Models
use App\Models\User;
use App\Models\Inventory;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        if(Auth::user()->role !== 'admin') {
            return response()->json([
                'message' => 'Unauthorized',
                'status' => 401
            ]);
        }

        return response()->json([
            'users' => User::where('role', 'user')->with('inventory')->get(),
            'message' => 'Successfully fetched users',
            'status' => 200
        ]);
    }

    public function show(User $user)
    {
        return response()->json([
            'user' => $user->with('inventory')->where('id', $user->id)->first(),
            'message' => 'Successfully fetched user',
            'status' => 200
        ]);
    }

    public function update(Request $request, User $user)
    {
        if(Auth::user()->role !== 'admin') {
            return response()->json([
                'message' => 'Unauthorized',
                'status' => 401
            ]);
        }

        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email',
            'role' => 'required|string',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;

        if ($user->save()) {
            return response()->json([
                'user' => $user,
                'message' => 'Successfully updated user',
                'status' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'Failed to update user',
                'status' => 400
            ]);
        }
    }

    public function destroy(User $user)
    {
        if(Auth::user()->role !== 'admin') {
            return response()->json([
                'message' => 'Unauthorized',
                'status' => 401
            ]);
        }else if ($user->inventory) {
            return response()->json([
                'message' => 'User has inventory assigned. Please unassign inventory first',
                'status' => 400
            ]);
        } else if ($user->delete()) {
            return response()->json([
                'message' => 'Successfully deleted user',
                'status' => 200
            ]);
        } else {
            return response()->json([
                'message' => 'Failed to delete user',
                'status' => 400
            ]);
        }
    }

    public function assignInventory(Request $request, User $user)
    {
        if(Auth::user()->role !== 'admin') {
            return response()->json([
                'message' => 'Unauthorized',
                'status' => 401
            ]);
        }

        $request->validate([
            'inventory_id' => 'required|numeric',
            'user_id' => 'required|numeric',
        ]);

        // Find the inventory by its ID
        $inventory = Inventory::findOrFail($request->inventory_id);
        $inventory->user_id = $request->user_id;
        $isAssigned = $inventory->update();
        if (!$isAssigned) {
            return response()->json([
                'message' => 'Failed to assign inventory to user',
                'status' => 400
            ]);
        }

        return response()->json([
            'user' => $user->with('inventory')->where('id', $request->user_id)->first(),
            'message' => 'Successfully assigned inventory to user',
            'status' => 200
        ]);
    }

    public function unassignInventory(User $user)
    {
        if(Auth::user()->role !== 'admin') {
            return response()->json([
                'message' => 'Unauthorized',
                'status' => 401
            ]);
        }

        $inventory          = $user->inventory;
        $inventory->user_id = null;
        $isUnassigned       = $inventory->update();
        
        if (!$isUnassigned) {
            return response()->json([
                'message' => 'Failed to unassign inventory from user',
                'status' => 400
            ]);
        }

        return response()->json([
            'user' => $user->with('inventory')->where('id', $user->id)->first(),
            'message' => 'Successfully unassigned inventory from user',
            'status' => 200
        ]);
    }

}
