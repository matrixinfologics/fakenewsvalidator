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

                    <dt>Twitter Consumer Key:</dt>
                    <dd>{{{ $company->twitter_consumer_key }}}</dd>

                    <dt>Twitter Consumer Secret:</dt>
                    <dd>{{{ $company->twitter_consumer_secret }}}</dd>

                    <dt>Twitter Access Token:</dt>
                    <dd>{{{ $company->twitter_access_token }}}</dd>

                    <dt>Twitter Access Token Secret:</dt>
                    <dd>{{{ $company->twitter_access_token_secret }}}</dd>

                </dl>
                @if (!Auth::user()->isCompanyAdmin())
                     <a href="{{ route('companies.index') }}" title="Back to company list" class="btn btn-sm btn-warning pull-left">
                        <i class="glyphicon glyphicon-fast-backward"></i>
                         Back
                    </a>
                    <a href="{{ route('companies.edit', $company->id) }}" title="Edit User" class="btn btn-sm btn-primary pull-right">
                        <i class="glyphicon glyphicon-pencil"></i>
                         Edit Company
                    </a>
                @endif
            </div>
        </div>
    </div>
@endif
