@extends('layouts.app', ['_TITLE' => 'Pricing – WikiDeadlines'])

@section('head.scripts') 
  <script src="https://js.stripe.com/v3/"></script>
@endsection

@section('content')
<style>
.top{
display:flex;
flex-direction:row;

}
  </style>
<h1> i am hear</h1>
   
<div class="container top">
   <div class="box">
      <h3><h3>Heading part</h3> 
      <p> this is main paregraph </p>
      <p>this is footer <buttton>select </buttton></p>
    </div> 

    <div class="box">
        <h3><h3>Heading part</h3> 
        <p> this is main paregraph </p>
        <p>this is footer <buttton>select </buttton></p>
    </div>

    <div class="box">
        <h3><h3>Heading part</h3> 
        <p> this is main paregraph </p>
        <p>this is footer <buttton>select </buttton></p>
    </div>
   
</div>

@endsection
