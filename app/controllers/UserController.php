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
            return Redirect::to('/');
        }

        return View::make('user.login');
    }

    /**
     * Attempt to do login
     *
     */
    public function postLogin()
    {
        if (Auth::attempt(array('user_name'=>Input::get('user_name'), 'password'=>Input::get('password')))) {
            return Redirect::to('/')->with('message', 'Thank you! Your submission has been received!');
        } else {
            return Redirect::to('user/login')
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
        return Redirect::to('user/login')->with('message', 'Your are now logged out!');
    }

}
