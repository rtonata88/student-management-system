@extends('layouts.student-portal')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Get Support</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="{{ route('student-portal.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Get Support</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">Contact Support</h4>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="text-center p-4">
                                <div class="avatar-lg mx-auto mb-3">
                                    <div class="avatar-title rounded-circle bg-primary">
                                        <i class="fas fa-phone fa-2x"></i>
                                    </div>
                                </div>
                                <h5>Call Us</h5>
                                <p class="text-muted">+264 81 37 0 37 26</p>
                                <p class="text-muted">Available 24/7</p>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="text-center p-4">
                                <div class="avatar-lg mx-auto mb-3">
                                    <div class="avatar-title rounded-circle bg-success">
                                        <i class="fas fa-envelope fa-2x"></i>
                                    </div>
                                </div>
                                <h5>Email Us</h5>
                                <p class="text-muted">info@educims.com</p>
                                <p class="text-muted">Response within 24 hours</p>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <form>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Full Name</label>
                                    <input type="text" class="form-control" id="name" placeholder="Enter your name">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" placeholder="Enter your email">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" class="form-control" id="subject" placeholder="Enter subject">
                        </div>
                        
                        <div class="form-group">
                            <label for="message">Message</label>
                            <textarea class="form-control" id="message" rows="5" placeholder="Describe your issue or question"></textarea>
                        </div>
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i> Send Message
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
