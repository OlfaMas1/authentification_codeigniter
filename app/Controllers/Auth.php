<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Libraries\Hash;

class Auth extends Controller
{
    public function __construct(){
        helper(['url','form']);
    }

    public function index()
    {
        return view('auth/login');
    }
    public function register(){
        return view('auth/register');
    }

    public function save(){
        
        $validation = $this->validate([
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Your full name is required.'
                ]
            ],
            'email' => [
                'rules' => 'required|valid_email|is_unique[users.email]',
                'errors' => [
                    'required' => 'Email is required.',
                    'valid_email' => 'You must enter a valid email.',
                    'is_unique' => 'Email already exist.'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[5]|max_length[12]',
                'errors' => [
                    'required' => 'Password is required.',
                    'min_length' => 'Password must have atleast 5 characters.',
                    'max_length' => 'Password must not have more than 12 characters.'
                ]
            ],
            'cpassword' => [
                'rules' => 'required|min_length[5]|max_length[12]|matches[password]',
                'errors' => [
                    'required' => 'Confirm password is required.',
                    'min_length' => 'Confirm password must have atleast 5 characters in.',
                    'max_length' => 'Confirm password must not have more than 12 characters.',
                    'matches' => 'Confirm password mot matches to password'
                ]
            ]
        ]);

        if(!$validation){
            return view('auth/register',['validation'=>$this->validator]);
        }else{
            $name = $this->request->getPost('name');
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $values = [
                'name'=>$name,
                'email' => $email, 
                'password'=>Hash::make($password),
            ];

            $usersModel = new \App\Models\UsersModel();
            $query = $usersModel->insert($values);
            if(!$query){
                return redirect()->back->with('fail','Something went wrong');
            }else{
                return redirect()->to('auth/register')->with('success','You are now registred successfully');
            }
        }
    }

    function check(){
        $validation = $this->validate([           
            'email' => [
                'rules' => 'required|valid_email|is_not_unique[users.email]',
                'errors' => [
                    'required' => 'Email is required.',
                    'valid_email' => 'Enter a valid email adress.',
                    'is_not_unique' => 'This email is not registred on our service.'
                ]
            ],
            'password' => [
                'rules' => 'required|min_length[5]|max_length[12]',
                'errors' => [
                    'required' => 'Password is required.',
                    'min_length' => 'Password must have atleast 5 characters.',
                    'max_length' => 'Password must not have more than 12 characters.'
                ]
            ]
        ]);

        if(!$validation){
            return view('auth/login',['validation'=>$this->validator]);
        }else{
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');
            $usersModel = new \App\Models\UsersModel();
            $user_info = $usersModel->where('email',$email)->first();
            $checkou_password = Hash::check($password, $user_info['password']);

            if(!$checkou_password){
                session()->setFlashdata('fail',' Incorrect password');
                return redirect()->to('/auth')->withInput();
            }else{
                $user_id  = $user_info['id'];
                session()->set('loggedUser',$user_id);
                return redirect()->to('/dashboard'); 
            }
            
        }
    }

}