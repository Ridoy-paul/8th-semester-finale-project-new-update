@extends('layouts.master')

@section('title')
	{{ 'Contact' . ' | '. env('APP_NAME') }}
@endsection

@section('style')
    <style type="text/css">
        .contact input.form-control{
            border: 0.5px solid #000;
        }
        .contact textarea.form-control{
            border: 0.5px solid #000;
        }
    </style>
@endsection


@section('content')
@php
	$business = App\Models\Setting::find(1);
@endphp

		<!-- Start of Main -->
        <main class="main contact">
            <!-- Start of PageContent -->
            <div class="page-content">
                <div class="container">
                	<div class="row">
                		<h2 class="pt-4 pb-4">CONTACT US</h2>
                    	<div class="col-md-8">
                    		@if(Session::has('success'))
                    		<h3 class="alert alert-success">
                    			{{ Session::get('success') }}
                    		</h3>
                    		@endif
                    		<form action="{{ route('message.send') }}" method="POST">
		                    	@csrf
		                		<div class="row">
	                    			<div class="col-md-12">
	                    				<div class="form-group">
	                    					<label>Name *</label>
	                    					<input type="text" name="name" class="form-control" required>
	                    				</div>
	                    			</div>
	                    			<div class="col-md-6">
	                    				<div class="form-group">
	                    					<label>Email *</label>
	                    					<input type="email" name="email" class="form-control" required>
	                    				</div>
	                    			</div>
	                    			<div class="col-md-6">
	                    				<div class="form-group">
	                    					<label>Phone *</label>
	                    					<input type="text" name="phone" class="form-control" required>
	                    				</div>
	                    			</div>
	                    			<div class="col-md-12">
	                    				<div class="form-group">
	                    					<label>Subject *</label>
	                    					<input type="text" name="subject" class="form-control" required>
	                    				</div>
	                    			</div>
	                    			<div class="col-md-12">
	                    				<div class="form-group">
	                    					<label>Message *</label>
	                    					<textarea class="form-control" rows="5" name="message"></textarea>
	                    				</div>
	                    			</div>
	                    			<button type="submit" class="btn btn-dark btn-rounded">Send Now</button>
	                    		</div>
		                    </form>
                    	</div>
                    	<div class="col-md-4">
                    		<p><b>Phone</b> : {{ $business->phone }}</p>
                    		<p><b>Email</b> : {{ $business->email }}</p>
                    		<p><b>Address</b> : {{ $business->address }}</p>
                    	</div>
                    	<div class="col-md-12 pt-4">
                    	    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d295.8660099706449!2d90.38271332426909!3d23.807856594540507!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c7285f7e6a75%3A0x14ddf7d3104a5602!2sInstitute%20of%20Science%20Trade%20%26%20Technology%20(ISTT)!5e0!3m2!1sen!2sbd!4v1662813409148!5m2!1sen!2sbd" width="100%"  height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    	</div>
                    </div>
                </div>
            </div>
            <!-- End of PageContent -->
        </main>
        <!-- End of Main -->

@endsection