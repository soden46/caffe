<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Comment;
use App\Exports\UsersExport;
use Illuminate\Http\Request;
use App\Exports\ExportUsersQuery;
use App\Models\Komen;
use App\Models\Transaksi;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    //


    public function __construct()
    {
        $this->middleware('authAdmin')->except('createregister', 'register', 'login', 'auth', 'profile', 'logout', 'editProfile', 'updateProfile');
    }
    public function index(Request $request)
    {
        if (!empty($request->search)) {
            return view('admin.users.index')->with([
                "users" => User::where('id', 'like', "%{$request->search}%")
                    ->orWhere('name', 'like', "%{$request->search}%")
                    ->orWhere('FullName', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%")
                    ->orWhere('ville', 'like', "%{$request->search}%")
                    ->paginate(5),
                'usersCount' => User::where('role', 'user')->count(),
                'usersArchivedCount' => User::whereNotNull('deleted_at')->withTrashed()->where('role', 'user')->count(),
                'penjualan' => Transaksi::where('dibayar', 1)->count(),
                'review' => Komen::where('status', 1)->count(),
                'reviews' => Komen::where('status', 1)->count(),
                'pendapatan' => Transaksi::sum('total'),
            ]);
        } else {
            return view('admin.users.index')->with([
                "users" => User::latest()->paginate(5),
                'usersCount' => User::where('role', 'user')->count(),
                'usersArchivedCount' => User::whereNotNull('deleted_at')->withTrashed()->where('role', 'user')->count(),
                'penjualan' => Transaksi::where('dibayar', 1)->count(),
                'revierw' => Komen::where('status', 1)->count(),
                'reviews' => Komen::where('status', 1)->count(),
                'pendapatan' => Transaksi::sum('total'),
            ]);
        }
    }
    public function removeAcount($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with(['succes s' => 'Acounte Deleted ']);
    }

    public function getUrchivedAcounts()
    {
        return view('admin.users.index')->with([
            "users" => User::whereNotNull('deleted_at')->withTrashed()->paginate(5),
            'usersCount' => User::where('role', 'user')->count(),
            'usersArchivedCount' => User::whereNotNull('deleted_at')->withTrashed()->where('role', 'user')->count(),
            'sales' => Transaksi::where('dibayar', 1)->count(),
            'reviews' => Komen::where('status', 1)->count(),
            'Earning' => Transaksi::sum('total'),
        ]);
    }
    public function Unurchive($id)
    {
        $user = User::where('id', $id)->withTrashed()->first();
        $user->deleted_at = null;
        $user->save();
        return redirect()->route('users.index')->with(['success' => 'User Unarchived']);
    }




    /*************** User Excel methods *******************/
    // export all usres
    public function ExportAllUser()
    {
        return Excel::download(new UsersExport, 'users-collection.xlsx'); // Export collection of users
    }

    // export one user using query class
    public function ExportUser($id)
    {
        $user = User::where('id', $id)->withTrashed()->first();
        return (new ExportUsersQuery($id))->download($user->name . '.xlsx');
    }









    /******************** Auth methods ***********************/
    // go to register blade function
    public function createregister()
    {
        return view('auth.register');
    }

    // rgister function
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|max:60|string',
            'email' => 'required|email',
            'password' => 'required|min:8',
            'ville' => 'Nullable||string',
        ]);
        User::create([
            'name' => $request->name,
            'FullName' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'ville' => $request->ville,
        ]);
        return redirect()->route('user.login')->with([
            'success' => 'Compte Created '
        ]);
    }



    // login function
    public function login()
    {
        return view('auth.login');
    }

    public function auth(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            //dd(auth()->user()->admin);
            //dd(auth()->attempt(['email' => $request->email, "password" => $request->password]));
            // ila kan admin imchi ldashboear d admin ila kan user imchi l index
            if (auth()->user()->role === "admin") {
                return redirect()->route('admin.index');
            } else {
                return redirect()->route('resto.index');
            }
        } else {
            return redirect()->route('user.login')->with([
                'error' => 'Email ou mot de passe est incorrect '
            ]);
        }
    }
    // profilr function
    public function profile($id)
    {
        $user = User::findOrFail($id);
        // had script knt drto okhdmt b 2 d bview db ankhdm 4a b views whda
        /*if ($user->admin) {
            return view('profiles.adminProfile')->with(['admin' => $user]);
        } else {
            return view('profiles.userProfile')->with(['user' => $user]);
        }*/
        return view('profiles.profile')->with(['user' => $user]);
    }
    // edit user profile function
    public function editProfile($id)
    {
        $user = User::findOrFail($id);
        /*if ($user->admin) {
            return view('profiles.edit')->with(['admin' => $user]);
        } else {
            return view('profiles.edit')->with(['user' => $user]);
        }*/
        return view('profiles.edit')->with(['user' => $user]);
    }

    // update profile function
    public function updateProfile(User $user, Request $request)
    {
        //dd($request);
        $request->validate([
            'nama' => 'required|string|max:70',
            'email' => 'email|required|unique:users,email,' . $user->id,
            //'password'=>'email|required',
            'foto' => 'image|mimes:png,jpg,jpeg|max:2048',

            //'email' => 'email|required',
        ]);
        if (!empty($request->password)) {
            $request->validate([
                'password' => 'required|string|min:8| confirmed',
                'password_confirmation' => 'required_with:password|same:password',
            ]);
            $user->password = Hash::make($request->password);
        }
        if ($request->has('foto') && !empty($request->foto)) {
            $image_path = public_path("images/profile/" . $user->foto);
            if (File::exists($image_path)) {
                unlink($image_path);
            }
            $file = $request->foto;
            $imageName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/profile'), $imageName);
            $user->foto = $imageName;
        }
        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'foto' => $user->foto,
            'password' => $user->password,
        ]);

        return redirect()->route('user.edit', $user->id);
    }
    // logout function
    public function logout()
    {
        if (auth()->user()->admin) {
            auth()->logout();
            return redirect()->route('user.login');
        } else {
            auth()->logout();
            return redirect()->route('resto.index');
        }
    }
}
