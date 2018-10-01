<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Company;
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

    /** @var Company */
    private $company;

    /**
     * UserController Consturctor
     *
     * @param User $user
     * @param Company $company
     */
    public function __construct(User $user, Company $company)
    {
        $this->user = $user;
        $this->company = $company;
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
            ->setColumn('name', 'Name', [
                    'wrapper'     => function ($value, $row) {
                        return '<a href="' .route('users.show', $row->id). '">' . $value . '</a>';
                    }
            ])
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
    public function create(Request $request)
    {
        $defaultCompany = null;
        if($request->has('company')) {
            $defaultCompany = $request->get('company');
        }
        $roles =  $this->user->getRolesAsArray();
        $companies = $this->company->pluck('name', 'id');
        return view('Admin.users.create', ['roles' => $roles, 'companies' => $companies, 'defaultCompany' => $defaultCompany]);
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

        // Assign company to user
        if($request->filled('company')) {
            $company = $this->company->find($request->get('company'));
            $this->user->company()->associate($company);
        }

        $this->user->save();

        return redirect(route('users.index'))
            ->with('success','User created successfully!');
    }

    /**
    * Show the user data.
    *
    * @return Response
    */
    public function show($id)
    {
        $user =  $this->user->findorFail($id);
        return view('Admin.users.show', ['user' => $user]);
    }

    /**
    * Show the form for edit a user.
    *
    * @return Response
    */
    public function edit($id)
    {
        $user =  $this->user->findorFail($id);
        $roles =  $this->user->getRolesAsArray();
        $companies = $this->company->pluck('name', 'id');
        return view('Admin.users.edit', ['user' => $user, 'roles' => $roles, 'companies' => $companies]);
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
        $user = $this->user->findorFail($id);
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->email = $request->get('email');
        $user->role = $request->get('role');
        if ($request->get('password') !== null) {
            $user->password = Hash::make($request->get('password'));
        }

        // Assign company to user
        if($request->filled('company')) {
            $company = $this->company->find($request->get('company'));
            $user->company()->associate($company);
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
        $user = $this->user->findorFail($id);
        $user->delete();

        return redirect(route('users.index'))
            ->with('success','User updated successfully!');
    }
}
