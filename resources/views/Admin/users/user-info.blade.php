@if (isset($user))
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ $title }}</h3>
            </div>
            <div class="box-body">
                <dl class="dl-horizontal">
                    <dt>First Name:</dt>
                    <dd>{{ $user->first_name }}</dd>

                    <dt>Last Name:</dt>
                    <dd>{{ $user->last_name }}</dd>

                    <dt>Email:</dt>
                    <dd>{{ $user->email }}</dd>

                    <dt>Role:</dt>
                    <dd>{{ $user->roleName }}</dd>

                </dl>
                <a href="{{ route('users.index') }}" title="Back to User list" class="btn btn-sm btn-warning pull-left">
                    <i class="glyphicon glyphicon-fast-backward"></i>
                     Back
                </a>
                <a href="{{ route('users.edit', $user->id) }}" title="Edit User" class="btn btn-sm btn-primary pull-right">
                    <i class="glyphicon glyphicon-pencil"></i>
                     Edit User
                </a>
            </div>
        </div>
    </div>
@endif
