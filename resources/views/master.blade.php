<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Gateway demo</title>

	<link href="{{ asset('/css/app.css') }}" rel="stylesheet">
</head>
<body>
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/payment/go') }}">
						<div class="panel-heading">Order</div>
						<section class="panel-body">
							<input type="hidden" name="_token" value="{{ csrf_token() }}">

							<div class="form-group">
								<label class="col-md-4 control-label">Amount</label>
								<div class="col-md-6"> <input type="number" class="form-control" name="order[amount]"> </div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Currancy Code</label>
								<div class="col-md-6"> 
									<select class="form-control" name="order[currancy]">
										@foreach($currencies as $i) <option value="{{$i}}">{{ $i }}</option> @endforeach
									</select>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Customer Full name</label>
								<div class="col-md-6"> <input type="text" class="form-control" name="order[name]"> </div>
							</div>
						</section>
						<div class="panel-heading">Payment</div>
						<section class="panel-body">

							<div class="form-group">
								<label class="col-md-4 control-label">Credit card holder name</label>
								<div class="col-md-6"> <input type="text" class="form-control" name="card[name]"> </div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Card type</label>
								<div class="col-md-6">
									<select class="form-control" name="card[type]">
										@foreach($cardTypes as $i) <option value="{{$i}}">{{ $i }}</option> @endforeach
									</select>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Credit card number</label>
								<div class="col-md-6"> <input type="text" class="form-control" name="card[number]" > </div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">Credit card expiration</label>
								<div class="col-md-6">
									<select class="form-control" name="card[expire]">
										@for($k=date('Y',time()) ;$k<(date('Y',time())+10);$k++) 
											@for($i=1;$i<13;$i++)
												<option value="{{date('m',strtotime($i.'/01'))}}/{{$k}}">{{ date('F',strtotime($i.'/01')).' '.$k }}</option>
											@endfor
										@endfor
									</select>
								</div>
							</div>

							<div class="form-group">
								<label class="col-md-4 control-label">CCV</label>
								<div class="col-md-6"> <input type="number" class="form-control" name="card[ccv]"> </div>
							</div>

							<div id="loading" class="loading-bar"><strong>loading</strong></div>

							<button class="btn btn-block btn-primary">Pay</button>
							<pre>
							<output></output>
							</pre>

						</section>
					</form>
				</div>
			</div>
		</div>
	</div>


	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script> 
		jQuery( document ).ready(function( $ ) {
			$('button').click(function(){
				$('#loading').slideDown();//couldn't help a little graphics
				$.ajax({ url: jQuery('form').attr('action'), data:$('form').serialize() })
				 .done(function(msg) { $('output').html(msg);$('#loading').slideUp(); });
				return false;
			});
		});
	</script>
</body>
</html>

