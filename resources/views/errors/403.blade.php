@extends('backend.master')

@section('body')

    <div class="error-area ptb-100">
        <div class="d-table">
            <div class="d-table-cell">
                <div class="error-content">
                    <h1>4 <span>0</span> 3</h1>
                    <h3>Oops! Access Denied</h3>
                    <p>You are not authorised to access this function. Please don't try again or your account will be locked.</p>
                    <a href="{{ url()->previous() }}" class="default-btn">
                        Return To Previous Page
                    </a>
                    <a href="{{ url('/dashboard') }}" class="default-btn">
                        Return To Home Page
                    </a>
                </div>
            </div>
        </div>
    </div>

@endsection
