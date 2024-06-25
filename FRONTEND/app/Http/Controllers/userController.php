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

    public function usersEdit(Request $request, $nrp)
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
            Log::info('User data fetched successfully', ['user' => $user]);

            
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
                return response()->json($user);

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


    public function usersUpdate(Request $request, $nrp)
    {
        $api_token = Session::get('api_token');

        if (!$api_token) {
            return response()->json(['error' => 'API token not found'], 401);
        }

        // Validate the request
        $request->validate([
            'nrp' => 'required|unique:users,nrp,',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,',
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
                    redirect()->route('admin-users-edit', $nrp)->with('error', 'Failed to update user: ' . $errorMessage);
            }
        } catch (\Exception $e) {
            Log::error('Failed to update user.', ['exception' => $e->getMessage()]);
            return $request->wantsJson() ?
                response()->json(['error' => 'Unable to update user', 'message' => $e->getMessage()], 500) :
                redirect()->route('admin-users-edit', $nrp)->with('error', 'Unable to update user: ' . $e->getMessage());
        }
    }

    public function usersDelete(Request $request, $nrp)

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


    public function rolesIndex(Request $request)

    {
        $api_token = Session::get('api_token');

        if (!$api_token) {
            return response()->json(['error' => 'API token not found'], 401);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,

            ])->get('http://localhost:5000/api/v1/role');

            $responseData = json_decode($response->getBody()->getContents(), true);
            $data = $responseData['data'];
            // Log:info('test', ['test roles' => $data]);


            $prodi_id = Session::get('prodi_id');
            $role_id = Session::get('role_id');

            if ($request->wantsJson()) {
                return response()->json($data);
            } else {
                return view('dashboard.admin.roles.index', ['data' => $data, 'role_id' => $role_id, 'prodi_id' => $prodi_id]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to fetch roles data.', ['exception' => $e->getMessage()]);
            return $request->wantsJson() ?
                response()->json(['error' => 'Unable to fetch data', 'message' => $e->getMessage()], 500) :
                view('dashboard.index', ['data' => [], 'error' => 'Unable to fetch data']);
        }
    }

    public function rolesCreate(Request $request)
    {
        $api_token = Session::get('api_token');

        if (!$api_token) {
            return response()->json(['error' => 'API token not found'], 401);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,

            ])->get('http://localhost:5000/api/v1/role/create');

            $responseData = json_decode($response->getBody()->getContents(), true);
            $data = $responseData['data'];

            $prodi_id = Session::get('prodi_id');
            $role_id = Session::get('role_id');

            if ($request->wantsJson()) {
                return response()->json($data);
            } else {

                return view('dashboard.admin.roles.create', [
                    'data' => $data,
                    'role_id' => $role_id, 
                    'prodi_id' => $prodi_id,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to fetch roles data.', ['exception' => $e->getMessage()]);
            return $request->wantsJson() ?
                response()->json(['error' => 'Unable to fetch data', 'message' => $e->getMessage()], 500) :
                view('dashboard.index', ['data' => [], 'error' => 'Unable to fetch data']);
        }
    }

    public function rolesStore(Request $request)
    {
        $api_token = Session::get('api_token');

        if (!$api_token) {
            return response()->json(['error' => 'API token not found'], 401);
        }


        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $data = [
                'nama_role' => $request->name,
            ];
            Log::info('Storing role data', ['data' => $data]);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,
            ])->post('http://localhost:5000/api/v1/role/create', $data);

            Log::info('API Response', ['response' => $response->json(), 'status' => $response->status()]);

            if ($response->successful()) {
                return $request->wantsJson() ?
                    response()->json(['message' => 'Role created successfully'], 201) :
                    redirect()->route('admin-roles')->with('success', 'Role created successfully');
            } else {
                $errorMessage = $response->json()['message'] ?? 'Failed to create role';
                return $request->wantsJson() ?
                    response()->json(['error' => 'Failed to create role', 'message' => $errorMessage], $response->status()) :
                    redirect()->route('admin-roles-create')->with('error', 'Failed to create role: ' . $errorMessage);
            }
        } catch (\Exception $e) {
            Log::error('Failed to create role.', ['exception' => $e->getMessage()]);
            return $request->wantsJson() ?
                response()->json(['error' => 'Unable to create role', 'message' => $e->getMessage()], 500) :
                redirect()->route('admin-roles-create')->with('error', 'Unable to create role: ' . $e->getMessage());
        }
    }   

    public function rolesEdit(Request $request, $id)
    {
        $api_token = Session::get('api_token');

        if (!$api_token) {
            return response()->json(['error' => 'API token not found'], 401);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,
            ])->get('http://localhost:5000/api/v1/role/' . $id);

            $responseData = json_decode($response->getBody()->getContents(), true);
            $data = $responseData['data'];

            $prodi_id = Session::get('prodi_id');
            $role_id = Session::get('role_id');

            if ($request->wantsJson()) {
                return response()->json($data);
            } else {
                return view('dashboard.admin.roles.edit', [
                    'data' => $data,
                    'role_id' => $role_id, 
                    'prodi_id' => $prodi_id,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to fetch role data.', ['exception' => $e->getMessage()]);
            return $request->wantsJson() ?
                response()->json(['error' => 'Unable to fetch data', 'message' => $e->getMessage()], 500) :
                view('dashboard.index', ['data' => [], 'error' => 'Unable to fetch data']);
        }
    }

    public function rolesUpdate(Request $request, $id)
    {
        $api_token = Session::get('api_token');

        if (!$api_token) {
            return response()->json(['error' => 'API token not found'], 401);
        }

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $data = [
                'nama_role' => $request->name,
            ];

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,
            ])->put('http://localhost:5000/api/v1/role/' . $id, $data);

            if ($response->successful()) {
                return $request->wantsJson() ?
                    response()->json(['message' => 'Role updated successfully'], 200) :
                    redirect()->route('admin-roles')->with('success', 'Role updated successfully');
            } else {
                $errorMessage = $response->json()['message'] ?? 'Failed to update role';
                return $request->wantsJson() ?
                    response()->json(['error' => 'Failed to update role', 'message' => $errorMessage], $response->status()) :
                    redirect()->route('admin-roles-edit', $id)->with('error', 'Failed to update role: ' . $errorMessage);
            }
        } catch (\Exception $e) {
            Log::error('Failed to update role.', ['exception' => $e->getMessage()]);
            return $request->wantsJson() ?
                response()->json(['error' => 'Unable to update role', 'message' => $e->getMessage()], 500) :
                redirect()->route('admin-roles-edit', $id)->with('error', 'Unable to update role: ' . $e->getMessage());
        }
    }

    public function rolesDelete(Request $request, $id)
    {
        $api_token = Session::get('api_token');

        if (!$api_token) {
            return response()->json(['error' => 'API token not found'], 401);
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,
            ])->delete('http://localhost:5000/api/v1/role/' . $id);

            if ($response->successful()) {
                return $request->wantsJson() ?
                    response()->json(['message' => 'Role deleted successfully'], 200) :
                    redirect()->route('admin-roles')->with('success', 'Role deleted successfully');
            } else {
                $errorMessage = $response->json()['message'] ?? 'Failed to delete role';
                return $request->wantsJson() ?
                    response()->json(['error' => 'Failed to delete role', 'message' => $errorMessage], $response->status()) :
                    redirect()->route('admin-roles')->with('error', 'Failed to delete role: ' . $errorMessage);
            }
        } catch (\Exception $e) {
            Log::error('Failed to delete role.', ['exception' => $e->getMessage()]);
            return $request->wantsJson() ?
                response()->json(['error' => 'Unable to delete role', 'message' => $e->getMessage()], 500) :
                redirect()->route('admin-roles')->with('error', 'Unable to delete role: ' . $e->getMessage());
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

    public function fakultasCreate(Request $request)
    {
        $api_token = Session::get('api_token');

        if (!$api_token) {
            return response()->json(['error' => 'API token not found'], 401);
        }

        try {
            // Fetch fakultas create data
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,
            ])->get('http://localhost:5000/api/v1/fakultas/create');

            $responseData = json_decode($response->getBody()->getContents(), true);
            $data = $responseData['data']; // Adjust based on your JSON structure

            // Fetch roles data
            $rolesResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,
            ])->get('http://localhost:5000/api/v1/role');

            $rolesData = json_decode($rolesResponse->getBody()->getContents(), true);
            $roles = $rolesData['data']; // Adjust based on your JSON structure
            $role_id = Session::get('role_id');

            if ($request->wantsJson()) {
                return response()->json($data);
            } else {
                return view('dashboard.admin.fakultas.create', [
                    'data' => $data,
                    'role_id' => $role_id, 
                    'roles' => $roles
                ]);
            }
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                Log::error('Failed to fetch fakultas data.', ['exception' => $e->getMessage()]);
                return response()->json(['error' => 'Unable to fetch data', 'message' => $e->getMessage()], 500);
            } else {
                return view('dashboard.index', ['data' => [], 'error' => 'Unable to fetch data']);
            }
        }
    }

    public function fakultasStore(Request $request)
    {
        $api_token = Session::get('api_token');

        if (!$api_token) {
            return response()->json(['error' => 'API token not found'], 401);
        }

        // Validate the request
        $request->validate([
            'kode' => 'required',
            'nama' => 'required|string|max:255'
        ]);

        try {
            // Prepare data to be sent to the API
            $data = [
                'kode' => $request->kode,
                'nama' => $request->nama,
            ];

            Log::info('Preparing to store fakultas', ['fakultas_data' => $data]);

            // Send POST request to API to create the fakultas
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,
            ])->post('http://localhost:5000/api/v1/fakultas/create', $data);

            Log::info('API Response', ['response' => $response->json()]);

            // Check response status
            if ($response->successful()) {
                return $request->wantsJson() ?
                    response()->json(['message' => 'Fakultas created successfully'], 201) :
                    redirect()->route('admin-fakultas')->with('success', 'Fakultas created successfully');
            } else {
                $errorMessage = $response->json()['message'] ?? 'Failed to create fakultas';
                return $request->wantsJson() ?
                    response()->json(['error' => 'Failed to create fakultas', 'message' => $errorMessage], $response->status()) :
                    redirect()->route('admin-fakultas-create')->with('error', 'Failed to create fakultas: ' . $errorMessage);
            }
        } catch (\Exception $e) {
            Log::error('Failed to create fakultas.', ['exception' => $e->getMessage()]);
            return $request->wantsJson() ?
                response()->json(['error' => 'Unable to create fakultas', 'message' => $e->getMessage()], 500) :
                redirect()->route('admin-fakultas-create')->with('error', 'Unable to create fakultas: ' . $e->getMessage());
        }
    }

    public function fakultasEdit(Request $request, $kode)
    {
        $api_token = Session::get('api_token');

        if (!$api_token) {
            return response()->json(['error' => 'API token not found'], 401);
        }

        try {
            // Fetch fakultas data
            $fakultasResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,
            ])->get('http://localhost:5000/api/v1/fakultas/'. $kode);
    
            $fakultasData = json_decode($fakultasResponse->getBody()->getContents(), true);
            $fakultas = $fakultasData['data']; // Adjust based on your JSON structure
            Log::info('test', ['test fakultas' => $fakultas]);

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
                return response()->json($fakultas);
            } else {
                return view('dashboard.admin.fakultas.edit', [
                    'fakultas' => $fakultas,
                    'role_id' => $role_id, 
                    'prodi_id' => $prodi_id,
                    'prodis' => $prodis,
                    'roles' => $roles
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to fetch fakultas data.', ['exception' => $e->getMessage()]);
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Unable to fetch data', 'message' => $e->getMessage()], 500);
            } else {
                return view('dashboard.index', ['data' => [], 'error' => 'Unable to fetch data']);
            }
        }
    }

    public function fakultasUpdate(Request $request, $kode)
    {
        $api_token = Session::get('api_token');

        if (!$api_token) {
            return response()->json(['error' => 'API token not found'], 401);
        }

        // Validate the request
        $request->validate([
            'kode' => 'required|string|max:10',
            'nama' => 'required|string|max:255'
        ]);

        try {
            // Prepare data to be sent to the API
            $data = [
                'kode' => $request->kode,
                'nama' => $request->nama
            ];

            Log::info('Preparing to update fakultas', ['fakultas_data' => $data]);

            // Send PUT request to API to update the fakultas
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,
            ])->put('http://localhost:5000/api/v1/fakultas/' . $kode, $data);

            Log::info('API Response', ['response' => $response->json()]);

            // Check response status
            if ($response->successful()) {
                return $request->wantsJson() ?
                    response()->json(['message' => 'Fakultas updated successfully'], 200) :
                    redirect()->route('admin-fakultas')->with('success', 'Fakultas updated successfully');
            } else {
                $errorMessage = $response->json()['message'] ?? 'Failed to update fakultas';
                return $request->wantsJson() ?
                    response()->json(['error' => 'Failed to update fakultas', 'message' => $errorMessage], $response->status()) :
                    redirect()->route('admin-fakultas-edit', $kode)->with('error', 'Failed to update fakultas: ' . $errorMessage);
            }
        } catch (\Exception $e) {
            Log::error('Failed to update fakultas.', ['exception' => $e->getMessage()]);
            return $request->wantsJson() ?
                response()->json(['error' => 'Unable to update fakultas', 'message' => $e->getMessage()], 500) :
                redirect()->route('admin-fakultas-edit', $kode)->with('error', 'Unable to update fakultas: ' . $e->getMessage());
        }
    }

    public function fakultasDelete(Request $request, $kode)
    {
        $api_token = Session::get('api_token');

        if (!$api_token) {
            return response()->json(['error' => 'API token not found'], 401);
        }

        try {
            // Send DELETE request to API to delete the fakultas
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,
            ])->delete('http://localhost:5000/api/v1/fakultas/' . $kode);

            // Check response status
            if ($response->successful()) {
                return $request->wantsJson() ?
                    response()->json(['message' => 'Fakultas deleted successfully'], 200) :
                    redirect()->route('admin-fakultas')->with('success', 'Fakultas deleted successfully');
            } else {
                $errorMessage = $response->json()['message'] ?? 'Failed to delete fakultas';
                return $request->wantsJson() ?
                    response()->json(['error' => 'Failed to delete fakultas', 'message' => $errorMessage], $response->status()) :
                    redirect()->route('admin-fakultas')->with('error', 'Failed to delete fakultas: ' . $errorMessage);
            }
        } catch (\Exception $e) {
            Log::error('Failed to delete fakultas.', ['exception' => $e->getMessage()]);
            return $request->wantsJson() ?
                response()->json(['error' => 'Unable to delete fakultas', 'message' => $e->getMessage()], 500) :
                redirect()->route('admin-fakultas')->with('error', 'Unable to delete fakultas: ' . $e->getMessage());
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

    public function prodiCreate(Request $request)
    {
        $api_token = Session::get('api_token');

        if (!$api_token) {
            return response()->json(['error' => 'API token not found'], 401);
        }

        try {
            // Fetch fakultas data
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,
            ])->get('http://localhost:5000/api/v1/fakultas');

            $responseData = json_decode($response->getBody()->getContents(), true);
            $fakultas = $responseData['data']; // Adjust based on your JSON structure

            // Fetch roles data
            $rolesResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,
            ])->get('http://localhost:5000/api/v1/role');

            $rolesData = json_decode($rolesResponse->getBody()->getContents(), true);
            $roles = $rolesData['data']; // Adjust based on your JSON structure
            $role_id = Session::get('role_id');

            if ($request->wantsJson()) {
                return response()->json($fakultas);
            } else {
                return view('dashboard.admin.prodi.create', [
                    'fakultas' => $fakultas,
                    'role_id' => $role_id, 
                    'roles' => $roles
                ]);
            }
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                Log::error('Failed to fetch fakultas data.', ['exception' => $e->getMessage()]);
                return response()->json(['error' => 'Unable to fetch data', 'message' => $e->getMessage()], 500);
            } else {
                return view('dashboard.index', ['fakultas' => [], 'error' => 'Unable to fetch data']);
            }
        }
    }

    public function prodiStore(Request $request)
    {
        $api_token = Session::get('api_token');
    
        if (!$api_token) {
            return response()->json(['error' => 'API token not found'], 401);
        }
    
        // Validate the request
        $request->validate([
            'fakultas_id' => 'required|integer',
            'kode' => 'required|string|max:10',
            'name' => 'required|string|max:255'
        ]);
    
        try {
            // Prepare data to be sent to the API
            $data = [
                'fakultas_id' => intval($request->fakultas_id),
                'kode' => $request->kode,
                'nama' => $request->name,
            ];
    
            Log::info('Preparing to store prodi', ['prodi_data' => $data]);
    
            // Send POST request to API to create the prodi
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,
            ])->post('http://localhost:5000/api/v1/prodi/create', $data);
    
            Log::info('API Response', ['response' => $response->json()]);
    
            // Check response status
            if ($response->successful()) {
                return $request->wantsJson() ?
                    response()->json(['message' => 'Prodi created successfully'], 201) :
                    redirect()->route('admin-prodi')->with('success', 'Prodi created successfully');
            } else {
                $errorMessage = $response->json()['message'] ?? 'Failed to create prodi';
                return $request->wantsJson() ?
                    response()->json(['error' => 'Failed to create prodi', 'message' => $errorMessage], $response->status()) :
                    redirect()->route('admin-prodi-create')->with('error', 'Failed to create prodi: ' . $errorMessage);
            }
        } catch (\Exception $e) {
            Log::error('Failed to create prodi.', ['exception' => $e->getMessage()]);
            return $request->wantsJson() ?
                response()->json(['error' => 'Unable to create prodi', 'message' => $e->getMessage()], 500) :
                redirect()->route('admin-prodi-create')->with('error', 'Unable to create prodi: ' . $e->getMessage());
        }
    }
    
    public function prodiEdit(Request $request, $kode)
    {
        $api_token = Session::get('api_token');

        if (!$api_token) {
            return response()->json(['error' => 'API token not found'], 401);
        }

        try {
            // Fetch prodi data
            $prodiResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,
            ])->get('http://localhost:5000/api/v1/prodi/' . $kode);

            $prodiData = json_decode($prodiResponse->getBody()->getContents(), true);
            $prodi = $prodiData['data']; // Adjust based on your JSON structure
            Log::info('test', ['test prodi' => $prodi]);

            // Fetch fakultas data
            $fakultasResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,
            ])->get('http://localhost:5000/api/v1/fakultas');

            $fakultasData = json_decode($fakultasResponse->getBody()->getContents(), true);
            $fakultas = $fakultasData['data']; // Adjust based on your JSON structure

            $prodi_id = Session::get('prodi_id');
            $role_id = Session::get('role_id');

            if ($request->wantsJson()) {
                return response()->json($prodi);
            } else {
                return view('dashboard.admin.prodi.edit', [
                    'prodi' => $prodi,
                    'fakultas' => $fakultas,
                    'role_id' => $role_id, 
                    'prodi_id' => $prodi_id,
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to fetch prodi data.', ['exception' => $e->getMessage()]);
            if ($request->wantsJson()) {
                return response()->json(['error' => 'Unable to fetch data', 'message' => $e->getMessage()], 500);
            } else {
                return view('dashboard.index', ['data' => [], 'error' => 'Unable to fetch data']);
            }
        }
    }

    public function prodiUpdate(Request $request, $kode)
    {
        $api_token = Session::get('api_token');
    
        if (!$api_token) {
            return response()->json(['error' => 'API token not found'], 401);
        }
    
        // Validate the request
        $request->validate([
            'kode' => 'required|string|max:10',
            'nama' => 'required|string|max:255'
        ]);
    
        try {
            // Prepare data to be sent to the API
            $data = [
                'fakultas_id' => intval($request->fakultas_id),
                'kode' => $request->kode,
                'nama' => $request->nama // Correct the field name
            ];
    
            Log::info('Preparing to update prodi', ['prodi_data' => $data]);
    
            // Send PUT request to API to update the prodi
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,
            ])->put('http://localhost:5000/api/v1/prodi/' . $kode, $data);
    
            Log::info('API Response', ['response' => $response->json()]);
    
            // Check response status
            if ($response->successful()) {
                return $request->wantsJson() ?
                    response()->json(['message' => 'Prodi updated successfully'], 200) :
                    redirect()->route('admin-prodi')->with('success', 'Prodi updated successfully');
            } else {
                $errorMessage = $response->json()['message'] ?? 'Failed to update prodi';
                return $request->wantsJson() ?
                    response()->json(['error' => 'Failed to update prodi', 'message' => $errorMessage], $response->status()) :
                    redirect()->route('admin-prodi-edit', ['kode' => $kode])->with('error', 'Failed to update prodi: ' . $errorMessage);
            }
        } catch (\Exception $e) {
            Log::error('Failed to update prodi.', ['exception' => $e->getMessage()]);
            return $request->wantsJson() ?
                response()->json(['error' => 'Unable to update prodi', 'message' => $e->getMessage()], 500) :
                redirect()->route('admin-prodi-edit', ['kode' => $kode])->with('error', 'Unable to update prodi: ' . $e->getMessage());
        }
    }
    
    public function prodiDelete(Request $request, $kode)
    {
        $api_token = Session::get('api_token');
    
        if (!$api_token) {
            return response()->json(['error' => 'API token not found'], 401);
        }
    
        try {
            // Send DELETE request to API to delete the prodi
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,
            ])->delete('http://localhost:5000/api/v1/prodi/' . $kode);
    
            // Check response status
            if ($response->successful()) {
                return $request->wantsJson() ?
                    response()->json(['message' => 'Prodi deleted successfully'], 200) :
                    redirect()->route('admin-prodi')->with('success', 'Prodi deleted successfully');
            } else {
                $errorMessage = $response->json()['message'] ?? 'Failed to delete prodi';
                return $request->wantsJson() ?
                    response()->json(['error' => 'Failed to delete prodi', 'message' => $errorMessage], $response->status()) :
                    redirect()->route('admin-prodi')->with('error', 'Failed to delete prodi: ' . $errorMessage);
            }
        } catch (\Exception $e) {
            Log::error('Failed to delete prodi.', ['exception' => $e->getMessage()]);
            return $request->wantsJson() ?
                response()->json(['error' => 'Unable to delete prodi', 'message' => $e->getMessage()], 500) :
                redirect()->route('admin-prodi')->with('error', 'Unable to delete prodi: ' . $e->getMessage());
        }
    }

    public function beasiswaIndex(Request $request)
    {
        $api_token = Session::get('api_token');
    
        if (!$api_token) {
            return response()->json(['error' => 'API token not found'], 401);
        }
    
        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,
            ])->get('http://localhost:5000/api/v1/beasiswa');
    
            $responseData = json_decode($response->getBody()->getContents(), true);
            $data = $responseData['data']; // Adjust based on your JSON structure
            $role_id = Session::get('role_id');
    
            if ($request->wantsJson()) {
                return response()->json($data);
            } else {
                return view('dashboard.admin.beasiswa.index', ['data' => $data, 'role_id' => $role_id]);
            }
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                Log::error('Failed to fetch beasiswa data.', ['exception' => $e->getMessage()]);
                return response()->json(['error' => 'Unable to fetch data', 'message' => $e->getMessage()], 500);
            } else {
                return view('dashboard.index', ['data' => [], 'error' => 'Unable to fetch data']);
            }
        }
    }
    
    
    public function beasiswaCreate(Request $request)
    {
        $api_token = Session::get('api_token');
    
        if (!$api_token) {
            return response()->json(['error' => 'API token not found'], 401);
        }
    
        try {
            // Fetch fakultas data
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,
            ])->get('http://localhost:5000/api/v1/fakultas');
    
            $responseData = json_decode($response->getBody()->getContents(), true);
            $fakultas = $responseData['data']; // Adjust based on your JSON structure
    
            // Fetch periode data
            $periodeResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,
            ])->get('http://localhost:5000/api/v1/periode');
    
            $periodeData = json_decode($periodeResponse->getBody()->getContents(), true);
            $periode = $periodeData['data']; // Adjust based on your JSON structure
    
            // Fetch roles data
            $rolesResponse = Http::withHeaders([
                'Authorization' => 'Bearer ' . $api_token,
            ])->get('http://localhost:5000/api/v1/role');
    
            $rolesData = json_decode($rolesResponse->getBody()->getContents(), true);
            $roles = $rolesData['data']; // Adjust based on your JSON structure
            $role_id = Session::get('role_id');
    
            if ($request->wantsJson()) {
                return response()->json($fakultas);
            } else {
                return view('dashboard.admin.beasiswa.create', [
                    'fakultas' => $fakultas,
                    'periode' => $periode,
                    'role_id' => $role_id, 
                    'roles' => $roles
                ]);
            }
        } catch (\Exception $e) {
            if ($request->wantsJson()) {
                Log::error('Failed to fetch data.', ['exception' => $e->getMessage()]);
                return response()->json(['error' => 'Unable to fetch data', 'message' => $e->getMessage()], 500);
            } else {
                return view('dashboard.index', ['fakultas' => [], 'error' => 'Unable to fetch data']);
            }
        }
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