<?php

namespace Tests\Unit;

use App\Role;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AssingRole extends TestCase
{
    /**
     * check if method assign the role of nutriologist.
     *
     * @return void
     */
    public function testBecomesNutriologistTest()
    {
        $user = User::find(1);
        $result = $user->becomesNutrioligist();
        $this->assertTrue($user->hasRole(Role::NUTRIOLOGIST));
    }
    /**
     * check if method remove the role of nutriologist.
     *
     * @return void
     */
    public function testRemoveNutriologistRoleTest(){
        $user = User::find(1);
        $result = $user->removeRole(Role::NUTRIOLOGIST);
        $this->assertFalse($user->hasRole(Role::NUTRIOLOGIST));
    }
    /**
     * check if method assign the role of patient.
     *
     * @return void
     */
    public function testBecomesPatientTest()
    {
        $user = User::find(1);
        $result = $user->becomesPatient();
        $this->assertTrue($user->hasRole(Role::PATIENT));
    }
    /**
     * check if method remove the role of patient.
     *
     * @return void
     */
    public function testRemovePatientRoleTest(){
        $user = User::find(1);
        $result = $user->removeRole(Role::PATIENT);
        $this->assertFalse($user->hasRole(Role::PATIENT));
    }
}
