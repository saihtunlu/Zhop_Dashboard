<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Permission_User;
use App\PermissionProduct;
use App\Role;
use app\User;
use App\User_Role;
use App\PermissionInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\SignupActivate;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = User::with('user_role', 'user_role.role')->get();
        return response()->json($user);
    }


    public function auth()
    {
        $id = Auth::id();
        $user = User::where('id', $id)->with('user_role', 'permission_user',   'permission_invoice')->first();
        return response()->json($user);
    }

    public function store(Request $request)
    {
        $this->authorize('isUser_Create');
        $user = json_decode($request->user);
        $permissions = json_decode($request->permissions);
        $password = Hash::make($user->password);
        $activation_token = Str::random(60);
        $profile_image = null;
        $email = $user->email;
        $checkEmail = User::where('email', $email)->first();
        if (!empty($checkEmail)) {
            return response()->json(['alert' => 'This email is already taken!']);
        } else {
            $file = $request->file;
            if ($file) {
                $image = $file; //base64 encoded
                $image = str_replace('data:image/png;base64,', '', $image);
                $image = str_replace(' ', '+', $image);
                $imageName = time() . '-file(avatar)' . '.png';
                $path = public_path() . "/images/uploads/" . $imageName;
                $image_decoded = base64_decode($image); // decoding File
                file_put_contents($path, $image_decoded);
                $profile_image = '/images/uploads/' . $imageName; //Profile Image For Employee
            } else {
                $profile_image = $user->profile_image;
            }
            //register user
            $User = new User;
            $User->profile_image = $profile_image;
            $User->email = $user->email;
            $User->name = $user->name;
            $User->password = $password;
            $User->activation_token = $activation_token;
            if ($user->position !== 'Customer') {
                $User->type = 'Employee';
            }
            $User->save();
            $Role = Role::where('name', $user->position)->first();
            $User_Role = new User_Role;
            $User_Role->user_id = $User->id;
            $User_Role->role_id = $Role->id;
            $User_Role->save();
            //set permissions
            if ($user->position === 'Customer') {
                //user_permission
                $Permission_User = new Permission_User;
                $Permission_User->name = 'User';
                $Permission_User->create = 0;
                $Permission_User->update = 0;
                $Permission_User->read = 0;
                $Permission_User->delete = 0;
                $Permission_User->user_id = $User->id;
                $Permission_User->save();
                //user_permission
                $PermissionProduct = new PermissionProduct;
                $PermissionProduct->name = 'Product';
                $PermissionProduct->create = 0;
                $PermissionProduct->update = 0;
                $PermissionProduct->read = 0;
                $PermissionProduct->delete = 0;
                $PermissionProduct->user_id = $User->id;
                $PermissionProduct->save();
                //invoice_permission
                $PermissionInvoice = new PermissionInvoice;
                $PermissionInvoice->name = 'Invoice';
                $PermissionInvoice->create = 0;
                $PermissionInvoice->update = 0;
                $PermissionInvoice->read = 0;
                $PermissionInvoice->delete = 0;
                $PermissionInvoice->user_id = $User->id;
                $PermissionInvoice->save();
            } else {
                foreach ($permissions as $data) {
                    if ($data->name == 'User') {
                        //user_permission
                        $Permission_User = new Permission_User;
                        $Permission_User->name = $data->name;
                        $Permission_User->create = $data->create;
                        $Permission_User->update = $data->update;
                        $Permission_User->read = $data->read;
                        $Permission_User->delete = $data->delete;
                        $Permission_User->user_id = $User->id;
                        $Permission_User->save();
                    }
                    if ($data->name == 'Product') {
                        //user_permission
                        $PermissionProduct = new PermissionProduct;
                        $PermissionProduct->name = $data->name;
                        $PermissionProduct->create = $data->create;
                        $PermissionProduct->update = $data->update;
                        $PermissionProduct->read = $data->read;
                        $PermissionProduct->delete = $data->delete;
                        $PermissionProduct->user_id = $User->id;
                        $PermissionProduct->save();
                    }
                    if ($data->name == 'Invoice') {
                        //invoice_permission
                        $PermissionInvoice = new PermissionInvoice;
                        $PermissionInvoice->name = $data->name;
                        $PermissionInvoice->create = $data->create;
                        $PermissionInvoice->update = $data->update;
                        $PermissionInvoice->read = $data->read;
                        $PermissionInvoice->delete = $data->delete;
                        $PermissionInvoice->user_id = $User->id;
                        $PermissionInvoice->save();
                    }
                }
            }

            $User->notify(new SignupActivate($User));
            return response()->json($User);
        }
    }
    public function profile(Request $request)
    {
        // $this->authorize('isUser_Update');
        $file = $request->file;
        $id = $request->id;
        if ($file) {
            $image = $file; // base64 encoded
            $extension = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];   // .jpg .png .pdf
            $replace = substr($image, 0, strpos($image, ',') + 1);
            $image = str_replace($replace, '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = time() . 'Avatar.' . $extension;
            $path = public_path() . "/images/uploads/" . $imageName;
            $image_decoded = base64_decode($image); // decoding File
            file_put_contents($path, $image_decoded);
            $profile_image = '/images/uploads/' . $imageName; //full path
            $User = User::find($id);
            $User->profile_image = $profile_image;
            $User->save();

            return response()->json($profile_image, 200);
        } else {
            return response()->json(['error' => "error"], 422);
        }
    }
    public function removeProfile()
    {
        $id = Auth::id();
        $User = User::find($id);
        $User->profile_image = null;
        $User->save();
        return response()->json('Success', 200);
    }
    public function permission(Request $request)
    {
        $this->authorize('isUser_Update');
        $user_id = $request->user_id;
        $permissions = $request->permissions;
        foreach ($permissions as $data) {
            if ($data['name'] == 'User') {
                Permission_User::where("user_id", $user_id)->delete();
                //user_permission
                $Permission_User = new Permission_User;
                $Permission_User->name = $data['name'];
                $Permission_User->create = $data['create'];
                $Permission_User->update = $data['update'];
                $Permission_User->read = $data['read'];
                $Permission_User->delete = $data['delete'];
                $Permission_User->user_id = $user_id;
                $Permission_User->save();
            }
            if ($data['name'] == 'Invoice') {
                PermissionInvoice::where("user_id", $user_id)->delete();
                $PermissionInvoice = new PermissionInvoice;
                $PermissionInvoice->name = $data['name'];
                $PermissionInvoice->create = $data['create'];
                $PermissionInvoice->update = $data['update'];
                $PermissionInvoice->read = $data['read'];
                $PermissionInvoice->delete = $data['delete'];
                $PermissionInvoice->user_id = $user_id;
                $PermissionInvoice->save();
            }
            if ($data['name'] == 'Product') {
                PermissionProduct::where("user_id", $user_id)->delete();
                $PermissionProduct = new PermissionProduct;
                $PermissionProduct->name = $data['name'];
                $PermissionProduct->create = $data['create'];
                $PermissionProduct->update = $data['update'];
                $PermissionProduct->read = $data['read'];
                $PermissionProduct->delete = $data['delete'];
                $PermissionProduct->user_id = $user_id;
                $PermissionProduct->save();
            }
        }
        return response()->json('Success');
    }
    public function general(Request $request)
    {

        // $this->authorize('isUser_Update');

        // $user_id = $request->user_id;
        $data = $request->data;
        $id = Auth::id();
        $name = $data['name'];
        $email = $data['email'];
        $phone = $data['phone'];
        // $permissions = $request->permissions;
        $ChangedEmail = false;
        $User = User::find($id);
        if ($User->email !== $email) {
            $ChangedEmail = true;
        }
        $User->name = $name;
        $User->email = $email;
        $User->phone = $phone;
        if ($ChangedEmail === true) {
            $User->active = false;
            $User->email_verified_at = null;
        }
        $User->save();
        // foreach ($permissions as $data) {
        //     if ($data['name'] == 'User') {
        //         Permission_User::where("user_id", $user_id)->delete();
        //         //user_permission
        //         $Permission_User = new Permission_User;
        //         $Permission_User->name = $data['name'];
        //         $Permission_User->create = $data['create'];
        //         $Permission_User->update = $data['update'];
        //         $Permission_User->read = $data['read'];
        //         $Permission_User->delete = $data['delete'];
        //         $Permission_User->user_id = $user_id;
        //         $Permission_User->save();
        //     }

        //     if ($data['name'] == 'Invoice') {
        //         PermissionInvoice::where("user_id", $user_id)->delete();
        //         //Student_permission
        //         $PermissionInvoice = new PermissionInvoice;
        //         $PermissionInvoice->name = $data['name'];
        //         $PermissionInvoice->create = $data['create'];
        //         $PermissionInvoice->update = $data['update'];
        //         $PermissionInvoice->read = $data['read'];
        //         $PermissionInvoice->delete = $data['delete'];
        //         $PermissionInvoice->user_id = $user_id;
        //         $PermissionInvoice->save();
        //     }
        // }

        if ($ChangedEmail === true) {
            $User->notify(new SignupActivate($User));
        }

        return response()->json($User);
    }
    public function show($id)
    {
        $user = User::where('id', $id)->with('user_role.role', 'permission_user',   'permission_invoice', 'permission_product')->first();
        return response()->json($user);
    }
    public function destroy($id)
    {
        $this->authorize('isUser_Delete');
        $User = User::find($id);
        $User->delete();
        return response()->json(['success' => 'User has been deleted Successfully']);
    }
    public function AuthGeneral(Request $request)
    {

        $user_id = $request->user_id;
        $user_data = $request->data;
        $name = $user_data['name'];
        $email = $user_data['email'];

        $User = User::find($user_id);
        $User->name = $name;
        $User->email = $email;
        if ($User->email !== $email) {
            $User->active = false;
            $User->email_verified_at = '';
            $User->notify(new SignupActivate($User));
        }
        $User->save();
        return response()->json(['success']);
    }

    public function Password(Request $request)
    {

        $user_id =  Auth::id();
        $user_data = $request->data;
        $new_password = Hash::make($user_data['new_password']);

        $User = User::find($user_id);
        if (Hash::check($user_data['current_password'], $User->password)) {
            $User->password = $new_password;
            $User->save();
            return response()->json(['success']);
        } else {
            return response()->json(['error' => 'The current password you have entered is incorrect'], 401);
        }
    }
}
