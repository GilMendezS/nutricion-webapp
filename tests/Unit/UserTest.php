<?php

namespace Tests\Unit;

use App\Role;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    /**
     * check if method assign the role of nutriologist.
     *
     * @return void
     */
    public function testVerifyUserCantAddNewPatientTest()
    {
        $user = User::find(1);
        $result = $user->canRegisterMorePatients();
        $this->assertFalse($result);
    }
    
}
