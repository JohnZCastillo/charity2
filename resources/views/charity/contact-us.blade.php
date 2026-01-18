@extends('layouts.charity')

@section('title','Charity')


@section('body')
    <section class="container-fluid hero-bg mt-3">

        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                {{$errors->first()}}
            </div>
        @endif

        @if(\Illuminate\Support\Facades\Session::has('message'))
            <div class="alert alert-success" role="alert">
                {{\Illuminate\Support\Facades\Session::get('message')}}
            </div>
        @endif


        <div class="row mx-0 section-padding text-primary pt-0">
            <div class="col-12">
                <h2 class="hero-title text-success fw-bold">Contact Us</h2>
            </div>
            <div class="col-12 col-md-5">
                <div class="media contact-info mb-2">
                    <div class="media-body">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d343.9918573403699!2d120.8737973770125!3d14.269136409225608!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd803f4cb2ca59%3A0x7affd96ed31805b7!2sMissionary%20of%20Charity%20Brothers!5e1!3m2!1sfil!2sph!4v1756527474107!5m2!1sfil!2sph" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                <div class="d-flex gap-2 mb-2">
                    <span class="contact-info__icon">
                        <i class="ti-tablet" style="font-size: 30px"></i>
                    </span>
                    <div class="media-body">
                        <h3 class="mb-0">419-1710</h3>
                        <p class="mb-0 text-secondary">Mon to Fri 9:00 am to 5:00 pm</p>
                    </div>
                </div>
                <div class="d-flex gap-2 mb-2">
                    <span class="contact-info__icon">
                        <i class="ti-email" style="font-size: 30px"></i>
                    </span>
                    <div class="media-body">
                        <p class="mb-0">Send us your query anytime!</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-7">
                <form class="form-contact contact_form" action="/inventory/inquiries" method="POST"
                      novalidate="novalidate">
                    @csrf
                    <div class="row mx-0 mb-2">
                        <div class="ps-0 pe-0 pe-md-5 col-12 col-sm-6 mb-2">
                            <div class="form-group">
                                <input class="form-control valid" name="name" id="name" type="text"
                                       onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your name'"
                                       placeholder="Enter your name">
                            </div>
                        </div>
                        <div class="ps-0 pe-0 pe-md-5 col-12 col-sm-6 mb-2">
                            <div class="form-group">
                                <input class="form-control valid" name="email" id="email" type="email"
                                       onfocus="this.placeholder = ''"
                                       onblur="this.placeholder = 'Enter email address'"
                                       placeholder="Email">
                            </div>
                        </div>
                        <div class="ps-0 pe-0 pe-md-5 col-12 mb-2">
                            <div class="form-group">
                                <input class="form-control" name="subject" id="subject" type="text"
                                       onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Subject'"
                                       placeholder="Enter Subject">
                            </div>
                        </div>
                        <div class="ps-0 pe-0 pe-md-5 col-12 mb-2">
                            <div class="form-group">
                                <textarea class="form-control w-100" name="message" id="message" cols="30" rows="9"
                                          onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Message'"
                                          placeholder=" Enter Message"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success px-4 py-2 text-white">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

@endsection
