<?php

namespace Tests\Feature\Auth;

use Tests\Feature\TestCase;

class AuthenticationTest extends TestCase
{

    /** @test */
    public function a_unauthenticated_user_is_redirected_to_login_page()
    {
        $response = $this->get('/');
        $response->assertStatus(302);

        $response->assertRedirect('authenticated');
    }

    /** @test */
    public function a_employee_is_redirected_to_the_employee_dashboard()
    {
        $user = $this->signIn();
        $dashboard = 'employee/'.$user->person->employee->uuid;

        $response = $this->get('/');
        $response->assertStatus(302);
        $response->assertRedirect($dashboard);

        $response = $this->get($dashboard);
        $response->assertStatus(200);
    }

}
