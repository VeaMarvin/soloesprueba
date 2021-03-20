@extends('layouts.master')
@section('title', 'Carro de pedido')
@section('extra-css')
    <style>
        .mt-32 {
            margin-top: 32px;
        }

    </style>
    <script src="https://js.stripe.com/v3/"></script>
@endsection

@section('content')
    <section id="cart_items">{{-- Breadcumbs y Tabla --}}
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{ route('consulta.index') }}">Inicio</a></li>
                    <li class="active">Carro de pedido</li>
                </ol>
            </div>
            <h2 class="title text-center">Formulario para realizar el pedido</h2>
            <div class="well well-lg" style="background: #fe980f;">
                <div class="row">
                    {!! Form::open(['route' => 'pedido.realizar', 'method' => 'POST', 'id' => 'payment-form']) !!}

                    <div class="col-sm-12">
                        <div class="shopper-info">
                            <p>Informacion del pedido</p>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="shopper-info">
                            <input class="textbox" placeholder="NIT" type="text" name="nit" value="{{ old('nit') }}">
                        </div>
                    </div>
                    <div class="col-sm-10">
                        <div class="shopper-info">
                            <input class="textbox" placeholder="Cliente" type="text" name="name_complete"
                                value="{{ old('name_complete') }}">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="shopper-info">
                            <input class="textbox" placeholder="Dirección" type="text" name="direction"
                                value="{{ old('direction') }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="shopper-info">
                            <input class="textbox" placeholder="Correo electrónico" type="email" name="email"
                                value="{{ old('email') }}">
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="shopper-info">
                            <input class="textbox" placeholder="Teléfono" type="text" name="phone"
                                value="{{ old('phone') }}">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="message_nuevo">
                            <textarea class="textbox" placeholder="Observación" rows="2" name="observation"
                                value="{{ old('observation') }}"></textarea>
                        </div>
                    </div>
                    @if (is_null($credito))
                        <div class="col-sm-3">
                            <div class="shopper-info">
                                <p>No cuenta con crédito <input class="textbox" type="checkbox" name="credit_id" hidden
                                        value="{{ old('credit_id') }}"></p>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="form-group">
                                <label for="name_on_card">Name on Card</label>
                                <input type="text" class="textbox form-control" id="name_on_card" name="name_on_card" value="">
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label for="card-element">
                                    Credit or debit card
                                </label>
                                <div id="card-element" class="textbox">
                                    <!-- a Stripe Element will be inserted here. -->
                                </div>

                                <!-- Used to display form errors -->
                                <div id="card-errors" role="alert"></div>
                            </div>
                        </div>
                    @else
                        <div class="col-sm-6">
                            <div class="shopper-info">
                                <p>{{ $credito->getCreditConcatAttribute() }} <input class="textbox" type="checkbox"
                                        name="credit_id"></p>
                            </div>
                        </div>
                    @endif
                    <div class="col-sm-12 ">
                        <button type="submit" id="complete-order" class="btn btn-md btn-success pull-right">Realizar pedido
                            ahora</button>
                    </div>
                </div>
            </div>
            @include('partials.detalle_pedido')
        </div>
    </section>{{-- ./Breadcumbs y Tabla --}}

    <section id="do_action">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                </div>
                <div class="col-sm-6">
                    <div class="total_area">
                        <ul>
                            <li class="text-right">Total <h1 style="color: black;"><strong>{{ $total }}</strong></h1>
                            </li>
                        </ul>
                        @if (empty($carrito))
                            <a class="btn btn-default btn-block check_out" href="{{ route('pedido.index') }}">Confirmar
                                pedido</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--/#do_action-->
@endsection
@section('scripts')
    <script>
        (function() {
            // Create a Stripe client
            var stripe = Stripe('{{ config('services.stripe.key') }}');
            // Create an instance of Elements
            var elements = stripe.elements();
            // Custom styling can be passed to options when creating an Element.
            // (Note that this demo uses a wider set of styles than the guide below.)
            var style = {
                base: {
                    color: '#32325d',
                    lineHeight: '18px',
                    fontFamily: '"Roboto", Helvetica Neue", Helvetica, sans-serif',
                    fontSmoothing: 'antialiased',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    }
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a'
                }
            };
            // Create an instance of the card Element
            var card = elements.create('card', {
                style: style,
                hidePostalCode: true
            });
            // Add an instance of the card Element into the `card-element` <div>
            card.mount('#card-element');
            // Handle real-time validation errors from the card Element.
            card.addEventListener('change', function(event) {
                var displayError = document.getElementById('card-errors');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });
            // Handle form submission
            var form = document.getElementById('payment-form');
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                // Disable the submit button to prevent repeated clicks
                document.getElementById('complete-order').disabled = true;
                var options = {
                    name: document.getElementById('name_on_card').value
                }
                stripe.createToken(card, options).then(function(result) {
                    if (result.error) {
                        // Inform the user if there was an error
                        var errorElement = document.getElementById('card-errors');
                        errorElement.textContent = result.error.message;
                        // Enable the submit button
                        document.getElementById('complete-order').disabled = false;
                    } else {
                        // Send the token to your server
                        stripeTokenHandler(result.token);
                    }
                });
            });

            function stripeTokenHandler(token) {
                // Insert the token ID into the form so it gets submitted to the server
                var form = document.getElementById('payment-form');
                var hiddenInput = document.createElement('input');
                hiddenInput.setAttribute('type', 'hidden');
                hiddenInput.setAttribute('name', 'stripeToken');
                hiddenInput.setAttribute('value', token.id);
                form.appendChild(hiddenInput);
                form.submit();
            }
        })();
    </script>
@endsection
