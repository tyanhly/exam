<?php

class UserController extends BaseController {

    /**
     * User Model
     * @var User
     */
    protected $user;
    /**
     * Inject the models.
     * @param User $user
     * @param UserRepository $userRepo
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    
    
    
    /**
     * Displays the login form
     *
     */
    public function getLogin()
    {
        $user = Auth::user();
        if(!empty($user->id)){
            return Redirect::route('product.index');
        }

        return View::make('user.login');
    }

    /**
     * Attempt to do login
     *
     */
    public function postLogin()
    {
        $validatorRules = array(
            'user_name'        => 'regex:/^[a-zA-Z0-9_]+$/',
        );
        //         dd(Input::all());
        $validator = Validator::make(Input::all(), $validatorRules);
        
        if ($validator->fails())
        {
            return Redirect::route('user.getLogin')
            ->with('error-message', $validator->errors()->first());
        }
        
        if (Auth::attempt(array('user_name'=>Input::get('user_name'), 'password'=>Input::get('password')))) {
            return Redirect::route('product.index')->with('message', 'Welcome to Exam Cart, You signed in. Your username is '. Input::get('user_name') .'!');
        } else {
            return Redirect::route('user.getLogin')
            ->with('error-message', 'Oops! Something went wrong while submitting the form :(')
            ->withInput();
        }

    }


    /**
     * Log the user out of the application.
     *
     */
    public function getLogout()
    {
        Auth::logout();
        return Redirect::route('user.getLogin')->with('message', 'Your are now logged out!');
    }

}
