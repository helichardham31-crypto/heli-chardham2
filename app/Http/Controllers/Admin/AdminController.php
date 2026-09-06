<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Admin;
use App\Models\MealStaff;
use App\Models\Meal;
use DB;

class AdminController extends Controller
{
    //
    public function adminlogin(){
        return view("adminlogin");
    }
   // Authenticate function
public function adminauthenticate(Request $request)
{
    // Validate the request data
    $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);

    // Extract email and password from the request
    $credentials = $request->only('email', 'password');

    // Attempt to authenticate the admin using the 'admins' guard
    if (Auth::guard('admins')->attempt($credentials)) {
        // Authentication passed, redirect to the admin dashboard
        return redirect()->intended('/admin/dashboard');
    } else {
        // Authentication failed, redirect back with error message
        return redirect()->back()->withInput()->withErrors([
            'login_error' => 'Invalid email or password',
        ]);
    }
}

    public function dashboard()
    {
      
         return view('admin/dashboard');
    }
       
    
// public function showSubmitData(Request $request)
// {
//     $code = $request->input('code');
//     // Assuming the QR code contains JSON data
//     $data = json_decode($code, true);

//     return view('admin.submit-data', [
//         'unique_code' => $data['unique_code'] ?? '',
//         'name' => $data['name'] ?? '',
//         'ref_id' => $data['ref_id'] ?? '',
//         'type' => $data['type'] ?? '',
//     ]);
// }


    // public function saveUserData(Request $request)
    // {
    //     $request->validate([
    //         'date' => 'required|date',
    //         'unique_code' => 'required|string',
    //         'name' => 'required|string',
    //         'meal' => 'required|string',
    //     ]);

    //     // Save the data to the meals table
    //     \DB::table('meals')->insert([
    //         'date' => $request->input('date'),
    //         'unique_code' => $request->input('unique_code'),
    //         'name' => $request->input('name'),
    //         'meal' => $request->input('meal'),
    //         'created_at' => now(),
    //         'updated_at' => now(),
    //     ]);

    //     return redirect()->back()->with('success', 'User data saved successfully!');
    // }
// public function showSubmitData(Request $request)
// {
//     // Retrieve the query parameters directly
//     $uniqueCode = $request->input('unique_code');
//     $name = $request->input('name');
//     $refId = $request->input('ref_id');
//     $type = $request->input('type');

//     // Log the received data for debugging purposes
//     \Log::info("Received Data: Unique Code: $uniqueCode, Name: $name, Ref ID: $refId, Type: $type");

//     // Check if all necessary parameters are present
//     if (!$uniqueCode || !$name || !$refId || !$type) {
//         \Log::error('Missing required QR code data.');
//         return back()->withErrors('Missing required QR code data.');
//     }

//     // Fetch the current date
//     $currentDate = date('Y-m-d');

//     // Fetch the meals the user has already selected for today
//     $selectedMeals = Meal::where('unique_code', $uniqueCode)
//         ->where('date', $currentDate)
//         ->pluck('meal') // Get only the 'meal' column
//         ->toArray(); // Convert result to array

//     // Log the selected meals for debugging
//     \Log::info('Selected meals: ', $selectedMeals);

//     // Pass the data and selected meals to the view
//     return view('admin.submit-data', [
//         'unique_code' => $uniqueCode,
//         'name' => $name,
//         'ref_id' => $refId,
//         'type' => $type,
//         'selectedMeals' => $selectedMeals, // Pass already selected meals to the view
//     ]);
// }

