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

.container{
  max-width: 1140px;
    display: flex;
    flex-direction: row;
    justify-content: space-around;
}
  </style>
   
<div class="container top">
   <div class="box">
      <h3><h3>Heading part</h3> 
      <p> this is main paregraph </p>
    <buttton type="button"  class="btn btn-prinery">select </buttton>
    </div> 

    <div class="box">
        <h3><h3>Heading part</h3> 
        <p> this is main paregraph </p>
      <buttton type="button" class="btn btn-prinery">select </buttton>
    </div>

    <div class="box">
        <h3><h3>Heading part</h3> 
        <p> this is main paregraph </p>
      <buttton  type="button" class="btn btn-prinery">select </buttton>
    </div>
   
</div>

@endsection
