<?php

namespace App\Http\Controllers;

use App\Notifications\NewUser;
use App\Page;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = Page::find(1);
        $topSubpages = $page->topSubpages;

        $users = User::all();

        return view('admin.users.index', compact('topSubpages', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page = Page::find(1);
        $topSubpages = $page->topSubpages;

        return view('admin.users.form', compact('topSubpages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'  => 'required',
            'email' => 'required|email|unique:users,email',
        ]);

        $user = User::create([
            'name'  => $request->name,
            'email' => $request->email,
        ]);

        $user->notify(new NewUser(Password::broker()->createToken($user)));

        return redirect()->route('admin.users.index')->with(['session' => 'Usuario creado exitosamente. Se ha enviado un email para la asignación de contraseña', 'session-result' => 'success']);
    }

    public function showPasswordForm(Request $request, $token = null)
    {
        $page = Page::find(1);
        $topSubpages = $page->topSubpages;

        return view('auth.passwords.set', compact('topSubpages'))->with(
            ['token' => $token, 'email' => $request->email]);
    }

    public function setPassword(Request $request)
    {
        $this->validate($request, [
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        $response = Password::broker()->reset($request->only(
            'email', 'password', 'password_confirmation', 'token'
        ), function ($user, $password) {
            $this->setUserPassword($user, $password);
        });

        if ($response == Password::PASSWORD_RESET) {
            return redirect('/')->with('status', trans($response));
        } else {
            return redirect()->back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => trans($response)]);
        }
    }

    /**
     * Reset the given user's password.
     *
     * @param  \Illuminate\Contracts\Auth\CanResetPassword $user
     * @param  string                                      $password
     *
     * @return void
     */
    protected function setUserPassword($user, $password)
    {
        $user->forceFill([
            'password'       => bcrypt($password),
            'remember_token' => Str::random(60),
        ])->save();

        Auth::guard()->login($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $page = Page::find(1);
        $topSubpages = $page->topSubpages;

        $user = User::find($id);

        if (is_null($user)) {
            abort(404);
        }

        return view('admin.users.form', compact('topSubpages', 'user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            abort(404);
        }

        $validations = [
            'name'  => 'required',

        ];

        if ($request->email != $user->email) {
            $validations['email'] = 'required|email|unique:users,email';
        }

        $this->validate($request, $validations);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('admin.users.index')->with(['session' => 'Usuario creado exitosamente. Se ha enviado un email para la asignación de contraseña', 'session-result' => 'success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (is_null($user)) {
            abort(404);
        }

        if ($id == Auth::user()->id) {
            return redirect()->back()->with(['status' => 'No te puedes eliminar a ti mismo!', 'status-result' => 'danger']);
        }

        $user->delete();

        return redirect()->back()->with(['status' => 'El usuario fué eliminado correctamente!', 'status-result' => 'success']);
    }
}
