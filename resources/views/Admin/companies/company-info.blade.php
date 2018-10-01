 @if (isset($company))
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">{{ $title }}</h3>
            </div>
            <div class="box-body">
                <dl class="dl-horizontal">
                    <dt>Name:</dt>
                    <dd>{{{ $company->name }}}</dd>

                    <dt>Website:</dt>
                    <dd>{{{ $company->website }}}</dd>

                    <dt>Phone:</dt>
                    <dd>{{{ $company->phone }}}</dd>

                    <dt>Address:</dt>
                    <dd>{{{ $company->address }}}</dd>

                </dl>
                 <a href="{{ route('companies.index') }}" title="Back to company list" class="btn btn-sm btn-warning pull-left">
                    <i class="glyphicon glyphicon-fast-backward"></i>
                     Back
                </a>
                <a href="{{ route('companies.edit', $company->id) }}" title="Edit User" class="btn btn-sm btn-primary pull-right">
                    <i class="glyphicon glyphicon-pencil"></i>
                     Edit Company
                </a>
            </div>
        </div>
    </div>
@endif
