<?php


namespace App\Controllers;


use App\Models\UserModel;


class AuthController extends BaseController
{
    public function register()
    {
        return view('auth/register', ['title' => 'Register']);
    }


    public function attemptRegister()
    {
        $rules = [
            'name'     => 'required|min_length[2]',
            'email'    => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'confirm'  => 'required|matches[password]',
        ];
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('errors', $this->validator->getErrors());
        }
        (new UserModel())->save([
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => $this->request->getPost('password'),
        ]);
        return redirect()->to('/login')->with('message', 'Registration successful. Please login.');
    }


    public function login()
    {
        return view('auth/login', ['title' => 'Login']);
    }


    public function attemptLogin()
    {
        $user = (new UserModel())->where('email', $this->request->getPost('email'))->first();
        if (! $user || ! password_verify($this->request->getPost('password'), $user['password'])) {
            return redirect()->back()->with('errors', ['Invalid email or password.']);
        }
        session()->set([
            'user_id'   => $user['id'],
            'user_name' => $user['name'],
            'logged_in' => true,
        ]);
        return redirect()->to('/tasks')->with('message', 'Welcome back, ' . $user['name'] . '!');
    }


    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('message', 'Logged out.');
    }
}