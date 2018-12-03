<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Company;
use Hash;
use Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests\Admin\StoreCompany;
use App\Http\Requests\Admin\updateCompany;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class CompanyController extends Controller
{
    /** @var Company */
    private $company;
    /** @var User */
    private $user;
    private $pagination = 10;

    /**
     * UserController Consturctor
     *
     * @param Company $company
     * @param User $user
     */
    public function __construct(Company $company, User $user)
    {
        $this->company = $company;
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
        $companies = $this->company->paginate(10);

        $grid = new \Datagrid($companies, $request->get('f', []));
        $grid
            ->setColumn('id', 'Id')
            ->setColumn('name', 'Name',[
                    'wrapper'     => function ($value, $row) {
                        return '<a href="' .route('companies.show', $row->id). '">' . $value . '</a>';
                    }
            ])
            ->setColumn('website', 'Website')
            ->setColumn('phone', 'Phone')
            ->setColumn('companyAdmin', 'Admin', [
                    'refers_to'   => 'companyAdmin.name'
            ])
            ->setColumn('created_at', 'Created At')
            ->setColumn('updated_at', 'Updated At')
            ->setActionColumn([
                'wrapper' => function ($value, $row) {
                    return '
                        <a href="'.route("companies.users", $row->id).'" title="View Company Users" class="btn btn-xs"><i class="fa fa-users" aria-hidden="true"></i></a>
                        <a href="'.route("companies.edit", $row->id).'" title="Edit" class="btn btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                         <a href="'.route("companies.delete", $row->id).'" title="Delete" data-method="DELETE" class="btn btn-xs text-danger delete_confirm" ><i class="fa fa-remove" aria-hidden="true"></i></a>
                        ';
                }
            ]);

        return view('Admin.companies.index', ['grid' => $grid]);
    }

    /**
    * Show the form for creating a new user.
    *
    * @return Response
    */
    public function create()
    {
        $users = User::where('role', User::ROLE_COMPANY_ADMIN)->whereNull('company_id')->get()->pluck('name', 'id');
        return view('Admin.companies.create', ['users' => $users]);
    }

    /**
    * Store user in database
    *
    * @param StoreUser $request
    * @return Response
    */
    public function store(StoreCompany $request)
    {

        $this->company->name = $request->get('name');
        $this->company->website = $request->get('website');
        $this->company->phone = $request->get('phone');
        $this->company->address = $request->get('address');
        $this->company->twitter_consumer_key = $request->get('twitter_consumer_key');
        $this->company->twitter_consumer_secret = $request->get('twitter_consumer_secret');
        $this->company->twitter_access_token = $request->get('twitter_access_token');
        $this->company->twitter_access_token_secret = $request->get('twitter_access_token_secret');

        $this->company->save();

        // Assign admin to company
        if($request->filled('admin')) {
            $user = $this->user->find($request->get('admin'));
            $this->company->users()->save($user);
        }

        return redirect(route('companies.index'))
            ->with('success','Company created successfully!');
    }

    /**
    * Show the company data
    *
    * @return Response
    */
    public function show($id)
    {
        $details = $this->company->getCompanyTwitterDetails($id);

        $company =  $this->company->findorFail($id);
        return view('Admin.companies.show', ['company' => $company]);
    }

    /**
    * Show the form for edit a company.
    *
    * @return Response
    */
    public function edit($id)
    {
        $company =  $this->company->findorFail($id);
        $users = User::where('role', User::ROLE_COMPANY_ADMIN)
                        ->where(function ($query) use ($id) {
                                $query->whereNull('company_id')
                                      ->orWhere('company_id', $id);
                            })
                        ->get()->pluck('name', 'id');
        return view('Admin.companies.edit', ['company' => $company, 'users' => $users]);
    }

    /**
    * Store company in database
    *
    * @param updateCompany $request
    * @param int $id
    * @return Response
    */
    public function update(updateCompany $request, $id)
    {
        $company = $this->company->findorFail($id);

        $company->name = $request->get('name');
        $company->website = $request->get('website');
        $company->phone = $request->get('phone');
        $company->address = $request->get('address');
        $company->twitter_consumer_key = $request->get('twitter_consumer_key');
        $company->twitter_consumer_secret = $request->get('twitter_consumer_secret');
        $company->twitter_access_token = $request->get('twitter_access_token');
        $company->twitter_access_token_secret = $request->get('twitter_access_token_secret');

        $company->save();

        // Assign admin to company
        if($request->filled('admin')) {
            // Remove old company admin
            if (is_object($company->companyAdmin)) {
                $oldUser = $this->user->find($company->companyAdmin->id);
                $oldUser->company()->dissociate($company);
                $oldUser->save();
            }

            $user = $this->user->find($request->get('admin'));
            $company->users()->save($user);

        }

        if( Auth::user()->isCompanyAdmin()) {
            return redirect()->back()->with('success','Company updated successfully!');
        }

        return redirect(route('companies.index'))
                ->with('success','Company updated successfully!');
    }

    /**
    * Delete Company
    *
    * @param int $id
    * @return Response
    */
    public function delete($id)
    {

        $company = $this->company->findorFail($id);
        $company->delete();

        return redirect(route('companies.index'))
            ->with('success','Company deleted successfully!');
    }

    /**
    * Company Users
    *
    * @param int $id
    * @return Response
    */
    public function users(Request $request, $id){
        $company = $this->company->findorFail($id);

        $users = $company->users()->paginate($this->pagination);

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

        return view('Admin.companies.users', ['company' => $company, 'grid' => $grid]);

    }

    public function autocomplete(Request $request){

        $query = $request->get('query','');

        $companies = Company::where('name','LIKE','%'.$query.'%')->get();

        return response()->json($companies);
    }

}
