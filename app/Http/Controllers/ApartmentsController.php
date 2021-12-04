<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Apartment;

class ApartmentsController extends Controller
{
    public function apartments(Request $request)
    {

        $token = $request->bearerToken();
        $user = User::where('remember_token', $token)->first();
        $request['user_id'] = $user->id;
        $apartment = new Apartment($request->all());

        if ($apartment->save()) {

            $data = $apartment->SaveDataApartment($apartment);

            return response($data, 201);
        }
    }

    public function delete($id)
    {
        $apartment = Apartment::find($id)->delete();
        return response($apartment, 204);
    }

    public function get($id)
    {
        return ['data' => Apartment::with('images')->find($id)];
    }

    public function patch(Request $request, $id)
    {
        $apartment = Apartment::find($id);
        $apartment->update($request->all());

        return ['data' => $apartment];
    }

    public function all(Request $request)
    {
        $priceFrom = $request->price['from'];
        $priceTo = $request->price['to'];

        $response = [
            'meta' => [
                'page' => 1,
                'totalPages' => 1,
                'nextPage' => null,
                'prevPage' => null,
            ],

            'data' => Apartment::with('images')
                ->where('price', '>', $priceFrom)
                ->where('price', '<', $priceTo)
                ->get(),
        ];

        return $response;
    }

    public function ApartmentsOnUserPage(Request $request)
    {
        $token = $request->bearerToken();
        $user = User::where('remember_token', $token)->first();
        $apartments = Apartment::where('user_id', $user->id)->get();

        $response = [
            'meta' => [
                'page' => 1,
                'totalPages' => 1,
                'nextPage' => null,
                'prevPage' => null,
            ],

            'data' => $apartments,
        ];

        return $response;
    }
}
