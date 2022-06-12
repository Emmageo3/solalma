<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cart;
use Auth;
use Session;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    public function loginRegister()
    {
        return view('front.users.login_register');
    }

    public function registerUser(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();

            if(empty($data['address'])){
                $data['address']="";
            }

            $userCount = User::where('email',$data['email'])->count();
            if($userCount>0){
                $message = "Cet utilisateur existe déja!";
                Session::flash('error_message',$message);
                return redirect()->back();
            }else {
                $user = new User;
                $user->name = $data['name'];
                $user->mobile = $data['mobile'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['password']);
                $user->address = "";
                $user->city = "";
                $user->state ="";
                $user->country="";
                $user->pincode="";
                $user->status = 0;
                $user->save();

                $email = $data['email'];
                $messageData = [
                    'email'=>$data['email'],
                    'name'=>$data['name'],
                    'code'=>base64_encode($data['email'])
                ];
                Mail::send('emails.confirmation',$messageData,function($message) use($email){
                    $message->to($email)->subject('Confirmation de votre compte');
                });

                $message = "Veuillez consulter votre boite mail pour confirmer votre compte. Si vous ne le trouvez pas, consultez vos spam";
                Session::flash('success_message',$message);
                return redirect()->back();

                /*if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){


                }*/
            }
        }
    }

    public function confirmAccount($email)
    {
        $email = base64_decode($email);
        $userCount = User::where('email',$email)->count();
        if($userCount>0)
        {
            $userDetails = User::where('email',$email)->first();
            if($userDetails->status == 1){
                $message = "Votre compte a déja été activé. Veuillez vous connecter";
                Session::flash('error_message',$message);
                return redirect('login-register');
            }else {
                User::where('email',$email)->update(['status'=>1]);

                $email = $userDetails['email'];
                $messageData = ['name'=>$userDetails['name'],'mobile'=>$userDetails['mobile'],'email'=>$userDetails['email']];
                Mail::send('emails.register',$messageData,function($message) use($email){
                    $message->to($email)->subject('Bienvenue chez Evisem');
                });

                $message = "Votre compte a été activé. Vous pouvez désormais vous connecter";
                Session::flash('success_message',$message);
                return redirect('login-register');

            }
        }else
        {
            abort(404);
        }
    }

    public function logoutUser()
    {
        Auth::logout();
        return redirect('/');
    }

    public function checkEmail(Request $request)
    {
        $data = $request->all();
        $emailCount = User::where('email',$data['email'])->count();
        if($emailCount>0){
            return "false";
        }else{
            return "true";
        }

    }

    public function loginUser(Request $request)
    {
        if($request->isMethod('post')){
            $data = $request->all();
            if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){

                $userStatus = User::where('email',$data['email'])->first();
                if($userStatus->status == 0){
                    Auth::logout();
                    $message = "Votre compte n'est pas encore activé. Veuillez l'activer en cliquant sur le lien envoyé par email.";
                    Session::flash('error_message',$message);
                    return redirect()->back();
                }

                if(!empty(Session::get('session_id'))){
                    $user_id = Auth::user()->id;
                    $session_id = Session::get('session_id');
                    Cart::where('session_id',$session_id)->update(['user_id'=>$user_id]);
                }

                return redirect('/cart');
            }else{
                $message = "Adresse email ou mot de passe invalide";
                Session::flash('error_message',$message);
                return redirect()->back();
            }
        }
    }
}