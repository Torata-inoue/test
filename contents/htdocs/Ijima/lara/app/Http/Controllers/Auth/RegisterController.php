<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\Auth\RegistUserService;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;

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
    protected $redirectTo = '/timeline';

    /**
     * RegisterController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * RegisterUsersのオーバーライド
     * 登録ページに部署、職種データを渡す
     *
     * @param RegistUserService $registUserService
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showRegistrationForm(RegistUserService $registUserService)
    {
        $belongs = $registUserService->fetchBelongs();

        return view('auth.register')->with(compact('belongs'));
    }

    /**
     * RegisterUsersのオーバーライド
     * ユーザーの新規登録を行う
     *
     * @param RegisterRequest $request
     * @param RegistUserService $registUserService
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function register(RegisterRequest $request, RegistUserService $registUserService)
    {
        try {
            event(new Registered($user = $registUserService->callRegister($request->all())));
        } catch (\Exception $e) {
            $errors = [$e->getMessage()];
            return redirect()->route('register')->withErrors(compact('errors'));
        }

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }
}
