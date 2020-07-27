<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ConnectionRedis;

class ExampleController extends Controller
{
        use ConnectionRedis;

        public function store(\Illuminate\Http\Request $request)
        {
            $redis = $this->getRedis();

            $this->validate($request, [
                'email' => 'required|email',

            ]);
            $redis->zAdd('emails',"15",$request->email);


            return response()->json($request->email, 201);
        }
}
