<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
class UserController extends Controller
{
    protected $userService;
    
    // Inject UserService vào controller thông qua constructor
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $users = $this->userService->getAllUsers();
        return view('users.index', compact('users'));
    }

    public function store(UserRequest $request)
    {  
        $data = $request->validated(); 
        $user = $this->userService->create($data); 
        return response()->json([
            'success' => true,
            'message' => trans('msg.created'),
            'user' => $user
        ]);
    }

    public function update(UserRequest $request, $id)
    {
        $data = $request->validated();
        $user = $this->userService->update($id, $data);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => trans('msg.update_failed'),
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' =>  trans('msg.updated'),
            'user' => $user
        ]);
    }


    public function destroy($id)
    {
        $this->userService->delete($id);
        return response()->json([
            'success' => trans('msg.deleted')
        ]);    }

    public function searchByName(Request $request)
    {  
        $name = $request->input('search');
        $users = $this->userService->searchByName($name);
        return response()->json([
            'success' => true,
            'users' => $users
        ]);    
    }
}
