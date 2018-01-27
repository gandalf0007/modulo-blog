

<div class="card card-outline-info">
      <div class="card-header">
          <h4 class="m-b-0 text-white">Configurar Comentarios (Disqus)</h4></div>
      <div class="card-body">
        <div class="row">
            <div class="form-group col-xs-12 col-sm-12 col-md-10">
                <div class="input-group">
                  <div class="input-group-addon"><i class="mdi mdi-link"></i></div>
                  {!!Form::text('disqus_html',null,['class'=>'form-control requiered ','placeholder'=>'ingrese el Link de disqus','required'])!!}
                </div>
            </div>

		@if ($settings->disqus_enable == 1)
			<div class="form-group col-xs-12 col-sm-12 col-md-2">
     			<input type="checkbox" name="enable" checked="" class="js-switch" data-color="#009efb">
			</div>
			
		@else

			<div class="form-group col-xs-12 col-sm-12 col-md-2">
     			<input type="checkbox" name="enable"  	class="js-switch" data-color="#009efb">
			</div>

		@endif

  

        </div>
      </div>
  </div>



                



   
    
 