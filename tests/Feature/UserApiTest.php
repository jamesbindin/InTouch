<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class UserApiTest extends TestCase
{
    private  $apiKey = "Bearer 62ac546c-1eb6-477c-8d7c-ad676b6609cf";
    private $testUser = array(
        'Username'=>'testUsername',
        'Firstname'=>'testFirstname',
        'Surname'=>'testSurname',
        'DateOfBirth'=>'2000/10/01',
        'PhoneNumber'=>'938595873937',
        'Email'=>'testemail@email.com'
    );
    /**
     * A basic feature test example.
     *
     * @return void
     */

    // checks the test user exists, if so it is deleted before the tests are carried out 
    public function testSetUp(){
        $response = $this->withHeaders([
            'Authorization' => $this->apiKey,
        ])->json('GET', 'api/user/'.$this->testUser['Username']);

        if($response){
            $this->assertTrue(true);
            $this->withHeaders([
                'Authorization' => $this->apiKey,
            ])->json('DELETE', 'api/user/'.$this->testUser['Username']);
        }
        $this->assertTrue(true);
    }


    // inserts test user into db using POST 
    public function testPost()
    {
        $response = $this->withHeaders([
            'Authorization' => $this->apiKey,
        ])->json('POST', 'api/user', $this->testUser);

        $response
            ->assertStatus(201)
            ->assertJson(['success'=>1]);
    }

    // checks GET for returning 1 user
    public function testGetOne()
    {
        $response = $this->withHeaders([
            'Authorization' => $this->apiKey,
        ])->json('GET', 'api/user/'.$this->testUser['Username']);

        $response
            ->assertStatus(200)
            ->assertJson(['success'=>1]);
    }

    // checks GET for returning all users
    public function testGetAll()
    {
        $response = $this->withHeaders([
            'Authorization' => $this->apiKey,
        ])->json('GET', 'api/user');

        $response
            ->assertStatus(200)
            ->assertJson(['success'=>1]);
    }

    // checks PUT, changes user but uses the same details
    public function testPut()
    {
        $response = $this->withHeaders([
            'Authorization' => $this->apiKey,
        ])->json('PUT', 'api/user', $this->testUser);

        $response
            ->assertStatus(200)
            ->assertJson(['success'=>1]);
    }

    // tests DELETE user
    public function testDelete()
    {
        $response = $this->withHeaders([
            'Authorization' => $this->apiKey,
        ])->json('DELETE', 'api/user/'.$this->testUser['Username']);

        $response
            ->assertStatus(200)
            ->assertJson(['success'=>1]);
    }

}
