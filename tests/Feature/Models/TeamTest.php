<?php

namespace Tests\Feature\Models;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TeamTest extends TestCase
{
    use DatabaseTransactions;
    /** @test */

    function a_team_has_a_name()
    {
        $team = new Team(['name'=>'Acme']);
        $this->assertEquals('Acme',$team->name);
    }

    /** @test */

    function a_team_can_add_a_member()
    {
        $team = Team::factory()->create();
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $team->add($user);
        $team->add($user2);
        $this->assertEquals(2,$team->count());
    }


    /** @test */

    function a_team_can_add_multiple_members()
    {
        $team = Team::factory()->create();
        $users = User::factory()->count(2)->create();
        $team->add($users);
        $this->assertEquals(2,$team->count());
    }

    /** @test */
    function a_team_has_maximum_size()
    {

        $team = Team::factory()->create(['size'=>2]);
        $user = User::factory()->create();
        $user2 = User::factory()->create();
        $team->add($user);
        $team->add($user2);
        $this->assertEquals(2,$team->count());
        $this->expectException('Exception');

        $user3 = User::factory()->create();
        $team->add($user3);
    }

    /** @test */

    function when_adding_many_users_to_a_team_you_may_not_exceed_the_team_max_size()
    {
        $team = Team::factory()->create(['size'=>2]);
        $users = User::factory()->count(3)->create();
        $this->expectException('Exception');
        $team->add($users);
    }
    /** @test */
    function a_team_can_remove_one_user()
    {
        $team = Team::factory()->create();
        $users = User::factory()->count(2)->create();
        $team->add($users);

        $team->remove($users[0]);
        $this->assertEquals(1,$team->count());
    }

    /** @test */
    function a_team_can_remove_all_users()
    {
        $team = Team::factory()->create();
        $users = User::factory()->count(2)->create();
        $team->add($users);

        $team->restart();
        $this->assertEquals(0,$team->count());
    }


    /** @test */
    function a_team_can_remove_more_than_one_user()
    {
        $team = Team::factory()->create(['size'=>3]);
        $users = User::factory()->count(3)->create();
        $team->add($users);

        $team->remove($users->slice(0,2));
        $this->assertEquals(1,$team->count());
    }
}
