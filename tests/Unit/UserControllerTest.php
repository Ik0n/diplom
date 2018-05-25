<?php
/**
 * Created by PhpStorm.
 * User: Ik0n1
 * Date: 14.12.2017
 * Time: 0:35
 */

namespace Tests\Unit;


use App\Http\Requests\UserRequest;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserControllerTest extends TestCase
{

    public function testStore() {
        $this->assertTrue(true);
    }
}