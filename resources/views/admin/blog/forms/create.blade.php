<div class="card card-outline-info">
      <div class="card-header">
          <h4 class="m-b-0 text-white">Titulo del post</h4></div>
      <div class="card-body">
        <div class="row">
            <div class="form-group col-xs-12 col-sm-12 col-md-12">
                <div class="input-group">
                  <div class="input-group-addon"><i class="mdi mdi-format-title"></i></div>
                  {!!Form::text('titulo',null,['class'=>'form-control requiered ','placeholder'=>'ingrese el titulo','required'])!!}
                </div>
            </div>
        </div>
      </div>
  </div>



<div class="card card-outline-info">
        <div class="card-header">
            <h4 class="m-b-0 text-white">Cargar Imagen de Portada</h4></div>
        <div class="card-body">
          <div class="row">
            <div class=" col-md-3"></div>

             <div class="form-group col-xs-12 col-sm-12 col-md-6">
            <label for="input-file-now"></label>
             <input type="file" id="input-file-now" class="dropify" name="imagen">
             </div>

             <div class="c col-md-3"></div>
           </div>
         </div>
     </div>





   
   <div class="card card-outline-info">
      <div class="card-header">
          <h4 class="m-b-0 text-white">Descripcion Corta</h4></div>
      <div class="card-body">
        <div class="row">

  <div class=" col-md-3"></div>
   <div class="form-group col-xs-12 col-sm-12 col-md-12">
         <div class="input-group">
        {!!Form::textarea ('descripcioncorta',null,['class'=>'my-editor text','id'=>'lfm','placeholder'=>'ingrese la Descripcion'])!!}
        
         </div>
         <h6 class="pull-right" id="count_message"></h6>
    </div>
    <div class=" col-md-3"></div>
    
        </div>
      </div>
   </div>


   <div class="card card-outline-info">
      <div class="card-header">
          <h4 class="m-b-0 text-white">Descripcion Larga</h4></div>
      <div class="card-body">
        <div class="row">

  <div class=" col-md-3"></div>
   <div class="form-group col-xs-12 col-sm-12 col-md-12">
         <div class="input-group">
        {!!Form::textarea ('descripcionlarga',null,['class'=>'my-editor text','id'=>'lfm','placeholder'=>'ingrese la Descripcion'])!!}
         </div>
         <h6 class="pull-right" id="count_message"></h6>
    </div>
    <div class=" col-md-3"></div>



        </div>
      </div>
   </div>


   <div class="card card-outline-info">
        <div class="card-header">
            <h4 class="m-b-0 text-white">Tags</h4></div>
        <div class="card-body">
          <div class="row">

         <h6 class="card-subtitle">Ingrese los tags separados por una coma</h6>
        <div class="form-group col-md-10 col-md-offset-1">
          
     
        <select multiple="" data-role="tagsinput" name="tag[]">
        </select>

      </div>

           </div>
         </div>
     </div>




     <div class="card card-outline-info">
        <div class="card-header">
            <h4 class="m-b-0 text-white">Categoria</h4></div>
        <div class="card-body">
          <div class="row">

            <div class="form-group col-xs-12 col-sm-12 col-md-12">
              <div class="input-group">
                <span class="input-group-addon" id="basic-addon3"><i class="fa fa-list"></i></span>
                 <select class="form-control input-sm" name="blog_categoria_id" id="categoria">
    @foreach($categorias as $id => $nombre)
      <option value="{{ $id }}">{{ $nombre }}</option>
    @endforeach
  </select>
                </div>
              </div>

           </div>
         </div>
     </div>



                






