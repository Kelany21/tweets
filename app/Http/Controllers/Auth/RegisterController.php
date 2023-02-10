<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\CartProductOption;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'image' => defaultImage(),
            'can_login' => 'yes',
            'country_id' => 198
        ]);
        DB::table('statuses')->where('label', 'all_users')->increment('count', 1);

        $carts = session()->get('cart');
        if ($carts) {
            foreach ($carts as $cart) {
                $createdCart = \App\Models\UserCartProduct::create([
                    'user_id' => auth()->id(),
                    'product_id' => $cart['product_id'],
                    'image' => $cart['image'],
                    'quantity' => $cart['quantity'],
                    'price' => $cart['price']
                ]);
                if ($cart['options'] != []) {
                    foreach ($cart['options'] as $option) {
                        CartProductOption::create([
                            'cart_id' => $createdCart->id,
                            'option_value_id' => $option,
                        ]);
                    }
                }
            }
        }
        return $user;
    }
}
