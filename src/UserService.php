<?php

namespace Microservices;

use Illuminate\Support\Facades\Http;

class UserService
{
    private $endpoint;

    public function __construct(){
        $this->endpoint = env('USERS_ENDPOINT');
    }

    public function headers(){
        
        return [
            'Authorization' => 'Bearer ' . request()->cookie('jwt')
        ]; 
    }

    public function request(){
        return  Http::withHeaders($this->headers());
    }

    // public function parseUser($json): User {
    //     $user = new User();
    //     $user->id = $json['id'];
    //     $user->first_name = $json['first_name'];
    //     $user->last_name = $json['last_name'];
    //     $user->email = $json['email'];
    //     $user->is_influencer = $json['is_influencer'] ?? 0;

    //     return $user;
    // }
    
    public function getUser(): User {

        $json = $this->request()->get("{$this->endpoint}/user")->json();

        // return $this->parseUser($json);
        return new User($json);
    }

    public function isAdmin(){
        return $this->request()->get("{$this->endpoint}/admin")->successful();
    }

    public function isInfluencer(){
        return $this->request()->get("{$this->endpoint}/influencer")->successful();
    }

    public function allows($ability, $arguments){
        return \Gate::forUser($this->getUser())->authorize($ability, $arguments);
    }

    public function all($page){
        return $this->request()->get("{$this->endpoint}/users?page={$page}")->json();
    }

    public function get($id): User {
        $json = $this->request()->get("{$this->endpoint}/users/{$id}")->json();
        // return $this->parseUser($json);
        return new User($json);

    }

    public function create($data): User {
        $json = $this->request()->post("{$this->endpoint}/users", $data)->json();
        // return $this->parseUser($json);
        return new User($json);

    }

    public function update($id, $data): User {
        $json = $this->request()->put("{$this->endpoint}/users/{$id}", $data)->json();
        // return $this->parseUser($json);
        return new User($json);

    }

    public function delete($id){
        return $this->request()->delete("{$this->endpoint}/users/{$id}")->successful();
    }
}