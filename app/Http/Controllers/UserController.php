<?php
 
namespace App\Http\Controllers;
 
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
 
class UserController extends Controller
{
    // Register a new user
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'username' => [
                'required',
                'string',
                'regex:/^(?!.*\.\.)(?!.*\.$)[^\W][\w.]{0,29}$/',
                'unique:users,username'
            ],
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                'string',
                'regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/',
                'confirmed'
            ],
            'role' => 'required|in:agent,client',
        ], [
            'username.regex' => 'The username may only contain letters, numbers, and underscores.',
            'password.regex' => 'The password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter and one number.',
        ]);
 
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
 
        try {
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role
            ]);
 
            Auth::login($user);
            return redirect()->route('welcome')->with('success', 'Registration successful!');
 
        } catch (\Exception $error) {
            return redirect()->back()
                ->with($error, 'An unexpected error occurred during registration.')
                ->withInput();
        }        
    }
 
 
    // Login a user
    public function login(Request $request) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
       
        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            return redirect()->intended('/')->with('success', 'Login successful!');
        }
 
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
 
 
    // Logout a user
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login')->with('success', 'You have been logged out.');
    }
 
 
    // Update a user
    public function update(Request $request) {
        $user = Auth::user();
 
        $validator = Validator::make($request->all(), [
            'username' => [
                'sometimes',
                'string',
                'regex:/^(?!.*\.\.)(?!.*\.$)[^\W][\w.]{0,29}$/',
                'unique:users,username,' . $user->userId . ',userId'
            ],
            'email' => 'sometimes|email|unique:users,email,' . $user->userId . ',userId',
            'current_password' => 'required_with:password|current_password',
            'password' => [
                'sometimes',
                'string',
                'regex:/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$/',
                'confirmed'
            ],
        ], [
            'username.regex' => 'The username may only contain letters, numbers, and underscores.',
            'password.regex' => 'The password must be at least 8 characters long and contain at least one uppercase letter, one lowercase letter and one number.',
            'current_password.current_password' => 'The current password is incorrect.'
        ]);
 
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
 
        try {
            $updateData = [];
           
            if ($request->filled('username')) {
                $updateData['username'] = $request->username;
            }
           
            if ($request->filled('email')) {
                $updateData['email'] = $request->email;
            }
           
            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }
 
            User::where('userId', $user->userId)->update($updateData);
           
            return redirect()->route('profile')
                ->with('success', 'Profile updated successfully!');
 
        } catch (\Exception $error) {
            return redirect()->back()
                ->with('error', 'An unexpected error occurred while updating your profile.')
                ->withInput();
        }
    }
 
 
    // Delete a user
    public function delete(Request $request) {
        $request->validate([
            'confirm' => 'required|in:DELETE',
        ]);
       
        try {
            $user = Auth::user();
            Auth::logout();
            User::where('userId', $user->userId)->delete();
           
            $request->session()->invalidate();
            $request->session()->regenerateToken();
           
            return redirect()->route('welcome')
                ->with('success', 'Your account has been permanently deleted.');
 
        } catch (\Exception $error) {
            return redirect()->back()
                ->with('error', 'An unexpected error occurred while deleting your account.');
        }
    }
 
    // Show user profile
    public function show() {
        return view('profile.show', ['user' => Auth::user()]);
    }
   
    // Show edit profile form
    public function edit() {
        return view('profile.edit', ['user' => Auth::user()]);
    }
}