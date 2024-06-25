<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;

class UserController extends Controller
{   

    public function usersIndex(Request $request)
    {
        $api_token = Session::get('api_token');

        if (!$api_token) {
            return response()->json(['error' => 'API token not found'], 401);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,
            ])->get('http://localhost:5000/api/v1/users');

            // $data = $response->json();
            $responseData = json_decode($response->getBody()->getContents(), true);
            $data = $responseData['data']; // Adjust based on your JSON structure
            // Log::info('info', $data);
            $prodi_id = Session::get('prodi_id');
            $role_id = Session::get('role_id');

            if ($request->wantsJson()) {
                return response()->json($data);
            } else {
                return view('dashboard.admin.users.index', ['data' => $data, 'role_id' => $role_id, 'prodi_id' => $prodi_id]);
            }
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                Log::error('Failed to fetch user data.', ['exception' => $e->getMessage()]);
                return response()->json(['error' => 'Unable to fetch data', 'message' => $e->getMessage()], 500);
            } else {
                return view('dashboard.index', ['data' => [], 'error' => 'Unable to fetch data']);
            }
        }
    }

    // public function usersCreate(Request $request)
    // {
    //     $api_token = Session::get('api_token');

    //     if (!$api_token) {
    //         return response()->json(['error' => 'API token not found'], 401);
    //     }

    //     try {
    //         $response = Http::withHeaders([
    //             'Authorization' => 'Bearer ' . $api_token,
    //         ])->get('http://localhost:5000/api/v1/users/create');

    //         // $data = $response->json();
    //         $responseData = json_decode($response->getBody()->getContents(), true);
    //         $data = $responseData['data']; // Adjust based on your JSON structure
    //         // Log::info('info', $data);
    //         $prodi_id = Session::get('prodi_id');
    //         $role_id = Session::get('role_id');

    //         if ($request->wantsJson()) {
    //             return response()->json($data);
    //         } else {
    //             return view('dashboard.admin.users.create', ['data' => $data, 'role_id' => $role_id, 'prodi_id' => $prodi_id]);
    //         }
    //     } catch (\Exception $e) {
    //         if ($request->wantsJson()) {
    //             Log::error('Failed to fetch user data.', ['exception' => $e->getMessage()]);
    //             return response()->json(['error' => 'Unable to fetch data', 'message' => $e->getMessage()], 500);
    //         } else {
    //             return view('dashboard.index', ['data' => [], 'error' => 'Unable to fetch data']);
    //         }
    //     }
    // }

    public function usersCreate(Request $request)
    {
        $api_token = Session::get('api_token');

        if (!$api_token) {
            return response()->json(['error' => 'API token not found'], 401);
        }

        try {
            // Fetch users create data
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,
            ])->get('http://localhost:5000/api/v1/users/create');

            // Log::info('info', $data);

            $responseData = json_decode($response->getBody()->getContents(), true);
            $data = $responseData['data']; // Adjust based on your JSON structure

            // Fetch fakultas data
            $fakultasResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,
            ])->get('http://localhost:5000/api/v1/fakultas');

            $fakultasData = json_decode($fakultasResponse->getBody()->getContents(), true);
            $fakultas = $fakultasData['data']; // Adjust based on your JSON structure

            // Fetch prodi data
            $prodiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,
            ])->get('http://localhost:5000/api/v1/prodi');

            $prodiData = json_decode($prodiResponse->getBody()->getContents(), true);
            $prodis = $prodiData['data']; // Adjust based on your JSON structure

            // Fetch roles data
            $rolesResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,
            ])->get('http://localhost:5000/api/v1/role');

            $rolesData = json_decode($rolesResponse->getBody()->getContents(), true);
            $roles = $rolesData['data']; // Adjust based on your JSON structure

            $prodi_id = Session::get('prodi_id');
            $role_id = Session::get('role_id');

            if ($request->wantsJson()) {
                return response()->json($data);
            } else {
                return view('dashboard.admin.users.create', [
                    'data' => $data, 
                    'role_id' => $role_id, 
                    'prodi_id' => $prodi_id,
                    'fakultas' => $fakultas,
                    'prodis' => $prodis,
                    'roles' => $roles
                ]);
            }
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                Log::error('Failed to fetch user data.', ['exception' => $e->getMessage()]);
                return response()->json(['error' => 'Unable to fetch data', 'message' => $e->getMessage()], 500);
            } else {
                return view('dashboard.index', ['data' => [], 'error' => 'Unable to fetch data']);
            }
        }
    }

    public function showEditForm(Request $request, $nrp)
    {
        $api_token = Session::get('api_token');

        if (!$api_token) {
            return response()->json(['error' => 'API token not found'], 401);
        }

        try {
            // Fetch users create data
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,
            ])->get('http://localhost:5000/api/v1/users/'. $nrp);

            
            $responseData = json_decode($response->getBody()->getContents(), true);
            $user = $responseData['data']; // Adjust based on your JSON structure
            Log::info('info', $data);
            
            // Fetch fakultas data
            $fakultasResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,
            ])->get('http://localhost:5000/api/v1/fakultas');

            $fakultasData = json_decode($fakultasResponse->getBody()->getContents(), true);
            $fakultas = $fakultasData['data']; // Adjust based on your JSON structure

            // Fetch prodi data
            $prodiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,
            ])->get('http://localhost:5000/api/v1/prodi');

            $prodiData = json_decode($prodiResponse->getBody()->getContents(), true);
            $prodis = $prodiData['data']; // Adjust based on your JSON structure

            // Fetch roles data
            $rolesResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,
            ])->get('http://localhost:5000/api/v1/role');

            $rolesData = json_decode($rolesResponse->getBody()->getContents(), true);
            $roles = $rolesData['data']; // Adjust based on your JSON structure

            $prodi_id = Session::get('prodi_id');
            $role_id = Session::get('role_id');

            if ($request->wantsJson()) {
                return response()->json($data);
            } else {
                return view('dashboard.admin.users.edit', [
                    'user' => $user, 
                    'role_id' => $role_id, 
                    'prodi_id' => $prodi_id,
                    'fakultas' => $fakultas,
                    'prodis' => $prodis,
                    'roles' => $roles
                ]);
            }
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                Log::error('Failed to fetch user data.', ['exception' => $e->getMessage()]);
                return response()->json(['error' => 'Unable to fetch data', 'message' => $e->getMessage()], 500);
            } else {
                return view('dashboard.index', ['data' => [], 'error' => 'Unable to fetch data']);
            }
        }
    }

    // Ubah fungsi generateDefaultPassword
    private function generateDefaultPassword()
    {
        return '123'; // Default password tetap 123 tanpa memeriksa role
    }

    // Sesuaikan fungsi usersStore
    public function usersStore(Request $request)
    {
        $api_token = Session::get('api_token');
    
        if (!$api_token) {
            return response()->json(['error' => 'API token not found'], 401);
        }
    
        // Validate the request
        $request->validate([
            'nrp' => 'required|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'program_studi_id' => 'required|integer',
            'role_id' => 'required|integer'
        ]);
    
        try {
            // Generate default password
            $defaultPassword = $this->generateDefaultPassword();
    
            // Prepare data to be sent to the API
            $data = [
                'nrp' => $request->nrp,
                'nama' => $request->name,
                'email' => $request->email,
                'password' => $defaultPassword,
                'status' => 'Aktif',
                'program_studi_id' => intval($request->program_studi_id),
                'role_id' => intval($request->role_id)
            ];
    
            Log::info('Preparing to store user', ['user_data' => $data]);
    
            // Send POST request to API to create the user
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,
            ])->post('http://localhost:5000/api/v1/users/create', $data);
    
            Log::info('API Response', ['response' => $response->json()]);
    
            // Check response status
            if ($response->successful()) {
                return $request->wantsJson() ?
                    response()->json(['message' => 'User created successfully'], 201) :
                    redirect()->route('admin-users')->with('success', 'User created successfully');
            } elseif ($response->status() == 409) {
                $errorMessage = $response->json()['message'] ?? 'User already exists';
                return $request->wantsJson() ?
                    response()->json(['error' => 'Conflict', 'message' => $errorMessage], 409) :
                    redirect()->route('admin-users-create')->with('error', 'Conflict: ' . $errorMessage);
            } else {
                $errorMessage = $response->json()['message'] ?? 'Failed to create user';
                return $request->wantsJson() ?
                    response()->json(['error' => 'Failed to create user', 'message' => $errorMessage], $response->status()) :
                    redirect()->route('admin-users-create')->with('error', 'Failed to create user: ' . $errorMessage);
            }
        } catch (\Exception $e) {
            Log::error('Failed to create user.', ['exception' => $e->getMessage()]);
            return $request->wantsJson() ?
                response()->json(['error' => 'Unable to create user', 'message' => $e->getMessage()], 500) :
                redirect()->route('admin-users-create')->with('error', 'Unable to create user: ' . $e->getMessage());
        }
    }

    public function userDelete(Request $request, $nrp)
    {
        $api_token = Session::get('api_token');

        if (!$api_token) {
            return response()->json(['error' => 'API token not found'], 401);
        }

        try {
            // Send DELETE request to API to delete the user
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,
            ])->delete('http://localhost:5000/api/v1/users/' . $nrp);

            // Check response status
            if ($response->successful()) {
                return $request->wantsJson() ?
                    response()->json(['message' => 'User deleted successfully'], 200) :
                    redirect()->route('admin-users')->with('success', 'User deleted successfully');
            } else {
                $errorMessage = $response->json()['message'] ?? 'Failed to delete user';
                return $request->wantsJson() ?
                    response()->json(['error' => 'Failed to delete user', 'message' => $errorMessage], $response->status()) :
                    redirect()->route('admin-users')->with('error', 'Failed to delete user: ' . $errorMessage);
            }
        } catch (\Exception $e) {
            Log::error('Failed to delete user.', ['exception' => $e->getMessage()]);
            return $request->wantsJson() ?
                response()->json(['error' => 'Unable to delete user', 'message' => $e->getMessage()], 500) :
                redirect()->route('admin-users')->with('error', 'Unable to delete user: ' . $e->getMessage());
        }
    }


    public function fakultasIndex(Request $request)
    {
        $api_token = Session::get('api_token');

        if (!$api_token) {
            return response()->json(['error' => 'API token not found'], 401);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,
            ])->get('http://localhost:5000/api/v1/fakultas');

            // $data = $response->json();
            $responseData = json_decode($response->getBody()->getContents(), true);
            $data = $responseData['data']; // Adjust based on your JSON structure
            // Log::info('info', $data);
            $prodi_id = Session::get('prodi_id');
            $role_id = Session::get('role_id');

            if ($request->wantsJson()) {
                return response()->json($data);
            } else {
                return view('dashboard.admin.fakultas.index', ['data' => $data, 'role_id' => $role_id, 'prodi_id' => $prodi_id]);
            }
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                Log::error('Failed to fetch user data.', ['exception' => $e->getMessage()]);
                return response()->json(['error' => 'Unable to fetch data', 'message' => $e->getMessage()], 500);
            } else {
                return view('dashboard.index', ['data' => [], 'error' => 'Unable to fetch data']);
            }
        }
    }

    public function prodiIndex(Request $request)
    {
        $api_token = Session::get('api_token');

        if (!$api_token) {
            return response()->json(['error' => 'API token not found'], 401);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,
            ])->get('http://localhost:5000/api/v1/prodi');

            // $data = $response->json();
            $responseData = json_decode($response->getBody()->getContents(), true);
            $data = $responseData['data']; // Adjust based on your JSON structure
            // Log::info('info', $data);
            $prodi_id = Session::get('prodi_id');
            $role_id = Session::get('role_id');

            if ($request->wantsJson()) {
                return response()->json($data);
            } else {
                return view('dashboard.admin.prodi.index', ['data' => $data, 'role_id' => $role_id, 'prodi_id' => $prodi_id]);
            }
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                Log::error('Failed to fetch user data.', ['exception' => $e->getMessage()]);
                return response()->json(['error' => 'Unable to fetch data', 'message' => $e->getMessage()], 500);
            } else {
                return view('dashboard.index', ['data' => [], 'error' => 'Unable to fetch data']);
            }
        }
    }

    public function create(Request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $nrp)
    {
        $api_token = Session::get('api_token');

        if (!$api_token) {
            return response()->json(['error' => 'API token not found'], 401);
        }

        // Validate the request
        $request->validate([
            'nrp' => 'required|unique:users,nrp,' . $nrp,
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $nrp,
            'password' => 'required',
            'status' => 'required',
            'program_studi_id' => 'required|integer',
            'role_id' => 'required|integer'
        ]);

        try {
            // Prepare data to be sent to the API
            $data = [
                'nrp' => $request->nrp,
                'nama' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'status' => $request->status,
                'program_studi_id' => intval($request->program_studi_id),
                'role_id' => intval($request->role_id)
            ];

            Log::info('Preparing to update user', ['user_data' => $data]);

            // Send PUT request to API to update the user
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,
            ])->put('http://localhost:5000/api/v1/users/' . $nrp, $data);

            Log::info('API Response', ['response' => $response->json()]);

            // Check response status
            if ($response->successful()) {
                return $request->wantsJson() ?
                    response()->json(['message' => 'User updated successfully'], 200) :
                    redirect()->route('admin-users')->with('success', 'User updated successfully');
            } else {
                $errorMessage = $response->json()['message'] ?? 'Failed to update user';
                return $request->wantsJson() ?
                    response()->json(['error' => 'Failed to update user', 'message' => $errorMessage], $response->status()) :
                    redirect()->route('admin-users-edit', ['nrp' => $nrp])->with('error', 'Failed to update user: ' . $errorMessage);
            }
        } catch (\Exception $e) {
            Log::error('Failed to update user.', ['exception' => $e->getMessage()]);
            return $request->wantsJson() ?
                response()->json(['error' => 'Unable to update user', 'message' => $e->getMessage()], 500) :
                redirect()->route('admin-users-edit', ['nrp' => $nrp])->with('error', 'Unable to update user: ' . $e->getMessage());
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {

    }


    // public function postData(Request $request)
    // {
    //     $api_token = Session::get('api_token');

    //     if (!$api_token) {
    //         return response()->json(['error' => 'API token not found'], 401);
    //     }

    //     $client = new Client([
    //         'base_uri' => env('API_URL'),
    //     ]);

    //     try {
    //         $response = $client->request('POST', '/your-endpoint', [
    //             'headers' => [
    //                 'Authorization' => 'Bearer ' . $api_token,
    //                 'Content-Type' => 'application/json',
    //             ],
    //             'json' => $request->all(),
    //         ]);

    //         $data = json_decode($response->getBody()->getContents(), true);
    //         return response()->json($data);
    //     } catch (\Exception $e) {
    //         return response()->json(['error' => 'Unable to post data', 'message' => $e->getMessage()], 500);
    //     }
    // }
}