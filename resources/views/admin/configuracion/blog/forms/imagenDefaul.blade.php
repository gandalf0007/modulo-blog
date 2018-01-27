<div class="card card-outline-info">
        <div class="card-header">
            <h4 class="m-b-0 text-white">Imagen por defecto de los Post</h4></div>
        <div class="card-body">
          <div class="row">

        
        <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="alert alert-success alert-rounded"> <i class="fa fa-exclamation-circle"></i> Al crear un nuevo post y al no asignarle una imagen de portada esta sera la imagen por defecto.
         <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">×</span> </button>
          </div>
          </div>


             
             <div class="form-group col-xs-12 col-sm-12 col-md-6">
            <label for="input-file-now"></label>
             <input type="file" id="input-file-now" class="dropify" name="imagen" required="">
             </div>
            

       @if($settings->image_defaul == "" or $settings->image_defaul == null)

              <div class="col-md-6 el-element-overlay">
                  <div class="card">
                        <div class="el-card-item">
                            <div class="el-card-avatar el-overlay-1"> <img src="storage/noticias/noticia.jpg" alt="user">
                                <div class="el-overlay">
                                  
                                     <ul class="el-info">
                                      <li><a class="btn default btn-outline image-popup-vertical-fit" href="storage/noticias/noticia.jpg"><i class="icon-magnifier"></i> Imagen por defecto</a></li>
                                        </ul>
                                   
                                    </div>
                                </div>
                            </div>
                        </div>
                  </div>
             
       @else

       <div class="col-md-6 el-element-overlay">
                  <div class="card">
                        <div class="el-card-item">
                            <div class="el-card-avatar el-overlay-1"> <img src="{{$settings->image_defaul}}" alt="user">
                                <div class="el-overlay">
                                  
                                     <ul class="el-info">
                                      <li><a class="btn default btn-outline image-popup-vertical-fit" href="{{$settings->imagen_defaul}}"><i class="icon-magnifier"></i> Imagen por defecto</a></li>
                                        </ul>
                                   
                                    </div>
                                </div>
                            </div>
                        </div>
                  </div>



       @endif
              

           </div>
         </div>
     </div>





                   