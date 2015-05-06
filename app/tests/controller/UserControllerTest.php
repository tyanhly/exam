<?php

/**
 *
 * @author tungly
 *         List TestCase
 *         testLoginResponseOk
 *         testUserHadLoginAndAccessLoginPageShouldRedirectToProductPage
 *         testLoginSuccess
 *         testLoginAttemptFail
 *         testLoginValidateFail
 *         testLogoutSuccess
 */
class UserControllerTest extends TestCase
{

    public function __construct () {
        // We have no interest in testing Eloquent
    }

    public function tearDown () {
        
        Mockery::close();
    }

    /**
     *
     * @author Tung Ly
     */
    public function testLoginResponseOk () {
        $this->console("testLoginResponseOk");
        $this->call('GET', '/login');
        $this->assertResponseOk();
    }

    /**
     *
     * @author Tung Ly
     */
    public function testUserHadLoginAndAccessLoginPageShouldRedirectToProductPage () {
        
        $this->console(
                "testUserHadLoginAndAccessLoginPageShouldRedirectToProductPage");
        $user = new User();
        $user->user_name = 'tyanhly';
        $user->first_name = 'Ly';
        $user->last_name = 'Tung';
        $user->password = hash('sha256', '123456');
        $this->be($user); // You are now authenticated
        
        $this->call('GET', '/login');
        
        $this->assertRedirectedToRoute('product.index');
    
    }

    /**
     *
     * @author Tung Ly
     */
    public function testLoginSuccess () {
        $this->console("testLoginSuccess");
        Auth::shouldReceive('attempt')->andReturn(true);
        $this->call('POST', 'login');
        $this->assertRedirectedToRoute('product.index');
    }

    /**
     *
     * @author Tung Ly
     */
    public function testLoginAttemptFail () {
        $this->console("testLoginAttemptFail");
        Auth::shouldReceive('attempt')->andReturn(false);
        $this->call('POST', 'login');
        $this->assertRedirectedToRoute('user.getLogin');
    }

    /**
     *
     * @author Tung Ly
     */
    public function testLoginValidateFail () {
        
        $this->console("testLoginValidateFail");
        $validator = Mockery::mock('Illuminate\Validation\Validator');
        $validator->shouldReceive('fails')->andReturn(true);
        $this->call('POST', 'login');
        $this->assertRedirectedToRoute('user.getLogin');
    }

    /**
     *
     * @author Tung Ly
     */
    public function testLogoutSuccess () {
        $this->console("testLogoutSuccess");
        
        $credentials = [
            'user_name' => 'user0',
            'password' => '123456',
            'csrf_token' => csrf_token()
        ];
        $auth = Mockery::mock('Illuminate\Auth\AuthManager');
        $auth->shouldReceive('attempt')
            ->with($credentials)
            ->andReturn(true);
        
        $this->app->instance('Illuminate\Auth\AuthManager', $auth);
        
        $this->call('GET', '/logout');
        $this->assertRedirectedToRoute('user.getLogin');
    }

}
