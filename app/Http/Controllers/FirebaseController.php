<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Laravel\Firebase\Facades\Firebase;

class FirebaseController extends Controller {
    private $database;

    public function __construct() {
        $this->database = Firebase::database();
    }

    public function store(Request $request) {
        $this->database->getReference('firebase/' . $request['name'])
            ->set([
                'name' => $request['name'],
                'email' => $request['email'],
                'phone' => $request['phone'],
                'password' => $request['password']
            ]);
        return response()->json("User registered successfully");
    }

    public function index() {
        $data = $this->database->getReference('firebase/')->getValue();
        return response()->json(['User' => $data]);
    }

    public function update(Request $request) {
        if($request->has('name')){
            $user = $this->database->getReference('firebase/' . $request['name'])
            ->update([
                'password' => $request['password']
            ]);
            return response()->json("Password changed successfully");
        }
        return response()->json("Please enter the name of user you want to update");
    }

    public function delete(Request $request) {
        $this->database->getReference('firebase/' . $request['name'])
            ->remove();
        if($request->has('name')){
            return response()->json("User deleted successfully");
        }
        return response()->json('All users deleted');
    }
}
