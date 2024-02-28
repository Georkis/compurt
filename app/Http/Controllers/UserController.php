<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Mail\SendPassword;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('roles')->paginate(25);
        $roles = Role::all();

        return inertia(component: 'User/Index', props: ['users' => $users, 'roles' => $roles, 'url_photo' => env('APP_URL_STORAGE')]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request): RedirectResponse|JsonResponse
    {
        $password = substr(string: str_shuffle(string: 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), offset: 0, length: 6);

        try {
            $userApp = User::create([
                'name' => $request->name,
                'lastname' => $request->lastname,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make(value: $password)
            ]);

            if(!$role = Role::find($request->role_id)){
                return response()->json("No se encuentra el role asignado");
            }

            $userApp->assignRole($role->name);

            $message = (new SendPassword($password))
                ->onConnection(connection: 'sync')
                ->onQueue(queue: 'emails');

            Mail::to($request->email)
                ->queue(mailable: $message);

        }catch (\Exception $exception){
            return response()->json(data: $exception->getMessage(), status: 400);
        }



        /** @var User $userApp */
        $role = Role::find($request->role_id);
        $userApp->assignRole($role->name);

        return redirect()->route('users.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, $id): void
    {
        $userApp = User::find($id);

        $userApp->name = $request->name;
        $userApp->lastname = $request->lastname;
        $userApp->email = $request->email;
        $userApp->phone = $request->phone;

        $roleObj = Role::find($request->role_id);
        $role = $roleObj->name;

        $userApp->syncRoles($role);
        $userApp->save();
    }

    public function active($id): void
    {
        $user = User::find($id);
        $user->active = $user->active ? 0 : 1;
        $user->save();
    }
}
