<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Company;
use Hash;
use Auth;
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

    private $pagination = 10;

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
        if( Auth::user()->isCompanyAdmin()) {
            $users = Auth::user()->company->users()->paginate($this->pagination);
        } else {
            $users = $this->user->paginate($this->pagination);
        }
        // $users = $this->user->paginate(10);
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
                    if($row->status == 1) {
                        $actions = '<a href="'.route("users.status", $row->id).'" data-tooltip="Disable User" class="btn btn-xs"><span class="glyphicon glyphicon-check text-danger" aria-hidden="true"></span></a>';
                    } else {
                        $actions = '<a href="'.route("users.status", $row->id).'" data-tooltip="Enable User" class="btn btn-xs"><span class="glyphicon glyphicon-check" aria-hidden="true"></span></a>';
                    }

                    $actions .= '<a href="'.route("users.edit", $row->id).'" data-tooltip="Edit" class="btn btn-xs"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                            <a href="'.route("users.delete", $row->id).'" data-tooltip="Delete" data-method="DELETE" class="btn btn-xs text-danger delete_confirm" ><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>';

                    return $actions;
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
        $defaultRole = null;
        if($request->has('company')) {
            $defaultCompany = $request->get('company');
            $defaultRole = User::ROLE_USER;
        }
        $roles =  $this->user->getRolesAsArray();
        $companies = $this->company->pluck('name', 'id');
        return view('Admin.users.create', [
            'roles' => $roles,
            'companies' => $companies,
            'defaultCompany' => $defaultCompany,
            'defaultRole' => $defaultRole
        ]);
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
        if($request->filled('company') && $request->get('role') == User::ROLE_USER) {
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
    * Update User status
    *
    * @param int $id
    * @return Response
    */
    public function changeStatus($id)
    {
        $user = $this->user->findorFail($id);
        $status = $user->status === '1' ? '0' : '1';
        $user->status = $status;
        $user->save();

        return redirect()->back()->with('success','User Status has been changed!');
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
            ->with('success','User deleted successfully!');
    }
}