public function showSubmitData(Request $request)
{
    // Retrieve the query parameters directly
    $uniqueCode = $request->input('unique_code');
    $name = $request->input('name');
    $refId = $request->input('ref_id');
    $type = $request->input('type');

    // Log the received data for debugging purposes
    \Log::info("Received Data: Unique Code: $uniqueCode, Name: $name, Ref ID: $refId, Type: $type");

    // Check if all necessary parameters are present
    if (!$uniqueCode || !$name || !$refId || !$type) {
        \Log::error('Missing required QR code data.');
        return back()->withErrors('Missing required QR code data.');
    }

    // Fetch the current date
    $currentDate = date('Y-m-d');

    // Fetch the meals the user has already selected for today, based on the type
    if ($type === 'IPCA_staff' || $type === 'pharma_staff') {
        // For IPCA_staff and pharma_staff, fetch from meals_staff table
        $selectedMeals = MealStaff::where('unique_code', $uniqueCode)
            ->where('date', $currentDate)
            ->pluck('meal') // Get only the 'meal' column
            ->toArray(); // Convert result to array
    } else {
        // For other types, fetch from meals table
        $selectedMeals = Meal::where('unique_code', $uniqueCode)
            ->where('date', $currentDate)
            ->pluck('meal') // Get only the 'meal' column
            ->toArray(); // Convert result to array
    }

    // Log the selected meals for debugging
    \Log::info('Selected meals: ', $selectedMeals);

    // Pass the data and selected meals to the view
    return view('admin.submit-data', [
        'unique_code' => $uniqueCode,
        'name' => $name,
        'ref_id' => $refId,
        'type' => $type,
        'selectedMeals' => $selectedMeals, // Pass already selected meals to the view
    ]);
}




        
    //  public function saveUserData(Request $request)
    // {
    //     $uniqueCode = $request->input('unique_code');
    //     $type = $request->input('type');
    //     $meal = $request->input('meal');
    //     $currentDate = date('Y-m-d');
    
    //     // Fetch the meals the user has already selected for today
    //     $mealCount = Meal::where('unique_code', $uniqueCode)
    //         ->where('type', $type)
    //         ->where('date', $currentDate)
    //         ->count();
    
    //     // Check if the selected meal is already taken by the user for today
    //     if (Meal::where('unique_code', $uniqueCode)
    //         ->where('meal', $meal)
    //         ->where('date', $currentDate)
    //         ->exists()) {
    //         return redirect()->route('dashboard')->with('error', 'You have already selected this meal for today.');
    //     }
    
    //     // Check meal limits based on type (Doctor: 4 meals, Accompany: 3 meals)
    //     if (($type === 'doctor' && $mealCount >= 4) || ($type === 'accompany' && $mealCount >= 3)) {
    //         return redirect()->route('dashboard')->with('error', 'You have reached the maximum meal selections for today.');
    //     }
    
    //     // Save the new meal selection
    //     $mealRecord = new Meal();
    //     $mealRecord->unique_code = $uniqueCode;
    //     $mealRecord->name = $request->input('name');
    //     $mealRecord->ref_id = $request->input('ref_id');
    //     $mealRecord->type = $type;
    //     $mealRecord->meal = $meal;
    //     $mealRecord->date = $currentDate;
    //     $mealRecord->save();
    
    //     return redirect()->route('dashboard')->with('success', 'Meal selection saved successfully.');
    // }

public function saveUserData(Request $request)
{
    $uniqueCode = $request->input('unique_code');
    $type = $request->input('type');
    $meal = $request->input('meal');
    $currentDate = date('Y-m-d');

    // Determine which table to check and save data into based on the type
    $mealModel = ($type === 'IPCA_staff' || $type === 'pharma_staff') ? new MealStaff() : new Meal();

    // Fetch the meals the user has already selected for today from the appropriate table
    $mealCount = $mealModel::where('unique_code', $uniqueCode)
        ->where('type', $type)
        ->where('date', $currentDate)
        ->count();

    // Check if the selected meal is already taken by the user for today
    if ($mealModel::where('unique_code', $uniqueCode)
        ->where('meal', $meal)
        ->where('date', $currentDate)
        ->exists()) {
        return redirect()->route('dashboard')->with('error', 'You have already selected this meal for today.');
    }

    // Check meal limits based on type (Doctor: 4 meals, Accompany: 3 meals)
    if (($type === 'doctor' && $mealCount >= 4) || ($type === 'accompany' && $mealCount >= 3)) {
        return redirect()->route('dashboard')->with('error', 'You have reached the maximum meal selections for today.');
    }

    // Save the new meal selection in the appropriate table
    $mealModel->unique_code = $uniqueCode;
    $mealModel->name = $request->input('name');
    $mealModel->ref_id = $request->input('ref_id');
    $mealModel->type = $type;
    $mealModel->meal = $meal;
    $mealModel->date = $currentDate;
    $mealModel->save();

    return redirect()->route('dashboard')->with('success', 'Meal selection saved successfully.');
}


public function adminlogout(Request $request)
{
    \Log::info('Admin logout triggered'); // Log to check if this method is called

    Auth::guard('admins')->logout(); // Use the 'admins' guard

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('adminlogin'); // Redirect to admin login page
}
public function contactList()
{
    $contacts = DB::table('contacts')->orderBy('created_at', 'desc')->get();
    return view('admin.contactlist', compact('contacts'));


}
}