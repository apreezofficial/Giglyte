<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function type($type){
return User::where('type', $type)->get();
}
public function index(){
return User::all();
}
public function new($email, $password){
  $password_hash = Hash::make($password);
  $code = random_int(1111, 9999);
  $item = new User();
  $item->email=$email;
  $item->password=$password_hash;
  $item->verification_code=$code;
  $item->save();
  echo "User" . $email . "Created Succesfully";
}
public function verify($id, $code){
  $item = User::all()
  ->where('id', $id)
  ->where('verification_code', $code)
  ->first();
  $item->email_verified=1;
  $item->verification_code=null;
  $item->update();
  echo "UserData with" . $id . "verified Succesfully";
}
public function delete($id){
  $item = User::findorfail($id)
  ->first();
  $item->delete();
  echo "Deleted user with" . $id . "verified Succesfully";
}
}
