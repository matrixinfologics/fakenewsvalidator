<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Hash;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests\Admin\StoreUser;
use App\Http\Requests\Admin\updateUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /** @var User */
    private $user;

    /**
     * UserController Consturctor
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
    * User listing
    *
    * @param Request $request
    * @return Response
    */
    public function index(Request $request)
    {
        $users = $this->user->paginate(10);

        $grid = new \Datagrid($users, $request->get('f', []));
        $grid
            ->setColumn('id', 'Id')
            ->setColumn('name', 'Name')
            ->setColumn('email', 'Email', [
                'wrapper'     => function ($value, $row) {
                    return '<a href="mailto:' . $value . '">' . $value . '</a>';
                },
            ])
            ->setColumn('roleName', 'Role')
            ->setColumn('created_at', 'Created At')
            ->setColumn('updated_at', 'Updated At')
            ->setActionColumn([
                'wrapper' => function ($value, $row) {
                    return '<a href="'.route("users.edit", $row->id).'" title="Edit" class="btn btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                            <a href="'.route("users.delete", $row->id).'" title="Delete" data-method="DELETE" class="btn btn-xs text-danger delete_confirm" ><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>';
                }
            ]);

        return view('Admin.users.index', ['grid' => $grid]);
    }

    /**
    * Show the form for creating a new user.
    *
    * @return Response
    */
    public function create()
    {
        $roles =  $this->user->getRolesAsArray();
        return view('Admin.users.create', ['roles' => $roles]);
    }

    /**
    * Store user in database
    *
    * @param StoreUser $request
    * @return Response
    */
    public function store(StoreUser $request)
    {
        $this->user->first_name = $request->get('first_name');
        $this->user->last_name = $request->get('last_name');
        $this->user->email = $request->get('email');
        $this->user->role = $request->get('role');
        $this->user->password = Hash::make($request->get('password'));
        $this->user->save();

        return redirect(route('users.index'))
            ->with('success','User created successfully!');
    }

    /**
    * Show the form for edit a user.
    *
    * @return Response
    */
    public function show($id)
    {
        $user =  $this->user->find($id);
        return view('Admin.users.show', ['user' => $user]);
    }

    /**
    * Show the form for edit a user.
    *
    * @return Response
    */
    public function edit($id)
    {
        $user =  $this->user->find($id);
        $roles =  $this->user->getRolesAsArray();
        return view('Admin.users.edit', ['user' => $user, 'roles' => $roles]);
    }

    /**
    * Store user in database
    *
    * @param updateUser $request
    * @param int $id
    * @return Response
    */
    public function update(updateUser $request, $id)
    {
        $user = $this->user->find($id);
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->email = $request->get('email');
        $user->role = $request->get('role');
        if ($request->get('password') !== null) {
            $user->password = Hash::make($request->get('password'));
        }

        $user->save();

        return redirect(route('users.index'))
            ->with('success','User updated successfully!');
    }

    /**
    * Delete User
    *
    * @param int $id
    * @return Response
    */
    public function delete($id)
    {
        $user = $this->user->find($id);
        $user->delete();

        return redirect(route('users.index'))
            ->with('success','User updated successfully!');
    }
}
