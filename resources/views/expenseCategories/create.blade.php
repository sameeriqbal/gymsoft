@extends('app')

@section('content')

    <div class="rightside bg-grey-100">
        <div class="container-fluid">
            <!-- Error Log -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="panel no-border">
                        <div class="panel-title">
                            <div class="panel-head font-size-20">Enter details of the expense category</div>
                        </div>
                        <div class="panel-body">
                            {!! Form::Open(['url' => 'expenses/categories', 'id' => 'expensecategoriesform']) !!}

                            @include('expenseCategories.form',['submitButtonText' => 'Add'])

                            {!! Form::Close() !!}
                        </div>
                    </div>
                </div>
            </div>
     </div>
         <footer>
        &copy; Copyrights {{date('Y')}}, Powered by  <span>Scientise7</span>
    </footer>
     </div>
            @stop
@section('footer_scripts')
    <script src="{{ URL::asset('assets/js/expenseCategory.js') }}" type="text/javascript"></script>
@stop