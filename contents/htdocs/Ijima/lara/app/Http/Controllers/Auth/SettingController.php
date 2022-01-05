<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthSettingRequest;
use App\Services\Auth\RegistUserService;
use App\Services\Auth\SettingUserInfoService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    /**
     * SettingController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *
     * ユーザー情報を取得し、settingページに表示する
     *
     * @param RegistUserService $registUserService
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showSettingPage(RegistUserService $registUserService)
    {
        $belongs = $registUserService->fetchBelongs();

        return view('setting')->with(compact('belongs'));
    }

    /**
     * ユーザーデータを新しいものに編集する
     *
     * @param AuthSettingRequest $request
     * @param SettingUserInfoService $service
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postSetting(AuthSettingRequest $request, SettingUserInfoService $service)
    {
        $input = $request->all();
        try {
            $service->updateAuth($input, Auth::id());
        } catch (\Exception $e) {
            $errors = [$e->getMessage()];
            return redirect()->route('auth_setting')->withErrors(compact('errors'));
        }
        $message = 'プロフィールを更新しました';

        return redirect()->route('auth_setting')->with(compact('message'));
    }
}
