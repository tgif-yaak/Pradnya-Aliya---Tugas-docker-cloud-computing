<?php namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('login');
    }

    public function prosesLogin()
    {
        $userModel = new UserModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $user = $userModel->where('username', $username)->first();

        if ($user && password_verify($password, $user['password'])) {
            session()->set('isLoggedIn', true);
            session()->set('username', $username);
            return redirect()->to('/ibadah');
        } else {
            return redirect()->back()->with('error', 'Username atau password tidak sesuai!');
        }
    }

    public function register()
    {
        return view('register');
    }

    public function saveRegister()
    {
        $userModel = new \App\Models\UserModel();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $userModel->save([
            'username' => $username,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ]);

        return redirect()->to('/login-doa')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }


    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login-doa');
    }
}
