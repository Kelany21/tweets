<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\CartProductOption;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectPath()
    {
        if(!auth()->guest() && auth()->user()->group->can_access_admin == 'yes'){
            return '/dashboard/home';
        }

        if (method_exists($this, 'redirectTo')) {
            return $this->redirectTo();
        }

        return property_exists($this, 'redirectTo') ? $this->redirectTo : '/home';
    }


    /**
     * The user has been authenticated.
     *
     * @param \Illuminate\Http\Request $request
     * @param mixed $user
     * @return mixed
     */
    protected function authenticated(Request $request, $user)
    {
        $carts = session()->get('cart');
        if ($carts){
            foreach ($carts as $cart){
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
        if ($user->can_login === 'no') {
            return route('logout');
        }
    }

    /**
     * Log the user out of the application.
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return redirect('/login');
    }
}
