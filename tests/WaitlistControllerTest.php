<?php
use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Test\CIUnitTestCase;

class WaitlistControllerTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testIndexPageLoads()
    {
        $result = $this->call('get', '/waitlist');
        $result->assertStatus(200);
        $result->assertSee('MYZUWA');
    }

    public function testPreSignupWithValidEmailRedirects()
    {
        $result = $this->call('post', '/waitlist/preSignup', [
            'email' => 'testuser@example.com'
        ]);
        $result->assertRedirect('waitlist/signup');
    }

    public function testPreSignupWithInvalidEmailFails()
    {
        $result = $this->call('post', '/waitlist/preSignup', [
            'email' => 'notanemail'
        ]);
        $result->assertRedirect('/');
    }

    public function testSignupFormLoads()
    {
        $result = $this->call('get', '/waitlist/signup');
        $result->assertStatus(200);
        $result->assertSee('Join the waitlist');
    }
}
